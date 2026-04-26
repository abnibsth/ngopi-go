<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'table_number',
        'customer_name',
        'phone',
        'status',
        'payment_method',
        'payment_status',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function getPaymentStatusLabel(): string
    {
        return $this->payment_status === 'paid' ? '✅ Lunas' : '⏳ Belum Lunas';
    }

    public function getPaymentStatusBadgeClass(): string
    {
        return $this->payment_status === 'paid'
            ? 'bg-green-900/50 text-green-400 border-green-500/30'
            : 'bg-yellow-900/50 text-yellow-400 border-yellow-500/30';
    }

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
}
