[English][[日本語](README_JA.md)][[Español](README_ES.md)]

---

# Easy Installer For Box3 (humbug/box).

A script that downloads and install the PHP Archiver "Box3" (`box.phar`) by [humbug/box](https://github.com/humbug/box).

This script does the following:

1. It checks the minimum requirements to run `box.phar`. (It does not check all the requirements. See [Issue #4](https://github.com/KEINOS/Phar_Box3_installer/issues/4))
2. It **downloads the latest "box.phar"** from the [head family's releases page](https://github.com/humbug/box/releases).<br>(At https://github.com/humbug/box/releases)
3. It validates the checksum to check if the downloaded file is not corrupted.
4. It creates an instance of Phar as a test.
5. It tries to change the mode executable.

- Of course you can download it from [humbug/box's releases page](https://github.com/humbug/box/releases) directly.

**To install Box3**, just run the one-liner below. It will install `box.phar` to your current directory.

```bash
curl -LSs https://keinos.github.io/Phar_Box3_installer/installer.php | php
```

![How to install box.phar via installer](https://keinos.github.io/Phar_Box3_installer/img/howto-install-20180427-0730.gif)

## Basic info

- **Download:** https://keinos.github.io/Phar_Box3_installer/installer.php
    - **%HASH_ALGO_UPPER%:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.%HASH_ALGO%
    - **Signature:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php.sig [[?](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/HowToVerifySignature.md)]
- **Source code:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php
- **Manifest:** https://keinos.github.io/Phar_Box3_installer/manifest.json
    - **%HASH_ALGO_UPPER%:** https://github.com/KEINOS/Phar_Box3_installer/blob/gh-pages/manifest.json.%HASH_ALGO%
    - **Signature:** https://github.com/KEINOS/Phar_Box3_installer/blob/gh-pages/manifest.json.sig [[?](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/HowToVerifySignature.md)]

## Secure way to download (recommended)

**NOTE**: Please do not redistribute the install code below. It **will change with every version** of the installer. Instead, please link to [this page](https://github.com/KEINOS/Phar_Box3_installer).

```bash
%SCRIPT_INSTALL%
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
