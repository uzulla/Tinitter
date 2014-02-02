<?php
// 設定ファイル読み込み
require __DIR__.'/Tinitter/config.php';

// エラーログが見れない環境向け↓
if(DEBUG===true){
    ini_set('display_errors', 1);
    set_error_handler("strict_error_handler");
}
function strict_error_handler($errno, $errstr, $errfile, $errline)
{
    die ("ERROR: '{$errfile}' の {$errline} 行目でエラーが発生しました".PHP_EOL);
}
// エラーログが見れない環境向け↑

// セッション開始
session_start();

// ライブラリ読み込み
require __DIR__.'/Tinitter/vendor/autoload.php';


// DB接続セットアップ
\Base\DB::registerIlluminate($db_settings);

// Slim初期化
$app = new \Slim\Slim(array(
    'templates.path' => TEMPLATES_DIR_PATH,
    'view' => new \Slim\Views\Twig(),
    'debug' => DEBUG,
));

// http://hostname/hoge/以下などにインストールする場合
$app->hook( 'slim.before.dispatch', function() use ( $app ) {
        $app->view()->appendData(array(
         'base_url' => BASE_URL
     ));
});

// Slimにルートを登録
\Tinitter\Route::registration($app);

// 実行
$app->run();
