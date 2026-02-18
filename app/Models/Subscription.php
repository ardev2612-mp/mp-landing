<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'midtrans_order_id',
        'amount',
        'payment_status',
        'expires_at',
        'current_plan',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Check if subscription is currently active.
     */
    public function isActive()
    {
        return $this->is_active 
            && $this->payment_status === 'success' 
            && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    /**
     * Check if subscription is expired.
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if customer can upgrade from this plan.
     */
    public function canUpgrade()
    {
        $planHierarchy = ['free', 'basic', 'pro', 'proplus', 'advanced'];
        $currentIndex = array_search($this->current_plan, $planHierarchy);
        
        return $currentIndex !== false && $currentIndex < count($planHierarchy) - 1;
    }

    /**
     * Get available upgrade plans.
     */
    public function getUpgradePlans()
    {
        $planHierarchy = ['free', 'basic', 'pro', 'proplus', 'advanced'];
        $currentIndex = array_search($this->current_plan, $planHierarchy);
        
        if ($currentIndex === false) {
            return [];
        }
        
        return array_slice($planHierarchy, $currentIndex + 1);
    }

    /**
     * Scope to get only active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('payment_status', 'success')
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', Carbon::now());
            });
    }
}
