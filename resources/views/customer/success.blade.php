<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- QRCode.js library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <style>
        @@keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            50% { box-shadow: 0 0 0 12px rgba(245, 158, 11, 0); }
        }
        .qr-pulse {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        @@keyframes scan-line {
            0% { top: 0; }
            50% { top: calc(100% - 3px); }
            100% { top: 0; }
        }
        .scan-line {
            position: absolute;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #f59e0b, transparent);
            animation: scan-line 2s ease-in-out infinite;
            box-shadow: 0 0 8px rgba(245, 158, 11, 0.8);
        }
        @@keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-3 sm:p-4" style="background-color:#0e0c0a; background-image: radial-gradient(ellipse at 20% 20%, rgba(184,146,74,0.06) 0%, transparent 50%), radial-gradient(ellipse at 80% 80%, rgba(184,146,74,0.04) 0%, transparent 50%); font-family: 'Inter', sans-serif; color: #f4ede3;">
    <div class="max-w-2xl w-full" style="background: rgba(30,20,16,0.85); border: 1px solid rgba(184,146,74,0.22); border-radius: 1.5rem; backdrop-filter: blur(12px); box-shadow: 0 30px 80px rgba(0,0,0,0.6); padding: 1.75rem 2rem; animation: slideUp 0.6s cubic-bezier(0.23,1,0.32,1) both;">
    <style>
        @keyframes slideUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pulse-ring { 0%,100%{box-shadow:0 0 0 0 rgba(184,146,74,0.35)} 50%{box-shadow:0 0 0 14px rgba(184,146,74,0)} }
        .success-icon { animation: pulse-ring 2.5s ease-in-out infinite; }
        .gold-text { background: linear-gradient(120deg,#b8924a 0%,#e8d5b0 45%,#c4a265 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .divider { height:1px; background: linear-gradient(90deg,transparent,rgba(184,146,74,0.5),transparent); margin: 1rem 0; }
        .info-label { color: rgba(184,146,74,0.7); font-size: 0.8rem; margin-bottom: 0.25rem; }
        .info-value { color: #f4ede3; font-weight: 600; font-size: 0.95rem; display:flex; align-items:center; gap:0.4rem; }
        .status-badge { display:inline-flex; padding:0.25rem 0.75rem; border-radius:9999px; font-size:0.75rem; font-weight:600; }
        .order-item-card { background: rgba(184,146,74,0.05); border: 1px solid rgba(184,146,74,0.15); border-radius:0.875rem; padding:0.75rem; }
        .btn-primary { display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; background:linear-gradient(120deg,#b8924a,#d4af7a); color:#0e0c0a; font-weight:700; padding:0.875rem 1.5rem; border-radius:0.875rem; text-decoration:none; transition:all 0.3s ease; font-size:0.9rem; }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(184,146,74,0.35); }
        .btn-secondary { display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; background:rgba(184,146,74,0.07); border:1px solid rgba(184,146,74,0.3); color:#f4ede3; font-weight:500; padding:0.875rem 1.5rem; border-radius:0.875rem; text-decoration:none; transition:all 0.3s ease; font-size:0.9rem; }
        .btn-secondary:hover { background:rgba(184,146,74,0.14); border-color:rgba(184,146,74,0.5); }
        .rec-card { background:rgba(184,146,74,0.04); border:1px solid rgba(184,146,74,0.15); border-radius:0.875rem; padding:0.5rem; transition:all 0.2s ease; cursor:pointer; }
        .rec-card:hover { border-color:rgba(184,146,74,0.4); background:rgba(184,146,74,0.08); }
        .qr-box { background:#fff; border-radius:1rem; padding:1rem; display:inline-flex; }
        .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        @media(max-width:480px){ .info-grid{grid-template-columns:1fr;} }
    </style>
        <!-- Success Icon -->
        <div class="success-icon" style="width:5rem;height:5rem;border-radius:50%;background:rgba(184,146,74,0.12);border:1px solid rgba(184,146,74,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
            <svg style="width:2.25rem;height:2.25rem;color:#b8924a" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 style="font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:700;text-align:center;margin-bottom:0.4rem;" class="gold-text">Pesanan Berhasil!</h1>
        <p style="color:rgba(184,146,74,0.7);font-size:0.875rem;text-align:center;margin-bottom:1.5rem;">Terima kasih telah memesan di NgopiGo</p>

        <!-- Order Info -->
        <div style="background:rgba(184,146,74,0.04);border:1px solid rgba(184,146,74,0.15);border-radius:1.25rem;padding:1.25rem;margin-bottom:1.25rem;">
            <!-- Queue Number -->
            <div style="text-align:center;margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid rgba(184,146,74,0.15);">
                <p style="color:rgba(184,146,74,0.7);font-size:0.8rem;margin-bottom:0.35rem;text-transform:uppercase;letter-spacing:0.06em;">Nomor Antrian</p>
                <p style="font-family:'Playfair Display',serif;font-size:3rem;font-weight:700;line-height:1;margin-bottom:0.5rem;" class="gold-text">#{{ $order->getFormattedQueueNumber() }}</p>
                <div style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
                    <span style="color:rgba(184,146,74,0.6);font-size:0.8rem;">No. Pesanan:</span>
                    <span style="color:#d4af7a;font-weight:700;font-size:0.9rem;font-family:monospace;">{{ $order->getFormattedOrderNumber() }}</span>
                </div>
            </div>

            <div class="info-grid" style="margin-bottom:1rem;">
                <div>
                    <p class="info-label">Meja</p>
                    <p class="info-value">
                        <svg style="width:16px;height:16px;color:#b8924a;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                        {{ $order->table_number }}
                    </p>
                </div>
                <div>
                    <p class="info-label">Status</p>
                    @php $statusLabels=['pending'=>'Menunggu','preparing'=>'Disiapkan','ready'=>'Siap','completed'=>'Selesai','cancelled'=>'Dibatalkan']; @endphp
                    <span class="status-badge"
                        style="@if($order->status==='pending') background:rgba(234,179,8,0.15);color:#fbbf24; @elseif($order->status==='preparing') background:rgba(59,130,246,0.15);color:#60a5fa; @elseif($order->status==='ready') background:rgba(34,197,94,0.15);color:#4ade80; @elseif($order->status==='completed') background:rgba(184,146,74,0.15);color:#d4af7a; @else background:rgba(239,68,68,0.15);color:#f87171; @endif">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                </div>
                <div>
                    <p class="info-label">Pembayaran</p>
                    <p class="info-value">
                        @if($order->payment_method === 'cod')
                        <svg style="width:16px;height:16px;color:#b8924a;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                        COD (Di Tempat)
                        @else
                        <svg style="width:16px;height:16px;color:#b8924a;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        Online
                        @endif
                    </p>
                </div>
                <div>
                    <p class="info-label">Waktu</p>
                    <p class="info-value">
                        <svg style="width:16px;height:16px;color:#b8924a;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $order->created_at->format('H:i') }}
                    </p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="divider"></div>
            <div class="info-grid">
                <div>
                    <p class="info-label">Nama</p>
                    <p class="info-value">
                        <svg style="width:16px;height:16px;color:#b8924a;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        {{ $order->customer_name }}
                    </p>
                </div>
                <div>
                    <p class="info-label">WhatsApp</p>
                    <p class="info-value">
                        <svg style="width:16px;height:16px;color:#b8924a;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18h3"/></svg>
                        {{ $order->phone }}
                    </p>
                </div>
                @if($order->email)
                <div>
                    <p class="info-label">Email</p>
                    <p class="info-value">
                        <svg style="width:16px;height:16px;color:#b8924a;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        {{ $order->email }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="divider"></div>
            <p style="color:rgba(184,146,74,0.7);font-size:0.8rem;margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.06em;">Detail Pesanan</p>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:0.75rem;margin-bottom:1rem;">
                @foreach($order->orderItems as $item)
                <div class="order-item-card">
                    <div style="font-size:0.65rem;color:rgba(184,146,74,0.6);font-family:monospace;margin-bottom:0.4rem;">{{ $order->getProductCode($item) }}</div>
                    @if($item->product->image)
                    <div style="width:100%;aspect-ratio:16/9;border-radius:0.5rem;overflow:hidden;margin-bottom:0.5rem;">
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    @endif
                    <p style="font-size:0.75rem;font-weight:600;color:#f4ede3;margin-bottom:0.4rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->product->name }}</p>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:0.7rem;background:rgba(184,146,74,0.15);color:#d4af7a;font-weight:700;padding:0.15rem 0.4rem;border-radius:0.25rem;">{{ $item->quantity }}x</span>
                        <span style="font-size:0.75rem;color:#e8d5b0;font-weight:500;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="divider"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding-top:0.5rem;">
                <span style="font-weight:600;color:#f4ede3;font-size:0.95rem;">Total Bayar</span>
                <span style="font-size:1.35rem;font-weight:700;" class="gold-text">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->notes)
        <div style="background:rgba(184,146,74,0.04);border:1px solid rgba(184,146,74,0.12);border-radius:0.875rem;padding:0.875rem;margin-bottom:1.25rem;">
            <p style="font-size:0.75rem;color:rgba(184,146,74,0.6);margin-bottom:0.25rem;">Catatan:</p>
            <p style="font-size:0.875rem;color:#f4ede3;">{{ $order->notes }}</p>
        </div>
        @endif

        {{-- Weather-Based Recommendation Section with Real Weather --}}
        @php
            // Get available products from database
            $availableProducts = \App\Models\Product::where('is_available', true)
                ->inRandomOrder()
                ->limit(6)
                ->get();

            // Use Jakarta timezone (WIB) for real-time
            $jakartaTime = now()->timezone('Asia/Jakarta');
            $hour = $jakartaTime->hour;
            
            // Debug info (remove in production)
            // $debugTime = $jakartaTime->format('H:i:s');
            
            $seasonalRecs = [
                'pagi' => [
                    'title' => 'Rekomendasi Pagi ☀️',
                    'description' => 'Mulai harimu dengan semangat!',
                    'gradient' => 'from-orange-50 to-amber-50',
                    'border' => 'border-orange-300',
                    'badge' => 'bg-orange-100 text-orange-700',
                    'icon' => '🌅'
                ],
                'siang' => [
                    'title' => 'Rekomendasi Siang 🔥',
                    'description' => 'Segarkan harimu yang panas!',
                    'gradient' => 'from-yellow-50 to-orange-50',
                    'border' => 'border-yellow-300',
                    'badge' => 'bg-yellow-100 text-yellow-700',
                    'icon' => '☀️'
                ],
                'sore' => [
                    'title' => 'Rekomendasi Sore 🌤️',
                    'description' => 'Nikmati sore yang santai!',
                    'gradient' => 'from-amber-100 to-orange-100',
                    'border' => 'border-amber-300',
                    'badge' => 'bg-amber-100 text-amber-700',
                    'icon' => '🌤️'
                ],
                'malam' => [
                    'title' => 'Rekomendasi Malam 🌙',
                    'description' => 'Hangatkan malammu!',
                    'gradient' => 'from-indigo-50 to-purple-50',
                    'border' => 'border-indigo-300',
                    'badge' => 'bg-indigo-100 text-indigo-700',
                    'icon' => '🌙'
                ]
            ];

            // Determine time of day based on Jakarta hour (WIB)
            if ($hour >= 5 && $hour < 11) {
                $weatherKey = 'pagi';
            } elseif ($hour >= 11 && $hour < 15) {
                $weatherKey = 'siang';
            } elseif ($hour >= 15 && $hour < 18) {
                $weatherKey = 'sore';
            } else {
                // 18:00 - 04:59 = malam (evening/night)
                $weatherKey = 'malam';
            }

            $weatherRec = $seasonalRecs[$weatherKey];
        @endphp

        <div class="fade-in" style="background:rgba(184,146,74,0.04);border:1px solid rgba(184,146,74,0.15);border-radius:1.25rem;padding:1.25rem;margin-bottom:1.25rem;">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;flex-wrap:wrap;">
                <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:rgba(184,146,74,0.12);border:1px solid rgba(184,146,74,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:1.1rem;height:1.1rem;color:#b8924a" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <h3 style="font-size:0.95rem;font-weight:700;color:#f4ede3;margin-bottom:0.1rem;">{{ $weatherRec['title'] }}</h3>
                    <p style="font-size:0.75rem;color:rgba(184,146,74,0.7);">{{ $weatherRec['description'] }} &bull; {{ $jakartaTime->format('H:i') }} WIB</p>
                </div>
                <span style="font-size:0.7rem;font-weight:600;background:rgba(184,146,74,0.12);color:#d4af7a;padding:0.2rem 0.6rem;border-radius:9999px;white-space:nowrap;">{{ strtolower(str_replace('Rekomendasi ', '', $weatherRec['title'])) }}</span>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:0.6rem;">
                @foreach($availableProducts as $product)
                <div class="rec-card">
                    <div style="aspect-ratio:1;border-radius:0.5rem;overflow:hidden;background:rgba(30,20,16,0.6);margin-bottom:0.4rem;">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:1.5rem;height:1.5rem;color:rgba(184,146,74,0.3)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M19.8 15a2.25 2.25 0 01-2.15 1.5H6.35A2.25 2.25 0 014.2 15"/></svg>
                        </div>
                        @endif
                    </div>
                    <p style="font-size:0.7rem;font-weight:600;color:#f4ede3;text-align:center;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $product->name }}</p>
                    <p style="font-size:0.7rem;color:#d4af7a;font-weight:700;text-align:center;margin-top:0.2rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- QR Code Section untuk COD yang belum dibayar --}}
        @if($order->payment_method === 'cod' && $order->payment_status !== 'paid')
        <div class="fade-in" style="animation-delay:0.3s;opacity:0;">
            <div style="background:rgba(184,146,74,0.04);border:1px solid rgba(184,146,74,0.2);border-radius:1.25rem;padding:1.25rem;margin-bottom:1.25rem;">
                <div style="text-align:center;margin-bottom:1rem;">
                    <div style="display:inline-flex;align-items:center;gap:0.4rem;background:rgba(184,146,74,0.1);color:#d4af7a;font-size:0.75rem;font-weight:600;padding:0.25rem 0.75rem;border-radius:9999px;margin-bottom:0.75rem;">
                        <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 18.75h.75v.75h-.75v-.75zM18.75 13.5h.75v.75h-.75v-.75zM18.75 18.75h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/></svg>
                        Bayar di Kasir
                    </div>
                    <h2 style="font-size:1rem;font-weight:700;color:#f4ede3;margin-bottom:0.35rem;">Scan QR Code Ini ke Kasir</h2>
                    <p style="font-size:0.8rem;color:rgba(184,146,74,0.7);">Tunjukkan QR code ini ke kasir untuk memproses pembayaran tunai Anda</p>
                </div>
                <!-- QR Box -->
                <div style="display:flex;justify-content:center;margin-bottom:1rem;">
                    <div style="position:relative;">
                        <div style="position:absolute;top:-6px;left:-6px;width:20px;height:20px;border-top:3px solid #b8924a;border-left:3px solid #b8924a;border-radius:4px 0 0 0;"></div>
                        <div style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;border-top:3px solid #b8924a;border-right:3px solid #b8924a;border-radius:0 4px 0 0;"></div>
                        <div style="position:absolute;bottom:-6px;left:-6px;width:20px;height:20px;border-bottom:3px solid #b8924a;border-left:3px solid #b8924a;border-radius:0 0 0 4px;"></div>
                        <div style="position:absolute;bottom:-6px;right:-6px;width:20px;height:20px;border-bottom:3px solid #b8924a;border-right:3px solid #b8924a;border-radius:0 0 4px 0;"></div>
                        <div class="qr-pulse" style="background:#fff;border-radius:0.75rem;padding:0.875rem;display:inline-flex;position:relative;overflow:hidden;">
                            <div class="scan-line" id="qr-scan-line"></div>
                            <div id="qrcode" style="display:flex;justify-content:center;"></div>
                        </div>
                    </div>
                </div>
                <!-- Order summary -->
                <div style="background:rgba(184,146,74,0.05);border:1px solid rgba(184,146,74,0.15);border-radius:0.875rem;padding:0.875rem;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
                        <span style="font-size:0.8rem;color:rgba(184,146,74,0.7);">No. Pesanan</span>
                        <span style="font-size:0.8rem;font-weight:700;color:#f4ede3;font-family:monospace;">{{ $order->getFormattedOrderNumber() }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
                        <span style="font-size:0.8rem;color:rgba(184,146,74,0.7);">Meja</span>
                        <span style="font-size:0.8rem;font-weight:700;color:#f4ede3;">{{ $order->table_number }}</span>
                    </div>
                    <div style="height:1px;background:rgba(184,146,74,0.15);margin:0.5rem 0;"></div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:0.85rem;font-weight:700;color:#f4ede3;">Total Bayar</span>
                        <span style="font-size:1rem;font-weight:700;background:linear-gradient(120deg,#b8924a,#e8d5b0,#c4a265);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
                <p style="text-align:center;font-size:0.75rem;color:rgba(184,146,74,0.6);margin-top:0.75rem;">
                    QR code ini unik untuk pesanan Anda. Kasir akan memindai dan mengkonfirmasi pembayaran.
                </p>
            </div>
        </div>

        @elseif($order->payment_method === 'cod' && $order->payment_status === 'paid')
        <div style="background:rgba(34,197,94,0.07);border:1px solid rgba(34,197,94,0.25);border-radius:1.25rem;padding:1.25rem;margin-bottom:1.25rem;text-align:center;" class="fade-in">
            <div style="width:3.5rem;height:3.5rem;border-radius:50%;background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                <svg style="width:1.5rem;height:1.5rem;color:#4ade80" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 style="font-size:1rem;font-weight:700;color:#4ade80;">Pembayaran Lunas!</h2>
            <p style="font-size:0.8rem;color:rgba(74,222,128,0.8);margin-top:0.35rem;">Pesanan Anda telah dibayar. Silahkan tunggu pesanan disiapkan.</p>
        </div>

        @else
        <div style="text-align:center;margin-bottom:1.25rem;">
            <p style="font-size:0.85rem;color:rgba(244,237,227,0.7);">Pesanan Anda sedang disiapkan. Silahkan tunggu di meja <strong style="color:#d4af7a;">{{ $order->table_number }}</strong></p>
            @if($order->payment_method === 'online')
            <p style="font-size:0.75rem;color:rgba(251,191,36,0.8);margin-top:0.5rem;display:flex;align-items:center;justify-content:center;gap:0.35rem;">
                <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                Untuk pembayaran online, silahkan tunggu konfirmasi sistem.
            </p>
            @endif
        </div>
        @endif

        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
            <a href="{{ route('order.create', $order->table_number) }}" class="btn-primary" style="flex:1;min-width:140px;">
                <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                Pesan Lagi
            </a>
            <a href="{{ route('order.success', $order->order_number) }}" class="btn-secondary">
                <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                Refresh
            </a>
        </div>
    </div>

    @if($order->payment_method === 'cod' && $order->payment_status !== 'paid')
    <script>
        // Generate QR Code yang mengarah ke halaman konfirmasi kasir
        const cashierScanUrl = '{{ route("cashier.scan", $order->order_number) }}';
        const qrContainer = document.getElementById('qrcode');

        if (qrContainer) {
            new QRCode(qrContainer, {
                text: cashierScanUrl,
                width: 200,
                height: 200,
                colorDark: '#1c0a00',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        // Auto-refresh setiap 10 detik untuk cek status pembayaran
        let refreshInterval = setInterval(function() {
            fetch('{{ route("order.check-payment", $order->order_number) }}')
                .then(r => r.json())
                .then(data => {
                    if (data.paid) {
                        clearInterval(refreshInterval);
                        window.location.reload();
                    }
                })
                .catch(() => {});
        }, 10000);
    </script>
    @endif

    @if($order->payment_method === 'online' && $order->payment_status !== 'paid')
    <script>
        // Untuk pembayaran online: polling endpoint status-bayar yang sekarang juga melakukan sync ke Midtrans API.
        // Ini penting kalau webhook Midtrans tidak bisa mengakses aplikasi (mis. masih localhost).
        let tries = 0;
        const maxTries = 24; // ~2 menit (5 detik sekali)
        const intervalMs = 5000;

        const onlineInterval = setInterval(function() {
            tries++;
            fetch('{{ route("order.check-payment", $order->order_number) }}')
                .then(r => r.json())
                .then(data => {
                    if (data.paid) {
                        clearInterval(onlineInterval);
                        window.location.reload();
                    }
                })
                .catch(() => {});

            if (tries >= maxTries) {
                clearInterval(onlineInterval);
            }
        }, intervalMs);
    </script>
    @endif
</body>
</html>
