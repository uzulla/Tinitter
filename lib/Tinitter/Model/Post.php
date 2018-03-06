<?php
namespace Tinitter\Model;

use Aura\SqlQuery\QueryFactory;

class Post
{
    /**
     * ページ指定での投稿取得
     * @param $per_page １ページあたりの件数
     * @param  int $page_num ページ番号
     * @return array 投稿の配列と、次ページ存在のフラグ
     */
    public static function getByPage($per_page, $page_num)
    {
        $queryFactory = new QueryFactory(DB_TYPE);
        $select = $queryFactory->newSelect();

        // 投稿を取得、次ページ存在判定のために１件多く取得
        $offset = $per_page * ($page_num - 1);// スキップする件数を計算
        $select
            ->cols(["*"])
            ->from('posts')
            ->orderBy(['id DESC'])
            ->limit($per_page + 1)
            ->offset($offset);

        $pdo = static::getPDO();

        $sth = $pdo->prepare($select->getStatement());
        $sth->execute();

        $post_list = $sth->fetchAll(\PDO::FETCH_ASSOC);

        // 次ページ存在をチェック
        if (count($post_list) > $per_page) {
            array_pop($post_list); //確認用の１件を捨てる
            $next_page_is_exist = true;
        } else {
            $next_page_is_exist = false;
        }

        return [$post_list, $next_page_is_exist];
    }

    /**
     * PostをINSERT
     * @param $nickname
     * @param $body
     */
    public static function insert($nickname, $body)
    {
        $queryFactory = new QueryFactory(DB_TYPE);
        $insert = $queryFactory->newInsert();

        $insert
            ->into('posts')
            ->cols([
                'nickname' => $nickname,
                'body' => $body,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        $pdo = static::getPDO();

        $sth = $pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());

        $id = $pdo->lastInsertId('id');

        if ($id === false) {
            throw new \RuntimeException('fail insert');
        }
    }

    /**
     * とりあえずPDOを返す君（いつか追い出す）
     * @return \PDO
     */
    private static function getPDO()
    {
        return new \PDO(
            DSN,
            '',
            '',
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING,
                \PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    }
}
