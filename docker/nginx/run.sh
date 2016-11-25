#!/bin/bash
echo 'Waiting for DB and ES'
sleep 10
php composer.phar install --prefer-source

chmod -R 777 /code/app/cache
chmod -R 777 /code/app/logs

service php7.0-fpm start
service nginx start

app/console doctrine:schema:drop --force --no-interaction
app/console doctrine:schema:create
app/console hautelook:fixtures:load

tail -f /var/log/nginx/access.log