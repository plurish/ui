FROM plurish/server:latest

RUN apt-get install -y --no-install-recommends vim & \
    npm i -g yarn & \
    pecl install xdebug && docker-php-ext-enable xdebug

WORKDIR /var/www

COPY ./ ./

# Creating dev user
RUN groupadd --force -g 1000 dev
RUN useradd -ms /bin/bash --no-user-group -g 1000 -u 1000 dev
RUN chmod 777 /var/www /var/www/yarn.lock

USER dev

# Installing dependencies
RUN composer install & yarn
RUN composer clear-cache & yarn cache clean

# Starting the app
COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

CMD ["bash", "./init.sh"]