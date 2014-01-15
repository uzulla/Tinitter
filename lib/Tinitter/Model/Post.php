<?php
namespace Tinitter\Model;
class Post extends \Illuminate\Database\Eloquent\Model
{
    /**
     * ページ指定での投稿取得
     * @param $per_page １ページあたりの件数
     * @param  int   $page_num ページ番号
     * @return array 投稿の配列と、次ページ存在のフラグ
     */
    public static function getByPage($per_page, $page_num)
    {
        // スキップする件数を計算
        $offset = $per_page*($page_num-1);

        // 投稿を取得、次ページ存在判定のために１件多く取得
        $post_list = static::orderBy('id', 'DESC')
            ->take($per_page+1)->skip($offset)
            ->get()->all();

        // 次ページ存在をチェック
        if (count($post_list)>$per_page) {
            array_pop($post_list); //確認用の１件を捨てる
            $next_page_is_exist = true;
        } else {
            $next_page_is_exist = false;
        }

        return array($post_list, $next_page_is_exist);
    }
}
