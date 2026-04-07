# ✅ FORMAT NOMOR PESANAN BARU - NgopiGo

## 📋 Perubahan Format Nomor Pesanan

### Format Lama:
```
ORD-5RJHNE  (Random string)
```

### Format Baru:
```
ORD-{meja}-{antrian}
ORD-01-003
```

---

## 🎯 Detail Format

### 1. **No. Pesanan** - `ORD-{meja}-{antrian}`

**Contoh:**
- `ORD-01-003` = Meja 1, Antrian ke-3
- `ORD-15-027` = Meja 15, Antrian ke-27

**Struktur:**
- `ORD` - Prefix tetap (Order)
- `01` - Nomor meja (2 digit, zero-padded)
- `003` - Nomor antrian hari ini (3 digit, zero-padded)

---

### 2. **No. Antrian**

Nomor antrian dihitung dari awal hari (000-999):
- Reset setiap hari (00:00:00)
- Format: 3 digit dengan leading zero

**Contoh:**
- Order pertama hari ini: `#001`
- Order ke-25: `#025`
- Order ke-156: `#156`

---

### 3. **No. Produk** - `{KAT}-{nomor}`

**Contoh:**
- `KOP-001` = Kategori Kopi, produk ke-1
- `MKN-002` = Kategori Makanan, produk ke-2
- `NMJ-003` = Kategori Minuman Jus, produk ke-3

**Struktur:**
- `KOP` - 3 huruf pertama kategori (uppercase)
- `001` - Nomor urut produk dalam order (3 digit)

---

## 🧾 Contoh Receipt Baru

```
════════════════════════════════════
           NGOPIGO
        Coffee & Chill
      07/04/2025 14:30
────────────────────────────────────
No. Antrian       #003
No. Pesanan       ORD-01-003
Meja              🪑 1
Pelanggan         Budi
Status            Siap
────────────────────────────────────
Item              Qty    Subtotal
────────────────────────────────────
KOP-001
Espresso           1x     18.000

MKN-002
Kentang Goreng     1x     25.000
────────────────────────────────────
Pembayaran        COD (Tunai)
Status Bayar      LUNAS
────────────────────────────────────
TOTAL                    Rp 43.000
════════════════════════════════════
    Terima kasih telah berkunjung!
   NgopiGo - Premium Coffee Experience
    Order dibuat: 07/04/2025 14:30:25
```

---

## 💻 Implementasi

### Model: Order.php

```php
/**
 * Get queue number for today's orders
 */
public function getQueueNumber(): int
{
    $todayStart = $this->created_at->copy()->startOfDay();
    $todayEnd = $this->created_at->copy()->endOfDay();
    
    $queueNumber = static::whereBetween('created_at', [$todayStart, $todayEnd])
        ->where('id', '<=', $this->id)
        ->count();
    
    return $queueNumber;
}

/**
 * Get formatted queue number with leading zero
 */
public function getFormattedQueueNumber(): string
{
    return str_pad($this->getQueueNumber(), 3, '0', STR_PAD_LEFT);
}

/**
 * Get new order number format: ORD-{meja}-{antrian}
 */
public function getFormattedOrderNumber(): string
{
    $queueNum = $this->getFormattedQueueNumber();
    return 'ORD-' . str_pad($this->table_number, 2, '0', STR_PAD_LEFT) . '-' . $queueNum;
}

/**
 * Get product sequence number for order items
 */
public function getProductSequenceNumber($orderItem): string
{
    $items = $this->orderItems()->orderBy('id')->get();
    $index = $items->search(fn($item) => $item->id === $orderItem->id);
    return str_pad($index + 1, 3, '0', STR_PAD_LEFT);
}

/**
 * Get product code with category
 */
public function getProductCode($orderItem): string
{
    $product = $orderItem->product;
    $category = strtolower(substr($product->category, 0, 3));
    $seqNumber = $this->getProductSequenceNumber($orderItem);
    return strtoupper($category) . '-' . $seqNumber;
}
```

---

### Controller: OrderController.php

