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

LaraFlare adalah aplikasi manajemen DNS berbasis Laravel yang terintegrasi dengan Cloudflare API. Dengan antarmuka yang modern dan intuitif, LaraFlare memudahkan Anda mengelola DNS records untuk semua domain Cloudflare Anda dalam satu dashboard.

## ✨ Fitur yang Tersedia

- 🔥 Manajemen DNS Record (A, AAAA, CNAME, TXT, MX)
- 🚀 Real-time DNS Updates
- 🔒 Integrasi dengan Cloudflare API
- 📊 Dashboard Domain Analytics
- 🌐 Multi-domain Support
- 📱 Responsive Design
- 🎨 Modern UI dengan Tailwind CSS
- ⚡ SweetAlert2 Notifications

## 📋 Persyaratan

- PHP >= 8.1
- Laravel 10.x
- Composer
- Cloudflare API Token
- Node.js & NPM (untuk development)

## 🛠️ Instalasi

1. Clone repository
```bash
git clone https://github.com/mjaya69703/laraflare.git
```

2. Install dependencies
```bash
composer install
```

3. Copy file environment
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Konfigurasi Cloudflare API di file .env
```bash
CLOUDFLARE_API_TOKEN=your_api_token
CLOUDFLARE_EMAIL=your_email
```

6. Jalankan aplikasi
```bash
php artisan serve
```

## 💡 Penggunaan

1. **Setup API Token**
   - Generate API Token di [Cloudflare Dashboard](https://dash.cloudflare.com/profile/api-tokens)
   - Tambahkan token ke file .env

2. **Manajemen DNS Records**
   - Lihat semua domain
   - Tambah record baru (A, AAAA, CNAME, TXT, MX)
   - Edit record yang ada
   - Hapus record
   - Toggle Proxy Status

3. **Fitur Tambahan**
   - Real-time status update
   - Validasi input otomatis
   - Konfirmasi aksi dengan SweetAlert
   - Responsive pada semua device

## 🎨 Teknologi yang Digunakan

- Laravel 12
- Tailwind CSS
- Alpine.js
- SweetAlert2
- Cloudflare API v4

## 📝 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE.md).

## 🙏 Credit

Dibuat dengan ❤️ menggunakan:
- [Laravel](https://laravel.com)
- [Cloudflare API](https://api.cloudflare.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [SweetAlert2](https://sweetalert2.github.io)

## 📧 Kontak & Kontribusi

Jika Anda menemukan bug atau memiliki saran pengembangan, silakan buat issue atau pull request di repository ini.

- Issues: [GitHub Issues](https://github.com/mjaya69703/laraflare/issues)
