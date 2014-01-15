<?php
namespace TestCase\Model;
use \Tinitter\Model\Post as M_Post;
class PostTest extends \Tinitter\Test\Base
{
    /**
     * Postが作成できるか、取得できるか
     */
    public function testPostCreate()
    {
        // 一件保存
        $post = new M_Post;
        $post->nickname = 'nickname';
        $post->body = 'body';
        $post->save();

        // 正しく保存されたか確認
        $id = $post->id;
        $same_post = M_Post::findOrFail($id);
        $this->assertEquals($same_post->nickname, 'nickname');
        $this->assertEquals($same_post->body, 'body');
    }

    /**
     * ページ指定で取得できるか
     */
    public function testGetByPage()
    {
        \Tinitter\Test\Farming::farmingPost(35);

        list($post_list, $next_page_is_exist) = M_Post::getByPage(10, 1);
        $this->assertCount(10, $post_list);
        $this->assertTrue($next_page_is_exist);

        list($post_list, $next_page_is_exist) = M_Post::getByPage(10, 4);
        $this->assertCount(5, $post_list);
        $this->assertFalse($next_page_is_exist);

        list($post_list, $next_page_is_exist) = M_Post::getByPage(10, 5);
        $this->assertCount(0, $post_list);
        $this->assertFalse($next_page_is_exist);
    }
}
