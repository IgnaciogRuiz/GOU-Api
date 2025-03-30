# Usa una imagen base de PHP
FROM php:8.1-apache

# Habilitar mod_rewrite (si lo necesitas)
RUN a2enmod rewrite

# Instalar extensiones necesarias de PHP
RUN docker-php-ext-install pdo pdo_mysql

# Copiar los archivos del proyecto a la carpeta adecuada
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80
