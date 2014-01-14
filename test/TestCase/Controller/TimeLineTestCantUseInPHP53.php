<?php
namespace TestCase\Controller;
class TimeLineTest extends \Tinitter\Test\Base
{
    /**
     * タイトルが設定されているか
     */
    public function testTitle()
    {
        $dom = $this->req_dom('/');
        $this->assertEquals('Tinitter', $dom->find('title', 0)->text);
    }

    /**
     * ページングの計算が誤っていないか
     */
    public function testPaging()
    {
        \Tinitter\Test\Farming::farmingPost(105);

        $dom = $this->req_dom('/page/1');
        $this->assertEquals(10, count($dom->find('.postcell')) );

        $dom = $this->req_dom('/page/11');
        $this->assertEquals(5, count($dom->find('.postcell')) );

        $dom = $this->req_dom('/page/100');
        $this->assertEquals(0, count($dom->find('.postcell')) );
    }

    /**
     * ページングのリンクが表示されているか
     */
    public function testPagingButton()
    {
        \Tinitter\Test\Farming::farmingPost(25);

        $dom = $this->req_dom('/');
        // !! をつけることで数値をbool型に変換している、0=false 1>=true
        $this->assertFalse(!!count($dom->find('.prev')) );
        $this->assertTrue(!!count($dom->find('.next')) );

        $dom = $this->req_dom('/page/2');
        $this->assertTrue(!!count($dom->find('.prev')) );
        $this->assertTrue(!!count($dom->find('.next')) );

        $dom = $this->req_dom('/page/3');
        $this->assertTrue(!!count($dom->find('.prev')) );
        $this->assertFalse(!!count($dom->find('.next')) );
    }

    /**
     * ページングのリンク先が正しいか
     */
    public function testPagingLink()
    {
        \Tinitter\Test\Farming::farmingPost(35);

        $dom = $this->req_dom('/');
        $this->assertEquals('/page/2', $dom->find('.next', 0)->getAttribute('href') );

        $dom = $this->req_dom('/page/2');
        $this->assertEquals('/', $dom->find('.prev', 0)->getAttribute('href') );
        $this->assertEquals('/page/3', $dom->find('.next', 0)->getAttribute('href') );

        $dom = $this->req_dom('/page/3');
        $this->assertEquals('/page/2', $dom->find('.prev', 0)->getAttribute('href') );
        $this->assertEquals('/page/4', $dom->find('.next', 0)->getAttribute('href') );
    }

    /**
     * 現在のページ番号が正しいか
     */
    public function testPagingNum()
    {
        \Tinitter\Test\Farming::farmingPost(25);

        $dom = $this->req_dom('/');
        $this->assertEquals('1', $dom->find('.page-num', 0)->text );

        $dom = $this->req_dom('/page/2');
        $this->assertEquals('2', $dom->find('.page-num', 0)->text );
    }

}