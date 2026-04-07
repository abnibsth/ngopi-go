<?php
/**
 * Script untuk generate password hash untuk user Dapur
 * Jalankan sekali untuk mendapatkan password hash yang benar
 */

$passwords = [
    'admin' => 'admin123',
    'dapur' => 'dapur123',
    'kasir' => 'kasir123',
];

echo "=== Password Hashes untuk Role-Based Access ===\n\n";

foreach ($passwords as $username => $password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    echo "Username: {$username}\n";
    echo "Password: {$password}\n";
    echo "Hash: {$hash}\n";
    echo "---\n";
}

echo "\n=== SQL Update Statement ===\n\n";
foreach ($passwords as $username => $password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    echo "UPDATE admins SET password = '{$hash}' WHERE username = '{$username}';\n";
}
