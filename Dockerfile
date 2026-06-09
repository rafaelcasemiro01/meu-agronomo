FROM webdevops/php-apache:8.2

ENV WEB_DOCUMENT_ROOT=/app/public
ENV PHP_DATE_TIMEZONE=America/Sao_Paulo

WORKDIR /app
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install --legacy-peer-deps
RUN npm run build
RUN mkdir -p database && touch database/database.sqlite
RUN php artisan storage:link
RUN php artisan migrate --force
RUN chown -R application:application /app/storage /app/bootstrap/cache /app/database