[[English](README.md)][日本語]

---

# Box3 インストーラ（humbug/box）

PHP アーカイバー「Box3」（`box.phar`）自体は [humbug/box リポジトリ](https://github.com/humbug/box)の[リリースページ](https://github.com/humbug/box/releases)から手動でダウンロードできます。

しかし、このインストーラは以下の確認を事前に行い、インストールの手助けをするための代替的な方法を提供します。

- `box.phar` を実行するのに必要な最低限の要件をチェックします。（すべての要件をチェックするわけではありません。[Issue #4](https://github.com/KEINOS/Phar_Box3_installer/issues/4)をご覧ください）
- [本家のリリース・ページ](https://github.com/humbug/box/releases)より、**最新の「box.phar」をダウンロード**します。（https://github.com/humbug/box/releases）
- ダウンロードしたファイルのチェックサムを検証し、ファイルが壊れていないかどうか確認します。
- 起動可能な `Phar` であるか、簡単なテストを行います。
- ダウンロードしたファイルのアクセス権（実行権限）を変更します。

## How to

以下のワンライナーを実行して、カレント・ディレクトリに `box.phar` をインストールします。

```
$ curl -LSs https://keinos.github.io/Phar_Box3_installer/installer.php | php
```

![How to install box.phar via installer](https://keinos.github.io/Phar_Box3_installer/img/howto-install-20180427-0730.gif)

- インストーラのダウンロードURL
     - https://keinos.github.io/Phar_Box3_installer/installer.php
     - [チェックサム (MD5, SHA1, SHA256, SHA512)](https://keinos.github.io/Phar_Box3_installer/manifest.json)
     - [ソースコードを見る](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php)

## Boxとは

PHP の[「PHAR」エクステンション](http://php.net/manual/ja/intro.phar.php)を有効にすると、あなたのPHPアプリケーション全体を「PHAR」（PHPアーカイブ）と呼ばれる単一のファイル内に置くことができます。これにより、Java の「JAR」ファイルのように、簡単に配布およびインストールができるようになります。

「Box」（`box.phar`）は、この「.phar」ファイルを簡単に作成するのに役立つ、すばらしい PHP アプリケーションです。

## Box3？

「[Box3](https://github.com/humbug/box)」は、永らくメンテナンスされていない[「Box2」プロジェクト](https://github.com/box-project/box2)のフォークで、[humbug/box](https://github.com/humbug) Organization によって支えられています。

- Box2 プロジェクト： https://github.com/box-project/box2
- Box3 Organization： https://github.com/humbug/box

## このインストーラについて

このスクリプトは Box2 のインストーラのフォークで、Box3 用にカスタマイズされているものです。

- オリジナルのインストーラ
    https://github.com/box-project/box2/blob/gh-pages/installer.php

## クレジット

すべての称賛とクレジットは [Box3（humbug/box）のコラボレーター](https://github.com/humbug/box)にあります。