<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_cart extends Model
{
      protected $table = 'carts';   
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id',
        'course_id',
        'quantity'
    ];
}
