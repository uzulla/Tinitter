<?php
namespace Tinitter\Test;
class Base extends \PHPUnit\Framework\TestCase
{
    use \Uzulla\MockSlimClient; // traitを利用

    /**
     * \Uzulla\MockSlimClientで呼び出される
     * @param \Slim\Slim $app
     */
    public static function registrationRoute(\Slim\Slim $app)
    {
        \Tinitter\Route::registration($app);
    }

    /**
     * \Uzulla\MockSlimClientで呼び出される
     * @return \Slim\Slim
     */
    public static function createSlim()
    {
        return new \Slim\Slim([
            'templates.path' => TEMPLATES_DIR_PATH,
            'view' => new \Slim\Views\Twig()
        ]);
    }

    /**
     * テストケース開始の度に呼び出される
     */
    protected function setUp() : void
    {
        // テスト用DBを初期化する
        $schema_sql = file_get_contents(TEST_SCHEMA_SQL);
        \Illuminate\Database\Capsule\Manager::connection()
            ->getPdo()->exec($schema_sql);
    }
}
