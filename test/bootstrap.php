<?php
// セッション開始
session_start();

// オートロード設定
require __DIR__.'/../vendor/autoload.php';

//// 設定をテスト用DB設定で上書き
//$db_settings = [
//    'driver' => 'sqlite',
//    'database' => ":memory:", // メモリ内にテスト用DBを作成する
//];
//define('DSN', 'sqlite:memory:');
//define('DB_TYPE', 'sqlite');
