FROM php:8.2-fpm-bookworm AS buider

# Installing packages
RUN apt update && apt install -y \
    git \
    curl \
    zip \
    unzip \
    vim \
    libicu-dev \
    npm

RUN npm i -g n && n 20 && npm i -g npm@latest

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl

RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt install symfony-cli

# Creating dev user
RUN groupadd --force -g 1000 dev
RUN useradd -ms /bin/bash --no-user-group -g 1000 -u 1000 dev
RUN chown -hR dev:dev /var/www

USER dev

# Installing dependencies
WORKDIR /var/www
COPY ./ ./

RUN composer install 
# RUN npm i -g yarn && yarn

# Starting the app
CMD ["bash", "./init.sh"]