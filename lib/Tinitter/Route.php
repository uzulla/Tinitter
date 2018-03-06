<?php
namespace Tinitter;

use Tinitter\Controller;

class Route
{
    /**
     * 渡されたslimインスタンスにルートを登録
     * @param \Slim\App $container
     */
    public static function registration(\Slim\Container $container)
    {
        /** @var \Slim\Router $app */
        $router = $container['router'];


        {
            // トップページ
            $router->map(['GET'], '/', Controller\TimeLine::class);

            // 投稿一覧
            $router->map(['GET'], '/page/{page_num:\d+}', Controller\TimeLine::class);

            $container[Controller\TimeLine::class] = function ($c) {
                return new Controller\TimeLine($c);
            };
        }

        {
            // 新規投稿系、保存
            $router->map(['POST'], '/post/commit', Controller\Post::class);

            $container[Controller\Post::class] = function ($c) {
                return new Controller\Post($c);
            };
        }
    }
}
