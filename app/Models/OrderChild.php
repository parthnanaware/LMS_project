<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderChild extends Model
{
    protected $table = 'order_child';
    protected $primaryKey = 'order_child_id';

    protected $fillable = [
        'order_id',
        'course_id',
        'quantity',
        'mrp',
        'sell_price'
    ];

    public function course()
    {
        return $this->belongsTo(tbl_corse::class, 'course_id', 'course_id');
    }
}
