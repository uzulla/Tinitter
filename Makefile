DOCROOT = htdocs/
DEV_SERVER_PORT = 8080
DEV_SERVER_LISTEN_IP = 127.0.0.1
PHP_PATH = php

# 開発環境準備系(主にローカル開発用)

dev-setup: composer.phar composer-install local-reset config.php

config.php:
	cp config.php.sample config.php

composer.phar:
	curl -sSfL -o composer-setup.php https://getcomposer.org/installer
	$(PHP_PATH) composer-setup.php --filename=composer.phar
	rm composer-setup.php

.PHONY: composer-install
composer-install: composer.phar
	$(PHP_PATH) composer.phar install

.PHONY: local-reset
local-reset:
	-rm sqlite.db
	cat schema.sqlite3.sql | sqlite3 sqlite.db

.PHONY: composer-dump-autoload-opt
composer-dump-autoload-opt:
	composer dump-autoload --optimize --no-dev

# for built in web server

# # ビルトインウェブサーバーの起動
.PHONY: start
start:
	$(PHP_PATH) -S $(DEV_SERVER_LISTEN_IP):$(DEV_SERVER_PORT) -t $(DOCROOT)


# uzulla作業用、全てが消えるので危険です。

.PHONY: uzulla-local-reset-all
uzulla-local-reset-all: local-reset
	find . | grep .DS_Store |xargs rm
	-rm composer.phar
	-rm sqlite.db
	-rm config.php
	-rm -r vendor/
	git status --ignored