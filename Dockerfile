FROM php:8.2-cli

WORKDIR /app

COPY . .

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer dépendances frontend
RUN npm install

# Build Vite/Tailwind
RUN npm run build

# Permissions
RUN chmod -R 775 storage bootstrap/cache

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT