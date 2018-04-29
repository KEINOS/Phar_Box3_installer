# Installer for Box3 (humbug/box).

It downloads the latest "box.phar" (The PHP archiver) from the latest release at https://github.com/humbug/box/releases .

## How to

Run the one-liner below to install `box.phar` to your current directory.

```
$ curl -LSs https://keinos.github.io/Phar_Box3_installer/installer.php | php
```

![How to install box.phar via installer](https://keinos.github.io/Phar_Box3_installer/img/howto-install-20180427-0730.gif)

- Installer download url
     - https://keinos.github.io/Phar_Box3_installer/installer.php
     - [Checksums (MD5, SHA1, SHA256, SHA512)](https://keinos.github.io/Phar_Box3_installer/manifest.json)
     - [View source](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php)

## What it does

- It checks the environment before download.<br>(Such as PHP's ver, extension and PHP.ini settings)
- It downloads the latest `box.phar`.
- It checks if valid Phar.
- Changes mode as executable.

## About Box3

- Box3 is a fork of the unmaintained Box2 project.
- Box3 is mantained by [humbug/box](https://github.com/humbug) organization.

    - Box2 project: https://github.com/box-project/box2
    - Box3 organization: https://github.com/humbug/box

## About this installer

This script is a fork of Box2's installer and customized for Box3.

- Original installer

    https://github.com/box-project/box2/blob/gh-pages/installer.php

## Credits

All the effort and credit goes to [Box3 (humbug/box) collaborators](https://github.com/humbug/box).