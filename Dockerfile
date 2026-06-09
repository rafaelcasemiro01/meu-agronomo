FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev \
    libxml2-dev libsqlite3-dev sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite zip mbstring exif pcntl bcmath

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install --legacy-peer-deps
RUN npm run build
RUN php artisan storage:link
RUN mkdir -p database && touch database/database.sqlite

EXPOSE 8080
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080