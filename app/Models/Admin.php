<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'username',
        'email',
        'password',
        'name',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_KITCHEN = 'kitchen';
    const ROLE_CASHIER = 'cashier';

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isKitchen(): bool
    {
        return $this->role === self::ROLE_KITCHEN;
    }

    public function isCashier(): bool
    {
        return $this->role === self::ROLE_CASHIER;
    }

    public function canManageDashboard(): bool
    {
        return $this->isAdmin();
    }

    public function canManageOrders(): bool
    {
        return $this->isAdmin() || $this->isCashier();
    }

    public function canManageKitchen(): bool
    {
        return $this->isAdmin() || $this->isKitchen();
    }

    public function canViewKitchenOrders(): bool
    {
        return $this->isAdmin() || $this->isKitchen();
    }

    public function canViewOrderHistory(): bool
    {
        return true; // All roles can view history
    }

    // Cashier specific permissions
    public function canUpdatePaymentStatus(): bool
    {
        return $this->isAdmin() || $this->isCashier();
    }

    public function canCreateWalkthroughOrder(): bool
    {
        return $this->isAdmin() || $this->isCashier();
    }

    public function canPrintReceipt(): bool
    {
        return true; // All roles can print receipt
    }

    // Get role display name
    public function getRoleName(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_KITCHEN => 'Dapur',
            self::ROLE_CASHIER => 'Kasir',
            default => $this->role,
        };
    }
}
