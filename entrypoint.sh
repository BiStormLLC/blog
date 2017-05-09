#!/bin/bash

sed -i 's/*:80/*:8301/g' /etc/apache2/sites-available/000-default.conf
sed -i 's/Listen 80/Listen 8301/g' /etc/apache2/ports.conf

mv /tmp/* /var/www/html/
mv /tmp/.htaccess /var/www/html/

chown -R www-data:www-data .

rm -rf /var/www/html/wp-content/uploads
ln -s /media/uploads /var/www/html/wp-content/uploads

exec "$@"