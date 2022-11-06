FROM php:8.0

RUN php artisan migrate --force