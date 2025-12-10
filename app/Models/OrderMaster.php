<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    protected $table = 'order_master';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'total_amount',
        'discount_amount',
        'final_amount',
        'status',
        'payment_method',
        'payment_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderChild::class, 'order_id', 'order_id');
    }
}
