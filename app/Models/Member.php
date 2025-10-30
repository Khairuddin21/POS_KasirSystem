<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'member_code',
        'name',
        'email',
        'phone',
        'address',
        'points',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points' => 'integer',
    ];

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
}
