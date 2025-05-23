FROM plurish/server:latest

ENV APP_ENV=prod

RUN apt-get install -y --no-install-recommends vim & \
    npm i -g yarn

WORKDIR /var/www

COPY ./ ./

RUN chmod 777 /var/www /var/www/yarn.lock /var/www/public

USER dev

# Installing dependencies
RUN composer install --no-dev --optimize-autoloader & yarn
RUN yarn build

# Starting the app
EXPOSE 8000

ENTRYPOINT ["symfony", "server:start"]