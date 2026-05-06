FROM php:8.4-apache

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer (so you don't have to do it every time)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install mysqli, pdo_mysql and curl extensions
RUN apt-get update && apt-get install -y libcurl4-openssl-dev default-libmysqlclient-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install mysqli pdo_mysql curl
RUN docker-php-ext-enable mysqli pdo_mysql curl

# Copy custom apache configuration if needed, or simply use default
# Enable mod_rewrite for nice URLs if needed
RUN a2enmod rewrite

# Change the document root to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
