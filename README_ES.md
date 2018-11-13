[[English](README.md)][[日本語](README_JA.md)][Español]

---

# Instalador fácil de Box3 (humbug/box)

Este es un script que descarga e instala el "Box3" (`box.phar`), el archivador de PHP, hecho por [humbug/box](https://github.com/humbug/box).

Este script hace lo siguiente:

1. Comprueba los requisitos mínimos para ejecutar "`box.phar`". (No verifica todos los requisitos. Consulte el [asunto #4](https://github.com/KEINOS/Phar_Box3_installer/issues/4).)
2. Se **descarga el más nuevo "`box.phar`"** des de la [página de lanzamiento](https://github.com/humbug/box/releases) de la cabeza de familia. (En https://github.com/humbug/box/releases)
3. Valida la suma de comprobación (el "checksum") para verificar si el archivo descargado no está curvado.
4. Se ejecuta si es un `Phar` válido.
5. Intenta cambiar el modo ejecutable.

- Por supuesto, puedes descargarlo desde su [página de lanzamiento](https://github.com/humbug/box/releases) directamente.

Para **instalar Box3**, simplemente ejecute el "one-liner" siguiente y instalará el `box.phar` en su directorio actual.

```bash
curl -LSs https://keinos.github.io/Phar_Box3_installer/installer.php | php
```

![How to install box.phar via installer](https://keinos.github.io/Phar_Box3_installer/img/howto-install-20180427-0730.gif)

## Información Básica

- **Descarga:** https://keinos.github.io/Phar_Box3_installer/installer.php
    - **SHA256:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.sha256
    - **Firma electrónica:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php.sig [[?](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/HowToVerifySignature.md)]
- **Código fuente:** https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/installer.php
- **Manifesto:** https://keinos.github.io/Phar_Box3_installer/manifest.json
    - **SHA256:** https://github.com/KEINOS/Phar_Box3_installer/blob/gh-pages/manifest.json.sha256
    - **Firma electrónica:** https://github.com/KEINOS/Phar_Box3_installer/blob/gh-pages/manifest.json.sig [[?](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/HowToVerifySignature.md)]

### Descargamiento en manera segura (recomendado)

**NOTA**: Por favor, no redistribuya el siguiente código de instalación. **Cambiará en cada versión** del instalador. En lugar, enlace a [esta página](https://github.com/KEINOS/Phar_Box3_installer/blob/Box3_installer/README_ES.md).

```bash
php -r "copy('https://keinos.github.io/Phar_Box3_installer/installer.php', 'installer.php');"
php -r "if (hash_file('sha256', 'installer.php') === 'f6684e8bd3f7b9aafb5b19fba68373bc0627c2ffcf09dbf513ad1ec673b793f8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('installer.php'); } echo PHP_EOL;"
php installer.php
php -r "unlink('installer.php');"
```

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


