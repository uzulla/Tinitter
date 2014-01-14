<?php
// セッション開始
session_start();

// ライブラリ読み込み
require __DIR__.'/../vendor/autoload.php';

// 設定ファイル読み込み
require __DIR__.'/../config.php';

// DB接続セットアップ
\Base\DB::registerIlluminate($db_settings);

// Slim初期化
$app = new \Slim\Slim([
    'templates.path' => TEMPLATES_DIR_PATH,
    'view' => new \Slim\Views\Twig(),
    'debug' => DEBUG,
]);

// Slimにルートを登録
\Tinitter\Route::registration($app);

// 実行
$app->run();
