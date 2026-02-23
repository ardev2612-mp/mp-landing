# MaticPost Landing Page & Customer Dashboard

Repository ini berisi kode sumber untuk landing page MaticPost yang telah terintegrasi dengan Customer Dashboard. Aplikasi ini dibangun menggunakan Laravel.

## Persyaratan Server

- Docker & Docker Compose
- Git

## Cara Install / Deploy Pertama Kali (Server)

Karena aplikasi ini sekarang menggunakan Laravel (bukan lagi file statis HTML), Anda perlu membangun ulang container Docker agar PHP service berjalan.

1. **Masuk ke folder project di server:**

    ```bash
    cd /path/to/mp-landing
    ```

2. **Update kode terbaru:**

    ```bash
    git pull origin main
    ```

3. **Duplikasi file env dan sesuaikan:**

    ```bash
    cp .env.example .env
    nano .env
    ```

    _Pastikan konfigurasi database di `.env` sesuai dengan `docker-compose.yml` Anda._
    _Set `APP_ENV=production` dan `APP_DEBUG=false` untuk production._

4. **Jalankan Ulang Docker (PENTING):**
   Karena ada perubahan struktur dari static ke dynamic (PHP), Anda harus rebuild container:

    ```bash
    docker-compose down
    docker-compose up -d --build
    ```

5. **Install Dependencies & Setup Laravel:**
   Jalankan perintah ini di dalam container `app`:
    ```bash
    docker-compose exec app composer install --no-dev --optimize-autoloader
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan migrate --force
    docker-compose exec app php artisan storage:link
    docker-compose exec app php artisan config:cache
    docker-compose exec app php artisan route:cache
    docker-compose exec app php artisan view:cache
    ```

## Cara Update (Deploy Rutin)

Setiap kali ada perubahan kode (git pull), jalankan script deploy atau perintah berikut:

```bash
git pull origin main
docker-compose exec app composer install --no-dev
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan optimize
```

## Troubleshooting

Jika halaman error 500:

- Cek permission folder storage: `docker-compose exec app chmod -R 775 storage bootstrap/cache`
- Cek log laravel: `docker-compose exec app tail -f storage/logs/laravel.log`
