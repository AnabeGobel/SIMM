# 1. Escolher a imagem base
FROM php:8.2-fpm

# 2. Instalar dependências do sistema
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
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Instalar Node.js de forma mais estável para o Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

# 3. Definir diretório de trabalho
WORKDIR /var/www/html

# 4. Instalar Composer primeiro
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 5. COPIAR TUDO PRIMEIRO (Para o Artisan estar presente)
COPY . .

# 6. Agora instalar dependências do PHP (com o arquivo artisan já presente)
RUN composer install --no-dev --optimize-autoloader

# 7. Build do Vite (CSS e JS)
RUN npm install
RUN npm run build

# 8. Permissões de pastas (Essencial para o Laravel não dar erro 500)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Comando de Inicialização
# Removi as migrações daqui porque o banco pode não estar pronto no build.
# Vamos rodar os caches e o servidor.
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php -S 0.0.0.0:$PORT -t public