<?php
// セッション開始
session_start();

// オートロード設定
require __DIR__.'/../vendor/autoload.php';

// 設定ファイル読み込み
require __DIR__.'/../config.php';

// 設定をテスト用DB設定で上書き
$db_settings = array(
    'driver' => 'sqlite',
    'database' => ":memory:", // メモリ内にテスト用DBを作成する
);
define("TEST_SCHEMA_SQL", __DIR__."/../schema.sqlite3.sql");

// DB接続セットアップ
\Base\DB::registerIlluminate($db_settings);
