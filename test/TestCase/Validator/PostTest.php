<?php
namespace TestCase\Validator;
use \Tinitter\Validator\Post as V_Post;
class PostTest extends \Tinitter\Test\Base
{
    /**
     * ニックネームが正しく検証できるか
     */
    public function testNickname()
    {
        $this->assertArrayHasKey('nickname', $this->_testOnlyNickname(''));
        $this->assertArrayHasKey('nickname', $this->_testOnlyNickname('日本語'));
        $this->assertArrayHasKey('nickname', $this->_testOnlyNickname('toooooooooolongnickname'));

        $this->assertArrayNotHasKey('nickname', $this->_testOnlyNickname('a'));
        $this->assertArrayNotHasKey('nickname', $this->_testOnlyNickname('1234567890123456'));
        $this->assertArrayNotHasKey('nickname', $this->_testOnlyNickname('contain space'));
        $this->assertArrayNotHasKey('nickname', $this->_testOnlyNickname('1234567890abcdef'));
    }
    private function _testOnlyNickname($nickname)
    {
        $input = array('nickname'=>$nickname, 'body'=>'ok_body');

        return V_Post::byArray($input);
    }

    /**
     * 本文が正しく検証できるか
     */
    public function testBody()
    {
        $this->assertArrayHasKey('body', $this->_testOnlyBody(''));

        $long_1000_chars = $this->_createLongStr(1000);
        $this->assertArrayNotHasKey('body', $this->_testOnlyBody($long_1000_chars));
        $this->assertArrayHasKey('body', $this->_testOnlyBody('a'.$long_1000_chars));

        $long_1000_mb_chars = $this->_createLongStr(1000, 'あ');
        $this->assertArrayNotHasKey('body', $this->_testOnlyBody($long_1000_mb_chars));
        $this->assertArrayHasKey('body', $this->_testOnlyBody('あ'.$long_1000_mb_chars));
    }
    private function _testOnlyBody($body)
    {
        $input = array('nickname'=>'oknickname', 'body'=>$body);

        return V_Post::byArray($input);
    }
    private function _createLongStr($length, $use_str="a")
    {
        $str = '';
        while (mb_strlen($str)<$length) {
            $str = $str.$use_str;
        }

        return $str;
    }
}
