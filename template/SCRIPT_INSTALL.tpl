php -r "copy('%URL_DOWNLOAD%', '%NAME_INSTALLER%');"
php -r "if (hash_file('%HASH_ALGO%', '%NAME_INSTALLER%') === '%HASH_INSTALLER%') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('%NAME_INSTALLER%'); } echo PHP_EOL;"
php %NAME_INSTALLER%
php -r "unlink('%NAME_INSTALLER%');"
