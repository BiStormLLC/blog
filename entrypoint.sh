#!/bin/bash

mv /tmp/* /var/www/html/
mv /tmp/.htaccess /var/www/html/

chown -R www-data:www-data .

rm -rf /var/www/html/wp-content/uploads
ln -s /media/uploads /var/www/html/wp-content/uploads

exec "$@"