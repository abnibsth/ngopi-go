<?php
/**
 * Test Midtrans Connection
 * Akses: http://localhost/NgopiGo/public/test-midtrans.php
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "<h1>🔍 Test Midtrans Connection</h1>";
echo "<pre>";

// Test 1: Config
echo "\n=== CONFIG ===\n";
$config = [
    'merchant_id' => config('services.midtrans.merchant_id'),
    'client_key' => config('services.midtrans.client_key'),
    'server_key' => substr(config('services.midtrans.server_key'), 0, 15) . '...',
    'is_production' => config('services.midtrans.is_production', false),
];
echo "Config: " . json_encode($config, JSON_PRETTY_PRINT) . "\n";

// Test 2: DNS Resolution
echo "\n=== DNS RESOLUTION ===\n";
$host = 'api.sandbox.midtrans.com';
$ip = gethostbyname($host);
$dnsResult = [
    'host' => $host,
    'ip' => $ip,
    'resolved' => $ip !== $host ? 'YES ✅' : 'NO ❌',
];
echo "DNS: " . json_encode($dnsResult, JSON_PRETTY_PRINT) . "\n";

// Test 3: HTTP Connection
echo "\n=== HTTP CONNECTION ===\n";
try {
    $ch = curl_init('https://api.sandbox.midtrans.com/v2/status');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "HTTP Code: $httpCode\n";
    echo "Response: $response\n";
    if ($error) {
        echo "Error: $error\n";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}

// Test 4: Ping
echo "\n=== PING TEST ===\n";
if (function_exists('shell_exec')) {
    $output = shell_exec('ping -n 1 api.sandbox.midtrans.com');
    echo $output ?? "Ping not available\n";
}

echo "</pre>";
echo "<hr>";
echo "<h3>📋 Kesimpulan:</h3>";
echo "<ul>";
echo "<li>Jika DNS 'NO' → Masalah internet/DNS</li>";
echo "<li>Jika HTTP error tapi DNS OK → Firewall/SSL issue</li>";
echo "<li>Jika semua OK → Midtrans siap digunakan</li>";
echo "</ul>";
