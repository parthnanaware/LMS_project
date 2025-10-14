<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_corse extends Model
{
    protected $table = 'tbl_corse';

    protected $primaryKey = 'id';

    protected $fillable = [
        'course_title',
        'course_description',
        'course_image',
        'subject_id',
    ];
    public function subject()
    {
        return $this->belongsTo(tbl_subject::class, 'subject_id');
    }
}


