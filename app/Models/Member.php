<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'member_code',
        'barcode',
        'name',
        'email',
        'phone',
        'address',
        'points',
        'total_spent',
        'rating',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points' => 'decimal:2',
        'total_spent' => 'decimal:2',
        'rating' => 'integer',
    ];

    protected $appends = ['rating_stars'];

    // Generate unique member code
    public static function generateMemberCode()
    {
        $prefix = 'MBR';
        $date = date('ymd');
        $lastMember = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        $number = $lastMember ? (int)substr($lastMember->member_code, -4) + 1 : 1;
        
        return $prefix . $date . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // Generate unique barcode (same as member_code for simplicity)
    public static function generateBarcode()
    {
        return self::generateMemberCode();
    }

    /**
     * Calculate and update member rating based on total spending
     * Rating tiers:
     * 1★: 0 - 999,999
     * 2★: 1,000,000 - 1,999,999
     * 3★: 2,000,000 - 2,999,999
     * 4★: 3,000,000 - 4,999,999
     * 5★: 5,000,000+
     */
    public function calculateRating()
    {
        $spent = $this->total_spent;

        if ($spent >= 5000000) {
            return 5;
        } elseif ($spent >= 3000000) {
            return 4;
        } elseif ($spent >= 2000000) {
            return 3;
        } elseif ($spent >= 1000000) {
            return 2;
        } else {
            return 1;
        }
    }

    /**
     * Update member after a purchase
     * - Add to total_spent
     * - Calculate points (Rp 500,000 = +0.5 points)
     * - Recalculate rating
     *
     * @param float $amount Purchase amount
     * @return void
     */
    public function addPurchase($amount)
    {
        // Update total spent
        $this->total_spent += $amount;

        // Calculate points to add (Rp 500,000 = 0.5 points)
        $pointsToAdd = ($amount / 500000) * 0.5;
        $this->points += $pointsToAdd;

        // Recalculate rating
        $this->rating = $this->calculateRating();

        // Save changes
        $this->save();
    }

    /**
     * Get rating as star string for display
     *
     * @return string
     */
    public function getRatingStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
