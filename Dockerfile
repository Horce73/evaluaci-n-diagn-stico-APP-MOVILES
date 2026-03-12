# ──────────────────────────────────────────────
# Stage 1: Build frontend assets (Node.js)
# ──────────────────────────────────────────────
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm install

COPY . .
RUN npm run build

# ──────────────────────────────────────────────
# Stage 2: PHP application
# ──────────────────────────────────────────────
FROM php:8.2-cli-alpine

LABEL maintainer="Laravel App"

# Install system dependencies and PHP extensions
# Note: mbstring, xml, bcmath, tokenizer, ctype, fileinfo, pdo are already
# compiled into the php:8.2-cli-alpine image. Only pdo_sqlite needs installing.
RUN apk add --no-cache \
        bash \
        curl \
        sqlite \
        sqlite-dev \
        zip \
        unzip \
    && docker-php-ext-install pdo_sqlite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install PHP dependencies (skip post-install scripts
# because artisan is not available yet at this stage)
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-scripts --no-interaction --no-progress

# Copy the rest of the application
COPY . .

# Copy built frontend assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Now run post-install scripts and optimise autoloader (artisan is available)
RUN composer dump-autoload --optimize --no-interaction

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Create SQLite database directory and fix permissions
RUN mkdir -p /var/www/html/database \
    && mkdir -p /var/www/html/storage/framework/{cache/data,sessions,testing,views} \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/database

EXPOSE 8000

ENTRYPOINT ["docker-entrypoint.sh"]
