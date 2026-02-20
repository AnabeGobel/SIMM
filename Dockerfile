# 1️⃣ Base: PHP + Apache
FROM php:8.2-apache

# 2️⃣ Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libzip-dev nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite

# 3️⃣ Diretório de trabalho
WORKDIR /var/www/html

# 4️⃣ Copiar todo o projeto Laravel
COPY . .

# 5️⃣ Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6️⃣ Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Instalar dependências Node.js e build dos assets
RUN npm install
RUN npm run build

# 8️⃣ Ajustar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9️⃣ Variáveis de ambiente Railway (opcional)
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_KEY=base64:COLOQUE_SUA_CHAVE_AQUI

# 1️⃣0️⃣ Expor porta padrão do Apache
EXPOSE 80

# 1️⃣1️⃣ Comando para rodar Apache
CMD ["apache2-foreground"]