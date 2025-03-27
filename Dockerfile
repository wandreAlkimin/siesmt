# Use a imagem oficial do PHP com Apache
FROM php:8.3-apache

# Instale extensões necessárias para o Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Instale o Composer globalmente (usando a imagem do Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilite o mod_rewrite do Apache
RUN a2enmod rewrite

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos do projeto para o container
COPY . /var/www/html

# Instale as dependências do Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajuste as permissões (opcional, conforme necessidade)
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta 80
EXPOSE 80
