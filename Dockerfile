FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões necessárias para o Laravel
RUN docker-php-ext-install pdo pdo_pgsql

# Instalar o Composer globalmente (usando a imagem do Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Ajustar o DocumentRoot para a pasta public do Laravel
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto para o container
COPY . /var/www/html

# Dependências do Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajuste de permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
