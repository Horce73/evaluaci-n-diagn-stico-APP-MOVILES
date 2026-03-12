#!/bin/bash
set -e

# ────────────────────────────────────────────────────────
# Laravel Docker Entrypoint
# ────────────────────────────────────────────────────────

echo "==> Preparando entorno Laravel..."

# Copiar .env si no existe
if [ ! -f ".env" ]; then
    echo "==> Copiando .env.example a .env..."
    cp .env.example .env
fi

# Generar APP_KEY si está vacía
if grep -q "^APP_KEY=$" .env; then
    echo "==> Generando APP_KEY..."
    php artisan key:generate --no-interaction
fi

# Crear el archivo de base de datos SQLite si no existe
DB_FILE="database/database.sqlite"
if [ ! -f "$DB_FILE" ]; then
    echo "==> Creando base de datos SQLite..."
    touch "$DB_FILE"
    chown www-data:www-data "$DB_FILE" 2>/dev/null || true
fi

# Asegurar que DB_CONNECTION sea sqlite en .env
if ! grep -q "^DB_CONNECTION=sqlite" .env; then
    sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
fi

# Ejecutar migraciones
echo "==> Ejecutando migraciones..."
php artisan migrate --force --no-interaction

# Limpiar y optimizar caché
echo "==> Optimizando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> ¡Listo! Iniciando servidor en http://0.0.0.0:8000"
exec php artisan serve --host=0.0.0.0 --port=8000
