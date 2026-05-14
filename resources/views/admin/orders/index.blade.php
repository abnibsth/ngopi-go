@extends('admin.layouts.app')

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<style>
    .premium-card {
        background: rgba(30,20,16,0.5);
        border: 1px solid rgba(184,146,74,0.15);
        border-radius: 1.25rem;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        overflow: hidden;
        position: relative;
    }
    .premium-card:hover {
        box-shadow: 0 12px 30px rgba(0,0,0,0.5), 0 0 0 1px rgba(184,146,74,0.3);
        background: rgba(30,20,16,0.8);
    }
    .premium-table th {
        background: rgba(184,146,74,0.05);
        color: rgba(184,146,74,0.8);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        border-bottom: 1px solid rgba(184,146,74,0.15);
    }
    .premium-table td {
        border-bottom: 1px solid rgba(184,146,74,0.05);
    }
    .premium-table tr:hover td {
        background: rgba(184,146,74,0.03);
    }
    .status-pill {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.2rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid transparent;
    }
</style>
@endpush

@section('title', 'Semua Pesanan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold gradient-gold flex items-center gap-3">
            <svg class="w-8 h-8 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75M6.75 21h9" />
            </svg>
            Semua Pesanan
        </h1>
        <p class="text-[var(--gold)]/70 mt-1 text-sm tracking-wide">Kelola antrean dan riwayat pesanan</p>
    </div>
    
    {{-- Tombol Scan QR - hanya untuk kasir & admin --}}
    @if(auth()->guard('admin')->user()->canUpdatePaymentStatus())
    <button id="open-qr-scanner"
            class="flex items-center gap-2 bg-gradient-to-r from-[var(--gold)] to-[var(--gold-light)] hover:from-[var(--gold-light)] hover:to-[var(--gold)] text-[var(--black)] font-semibold py-2.5 px-5 rounded-lg transition-all shadow-[0_4px_12px_rgba(184,146,74,0.2)] hover:shadow-[0_6px_16px_rgba(184,146,74,0.3)] hover:-translate-y-0.5 text-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
        </svg>
        Scan QR Bayar
    </button>
    @endif
</div>

{{-- ========== MODAL QR SCANNER ========== --}}
<div id="qr-scanner-modal"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 hidden"
     style="background: rgba(14,12,10,0.9); backdrop-filter: blur(8px);">
    <div class="bg-[rgba(30,20,16,0.95)] rounded-2xl border border-[rgba(184,146,74,0.3)] shadow-[0_20px_50px_rgba(0,0,0,0.7)] w-full max-w-sm overflow-hidden">
        {{-- Modal Header --}}
        <div class="bg-gradient-to-r from-[rgba(184,146,74,0.1)] to-transparent px-5 py-4 border-b border-[rgba(184,146,74,0.15)] flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-[rgba(184,146,74,0.15)] flex items-center justify-center">
                    <svg class="w-4 h-4 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-white font-semibold text-sm">Scan QR Pelanggan</h2>
                    <p class="text-[var(--gold)]/60 text-xs">Arahkan kamera ke QR code</p>
                </div>
            </div>
            <button id="close-qr-scanner" class="text-[var(--gold)]/60 hover:text-white transition w-8 h-8 flex items-center justify-center rounded-lg hover:bg-[rgba(184,146,74,0.1)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Camera Viewport --}}
        <div class="px-5 py-5">
            <div class="relative rounded-xl overflow-hidden bg-black border border-[rgba(184,146,74,0.2)]" style="aspect-ratio: 1;">
                {{-- Corner brackets --}}
                <div class="absolute top-3 left-3 w-6 h-6 border-t-2 border-l-2 border-[var(--gold)] rounded-tl-lg z-10"></div>
                <div class="absolute top-3 right-3 w-6 h-6 border-t-2 border-r-2 border-[var(--gold)] rounded-tr-lg z-10"></div>
                <div class="absolute bottom-3 left-3 w-6 h-6 border-b-2 border-l-2 border-[var(--gold)] rounded-bl-lg z-10"></div>
                <div class="absolute bottom-3 right-3 w-6 h-6 border-b-2 border-r-2 border-[var(--gold)] rounded-br-lg z-10"></div>

                {{-- Scan line animation --}}
                <div id="scanner-scan-line"
                     class="absolute left-4 right-4 h-0.5 z-10"
                     style="background: linear-gradient(90deg, transparent, var(--gold), transparent); box-shadow: 0 0 10px rgba(184,146,74,0.8); animation: scanMove 2s ease-in-out infinite; top: 20%;"></div>

                {{-- Camera feed container --}}
                <div id="qr-reader" class="w-full h-full"></div>
            </div>

            {{-- Status text --}}
            <div id="qr-status" class="text-center mt-4">
                <p class="text-[var(--gold)] text-sm flex items-center justify-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menunggu kamera...
                </p>
            </div>

            {{-- Error area --}}
            <div id="qr-error" class="hidden mt-3 bg-[rgba(248,113,113,0.1)] border border-[rgba(248,113,113,0.2)] rounded-lg p-3 text-center">
                <p class="text-[#f87171] text-xs font-medium"></p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scanMove {
        0%   { top: 15%; }
        50%  { top: 80%; }
        100% { top: 15%; }
    }
    /* Override html5-qrcode default UI */
    #qr-reader__scan_region > img { display: none !important; }
    #qr-reader__dashboard { display: none !important; }
    #qr-reader video { width: 100% !important; height: 100% !important; object-fit: cover; }
    #qr-reader { width: 100% !important; height: 100% !important; border: none !important; }
</style>

<script>
(function() {
    const modal        = document.getElementById('qr-scanner-modal');
    const openBtn      = document.getElementById('open-qr-scanner');
    const closeBtn     = document.getElementById('close-qr-scanner');
    const statusEl     = document.getElementById('qr-status');
    const errorEl      = document.getElementById('qr-error');
    const errorText    = errorEl ? errorEl.querySelector('p') : null;

    let html5QrCode = null;
    let isScanning  = false;
    let scanLocked  = false;

    openBtn && openBtn.addEventListener('click', function () {
        modal.classList.remove('hidden');
        startScanner();
    });

    closeBtn && closeBtn.addEventListener('click', closeModal);
    modal && modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    function closeModal() {
        stopScanner();
        modal.classList.add('hidden');
        scanLocked = false;
    }

    function setStatus(msg, isError = false, icon = null) {
        if (statusEl) {
            let iconHtml = '';
            if (icon === 'success') {
                iconHtml = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>`;
            } else if (icon === 'error') {
                iconHtml = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>`;
            } else if (icon === 'camera') {
                iconHtml = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /></svg>`;
            }
            
            statusEl.innerHTML = `<p class="${isError ? 'text-[#f87171]' : 'text-[var(--gold)]'} text-sm flex items-center justify-center gap-1.5 font-medium">
                ${iconHtml}
                ${msg}
            </p>`;
        }
    }

    function showError(msg) {
        if (errorEl && errorText) {
            errorText.textContent = msg;
            errorEl.classList.remove('hidden');
        }
    }

    function startScanner() {
        if (isScanning) return;
        if (typeof Html5Qrcode === 'undefined') {
            setStatus('Library scanner tidak tersedia', true, 'error');
            return;
        }

        errorEl && errorEl.classList.add('hidden');
        
        // initial loading text already set in html
        
        html5QrCode = new Html5Qrcode('qr-reader');

        Html5Qrcode.getCameras().then(cameras => {
            if (!cameras || cameras.length === 0) {
                setStatus('Kamera tidak ditemukan', true, 'error');
                return;
            }

            const backCamera = cameras.find(c =>
                c.label.toLowerCase().includes('back') ||
                c.label.toLowerCase().includes('belakang') ||
                c.label.toLowerCase().includes('rear') ||
                c.label.toLowerCase().includes('environment')
            ) || cameras[cameras.length - 1];

            const config = {
                fps: 10,
                qrbox: { width: 220, height: 220 },
                aspectRatio: 1.0,
                disableFlip: false,
            };

            html5QrCode.start(
                backCamera.id,
                config,
                onScanSuccess,
                onScanError
            ).then(() => {
                isScanning = true;
                setStatus('Kamera aktif — Arahkan ke QR Code pelanggan', false, 'camera');
            }).catch(err => {
                console.error('Start camera error:', err);
                setStatus('Gagal membuka kamera', true, 'error');
                showError('Pastikan izin kamera sudah diberikan di browser.');
            });

        }).catch(err => {
            console.error('getCameras error:', err);
            setStatus('Tidak bisa mengakses kamera', true, 'error');
            showError('Izin kamera ditolak atau tidak tersedia.');
        });
    }

    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().catch(() => {});
            isScanning = false;
        }
    }

    function onScanSuccess(decodedText) {
        if (scanLocked) return;

        const expectedPattern = /\/kasir\/scan\//;
        if (!expectedPattern.test(decodedText)) {
            setStatus('QR Code tidak valid. Scan QR dari pelanggan NgopiGo.', true, 'error');
            return;
        }

        scanLocked = true;
        stopScanner();
        setStatus('QR valid! Mengarahkan ke konfirmasi...', false, 'success');

        setTimeout(() => {
            window.location.href = decodedText;
        }, 600);
    }

    function onScanError(error) {
        // ignore
    }
})();
</script>

<div class="premium-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left premium-table">
            <thead>
                <tr>
                    <th class="px-5 py-4">Order #</th>
                    <th class="px-5 py-4">Meja</th>
                    <th class="px-5 py-4">Customer</th>
                    <th class="px-5 py-4">Pembayaran</th>
                    <th class="px-5 py-4">Status Bayar</th>
                    <th class="px-5 py-4">Items</th>
                    <th class="px-5 py-4">Total</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">Waktu</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="transition-colors group hover:bg-[rgba(184,146,74,0.02)]">
                    <td class="px-5 py-4 whitespace-nowrap border-b border-[rgba(184,146,74,0.05)]">
                        <span class="font-semibold text-[var(--gold-pale)] font-mono text-sm">{{ $order->order_number }}</span>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap border-b border-[rgba(184,146,74,0.05)]">
                        <span class="text-white font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[var(--gold)]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            {{ $order->table_number }}
                        </span>
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)]">
                        <div class="text-sm">
                            <div class="font-medium text-white">{{ $order->customer_name }}</div>
                            <div class="text-[var(--gold)]/60 flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                {{ $order->phone }}
                            </div>
                            @if($order->email)
                            <div class="text-[var(--gold)]/50 text-xs mt-0.5 truncate max-w-[120px]">{{ $order->email }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap border-b border-[rgba(184,146,74,0.05)]">
                        <span class="px-2.5 py-1 rounded text-xs font-medium flex items-center gap-1 w-max
                            @if($order->payment_method === 'cod') bg-[rgba(74,222,128,0.1)] text-[#4ade80] border border-[rgba(74,222,128,0.2)]
                            @else bg-[rgba(96,165,250,0.1)] text-[#60a5fa] border border-[rgba(96,165,250,0.2)]
                            @endif">
                            @if($order->payment_method === 'cod')
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                COD / Kasir
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                Online
                            @endif
                        </span>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap border-b border-[rgba(184,146,74,0.05)]">
                        @if(auth()->guard('admin')->user()->canUpdatePaymentStatus())
                        <a href="{{ route('admin.orders.payment', $order->id) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all hover:-translate-y-0.5 hover:shadow-md
                               {{ $order->getPaymentStatusBadgeClass() }}">
                            {!! str_replace(['✅', '⏳'], ['<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>', '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'], $order->getPaymentStatusLabel()) !!}
                        </a>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                            {{ $order->getPaymentStatusBadgeClass() }}">
                            {!! str_replace(['✅', '⏳'], ['<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>', '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'], $order->getPaymentStatusLabel()) !!}
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)]">
                        <div class="text-sm text-white space-y-1">
                            @foreach($order->orderItems->take(2) as $item)
                            <div class="flex items-start gap-1">
                                <span class="text-[var(--gold)] font-medium">{{ $item->quantity }}x</span>
                                <span class="truncate max-w-[120px]" title="{{ $item->product->name }}">{{ $item->product->name }}</span>
                            </div>
                            @endforeach
                            @if($order->orderItems->count() > 2)
                            <div class="text-[var(--gold)]/50 text-xs italic">+{{ $order->orderItems->count() - 2 }} item lainnya</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap border-b border-[rgba(184,146,74,0.05)]">
                        <span class="font-bold gradient-gold text-base">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap border-b border-[rgba(184,146,74,0.05)]">
                        <span class="status-pill
                            @if($order->status === 'pending') bg-[rgba(251,191,36,0.1)] text-[#fbbf24] border-[rgba(251,191,36,0.2)]
                            @elseif($order->status === 'preparing') bg-[rgba(96,165,250,0.1)] text-[#60a5fa] border-[rgba(96,165,250,0.2)]
                            @elseif($order->status === 'ready') bg-[rgba(74,222,128,0.1)] text-[#4ade80] border-[rgba(74,222,128,0.2)]
                            @elseif($order->status === 'completed') bg-[rgba(244,237,227,0.1)] text-white border-[rgba(244,237,227,0.2)]
                            @else bg-[rgba(248,113,113,0.1)] text-[#f87171] border-[rgba(248,113,113,0.2)]
                            @endif">
                            @php
                                $statusIcons = [
                                    'pending' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                                    'preparing' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>',
                                    'ready' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
                                    'completed' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
                                    'cancelled' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>'
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'preparing' => 'Disiapkan',
                                    'ready' => 'Siap',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan'
                                ];
                            @endphp
                            {!! $statusIcons[$order->status] ?? '' !!}
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-white">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            <span class="text-[var(--gold)]/50 text-xs">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-right border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.orders.edit', $order->id) }}"
                               class="w-8 h-8 rounded-lg bg-[rgba(96,165,250,0.1)] text-[#60a5fa] border border-[rgba(96,165,250,0.2)] hover:bg-[rgba(96,165,250,0.2)] flex items-center justify-center transition-colors" title="Edit Pesanan">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                            </a>
                            @if(auth()->guard('admin')->user()->canUpdatePaymentStatus())
                            <a href="{{ route('admin.orders.receipt', $order->id) }}" target="_blank"
                               class="w-8 h-8 rounded-lg bg-[rgba(74,222,128,0.1)] text-[#4ade80] border border-[rgba(74,222,128,0.2)] hover:bg-[rgba(74,222,128,0.2)] flex items-center justify-center transition-colors" title="Cetak Receipt">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </a>
                            @endif
                            @if(auth()->guard('admin')->user()->isAdmin())
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="if(confirm('Hapus pesanan ini secara permanen?')) this.closest('form').submit()"
                                        class="w-8 h-8 rounded-lg bg-[rgba(248,113,113,0.1)] text-[#f87171] border border-[rgba(248,113,113,0.2)] hover:bg-[rgba(248,113,113,0.2)] flex items-center justify-center transition-colors" title="Hapus Pesanan">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-5 py-12 text-center text-[var(--gold)]/50 text-sm border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <svg class="w-8 h-8 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75M6.75 21h9" /></svg>
                            Belum ada pesanan
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($orders->hasPages())
<div class="mt-6">
    {{ $orders->links() }}
</div>
@endif
@endsection
