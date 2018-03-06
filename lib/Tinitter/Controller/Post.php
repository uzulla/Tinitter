<?php
namespace Tinitter\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use \Tinitter\Model\Post as M_Post;
use \Tinitter\Validator\Post as V_Post;

class Post
{
    /** @var \Slim\Views\Twig */
    private $view;

    public function __construct($c)
    {
        $this->view = $c->view;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, $args)
    {
        $params = $request->getParsedBody();

        $error_list = V_Post::byArray($params);

        if (empty($error_list)) {
            M_Post::insert(
                $params['nickname'],
                $params['body']
            );
            return $response->withRedirect('/', 301);

        } else {
            return $this->view->render($response, 'Post/form.twig', [
                'params' => $params,
                'error_list' => $error_list
            ]);
        }
    }
}
