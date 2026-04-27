# NgopiGo

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

**Sistem Pemesanan Restoran & Cafe Modern**

</div>

---

## 📖 Tentang Project

**NgopiGo** adalah sistem manajemen pemesanan untuk restoran dan cafe yang dibangun menggunakan **Laravel 13**. Aplikasi ini memungkinkan pelanggan untuk memesan menu langsung dari meja, memilih metode pembayaran (COD atau QRIS/Midtrans), dan memantau status pesanan secara real-time.

### ✨ Fitur Utama

- 🛒 **Pemesanan Mandiri** - Pelanggan bisa order langsung dari meja
- 💳 **Multi Payment** - COD (Bayar di Tempat) & QRIS (Midtrans)
- 📱 **Responsive Design** - Tampilan optimal untuk mobile dan desktop
- 👨‍🍳 **Kitchen Display** - Dapur bisa lihat pesanan yang perlu disiapkan
- 👤 **Admin Dashboard** - Kasir dan manager bisa manage orders
- 🔔 **Real-time Status** - Update status: Pending → Preparing → Ready → Completed
- 📊 **Order History** - Riwayat pesanan selesai dan dibatalkan
- 🖨️ **Cetak Struk** - Generate struk untuk setiap pesanan

---

## 🔄 Flow Pemesanan

Berikut adalah alur lengkap sistem pemesanan di NgopiGo:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                         FLOW PEMESANAN NGOPIGO                              │
└─────────────────────────────────────────────────────────────────────────────┘

    ┌──────────────┐
    │   CUSTOMER   │
    │  Melihat     │
    │    Menu      │
    └──────┬───────┘
           │
           ▼
    ┌──────────────┐
    │   CUSTOMER   │
    │  Membuat     │
    │   Pesanan    │
    │  (Pilih Menu │
    │   + Jumlah)  │
    └──────┬───────┘
           │
           ▼
    ┌──────────────────────────────┐
    │      PILIH METODE BAYAR      │
    └──────────────┬───────────────┘
                   │
        ┌──────────┴──────────┐
        │                     │
        ▼                     ▼
┌───────────────┐     ┌───────────────┐
│     COD       │     │    ONLINE     │
│ (Bayar di     │     │  (QRIS/       │
│  Tempat)      │     │   Midtrans)   │
└───────┬───────┘     └───────┬───────┘
        │                     │
        ▼                     ▼
┌───────────────┐     ┌───────────────┐
│   Order       │     │   Order       │
│   Status:     │     │   Status:     │
│   PENDING     │     │   PENDING     │
│   Payment:    │     │   Payment:    │
│   PENDING     │     │   PENDING     │
└───────┬───────┘     └───────┬───────┘
        │                     │
        │                     ▼
        │             ┌───────────────┐
        │             │   Customer    │
        │             │   Bayar via   │
        │             │  Midtrans UI  │
        │             └───────┬───────┘
        │                     │
        │                     ▼
        │             ┌───────────────┐
        │             │   Payment     │
        │             │   Success     │
        │             │   (Auto)      │
        │             └───────┬───────┘
        │                     │
        ▼                     ▼
    ┌─────────────────────────────┐
    │         KASIR SCAN          │
    │    QR Code di HP Customer   │
    │    (Konfirmasi Pembayaran)  │
    └──────────────┬──────────────┘
                   │
                   ▼
    ┌─────────────────────────────┐
    │      KASIR KONFIRMASI       │
    │   "Bayar di Tempat" / Lunas │
    │   Status: PENDING → PAID    │
    └──────────────┬──────────────┘
                   │
                   ▼
    ┌─────────────────────────────┐
    │        KITCHEN/DAPUR        │
    │   Lihat pesanan masuk       │
    │   Status: PAID              │
    └──────────────┬──────────────┘
                   │
                   ▼
    ┌─────────────────────────────┐
    │        KITCHEN/DAPUR        │
    │   Siapkan Pesanan           │
    │   Status: PAID → PREPARING  │
    └──────────────┬──────────────┘
                   │
                   ▼
    ┌─────────────────────────────┐
    │        KITCHEN/DAPUR        │
    │   Pesanan Selesai           │
    │   Status: PREPARING → READY │
    └──────────────┬──────────────┘
                   │
                   ▼
    ┌─────────────────────────────┐
    │      CUSTOMER Menerima      │
    │         Pesanan             │
    └──────────────┬──────────────┘
                   │
                   ▼
    ┌─────────────────────────────┐
    │         KASIR/KITCHEN       │
    │   Tandai Selesai            │
    │   Status: READY → COMPLETED │
    └─────────────────────────────┘


    ┌─────────────────────────────────────────────────────────────────────────┐
    │                         STATUS ORDER                                    │
    │                                                                         │
    │   PENDING ──→ PAID ──→ PREPARING ──→ READY ──→ COMPLETED               │
    │      │                              │                                   │
    │      └──────────→ CANCELLED ←───────┘                                   │
    └─────────────────────────────────────────────────────────────────────────┘
```

### 📝 Penjelasan Flow

#### 1. **Customer Melihat Menu** 👀
- Customer mengakses halaman pemesanan melalui QR code di meja atau link langsung
- Sistem menampilkan daftar menu yang tersedia (dikelompokkan per kategori)
- Hanya produk yang `is_available = true` yang ditampilkan

#### 2. **Customer Membuat Pesanan** 📝
- Customer memilih menu dan jumlah yang diinginkan
- Mengisi informasi:
  - Nomor meja
  - Nama customer
  - Nomor telepon
  - Catatan tambahan (optional)
- Memilih metode pembayaran: **COD** atau **Online (QRIS)**

#### 3. **Pilih Metode Bayar** 💰

**A. COD (Bayar di Tempat):**
- Order langsung dibuat dengan status `PENDING` dan `payment_status = PENDING`
- Customer menunggu konfirmasi kasir

**B. Online (QRIS/Midtrans):**
- Sistem membuat Midtrans Snap Token
- Customer diarahkan ke halaman pembayaran Midtrans
- Customer scan QRIS atau pilih metode pembayaran lain (GoPay, OVO, ShopeePay, Credit Card, dll)
- Setelah bayar, Midtrans kirim callback → status otomatis update jadi `PAID`

#### 4. **Kasir Scan QR & Konfirmasi** 📱
- Customer menunjukkan QR code/order number ke kasir
- Kasir scan QR code dari HP customer
- Kasir konfirmasi pembayaran (terutama untuk COD)
- Status berubah: `PENDING` → `PAID`

#### 5. **Kitchen/Dapur Menerima Pesanan** 👨‍🍳
- Pesanan muncul di **Kitchen Display**
- Hanya pesanan dengan `payment_status = PAID` yang ditampilkan
- Dapur mulai menyiapkan pesanan

#### 6. **Kitchen Update Status** 🔄
- Dapur update status pesanan:
  - `PENDING` → `PREPARING` (sedang dibuat)
  - `PREPARING` → `READY` (siap disajikan)
  - `READY` → `COMPLETED` (sudah diterima customer)

#### 7. **Customer Menerima Pesanan** ✅
- Customer menerima pesanan yang sudah READY
- Proses selesai ketika status `COMPLETED`

---

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
