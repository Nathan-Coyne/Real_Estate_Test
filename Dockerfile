FROM php:8.1-fpm

# Install system dependencies and ICU development libraries
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql intl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHPUnit globally
RUN curl -L https://phar.phpunit.de/phpunit-10.1.phar -o /usr/local/bin/phpunit && \
    chmod +x /usr/local/bin/phpunit

# Set the working directory
WORKDIR /var/www/html/real-estate

# Copy your application code into the container
COPY ./api /var/www/html/

# Expose the port PHP-FPM is running on
EXPOSE 9002

# Default command to run the application
CMD ["php-fpm"]