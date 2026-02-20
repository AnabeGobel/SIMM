# 1. Escolher a imagem base com PHP 8.2 + Composer + Node
FROM php:8.2-fpm

# 2. Instalar dependências do sistema e extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    npm \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# 3. Definir diretório de trabalho
WORKDIR /var/www/html

# 4. Copiar apenas arquivos de dependências primeiro (otimização de build)
COPY composer.json composer.lock ./

# 5. Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6. Instalar dependências do PHP
RUN composer install --no-dev --optimize-autoloader

# 7. Copiar todo o projeto
COPY . .

# 8. Instalar dependências do Node para assets (CSS, JS)
RUN npm install --production
RUN npm run build

# 9. Rodar caches e migrações
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan migrate --force

# 10. Expor porta (Railway vai mapear automaticamente)
EXPOSE 8080

# 11. Entrypoint
CMD ["php-fpm"]
CMD php -S 0.0.0.0:$PORT -t public


