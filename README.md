<p align="center">
<img src="https://raw.githubusercontent.com/cloudflare/cloudflare-brand/main/logo/cf-logo-v-rgb.png" width="400" alt="Cloudflare Logo">
</p>

<h1 align="center">LaraFlare</h1>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
<a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-10.x-red.svg" alt="Laravel Version"></a>
<a href="https://cloudflare.com"><img src="https://img.shields.io/badge/Cloudflare-API-orange.svg" alt="Cloudflare API"></a>
</p>

## 🚀 Tentang LaraFlare

LaraFlare adalah aplikasi manajemen DNS berbasis Laravel yang powerful untuk mengelola domain Anda di Cloudflare melalui API. Dengan antarmuka yang intuitif dan fitur-fitur canggih, LaraFlare membuat pengelolaan DNS menjadi lebih mudah dan efisien.

## ✨ Fitur Utama

- 🔥 Manajemen DNS Record secara Real-time
- 🔒 Integrasi Penuh dengan Cloudflare API
- 📊 Dashboard Analytics yang Informatif
- 🔄 Bulk Update DNS Records
- 👥 Multi-user Management
- 🎯 Zone Management
- 📱 Responsive Design
- 🌐 Multi-domain Support

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Laravel 10.x
- Composer
- Cloudflare API Token
- MySQL/PostgreSQL

## 🛠️ Instalasi

1. Clone repository:
   ```bash
   git clone https://github.com/yourusername/laraflare.git
   cd laraflare
   ```
2. Masuk ke direktori project
   ```bash
   cd laraflare
   ```
3. Install dependencies
   ```bash
   composer install
   ```
4. Copy file environment
   ```bash
   cp .env.example .env
   ```
5. Generate application key
   ```bash
   php artisan key:generate
   ```
6. Konfigurasi database dan Cloudflare API di file .env
   ```bash
   CLOUDFLARE_API_TOKEN=your_api_token
   CLOUDFLARE_EMAIL=your_email
   ```
7. Jalankan migrasi
   ```bash
   php artisan migrate
   ```
8. Jalankan aplikasi
   ```bash
   php artisan serve
   ```

## 🤝 Kontribusi

Kontribusi selalu diterima dengan senang hati! Silakan buat pull request atau laporkan issues.

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE.md).

## 🙏 Credit

Dibuat dengan ❤️ menggunakan [Laravel](https://laravel.com) dan [Cloudflare API](https://api.cloudflare.com).

## 📧 Kontak

Jika Anda memiliki pertanyaan atau masukan, silakan hubungi kami di:
- Email: your@email.com
- Issues: [GitHub Issues](https://github.com/username/laraflare/issues)
