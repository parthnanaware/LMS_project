<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_enrolment extends Model
{
    protected $table = 'tbl_enrolment';

    protected $primaryKey = 'id';

    protected $fillable = [
        'student_id',
        'course_id',
        'mrp',
        'sell_price',
        'status'
    ];

    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(tbl_corse::class, 'course_id', 'course_id');
    }
}

