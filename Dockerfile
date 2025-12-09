FROM php:8.3-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP (incluant pdo_mysql)
RUN docker-php-ext-install pdo_mysql pdo mbstring exif pcntl bcmath gd zip opcache

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail (doit correspondre au docker-compose)
WORKDIR /app

# Copier les fichiers de l'application
COPY . /app

# Installer les dépendances Symfony
RUN composer install --optimize-autoloader --no-interaction

# Créer les dossiers nécessaires et définir les permissions
RUN mkdir -p /app/var/cache /app/var/log /app/public/uploads/lieux && \
    chmod -R 777 /app/var && \
    chmod -R 777 /app/public/uploads

# Exposer le port PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]