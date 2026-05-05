<?php

namespace Tests\Feature;

use App\Models\Order;
use Tests\TestCase;

class MidtransCallbackTest extends TestCase
{
    public function test_midtrans_settlement_marks_order_as_paid(): void
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('pdo_sqlite driver is not available in this environment.');
        }

        config()->set('services.midtrans.server_key', 'test-server-key');

        $order = Order::create([
            'order_number' => 'ORD-TEST01',
            'table_number' => '1',
            'customer_name' => 'Tester',
            'phone' => '0800000000',
            'status' => 'pending',
            'payment_method' => 'online',
            'payment_status' => 'pending',
            'total_amount' => 22000,
            'notes' => null,
        ]);

        $payload = [
            'order_id' => $order->order_number,
            'status_code' => '200',
            'gross_amount' => '22000.00',
            'transaction_status' => 'settlement',
            'signature_key' => hash('sha512', $order->order_number . '200' . '22000.00' . 'test-server-key'),
        ];

        $this->postJson('/midtrans/callback', $payload)
            ->assertOk()
            ->assertJson(['status' => 'ok']);

        $order->refresh();
        $this->assertSame('paid', $order->payment_status);
        $this->assertSame('preparing', $order->status);
    }

    public function test_midtrans_invalid_signature_is_rejected(): void
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('pdo_sqlite driver is not available in this environment.');
        }

        config()->set('services.midtrans.server_key', 'test-server-key');

        $order = Order::create([
            'order_number' => 'ORD-TEST02',
            'table_number' => '1',
            'customer_name' => 'Tester',
            'phone' => '0800000000',
            'status' => 'pending',
            'payment_method' => 'online',
            'payment_status' => 'pending',
            'total_amount' => 38000,
            'notes' => null,
        ]);

        $payload = [
            'order_id' => $order->order_number,
            'status_code' => '200',
            'gross_amount' => '38000.00',
            'transaction_status' => 'settlement',
            'signature_key' => 'invalid',
        ];

        $this->postJson('/midtrans/callback', $payload)
            ->assertStatus(400)
            ->assertJson(['status' => 'invalid signature']);

        $order->refresh();
        $this->assertSame('pending', $order->payment_status);
        $this->assertSame('pending', $order->status);
    }
}

