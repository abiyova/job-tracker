FROM webdevops/php-nginx:8.2

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

RUN cp .env.example .env || true

RUN php artisan key:generate --force

RUN php artisan storage:link || true

RUN chown -R application:application storage bootstrap/cache

EXPOSE 8080