<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'is_member',
        'total_price',
        'paid',
        'change',
        'points_used',
        'points_earned',
        'user_id'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}
