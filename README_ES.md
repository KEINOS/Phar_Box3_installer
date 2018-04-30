[[English](README.md)][[日本語](README_JA.md)][Español]

---

# Instalador para Box3 (humbug/box)


El Archivador de PHP "Box3" (`box.phar`) se puede descargar si mismo de forma manual desde la [página de lanzamiento](https://github.com/humbug/box/releases) en el [repositorio de humbug/box](https://github.com/humbug/box).

A pesar de ello, este instalador hace lo siguiente para ayudarlo y proporcionarle como una instalación alternativa.

- Comprueba los requisitos mínimos para ejecutar "`box.phar`". (No verifica todos los requisitos. Consulte el [asunto #4](https://github.com/KEINOS/Phar_Box3_installer/issues/4).)
- Se **descarga el más nuevo "`box.phar`"** des de la [página de lanzamiento](https://github.com/humbug/box/releases) de la cabeza de familia. (En https://github.com/humbug/box/releases)
- Valida la suma de comprobación (el "checksum") para verificar si el archivo descargado no está curvado.
- Se ejecuta si es un Phar válido.
- Intenta cambiar el modo ejecutable.

## Cómo

Ejecute el siguiente "one-liner" para instalar el `box.phar` en su directorio actual.

```
$ curl -LSs https://keinos.github.io/Phar_Box3_installer/installer.php | php
```

![How to install box.phar via installer](https://keinos.github.io/Phar_Box3_installer/img/howto-install-20180427-0730.gif)

-  Información y URL de descarga del instalador
     - https://keinos.github.io/Phar_Box3_installer/installer.php
     - [Suma de verificación (MD5, SHA1, SHA256, SHA512)](https://keinos.github.io/Phar_Box3_installer/manifest.json)
     - [Ver código fuente](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php)

## ¿Qué es Box?

Si la [extensión "PHAR" de PHP](http://php.net/manual/es/intro.phar.php) está habilitado, puede poner todo sus aplicaciones PHP en un solo archivo llamado "PHAR" (Archivo de PHP) para proporcionar una fácil distribución e instalación. Como un archivo de "JAR" en Java.

"Box" (`box.phar`) es una asombrosa aplicación de PHP para ayudarle a crear ese archivo ".phar" mucho más fácilmente.

## ¿Box3?

"[Box3](https://github.com/humbug/box)" es una bifurcación del [proyecto de Box2](https://github.com/box-project/box2) sin mantenimiento. Ahora mantenido por la organización [humbug/box](https://github.com/humbug) en GitHub.

- Proyecto Box2: https://github.com/box-project/box2
- Organización Box3: https://github.com/humbug/box

## Acerca de este instalador

Este script es un bifurcación del instalador de Box2 y personalizado para Box3.

- Instalador original

    https://github.com/box-project/box2/blob/gh-pages/installer.php

## Créditos

Todo el esfuerzo y el crédito van a [los colaboradores de Box3 (humbug/box)](https://github.com/humbug/box).


