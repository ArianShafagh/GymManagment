FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli

# Copy custom apache configuration if needed, or simply use default
# Enable mod_rewrite for nice URLs if needed
RUN a2enmod rewrite

# Change the document root to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
