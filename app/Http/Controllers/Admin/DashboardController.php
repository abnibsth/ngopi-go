<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        // Statistik Utama
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $pendingOrders = Order::whereIn('status', ['pending', 'preparing', 'ready'])->count();
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_available', true)->count();

        // Statistik Hari Ini
        $todayOrdersCount = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())
            ->where(function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->sum('total_amount');
        $todayOrders = $todayOrdersCount;

        // Statistik Minggu Ini
        $weekRevenue = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        $weekOrders = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        // Statistik Bulan Ini
        $monthRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        $monthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Top 5 Produk Terlaris
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', 'products.image', 'products.category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name', 'products.image', 'products.category')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Top 10 Produk Terlaris - 7 Hari Terakhir
        $top10Products = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('products.name', 'products.category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereBetween('orders.created_at', [now()->subDays(7), now()])
            ->where('orders.payment_status', 'paid')
            ->groupBy('products.id', 'products.name', 'products.category')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Top 10 Produk Terlaris Bulan Ini
        $top10ProductsMonth = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('products.name', 'products.category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereBetween('orders.created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->where('orders.payment_status', 'paid')
            ->groupBy('products.id', 'products.name', 'products.category')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Produk Terlaris per Kategori - 7 Hari Terakhir
        $productsByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('products.category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereBetween('orders.created_at', [now()->subDays(7), now()])
            ->where('orders.payment_status', 'paid')
            ->groupBy('products.category')
            ->orderBy('total_sold', 'desc')
            ->get();

        // Produk Terlaris per Kategori Bulan Ini
        $productsByCategoryMonth = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('products.category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereBetween('orders.created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->where('orders.payment_status', 'paid')
            ->groupBy('products.category')
            ->orderBy('total_sold', 'desc')
            ->get();

        // Grafik Penjualan 7 Hari Terakhir
        $salesChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Order::whereDate('created_at', $date->format('Y-m-d'))
                ->where('payment_status', 'paid')
                ->sum('total_amount');
            $orders = Order::whereDate('created_at', $date->format('Y-m-d'))->count();

            $salesChart[] = [
                'date' => $date->format('d M'),
                'revenue' => $revenue,
                'orders' => $orders,
            ];
        }

        // Status Orders Breakdown
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Pembayaran Breakdown
        $paymentsByMethod = Order::selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method');

        // Recent Orders
        $recentOrders = Order::with('orderItems.product')
            ->latest()
            ->limit(5)
            ->get();

        // Admin Count
        $adminCount = Admin::where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'totalProducts',
            'activeProducts',
            'todayOrders',
            'todayRevenue',
            'todayOrdersCount',
            'weekRevenue',
            'weekOrders',
            'monthRevenue',
            'monthOrders',
            'topProducts',
            'top10Products',
            'top10ProductsMonth',
            'productsByCategory',
            'productsByCategoryMonth',
            'salesChart',
            'ordersByStatus',
            'paymentsByMethod',
            'recentOrders',
            'adminCount'
        ));
    }
}
