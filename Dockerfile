# 1. Imagem base
FROM php:8.2-fpm

# 2. Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libonig-dev libpng-dev \
    libjpeg-dev libfreetype6-dev zip \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# 3. INSTALAR NODE.JS (Necessário para o Vite compilar o CSS)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# 4. Diretório de trabalho
WORKDIR /var/www/html

# 5. Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6. Copiar arquivos do projeto (Vem ANTES do composer install para ter o arquivo artisan)
COPY . .

# 7. Instalar dependências do PHP
RUN composer install --no-dev --optimize-autoloader

# 8. COMPILAR CSS/JS COM VITE
# Isso resolve o problema do site vir "sem estilo"
RUN npm install && npm run build

# 9. Permissões (Evita erro 500)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Porta e Comando de Inicialização (Usando técnica para evitar erro de string/int)
ENV PORT=8080
EXPOSE 8080

CMD sh -c "php artisan migrate --force && php artisan db:seed --class=UsuariosSeeder --force && php -S 0.0.0.0:8080 -t public"