#!/bin/bash

# Script Deploy Otomatis untuk MaticPost Landing Page
# Jalankan script ini di server production

echo "🚀 Memulai proses deploy..."

# 1. Pull kode terbaru
echo "📥 Mengambil kode terbaru dari git..."
git pull origin main

# 2. Rebuild container jika ada perubahan Dockerfile/docker-compose
# Uncomment baris di bawah jika Anda ingin selalu rebuild (lebih aman tapi lebih lama)
# docker-compose down
# docker-compose up -d --build

# Jika tidak rebuild, pastikan container berjalan
if [ ! "$(docker ps -q -f name=mp-landing-app)" ]; then
    echo "⚠️ Container tidak berjalan. Menjalankan docker-compose up..."
    docker-compose up -d --build
fi

# 3. Install dependencies
echo "📦 Menginstall dependencies (Composer)..."
docker-compose exec -T app composer install --no-dev --optimize-autoloader

# 4. Run Migrations
echo "🗄️ Menjalankan migrasi database..."
docker-compose exec -T app php artisan migrate --force

# 5. Clear & Cache Config
echo "🧹 Membersihkan dan cache konfigurasi..."
docker-compose exec -T app php artisan optimize
docker-compose exec -T app php artisan view:cache

# 6. Storage Link (Ensure it exists)
echo "🔗 Membuat storage link..."
docker-compose exec -T app php artisan storage:link

echo "✅ Deploy selesai! Aplikasi siap digunakan."
