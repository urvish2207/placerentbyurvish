# ============================================================
# PlaceRent - Laravel Production Dockerfile
# Optimized for Google Cloud Run
# ============================================================

FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache

# Install Composer
COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer

# Configure Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite headers

# Configure PHP for production
RUN echo "opcache.enable=1\nopcache.memory_consumption=128\nopcache.interned_strings_buffer=8\nopcache.max_accelerated_files=4000\nopcache.revalidate_freq=2\nopcache.fast_shutdown=1" \
    > /usr/local/etc/php/conf.d/opcache.ini

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for layer caching)
COPY composer.json composer.lock ./

# Install PHP dependencies (no dev)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# Copy package files
COPY package.json package-lock.json ./

# Copy the entire application
COPY . .

# Copy pre-built assets (already built)
COPY public/build ./public/build

# Run Laravel post-install scripts
RUN composer run-script post-autoload-dump --no-interaction || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Create storage symlink
RUN php artisan storage:link || true

# Apache configuration for Cloud Run
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 8080 (Cloud Run expects this by default)
EXPOSE 8080

# Update Apache to listen on 8080
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf

# Create startup script that runs migrations then starts Apache
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
echo "==> Running Laravel optimizations..."\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
echo "==> Running database migrations..."\n\
php artisan migrate --force --no-interaction\n\
\n\
echo "==> Starting Apache..."\n\
apache2-foreground\n\
' > /startup.sh && chmod +x /startup.sh

CMD ["/startup.sh"]
