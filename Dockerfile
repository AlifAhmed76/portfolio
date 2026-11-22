FROM richarvey/nginx-php-fpm:3.1.6

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Environment for Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install composer production dependencies during build
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction && \
    php artisan storage:link || true

# Image and PHP-FPM Configuration
ENV WEBROOT=/var/www/html/public
ENV SKIP_COMPOSER=1
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Laravel Production Defaults
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

CMD ["/start.sh"]
