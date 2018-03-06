<?php
namespace Tinitter\Controller;

use \Tinitter\Model\Post;

/**
 * タイムライン表示Action
 * @package Tinitter\Controller
 */
class TimeLine
{
    /** @var \Slim\Views\Twig */
    private $view;

    public function __construct($c)
    {
        $this->view = $c->view;
    }

    public function __invoke($request, $response, $args)
    {
        $page_num = $args['page_num'] ?? 1;

        list($post_list, $next_page_is_exist) = Post::getByPage(10, $page_num);

        return $this->view->render($response, 'TimeLine/show.twig', [
            'post_list' => $post_list,
            'page_num' => $page_num,
            'next_page_is_exist' => $next_page_is_exist
        ]);
    }
}
