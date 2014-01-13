サンプルアプリケーション Tinitter
==============================

これはサンプルアプリケーションの掲示板、Tinitterです。

- ニックネームとテキストを投稿できる
- 投稿をページ送りで見る事ができる

だけの単純なウェブアプリケーションです

# 構成要素

- WAF: Slim Framework
- Template Engine: Twig
- ORM: Illuminate/Eloquent
- Varidator: Respect/Validation
- Test: phpunit, faker

# 動作に必要な条件

- PHP 5.4以上
- sqlite3 サポート
- （DBセットアップのためにsqlite3のcli）

# セットアップ

## composerでライブラリを取得

### Composerインストール

```
# プロジェクトトップディレクトリで
$ php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
```

### Composerでライブラリのインストール

```
# プロジェクトトップディレクトリで
$ php composer.phar install
```

## config を作成

```
# サンプルコンフィグファイルをコピーして作成する
$ cp config.php.sample config.php
```

SQLiteを使う場合には、内容を変更する必要はありません。
Mysqlを利用する場合には、後述の設定を行ってください。

## .htaccess設定

Apacheの場合、以下の設定をおこなってください

```
$ cp htdocs/.htaccess.sample htdocs/.htaccess
```

## DBセットアップ

### SQLite利用時

```
# プロジェクトトップディレクトリで
$ sqlite3 sqlite.db < schema.sqlite3.sql
```

データを初期化したい場合、上記を再度実行してください。

### Mysql利用時

- DB名：tinitter
- ユーザー名：tinitter_user
- パスワード：tinitter_pass
の場合

以下を実行してDBにテーブルを登録

```
$ mysql -u tinitter_user -p tinitter < schema.mysql.sql
# プロンプトがでたら、パスワードを入力
```

`config.php`を修正し、既存の`$db_settings〜`を以下のように書き換えます。

```
$db_settings = [
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'database'  => 'tinitter',
    'username'  => 'tinitter_user',
    'password'  => 'tinitter_pass',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci'
];
```

**上記設定をしても、テストはSQLiteで動作します。詳しくはテストの項目を参照ください。**


# Builtin Serverでの起動

```
# プロジェクトの`htdocs/`ディレクトリで
$ php -S 127.0.0.1:8080
```

`http://localhost:8080/`にアクセス

# 他の実行環境での実行

プロジェクトの`htdocs/`をDocumentRootに設定してください。

# 設定項目

## デバッグモード切替

DEBUG定数を`true`/`false`で切り換える。

```
# config.php
define('DEBUG', true);
```

`true`時は、例外時にSlimがスタックトレースを出力します。本番では`false`にします。

## テンプレート切り替え

同梱されたBootstrapを適用したテンプレートを利用するには、`TEMPLATES_DIR_PATH`を変更します。

```
# config.php
define('TEMPLATES_DIR_PATH', __DIR__.'/templates_bootstrap');
```

# 自動テスト

`test/README.md`を参照してください
