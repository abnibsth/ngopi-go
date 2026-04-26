<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MidtransService
{
    protected $serverKey;
    protected $clientKey;
    protected $merchantId;
    protected $isProduction;
    protected $baseUrl;
    protected $snapUrl;

    public function __construct()
    {
        $this->merchantId = config('services.midtrans.merchant_id');
        $this->serverKey = config('services.midtrans.server_key');
        $this->clientKey = config('services.midtrans.client_key');
        $this->isProduction = config('services.midtrans.is_production', false);

        // Sandbox URLs
        // Using direct IP to avoid DNS resolution issues
        $this->baseUrl = 'https://api.sandbox.midtrans.com';
        $this->snapUrl = 'https://app.sandbox.midtrans.com';

        // Production URLs (jika nanti digunakan)
        if ($this->isProduction) {
            $this->baseUrl = 'https://api.midtrans.com';
            $this->snapUrl = 'https://app.midtrans.com';
        }
        
        \Log::info('Midtrans Service initialized');
        \Log::info('Base URL: ' . $this->baseUrl);
        \Log::info('Server Key configured: ' . (empty($this->serverKey) ? 'NO' : 'YES'));
    }

    /**
     * Create Midtrans Snap transaction
     */
    public function createSnapToken($order)
    {
        try {
            \Log::info('=== MIDTRANS API CALL START ===');
            \Log::info('Creating Midtrans Snap Token for order: ' . $order->order_number);
            \Log::info('Server Key configured: ' . (empty($this->serverKey) ? 'NO' : 'YES'));
            \Log::info('Base URL: ' . $this->baseUrl);
            
            $transactionData = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $order->customer_name,
                    'phone' => $order->phone,
                ],
                'item_details' => $this->getItemDetails($order),
                'enabled_payments' => [
                    'credit_card',
                    'gopay',
                    'shopeepay',
                    'permata_va',
                    'bca_va',
                    'bni_va',
                    'bri_va',
                    'cimb_va',
                    'other_va',
                    'mandiri_bill',
                    'qris',
                    'indomaret',
                    'alfamart',
                ],
            ];

            \Log::info('Transaction Data: ' . json_encode($transactionData));
            \Log::info('Request Headers: Authorization=Basic [HIDDEN]');

            // Use Guzzle HTTP client directly for better control
            $client = new \GuzzleHttp\Client([
                'verify' => false, // Disable SSL verification
                'timeout' => 30,
            ]);

            try {
                // Snap API endpoint - returns snap_token for popup
                $response = $client->post($this->snapUrl . '/snap/v1/transactions', [
                    'json' => $transactionData,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':'),
                    ],
                ]);

                $statusCode = $response->getStatusCode();
                $responseBody = json_decode($response->getBody(), true);
                
                \Log::info('Midtrans Response Status: ' . $statusCode);
                \Log::info('Midtrans Response Body: ' . json_encode($responseBody));

                if ($statusCode == 200 || $statusCode == 201) {
                    \Log::info('✅ Midtrans Snap API Success');
                    // Snap API returns 'token' as snap_token
                    $snapToken = $responseBody['token'] ?? null;
                    $redirectUrl = $responseBody['redirect_url'] ?? null;
                    
                    if ($snapToken) {
                        \Log::info('✅ Snap Token created: ' . substr($snapToken, 0, 10) . '...');
                        return [
                            'success' => true,
                            'snap_token' => $snapToken,
                            'redirect_url' => $redirectUrl,
                        ];
                    } else {
                        \Log::error('❌ No token in response');
                        return [
                            'success' => false,
                            'message' => 'Gagal generate snap token',
                        ];
                    }
                }

                \Log::error('❌ Midtrans API Error: ' . json_encode($responseBody));
                return [
                    'success' => false,
                    'message' => $responseBody['status_message'] ?? 'Failed to create payment',
                ];

            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $response = $e->getResponse();
                $responseBody = json_decode($response->getBody(), true);
                \Log::error('❌ Midtrans Client Exception: ' . json_encode($responseBody));
                return [
                    'success' => false,
                    'message' => $responseBody['status_message'] ?? $e->getMessage(),
                ];
            } catch (\Exception $e) {
                \Log::error('❌ Midtrans Exception: ' . $e->getMessage());
                \Log::error('Exception type: ' . get_class($e));
                return [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
            }
        } catch (\Exception $e) {
            \Log::error('❌ Outer Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get item details for Midtrans
     */
    protected function getItemDetails($order)
    {
        $items = [];
        foreach ($order->orderItems as $item) {
            $items[] = [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        }
        return $items;
    }

    /**
     * Check transaction status
     */
    public function getTransactionStatus($orderId)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':'),
            ])->get($this->baseUrl . '/v2/' . $orderId . '/status');

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get client key for Snap JS
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * Get base URL
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
