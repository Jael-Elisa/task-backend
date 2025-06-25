FROM php:8.1-apache

# Instala las extensiones mysqli, pdo y pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]
