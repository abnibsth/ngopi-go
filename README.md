# NgopiGo

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

**Platform Transaksi Digital Modern**

</div>

---

## 📖 Tentang Project

NgopiGo adalah aplikasi berbasis web yang dibangun menggunakan **Laravel 13** dengan arsitektur modern. Project ini dirancang untuk mendukung transaksi digital dengan integrasi payment gateway **Midtrans**.

### ✨ Fitur Utama

- 🚀 **Laravel 13** - Framework PHP terbaru dengan performa optimal
- 💳 **Midtrans Integration** - Payment gateway untuk berbagai metode pembayaran
- 🎨 **Tailwind CSS v4** - Styling modern dan responsif
- ⚡ **Vite** - Build tool yang cepat untuk development
- 🗄️ **Database Agnostic** - Support SQLite, MySQL, PostgreSQL
- 🔐 **Session & Queue Management** - Robust session dan background job processing
- 🧪 **PHPUnit** - Testing framework untuk memastikan kualitas kode

## 🛠️ Tech Stack

| Backend | Frontend | Database | Payment |
|---------|----------|----------|---------|
| Laravel 13 | Tailwind CSS v4 | SQLite/MySQL | Midtrans |
| PHP 8.3+ | Vite | Redis (optional) | |

## 📋 Prerequisites

Pastikan sistem Anda telah terinstall:

- **PHP** >= 8.3
- **Composer** (Latest version)
- **Node.js** & **NPM**
- **Database** (SQLite/MySQL/PostgreSQL)
- **Git**

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/YOUR_USERNAME/NgopiGo.git
cd NgopiGo
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=sqlite
# Atau untuk MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=ngopigo
# DB_USERNAME=root
# DB_PASSWORD=
```

Untuk SQLite:

```bash
# Buat database SQLite
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate
```

### 5. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

## 🏃 Menjalankan Aplikasi

### Development Mode

Jalankan semua service (server, queue, logs, vite):

```bash
composer run dev
```

Atau jalankan manual:

```bash
# Terminal 1 - Laravel Server
php artisan serve

# Terminal 2 - Vite Dev Server
npm run dev

# Terminal 3 - Queue Worker (optional)
php artisan queue:work
```

### Production Mode

```bash
# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build assets
npm run build

# Gunakan production server (Nginx/Apache)
```

## 🧪 Testing

```bash
# Jalankan semua test
composer run test

# Atau
php artisan test
```

## 📦 Available Scripts

| Command | Description |
|---------|-------------|
| `composer run dev` | Jalankan development server dengan hot reload |
| `composer run build` | Build assets untuk production |
| `composer run test` | Jalankan test suite |
| `composer setup` | Setup lengkap (install, migrate, build) |

## 🔧 Midtrans Configuration

Project ini sudah terkonfigurasi dengan Midtrans Sandbox untuk development.

**Sandbox Credentials** (`.env`):
```env
MIDTRANS_MERCHANT_ID=G091529286
MIDTRANS_CLIENT_KEY=SB-Mid-client-DP1_x_7wqlAVWgyb
MIDTRANS_SERVER_KEY=SB-Mid-server-O9qrYLyIraaizmXSmt_WQqWS
MIDTRANS_IS_PRODUCTION=false
```

> ⚠️ **Penting**: Ganti dengan credential production Anda sebelum deploy!

## 📁 Project Structure

```
NgopiGo/
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Providers/
│   └── ...
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
├── tests/
└── ...
```

## 🤝 Contributing

Terima kasih telah mempertimbangkan untuk berkontribusi! Silakan:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## 📄 License

Project ini open-source dan dilisensikan di bawah [MIT License](LICENSE).

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework for Web Artisans
- [Midtrans](https://midtrans.com) - Payment Gateway Indonesia
- [Tailwind CSS](https://tailwindcss.com) - A Utility-First CSS Framework
- [Vite](https://vitejs.dev) - Next Generation Frontend Tooling

---

<div align="center">

**Dibuat dengan ❤️ menggunakan Laravel**

</div>
