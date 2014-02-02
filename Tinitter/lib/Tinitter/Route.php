<?php
namespace Tinitter;
class Route
{
    /**
     * 渡されたslimインスタンスにルートを登録
     * @param \Slim\Slim $app
     */
    public static function registration(\Slim\Slim $app)
    {
        // SlimのCSRF対策プラグインを有効化
        $app->add(new \Slim\Extras\Middleware\CsrfGuard());
        // トップページ
        $app->get('/', '\Tinitter\Controller\TimeLine:show');
        // 投稿一覧
        $app->get('/page/:page_num', '\Tinitter\Controller\TimeLine:show');
        // 新規投稿系、保存
        $app->post('/post/commit', '\Tinitter\Controller\Post:commit');
    }
}
