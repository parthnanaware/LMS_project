<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_enrolment extends Model
{
    // Table name (if not following Laravel naming convention)
    protected $table = 'tbl_enrolment';

    // Primary key
    protected $primaryKey = 'id';

    // Mass assignable fields
    protected $fillable = [
        'student_id',
        'course_id',
        'mrp',
        'sell_price'
    ];

    // If table uses timestamps
    public $timestamps = true;

    // Student relationship
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    // Course relationship
    public function course()
    {
        return $this->belongsTo(tbl_corse::class, 'course_id', 'course_id');
    }
}

