FROM romeoz/docker-apache-php:7.3

ENV APACHE_CONF_DIR=/etc/apache2 \
    PHP_CONF_DIR=/etc/php/7.3 \
    PHP_DATA_DIR=/var/lib/php 

COPY ./configuration/php7conf/uploads.ini ${PHP_CONF_DIR}/apache2/conf.d/custom.ini
COPY ./configuration/prefox.conf ${APACHE_CONF_DIR}/mods-enabled/mpm_prefork.conf
COPY ./configuration/app.conf ${APACHE_CONF_DIR}/sites-enabled/app.conf
COPY ./configuration/apache2.conf ${APACHE_CONF_DIR}/apache2.conf

# APP 
COPY ./ /var/www/app/

RUN rm -rf /var/www/app/configuration
RUN chmod -R 755 /var/www/app
RUN chown www-data:www-data /var/www/app -Rf