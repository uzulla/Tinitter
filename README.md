サンプルアプリケーション Tinitter、レンタルサーバー向け設定
====================================================

これはサンプルアプリケーションの掲示板、Tinitter v1.0.0を一部のレンタルサーバーで動作するように修正したものです。テストなどが省かれています。

こちらからZIPでDLできます。
[https://github.com/uzulla/Tinitter/archive/for_rental_server.zip](https://github.com/uzulla/Tinitter/archive/for_rental_server.zip)

こちらは修正例なので、詳しくは通常版の[Tinitter](https://github.com/uzulla/Tinitter)を見てください

# 構成要素

- WAF: Slim Framework
- Template Engine: Twig
- ORM: Illuminate/Eloquent
- Varidator: Respect/Validation
- Test: phpunit, faker

# 動作に必要な条件

- PHP 5.3以上
- Mysql サポート
− この手直しバージョンはApacheを想定しています。

# セットアップ

## composerでライブラリを取得（手元のPCで実行します）

### Composerインストール

```
# ローカルのPCで
# Tinitter ディレクトリの中で
$ php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
```

### Composerでライブラリのインストール

```
# ローカルのPCで
# Tinitter ディレクトリの中で
$ php composer.phar install
```

## config を作成

```
# サンプルコンフィグファイルをコピーして作成します。
$ cp Tinitter/config.php.sample Tinitter/config.php
```

もしサーバーが`http://hostname/~hoge/`や`http://hostname/hoge/`のようにディレクトリ以下がトップになる場合には、
```
define('BASE_URL', '/hoge');
```
などと修正してください。

## DBセットアップ（レンタルサーバーの管理画面などで実行します）

### Mysql利用時

業者によってまちまちですが、管理画面よりMysqlのDB、ユーザーなどを作成し、`Tinitter/schema.mysql.sql`の内容を、phpMyAdmin等からSQL（やインポート）として実行してください。

その後`Tinitter/config.php`を修正し、既存の`$db_settings〜`を書き換えます。(ユーザー名やDB名、host名は的旨変更ください）

```
$db_settings = array(
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'database'  => 'tinitter',
    'username'  => 'tinitter_user',
    'password'  => 'tinitter_pass',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci'
);
```

# 設定項目

## デバッグモード切替

DEBUG定数を`true`/`false`で切り換えます。

```
# `Tinitter/config.php`
define('DEBUG', true);
```

`true`時は、例外時にSlimがスタックトレースを出力します。
動作を確認したら、かならずfalseにしましょう。


# アップロード


```
index.php
favicon.ico
.htaccess
Tinitter/
css/
vendor/
```

これらをアップロードします。
これら以外はアップロードしません。

サーバーによっては.htaccessがすでにアップロードされている場合があります、既存のものにうまく追記しましょう。
（または、ディレクトリを別途作成して、その中にアップロードしてみましょう）

# うまく動かない場合

まずはエラーログを見てください。
次に、DB等の設定がまちがっていないか確認してください。
PHPのバージョンがとても古かったりしないか確認してください。


