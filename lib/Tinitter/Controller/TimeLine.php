<?php
namespace Tinitter\Controller;
use \Tinitter\Model\Post as M_Post;
class TimeLine
{
    public function show($page_num=1)
    {
        $app = \Slim\Slim::getInstance();
	list($post_list, $next_page_is_exist) = M_Post::getByPage(10, $page_num);
	$ec2_instance_id = file_get_contents('http://169.254.169.254/latest/meta-data/instance-id/');

        $app->render(
            'TimeLine/show.twig',
            [
                'post_list' => $post_list,
                'page_num' => $page_num,
		'next_page_is_exist' => $next_page_is_exist,
		'ec2_instance_id' => $ec2_instance_id,
            ]
        );
    }
}
