FROM plurish/server:latest

RUN apt-get install -y --no-install-recommends vim & \
    npm i -g yarn & \
    pecl install xdebug && docker-php-ext-enable xdebug

WORKDIR /var/www

COPY ./ ./

RUN chmod 777 /var/www /var/www/yarn.lock /var/www/public

USER dev

# Installing dependencies
RUN composer install & yarn
RUN composer clear-cache & yarn cache clean

# Starting the app
COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

CMD ["bash", "./init.sh"]