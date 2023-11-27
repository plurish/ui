FROM node:20-bookworm-slim AS builder

WORKDIR /app
COPY ./ ./
RUN yarn
RUN yarn build

FROM php:8.2-fpm-bookworm

# Installing packages
RUN apt update && apt install -y \
    git \
    curl \
    zip \
    unzip \
    libicu-dev

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl

RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer \
    & curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
        && apt install symfony-cli

WORKDIR /var/www
COPY ./ ./

# Creating dev user
RUN groupadd --force -g 1000 dev
RUN useradd -ms /bin/bash --no-user-group -g 1000 -u 1000 dev
RUN chown -hR dev:dev /var/www

USER dev

# Installing dependencies + Clearing cache
RUN composer install --no-dev --optimize-autoloader

# Get the builded front-end code
COPY --from=builder /app/public/build /var/www/public/build

# Executing database migrations
# RUN yes | symfony console doctrine:migrations:migrate

# Starting the app
EXPOSE 8000
EXPOSE 9000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]