```php
public function walkthroughStore(Request $request)
{
    // Get queue number for today
    $todayStart = now()->startOfDay();
    $todayEnd = now()->endOfDay();
    $queueNumber = Order::whereBetween('created_at', [$todayStart, $todayEnd])->count() + 1;
    $formattedQueue = str_pad($queueNumber, 3, '0', STR_PAD_LEFT);
    $formattedTable = str_pad($request->table_number, 2, '0', STR_PAD_LEFT);
    
    // Format: ORD-{meja}-{antrian}
    $orderNumber = 'ORD-' . $formattedTable . '-' . $formattedQueue;
    
    // ... create order with new number
}
```

---

## 📊 Contoh Penggunaan

### Scenario 1: Order Pertama Hari Ini (Meja 1)
- **Queue:** 1
- **Table:** 1
- **Order Number:** `ORD-01-001`
- **Receipt Shows:**
  - No. Antrian: #001
  - No. Pesanan: ORD-01-001

### Scenario 2: Order Kelima Hari Ini (Meja 5)
- **Queue:** 5
- **Table:** 5
- **Order Number:** `ORD-05-005`
- **Receipt Shows:**
  - No. Antrian: #005
  - No. Pesanan: ORD-05-005

### Scenario 3: Order ke-125 (Meja 12)
- **Queue:** 125
- **Table:** 12
- **Order Number:** `ORD-12-125`
- **Receipt Shows:**
  - No. Antrian: #125
  - No. Pesanan: ORD-12-125

---

## 🎨 Tampilan di Receipt

### Header Section:
```
        NGOPIGO
     Coffee & Chill
   07/04/2025 14:30
```

### Order Info:
```
No. Antrian       #003
No. Pesanan       ORD-01-003
Meja              🪑 1
Pelanggan         Budi
Status            Siap
```

### Order Items:
```
Item              Qty    Subtotal
────────────────────────────────
KOP-001
Espresso           1x     18.000

MKN-002
Kentang Goreng     1x     25.000
```

---

## ✅ Keuntungan Format Baru

1. **Lebih Informatif**
   - Langsung tahu dari meja mana order berasal
   - Tahu urutan antrian hari ini

2. **Mudah Dilacak**
   - Staff dapur bisa prioritas berdasarkan antrian
   - Kasir mudah track order per meja

3. **Professional**
   - Terstruktur seperti sistem POS modern
   - Mudah dibaca di receipt

4. **Reset Otomatis**
   - Antrian reset setiap hari baru
   - Tidak ada nomor antrian 999+

---

## 🔧 Migration (Jika Perlu)

Untuk existing orders, tidak perlu update karena format baru hanya untuk order baru.

Jika ingin update semua order:

```sql
-- Tidak direkomendasikan untuk production
-- Hanya untuk testing
UPDATE orders 
SET order_number = CONCAT('ORD-', LPAD(table_number, 2, '0'), '-', LPAD(id, 3, '0'))
WHERE order_number LIKE 'ORD-%';
```

---

## 🧪 Testing

### Test Create Order via Walkthrough:
1. Login sebagai kasir
2. Klik "➕ Buat Pesanan"
3. Pilih Meja 1
4. Tambah 1 produk
5. Submit

**Expected Result:**
- Order Number: `ORD-01-001` (jika order pertama hari ini)
- Receipt menampilkan:
  - No. Antrian: #001
  - No. Pesanan: ORD-01-001
  - Produk: KOP-001 (jika kategori Kopi)

---

## 📝 Notes

1. **Queue Number Calculation**
   - Dihitung dari order hari ini (00:00:00 - 23:59:59)
   - Berdasarkan waktu `created_at`
   - Reset otomatis setiap hari

2. **Table Number Padding**
   - Meja 1 → `01`
   - Meja 10 → `10`
   - Meja 100 → `100` (tetap 3 digit)

3. **Product Code**
   - Berdasarkan kategori produk
   - Urut sesuai input di order
   - Unique per order

---

## ✅ Done!

Format nomor pesanan baru sudah aktif:
- ✅ No. Antrian (queue number)
- ✅ No. Pesanan (ORD-meja-antrian)
- ✅ No. Produk (KAT-nomor)

**Test sekarang dengan buat order baru via walkthrough!** 🎉
