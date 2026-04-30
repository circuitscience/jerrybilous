FROM php:8.1-apache

# Install MySQL PDO extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY ./public /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html
