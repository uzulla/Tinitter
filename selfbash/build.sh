#!/bin/sh

cd ../

tar czf \
--exclude-vcs \
selfbash/ball.tgz \
htdocs \
lib \
templates \
vendor \
sqlite.db \
main.php \
config.php \
php

cd -

cat head.sh ball.tgz > selfbash.sh

chmod +x selfbash.sh