<?php
namespace TestCase\Controller;
class NewPostTest extends \Tinitter\Test\Base
{
    /**
     * 投稿が保存されるか
     */
    public function testAddPost()
    {
        // CSRF対策のトークンを事前取得
        $this->req('/');
        $csrf_token = $_SESSION['csrf_token'];

        // テストデータ生成
        $test_name = 'testname';
        $test_body = 'testbody';
        $input = http_build_query([
            'nickname'=>$test_name,
            'body'=>$test_body,
            'csrf_token'=>$csrf_token
        ]);

        // データを送信
        $this->req('/post/commit', 'POST', $input);

        // DBに保存されたかを確認
        $post = \Tinitter\Model\Post::find(1);
        $this->assertEquals($test_name, $post->nickname);
        $this->assertEquals($test_body, $post->body);

        // 投稿がページに表示されているか確認
        $dom = $this->req_dom('/page/1');
        $this->assertEquals($test_name, $dom->find('.postcell .nickname', 0)->text);
        $this->assertEquals($test_body, $dom->find('.postcell .body', 0)->text);
    }
}
