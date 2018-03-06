テスト実行方法
============

TBD

# 準備

事前にComposerでphpunitをインストールします

# 注意

## PHPの設定

`php.ini`にて

```
mbstring.internal_encoding = UTF-8
```

が適切に設定されていないと、文字列比較のテストで失敗します。

## Windowsの場合

実行行の`/`を`\\`に置き換えて読んでください。  

# 全テスト実行

```
# test/ディレクトリにて
$ ../vendor/bin/phpunit
```

# 単テスト実行

```
# test/ディレクトリにて
$ ../vendor/bin/phpunit Test/Controller/TimeLineTest.php
```

#ディレクトリ以下のテスト実行

```
# test/ディレクトリにて
$ ../vendor/bin/phpunit Test/Controller/
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


