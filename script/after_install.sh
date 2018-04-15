#!/bin/sh

cd /Tinitter
php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
php composer.phar install

cp config.php.sample config.php
sqlite3 sqlite.db < schema.sqlite3.sql

cd /Tinitter/htdocs
cp .htaccess.sample .htaccess

chown -R apache:apache /Tinitter
chmod 777 /Tinitter/sqlite.db

