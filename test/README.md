テスト実行方法
============

# 準備

事前にComposerででphpunitをインストールします

# 全テスト実行

```
# test/ディレクトリにて
$ php ../vendor/bin/phpunit
```

# 単テスト実行

```
# test/ディレクトリにて
$ php ../vendor/bin/phpunit Test/Controller/TimeLineTest.php
```

#ディレクトリ以下のテスト実行

```
# test/ディレクトリにて
$ php ../vendor/bin/phpunit Test/Controller/
```

PHPUnit でディレクトリを指定した場合、`*Test.php`のファイルが再帰的に読み込まれ、実行されます。

> PHPUnitのドキュメント
> [http://phpunit.de/manual/3.8/ja/index.html](http://phpunit.de/manual/3.8/ja/index.html)

ファイル解説
===============

|ファイル名 | 概要|
|----|----|
| `phpunit.xml`| PHPUnit設定ファイル|
| `bootstrap.php`| `phpunit.xml`で指定された、テスト実行時に事前実行されるコード、lib以下のオートロードなど設定|
| `../lib/Tinitter/Test/`| テスト用のライブラリクラス|
| `../lib/Tinitter/Test/Base.php`| テスト用のベースクラス、初期化やユーティリティ関数など|
| `TestCase/*/*Test.php`| PHPUnitテスト定義|


mysqlを利用したテスト
===================

`bootstrap.php`に記述されたDB接続情報を編集してください。

```
// Mysql設定例
$db_settings = [
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'database'  => 'tinitter_test',
    'username'  => 'tinitter_test_user',
    'password'  => 'tinitter_test_pass',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci'
];
define("TEST_SCHEMA_SQL", __DIR__."/../schema.mysql.sql");
```

**Mysqlの場合も実行するとテーブルの再作成をおこないますので、データは初期化されます。必ずテスト用のDBを用意してそちらに接続するようにしてください。**
