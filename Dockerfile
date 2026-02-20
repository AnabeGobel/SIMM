# Usar PHP 8.2 com Apache
FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Ativar mod_rewrite do Apache
RUN a2enmod rewrite

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar composer e instalar dependências
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Copiar todo o projeto
COPY . .

# Instalar Node.js e dependências do front-end
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
RUN apt-get install -y nodejs
RUN npm install
RUN npm run build

# Dar permissão para storage e bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor porta 80
EXPOSE 80

# Rodar o Apache
CMD ["apache2-foreground"]