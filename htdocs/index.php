<?php
// セッション開始
session_start();

// ライブラリ読み込み
require __DIR__ . '/../vendor/autoload.php';

// 設定ファイル読み込み
require __DIR__ . '/../config.php';

// Slim初期化
$container = new \Slim\Container;
$app = new \Slim\App($container);

// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(TEMPLATES_DIR_PATH, []);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

// csrfプラグインの追加
$csrf = new \Slim\Csrf\Guard;
$app->add($csrf);
$container->view->addExtension(new \Tinitter\Misc\TwigExt\CsrfExtension($csrf));

// Slimにルートを登録
\Tinitter\Route::registration($container);

// 実行
$app->run();
