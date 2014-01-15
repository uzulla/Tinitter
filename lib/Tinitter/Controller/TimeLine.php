<?php
namespace Tinitter\Controller;
use \Tinitter\Model\Post as M_Post;
class TimeLine
{
    public function show($page_num=1)
    {
        $app = \Slim\Slim::getInstance();
        list($post_list, $next_page_is_exist) = M_Post::getByPage(10, $page_num);

        $app->render(
            'TimeLine/show.twig',
            [
                'post_list' => $post_list,
                'page_num' => $page_num,
                'next_page_is_exist' => $next_page_is_exist
            ]
        );
    }
}
