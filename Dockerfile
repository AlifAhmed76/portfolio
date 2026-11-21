FROM richarvey/nginx-php-fpm:3.1.6

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Image and PHP-FPM Configuration
ENV WEBROOT=/var/www/html/public
ENV SKIP_COMPOSER=0
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV COMPOSER_ALLOW_SUPERUSER=1

# Laravel Production Defaults
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

CMD ["/start.sh"]
