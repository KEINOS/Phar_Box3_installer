[English][[日本語](README_JA.md)][[Español](README_ES.md)]

---

# Installer for Box3 (humbug/box).

You can download the PHP Archiver "Box3" (`box.phar`) it self manually from the [humbug/box repository](https://github.com/humbug/box)'s [releases page](https://github.com/humbug/box/releases).

Though this installer does the following to help you and provide an alternative installation.

1. It checks the minimum requirements to run `box.phar`. (It does not check all the requirements. See [Issue #4](https://github.com/KEINOS/Phar_Box3_installer/issues/4))
2. It **downloads the latest "box.phar"** from the [head family's releases page](https://github.com/humbug/box/releases).<br>(At https://github.com/humbug/box/releases)
1. It validates the checksum to check if the downloaded file is not curropted.
3. It test run if it's a valid Phar.
4. It tries to change the mode executable.

## How to

- Installer download url
     - https://keinos.github.io/Phar_Box3_installer/installer.php
     - [Checksums (MD5, SHA1, SHA256, SHA512)](https://keinos.github.io/Phar_Box3_installer/manifest.json)
     - [View source](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php)

### Simple way

Run the one-liner below to install `box.phar` to your current directory.

```
$ curl -LSs https://keinos.github.io/Phar_Box3_installer/installer.php | php
```

![How to install box.phar via installer](https://keinos.github.io/Phar_Box3_installer/img/howto-install-20180427-0730.gif)

### Secure way (recommended)

```
php -r "copy('https://keinos.github.io/Phar_Box3_installer/installer.php', 'installer.php');"
php -r "if (hash_file('sha256', 'installer.php') === 'f51a5992fa057af5cbc99a8964a0183fcc8a838c33f8032f5689e4f736fcea25') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php installer.php
php -r "unlink('installer.php');"
```

## What is Box?

With a ["PHAR" extension](http://php.net/manual/en/intro.phar.php) enabled, you can put your entire PHP applications into a single file called a "PHAR" (PHP Archive) for easy distribution and installation. Like a "JAR" file in Java.

"Box" (`box.phar`) is an awesome PHP application to help you create that ".phar" file much more easily.

## Box3?

"[Box3](https://github.com/humbug/box)" is a fork of the unmaintained [Box2 project](https://github.com/box-project/box2). Mantained by The [humbug/box](https://github.com/humbug) organization.

- Box2 project: https://github.com/box-project/box2
- Box3 organization: https://github.com/humbug/box

## About this installer

This script is a fork of Box2's installer and customized for Box3.

- Original installer

    https://github.com/box-project/box2/blob/gh-pages/installer.php

## Credits

All the effort and credit goes to [Box3 (humbug/box) collaborators](https://github.com/humbug/box).
