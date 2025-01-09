# Use an official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    curl \
    && docker-php-ext-install zip pdo_pgsql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the Apache DocumentRoot to public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy SSL certificate for Supabase
COPY certificates/root.crt /etc/ssl/certs/root.crt

# Copy Laravel application to the container
COPY . /var/www/html

# Copy .env file
COPY .env .env

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache

# Enable error reporting for debugging
RUN echo "display_errors = On" > /usr/local/etc/php/conf.d/display-errors.ini
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/display-errors.ini

# No need to generate key since it's already in .env
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 80

CMD ["apache2-foreground"]