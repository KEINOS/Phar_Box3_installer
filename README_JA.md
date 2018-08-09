[[English](README.md)][日本語][[Español](README_ES.md)]

---

# 簡単 Box3 インストーラ（humbug/box）

[humbug/box](https://github.com/humbug/box) による PHP アーカイバー「Box3」（`box.phar`）のダウンロード／インストールするスクリプトです。

このスクリプトは以下を行います：

1. `box.phar` を実行するのに必要な最低限の要件をチェックします。（すべての要件をチェックするわけではありません。[Issue #4](https://github.com/KEINOS/Phar_Box3_installer/issues/4)をご覧ください）
2. [本家のリリース・ページ](https://github.com/humbug/box/releases)より、**最新の「box.phar」をダウンロード**します。（https://github.com/humbug/box/releases）
3. ダウンロードしたファイルのチェックサムを検証し、ファイルが壊れていないかどうか確認します。
4. 起動可能な `Phar` であるか、簡単なテストを行います。
5. ダウンロードしたファイルのアクセス権（実行権限）を変更します。

- もちろん本家 [humbug/box のリリースページ](https://github.com/humbug/box/releases)から直接ダウンロードできます。

**Box3 のインストール**は単純に以下のワンライナーを実行するだけです。カレント・ディレクトリに `box.phar` がインストールされます。

```bash
curl -LSs https://keinos.github.io/Phar_Box3_installer/installer.php | php
```

![How to install box.phar via installer](https://keinos.github.io/Phar_Box3_installer/img/howto-install-20180427-0730.gif)

## 基本情報

- **Download:** https://keinos.github.io/Phar_Box3_installer/installer.php
    - **SHA256:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.sha256
    - **電子署名:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php.sig [[?](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/HowToVerifySignature.md)]
- **Source code:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php
- **Manifest:** https://keinos.github.io/Phar_Box3_installer/manifest.json
    - **SHA256:** https://github.com/KEINOS/Phar_Box3_installer/blob/gh-pages/manifest.json.sha256
    - **電子署名:** https://github.com/KEINOS/Phar_Box3_installer/blob/gh-pages/manifest.json.sig [[?](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/HowToVerifySignature.md)]

## 安全なダウンロード方法 （推奨）

**注意**：以下のインストールコードを再配布しないでください。インストーラの**バージョン毎に変更されます**。代わりに、[このページ](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/README_JA.md)にリンクしてください。

```bash
php -r "copy('https://keinos.github.io/Phar_Box3_installer/installer.php', 'installer.php');"
php -r "if (hash_file('sha256', 'installer.php') === '88ea16a2abfa275a380d61d785108ddefa6e6fd869b92e23f494316d250360c8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('installer.php'); } echo PHP_EOL;"
php installer.php
php -r "unlink('installer.php');"
```

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
