@extends('admin.layouts.app')

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@section('title', 'Semua Pesanan')

@section('content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-gold">Semua Pesanan</h1>
            <p class="text-[#C69C6D] mt-1">Riwayat Pesanan NgopiGo</p>
        </div>
        {{-- Tombol Scan QR - hanya untuk kasir & admin --}}
        @if(auth()->guard('admin')->user()->canUpdatePaymentStatus())
        <button id="open-qr-scanner"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-3 px-5 rounded-xl shadow-lg transition-all duration-200 hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            Scan QR Bayar
        </button>
        @endif
    </div>

    {{-- ========== MODAL QR SCANNER ========== --}}
    <div id="qr-scanner-modal"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
         style="background: rgba(0,0,0,0.85); backdrop-filter: blur(6px);">

        <div class="bg-[#1a120f] rounded-2xl border border-[#C69C6D]/30 shadow-2xl w-full max-w-sm overflow-hidden">

            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-6 py-4 border-b border-[#C69C6D]/20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#C69C6D]/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#C69C6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[#F5F0E6] font-bold">Scan QR Pelanggan</h2>
                        <p class="text-[#C69C6D] text-xs">Arahkan kamera ke QR code</p>
                    </div>
                </div>
                <button id="close-qr-scanner" class="text-[#C69C6D] hover:text-[#F5F0E6] transition text-2xl leading-none">&times;</button>
            </div>

            {{-- Camera Viewport --}}
            <div class="px-6 py-5">
                <div class="relative rounded-xl overflow-hidden bg-black" style="aspect-ratio: 1;">
                    {{-- Corner brackets --}}
                    <div class="absolute top-3 left-3 w-7 h-7 border-t-3 border-l-3 border-[#C69C6D] rounded-tl-lg z-10" style="border-top-width:3px;border-left-width:3px;"></div>
                    <div class="absolute top-3 right-3 w-7 h-7 border-t-3 border-r-3 border-[#C69C6D] rounded-tr-lg z-10" style="border-top-width:3px;border-right-width:3px;"></div>
                    <div class="absolute bottom-3 left-3 w-7 h-7 border-b-3 border-l-3 border-[#C69C6D] rounded-bl-lg z-10" style="border-bottom-width:3px;border-left-width:3px;"></div>
                    <div class="absolute bottom-3 right-3 w-7 h-7 border-b-3 border-r-3 border-[#C69C6D] rounded-br-lg z-10" style="border-bottom-width:3px;border-right-width:3px;"></div>

                    {{-- Scan line animation --}}
                    <div id="scanner-scan-line"
                         class="absolute left-4 right-4 h-0.5 z-10"
                         style="background: linear-gradient(90deg, transparent, #C69C6D, transparent); box-shadow: 0 0 10px rgba(198,156,109,0.8); animation: scanMove 1.8s ease-in-out infinite; top: 20%;"></div>

                    {{-- Camera feed container --}}
                    <div id="qr-reader" class="w-full h-full"></div>
                </div>

                {{-- Status text --}}
                <div id="qr-status" class="text-center mt-4">
                    <p class="text-[#C69C6D] text-sm">📷 Menunggu kamera...</p>
                </div>

                {{-- Error area --}}
                <div id="qr-error" class="hidden mt-3 bg-[#2f1a1a] border border-[#f87171]/30 rounded-lg p-3 text-center">
                    <p class="text-[#f87171] text-sm"></p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @@keyframes scanMove {
            0%   { top: 15%; }
            50%  { top: 80%; }
            100% { top: 15%; }
        }
        /* Override html5-qrcode default UI yang tidak dipakai */
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
        let scanLocked  = false; // Cegah multiple redirect

        // Buka modal
        openBtn && openBtn.addEventListener('click', function () {
            modal.classList.remove('hidden');
            startScanner();
        });

        // Tutup modal
        closeBtn && closeBtn.addEventListener('click', closeModal);
        modal && modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });

        function closeModal() {
            stopScanner();
            modal.classList.add('hidden');
            scanLocked = false;
        }

        function setStatus(msg, isError = false) {
            if (statusEl) statusEl.innerHTML = `<p class="${isError ? 'text-[#f87171]' : 'text-[#C69C6D]'} text-sm">${msg}</p>`;
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
                setStatus('❌ Library scanner tidak tersedia', true);
                return;
            }

            errorEl && errorEl.classList.add('hidden');
            setStatus('📷 Memulai kamera...');

            html5QrCode = new Html5Qrcode('qr-reader');

            Html5Qrcode.getCameras().then(cameras => {
                if (!cameras || cameras.length === 0) {
                    setStatus('❌ Kamera tidak ditemukan', true);
                    return;
                }

                // Pilih kamera belakang jika ada
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
                    setStatus('✅ Kamera aktif — Arahkan ke QR Code pelanggan');
                }).catch(err => {
                    console.error('Start camera error:', err);
                    setStatus('❌ Gagal membuka kamera', true);
                    showError('Pastikan izin kamera sudah diberikan di browser.');
                });

            }).catch(err => {
                console.error('getCameras error:', err);
                setStatus('❌ Tidak bisa mengakses kamera', true);
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

            // Validasi URL harus mengandung /kasir/scan/
            const expectedPattern = /\/kasir\/scan\//;
            if (!expectedPattern.test(decodedText)) {
                setStatus('⚠️ QR Code tidak valid. Scan QR dari pelanggan NgopiGo.', true);
                return;
            }

            scanLocked = true;
            stopScanner();
            setStatus('✅ QR valid! Mengarahkan ke konfirmasi...');

            // Tunda sedikit agar kasir lihat feedback, lalu redirect
            setTimeout(() => {
                window.location.href = decodedText;
            }, 600);
        }

        function onScanError(error) {
            // Error biasa saat kamera sweep, ignore
        }
    })();
    </script>

    @if(session('success'))
    <div class="bg-[#1a2f1a] border border-[#4ade80]/50 text-[#4ade80] px-4 py-3 rounded-lg mb-6 shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-[#1a120f] rounded-xl shadow-xl overflow-hidden border border-[#C69C6D]/20 premium-card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#C69C6D]/20">
                <thead class="bg-[#2E1F1A]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Status Bayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-[#1a120f] divide-y divide-[#C69C6D]/10">
                    @forelse($orders as $order)
                    <tr class="hover:bg-[#2E1F1A]/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-semibold text-[#F5F0E6]">{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-[#F5F0E6] font-medium">🪑 {{ $order->table_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="font-medium text-[#F5F0E6]">{{ $order->customer_name }}</div>
                                <div class="text-[#C69C6D]">📱 {{ $order->phone }}</div>
                                @if($order->email)
                                <div class="text-[#C69C6D]">📧 {{ $order->email }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($order->payment_method === 'cod') bg-[#1a2f1a] text-[#4ade80] border border-[#4ade80]/30
                                @else bg-[#1a2330] text-[#60a5fa] border border-[#60a5fa]/30
                                @endif">
                                @if($order->payment_method === 'cod')
                                    💵 COD
                                @else
                                    💳 Online
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(auth()->guard('admin')->user()->canUpdatePaymentStatus())
                            <a href="{{ route('admin.orders.payment', $order->id) }}"
                               class="inline-flex items-center gap-2 px-3 py-1 rounded-lg text-xs font-medium transition
                                   {{ $order->getPaymentStatusBadgeClass() }} hover:opacity-80">
                                {!! $order->getPaymentStatusLabel() !!}
                            </a>
                            @else
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg text-xs font-medium
                                {{ $order->getPaymentStatusBadgeClass() }}">
                                {!! $order->getPaymentStatusLabel() !!}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-[#F5F0E6]">
                                @foreach($order->orderItems->take(2) as $item)
                                <div>{{ $item->quantity }}x {{ $item->product->name }}</div>
                                @endforeach
                                @if($order->orderItems->count() > 2)
                                <div class="text-[#C69C6D]">+{{ $order->orderItems->count() - 2 }} lainnya</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-medium border
                                @if($order->status === 'pending') bg-[#2f261a] text-[#fbbf24] border-[#fbbf24]/30
                                @elseif($order->status === 'preparing') bg-[#1a2330] text-[#60a5fa] border-[#60a5fa]/30
                                @elseif($order->status === 'ready') bg-[#1a2f1a] text-[#4ade80] border-[#4ade80]/30
                                @elseif($order->status === 'completed') bg-[#1a1a1a] text-[#F5F0E6] border-[#F5F0E6]/30
                                @else bg-[#2f1a1a] text-[#f87171] border-[#f87171]/30
                                @endif">
                                @php
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'preparing' => 'Disiapkan',
                                        'ready' => 'Siap',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan'
                                    ];
                                @endphp
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#C69C6D]">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                            <br>
                            <span class="text-xs text-[#C69C6D]/70">{{ $order->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.orders.edit', $order->id) }}"
                                   class="text-[#60a5fa] hover:text-[#93c5fd] transition" title="Edit">
                                    ✏️
                                </a>
                                @if(auth()->guard('admin')->user()->canUpdatePaymentStatus())
                                <a href="{{ route('admin.orders.receipt', $order->id) }}"
                                   class="text-[#4ade80] hover:text-[#6ee7b7] transition" title="Cetak Receipt">
                                    🧾
                                </a>
                                @endif
                                @if(auth()->guard('admin')->user()->isAdmin())
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="if(confirm('Hapus pesanan ini?')) this.closest('form').submit()"
                                            class="text-[#f87171] hover:text-[#fca5a5] transition" title="Hapus">
                                        🗑️
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-[#C69C6D]">
                            📭 Belum ada pesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
    @endif
@endsection
