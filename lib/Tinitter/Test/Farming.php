<?php
namespace Tinitter\Test;
use \Tinitter\Model\Post as M_Post;
class Farming
{
    /**
     * ダミーの投稿（\Tinitter\Model\Post）を指定数だけ生成保存する
     * @param $num 生成する数
     */
    static function farmingPost($num)
    {
        $faker = \Faker\Factory::create();
        for($i=0; $i<$num; $i++){
            $post = new M_Post;
            $post->nickname = $faker->firstName;
            $post->body = $faker->paragraph(2);
            $post->save();
        }
    }
}