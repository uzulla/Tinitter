<?php
require "vendor/autoload.php";
require __DIR__ . '/config.php';

use \Psr\Http\Message\ServerRequestInterface;
use \React\Http\Server;
use \React\Http\Response;

$loop = React\EventLoop\Factory::create();

$cache = new \React\Cache\ArrayCache();

$server = new Server(array(
    // エラーハンドリング
    function (ServerRequestInterface $request, callable $next) {
        $promise = new React\Promise\Promise(function ($resolve) use ($next, $request) {
            $resolve($next($request));
        });
        return $promise->then(null, function (Throwable $e) {
            error_log("ERROR:" . $e->getMessage());
            error_log($e->getTraceAsString());

            return new Response(
                500,
                array(),
                'Internal Server error'
            );
        });
    },
    // 静的ファイル配信
    new \WyriHaximus\React\Http\Middleware\WebrootPreloadMiddleware(__DIR__."/htdocs"),
    // セッション
    new \WyriHaximus\React\Http\Middleware\SessionMiddleware(
        'MySessionCookie',
        $cache, // Instance implementing React\Cache\CacheInterface
        [ // Optional array with cookie settings, order matters
            0, // expiresAt, int, default
            '', // path, string, default
            '', // domain, string, default
            false, // secure, bool, default
            false // httpOnly, bool, default
        ]
    ),
    // csrf対策
    function (ServerRequestInterface $request, callable $next) {
        // read session
        $session_obj = $request->getAttribute(\WyriHaximus\React\Http\Middleware\SessionMiddleware::ATTRIBUTE_NAME);
        $session = $session_obj->getContents();
        if(!isset($session['csrf_token'])) {
            $csrf_token = base64_encode(random_bytes(64));
            $session_obj->setContents([
                'csrf_token' => $csrf_token,
            ]);
        }else{
            $csrf_token = $session['csrf_token'];
        }

        // check token
        if(strtolower($request->getMethod()) === "post"){
            $params = $request->getParsedBody();
            if(!isset($params['csrf_token']) || $params['csrf_token'] !== $csrf_token){
                error_log("invalid csrf_token");
                return new Response(400, [], "invalid csrf_token");
            }
        }
        $request = $request->withAttribute('csrf_token', $csrf_token);
        return $next($request);
    },
    // ウェブアプリ
    function (ServerRequestInterface $request) {

        // Slim初期化
        $container = new \Slim\Container;
        $app = new \Slim\App($container);

        // reactのrequestを突っ込む
        $container['request'] = function ($container) use ($request) {
            return $request;
        };

        // Register Twig View helper
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(TEMPLATES_DIR_PATH, []);
            $view->addExtension(new \Slim\Views\TwigExtension($c['router'], '/'));
            return $view;
        };

        // csrf_tokenを保持し、Twigヘルパに渡す
        $csrf_token = $request->getAttribute('csrf_token');
        $container['csrf_token'] = function ($c) use ($csrf_token){
            return $csrf_token;
        };
        $container->view->addExtension(new \Tinitter\Misc\TwigExt\CsrfExtension($csrf_token));

        // Slimにルートを登録
        \Tinitter\Route::registration($container);

        // 実行
        return $app->run(true);

    }
));

$socket = new React\Socket\Server(8888, $loop);
$server->listen($socket);
$loop->run();
