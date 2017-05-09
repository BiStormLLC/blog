FROM wordpress:apache
MAINTAINER BiStormLLC <info@bistorm.org>

COPY entrypoint.sh /entrypoint.sh
RUN chmod 777 /entrypoint.sh

COPY ./wp /tmp
COPY ./wp/.htaccess /tmp

ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]