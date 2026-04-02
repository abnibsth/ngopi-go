# Midtrans Payment Integration - NgopiGo

## Konfigurasi Midtrans

Midtrans telah dikonfigurasi dengan kredensial berikut:

- **Merchant ID**: G091529286
- **Client Key**: SB-Mid-client-DP1_x_7wqlAVWgyb
- **Server Key**: SB-Mid-server-O9qrYLyIraaizmXSmt_WQqWS
- **Mode**: Sandbox (Testing)

## File yang Diubah/Dibuat

### 1. Environment Variables (`.env`)
```
MIDTRANS_MERCHANT_ID=G091529286
MIDTRANS_CLIENT_KEY=SB-Mid-client-DP1_x_7wqlAVWgyb
MIDTRANS_SERVER_KEY=SB-Mid-server-O9qrYLyIraaizmXSmt_WQqWS
MIDTRANS_IS_PRODUCTION=false
```

### 2. Config (`config/services.php`)
Ditambahkan konfigurasi Midtrans:
```php
'midtrans' => [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
],
```

### 3. Midtrans Service (`app/Services/MidtransService.php`)
Service untuk komunikasi dengan Midtrans API:
- `createSnapToken()` - Membuat token untuk Snap popup
- `getTransactionStatus()` - Cek status transaksi
- `getClientKey()` - Mendapatkan client key untuk Snap JS

### 4. Order Controller (`app/Http/Controllers/OrderController.php`)
Ditambahkan method:
- `payment()` - Menampilkan halaman pembayaran
- `midtransCallback()` - Handle notification dari Midtrans

### 5. Routes (`routes/web.php`)
Ditambahkan routes:
- `GET /pembayaran/{order}/{snapToken}` - Halaman pembayaran
- `POST /midtrans/callback` - Webhook callback dari Midtrans

### 6. Payment View (`resources/views/customer/payment.blade.php`)
Halaman pembayaran dengan Midtrans Snap popup

## Cara Kerja

1. **Customer memilih "Bayar Online"** saat checkout
2. **Order dibuat** dengan status `pending`
3. **Snap token dibuat** oleh server menggunakan Midtrans API
4. **Customer diarahkan** ke halaman pembayaran
5. **Customer klik "Bayar Sekarang"** - Snap popup terbuka
6. **Customer memilih metode pembayaran** (Transfer Bank, E-Wallet, QRIS, dll)
7. **Midtrans memproses pembayaran**
8. **Callback diterima** - Status order diupdate otomatis

## Metode Pembayaran yang Tersedia

- ✅ Credit Card (Visa, Mastercard, JCB)
- ✅ GoPay
- ✅ ShopeePay
- ✅ QRIS
- ✅ Virtual Accounts (BCA, BNI, BRI, Mandiri, Permata, CIMB)
- ✅ Indomaret & Alfamart
- ✅ Mandiri Bill

## Testing

### Sandbox Environment
Karena menggunakan mode Sandbox, semua transaksi adalah **simulasi**:

**Test Credit Cards:**
- 4811 1111 1111 1114 (Visa)
- 5211 1111 1111 1117 (Mastercard)
- CVV: 123
- Exp: 12/2030

**Test GoPay:**
- Gunakan nomor HP: 08111222333
- PIN: 123123

### Callback Testing
Untuk testing webhook di localhost, gunakan ngrok:
```bash
ngrok http 8000
```
Kemudian daftarkan URL ngrok ke Midtrans Dashboard:
Settings > Configuration > Payment Notification URL

## Update Status Order

| Status Midtrans | Status Order |
|----------------|--------------|
| pending | pending |
| settlement | preparing |
| capture | preparing |
| deny | cancelled |
| expire | cancelled |
| cancel | cancelled |

## Troubleshooting

### Snap tidak muncul
- Pastikan Client Key benar
- Cek koneksi internet
- Buka console browser untuk error

### Callback tidak diterima
- Pastikan server dapat diakses publik (gunakan ngrok untuk localhost)
- Daftarkan URL callback ke Midtrans Dashboard
- Cek log untuk error

### Payment gagal
- Cek kredensial di Midtrans Dashboard
- Pastikan mode Sandbox/Production sesuai
- Verifikasi signature key

## Keamanan

- ✅ Signature key verification untuk callback
- ✅ Server key hanya di server (tidak di-expose ke client)
- ✅ HTTPS required untuk production
- ✅ Order validation sebelum proses payment

## Production Deployment

Sebelum go-live ke production:

1. Ganti ke **Production Keys** dari Midtrans Dashboard
2. Set `MIDTRANS_IS_PRODUCTION=true`
3. Daftarkan **Production Callback URL**
4. Test dengan **real payment** (amount kecil)
5. Enable **Security Settings** di Midtrans Dashboard

## Support

- Midtrans Documentation: https://docs.midtrans.com
- Midtrans Support: support@midtrans.com
- Sandbox Dashboard: https://dashboard.sandbox.midtrans.com
