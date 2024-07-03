#!/bin/bash

apt-get -y update
apt-get -y install libapache2-mod-php php php-cli

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer

composer require firewallforce/kc-web-app-php
composer require promphp/prometheus_client_php
composer require jenssegers/agent

# Config Files owners
chown -R www-data:www-data /var/www/html
# chmod -R 777 /var/www/html/logs

# Start Apache
exec apachectl -DFOREGROUND
