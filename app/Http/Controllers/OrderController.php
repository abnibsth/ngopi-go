<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($tableNumber = null)
    {
        $products = Product::where('is_available', true)->get()->groupBy('category');
        $tableNumber = $tableNumber ?? '1';

        return view('customer.order', compact('products', 'tableNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('=== ORDER STORE START ===');
        \Log::info('Payment Method: ' . $request->payment_method);
        \Log::info('Items: ' . json_encode($request->items));
        
        $request->validate([
            'table_number' => 'required|string',
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cod,online',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $orderNumber = 'ORD-' . strtoupper(Str::random(6));
            $totalAmount = 0;

            // Hitung total
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;
            }

            // Buat order
            $order = Order::create([
                'order_number' => $orderNumber,
                'table_number' => $request->table_number,
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            \Log::info('Order created: ' . $orderNumber);

            // Buat order items
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();
            \Log::info('Order committed to database');

            // Jika pembayaran online, buat snap token dan simpan di session
            if ($request->payment_method === 'online') {
                \Log::info('Creating Midtrans Snap Token...');
                $snapToken = $this->midtransService->createSnapToken($order);

                if ($snapToken['success']) {
                    \Log::info('Snap Token created: ' . $snapToken['snap_token']);
                    // Simpan snap token di session
                    session([
                        'midtrans_snap_token_' . $order->order_number => $snapToken['snap_token'],
                        'midtrans_client_key' => $this->midtransService->getClientKey()
                    ]);
                    
                    $redirectUrl = route('order.payment', [
                        'order' => $order->order_number
                    ]);
                    \Log::info('Redirecting to: ' . $redirectUrl);
                    
                    // Redirect ke halaman pembayaran
                    return redirect()->route('order.payment', [
                        'order' => $order->order_number
                    ]);
                } else {
                    \Log::error('Midtrans Snap Token Error: ' . $snapToken['message']);
                    // Delete order jika payment gagal
                    $order->delete();
                    // Redirect back dengan error
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal membuat pembayaran: ' . $snapToken['message'] . '. Silakan coba lagi atau pilih COD.');
                }
            }

            \Log::info('Redirecting to success page (COD)');
            return redirect()->route('order.success', $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order Creation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pesanan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($orderNumber)
    {
        $order = Order::with('orderItems.product')->where('order_number', $orderNumber)->firstOrFail();

        return view('customer.success', compact('order'));
    }

    /**
     * Display payment page with Midtrans Snap.
     */
    public function payment($orderNumber)
    {
        $order = Order::with('orderItems.product')->where('order_number', $orderNumber)->firstOrFail();

        // Get snap token from session
        $snapToken = session('midtrans_snap_token_' . $orderNumber);
        $clientKey = session('midtrans_client_key') ?? $this->midtransService->getClientKey();

        \Log::info('=== PAYMENT PAGE LOAD ===');
        \Log::info('Order Number: ' . $orderNumber);
        \Log::info('Snap Token from session: ' . ($snapToken ?? 'NULL'));
        \Log::info('Client Key: ' . substr($clientKey, 0, 15) . '...');

        if (!$snapToken) {
            \Log::info('No snap token in session, creating new one...');
            // Jika tidak ada snap token, buat baru
            $snapTokenResult = $this->midtransService->createSnapToken($order);
            if ($snapTokenResult['success']) {
                $snapToken = $snapTokenResult['snap_token'];
                session([
                    'midtrans_snap_token_' . $orderNumber => $snapToken,
                    'midtrans_client_key' => $clientKey
                ]);
                \Log::info('New snap token created: ' . substr($snapToken, 0, 10) . '...');
            } else {
                \Log::error('Failed to create snap token: ' . $snapTokenResult['message']);
                return redirect()->route('order.success', $orderNumber)
                    ->with('error', 'Gagal memuat pembayaran: ' . $snapTokenResult['message']);
            }
        }
        
        // Generate Midtrans redirect URL (fallback jika Snap popup gagal)
        $midtransUrl = 'https://app.sandbox.midtrans.com/snap/v4/redirection/' . $snapToken;

        \Log::info('Rendering payment view with snap token');
        
        return view('customer.payment', compact('order', 'snapToken', 'clientKey', 'midtransUrl'));
    }

    /**
     * Handle Midtrans payment callback/notification.
     */
    public function midtransCallback(Request $request)
    {
        $notification = $request->all();
        
        // Verifikasi signature key
        $signatureKey = hash('sha512', $notification['order_id'] . $notification['status_code'] . $notification['gross_amount'] . config('services.midtrans.server_key'));
        
        if ($signatureKey !== ($notification['signature_key'] ?? '')) {
            return response()->json(['status' => 'invalid signature'], 400);
        }

        $order = Order::where('order_number', $notification['order_id'])->first();
        
        if (!$order) {
            return response()->json(['status' => 'order not found'], 404);
        }

        $transactionStatus = $notification['transaction_status'];
        $fraudStatus = $notification['fraud_status'] ?? null;

        // Update status order berdasarkan status pembayaran
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $order->update([
                    'status' => 'preparing',
                    'payment_status' => 'paid'
                ]);
            }
        } else if ($transactionStatus == 'settlement') {
            $order->update([
                'status' => 'preparing',
                'payment_status' => 'paid'
            ]);
        } else if ($transactionStatus == 'pending') {
            $order->update(['status' => 'pending']);
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $order->update(['status' => 'cancelled']);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Display kitchen view.
     */
    public function kitchen()
    {
        $orders = Order::with('orderItems.product')
            ->where('payment_status', 'paid')
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->latest()
            ->get();

        // Hitung semua pesanan yang sudah selesai (total)
        $completedToday = Order::where('status', 'completed')->count();

        return view('admin.kitchen', compact('orders', 'completedToday'));
    }

    /**
     * Display order history.
     */
    public function history()
    {
        $orders = Order::with('orderItems.product')
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest()
            ->paginate(20);

        return view('admin.history', compact('orders'));
    }

    /**
     * Show payment update form for cashier.
     */
    public function updatePayment($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.payment', compact('order'));
    }

    /**
     * Update payment status for cashier.
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'payment_status' => 'required|in:pending,paid',
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Status pembayaran berhasil diupdate.');
    }

    /**
     * Print receipt for order.
     */
    public function printReceipt($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('admin.orders.receipt', compact('order'));
    }

    /**
     * Halaman konfirmasi pembayaran kasir setelah scan QR code pelanggan.
     */
    public function cashierScan($orderNumber)
    {
        $order = Order::with('orderItems.product')->where('order_number', $orderNumber)->firstOrFail();
        return view('admin.orders.scan-pay', compact('order'));
    }

    /**
     * Konfirmasi pembayaran tunai oleh kasir setelah scan QR.
     */
    public function cashierConfirmPayment($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('admin.orders.index')
                ->with('success', 'Pesanan ' . $order->getFormattedOrderNumber() . ' sudah ditandai lunas sebelumnya.');
        }

        $order->update([
            'payment_status' => 'paid',
            'status'         => 'preparing',
        ]);

        \Log::info('Cashier confirmed payment via QR scan: ' . $orderNumber);

        return redirect()->route('admin.orders.index')
            ->with('success', '✅ Pembayaran pesanan ' . $order->getFormattedOrderNumber() . ' berhasil dikonfirmasi lunas!');
    }

    /**
     * Cek status pembayaran order (AJAX polling dari halaman pelanggan).
     */
    public function checkPaymentStatus($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return response()->json(['paid' => false, 'error' => 'Order not found'], 404);
        }

        return response()->json([
            'paid'           => $order->payment_status === 'paid',
            'payment_status' => $order->payment_status,
            'status'         => $order->status,
        ]);
    }

    /**
     * Show walkthrough order creation form for cashier.
     */
    public function walkthroughCreate()
    {
        $products = \App\Models\Product::where('is_available', true)->get()->groupBy('category');
        $tables = range(1, 20); // Meja 1-20
        
        return view('admin.orders.walkthrough', compact('products', 'tables'));
    }

    /**
     * Store walkthrough order created by cashier.
     */
    public function walkthroughStore(Request $request)
    {
        \Log::info('=== WALKTHROUGH ORDER STORE ===');
        
        $request->validate([
            'table_number' => 'required|string',
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'payment_method' => 'required|in:cod,online',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        \DB::beginTransaction();
        try {
            // Get queue number for today
            $todayStart = now()->startOfDay();
            $todayEnd = now()->endOfDay();
            $queueNumber = \App\Models\Order::whereBetween('created_at', [$todayStart, $todayEnd])->count() + 1;
            $formattedQueue = str_pad($queueNumber, 3, '0', STR_PAD_LEFT);
            $formattedTable = str_pad($request->table_number, 2, '0', STR_PAD_LEFT);
            
            // Format: ORD-{meja}-{antrian}
            $orderNumber = 'ORD-' . $formattedTable . '-' . $formattedQueue;
            
            $totalAmount = 0;

            // Hitung total
            foreach ($request->items as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;
            }

            // Buat order
            $order = \App\Models\Order::create([
                'order_number' => $orderNumber,
                'table_number' => $request->table_number,
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'total_amount' => $totalAmount,
            ]);

            // Buat order items
            foreach ($request->items as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ]);
            }

            \DB::commit();

            // Redirect ke receipt untuk cetak
            return redirect()->route('admin.orders.receipt', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Walkthrough Order Error: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Gagal membuat pesanan: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
