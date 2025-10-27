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
    return $this->belongsToMany(tbl_subject::class,
    'course_subject', 'course_id', 'subject_id');
}
    public function subjects()
{
    return $this->belongsToMany(tbl_student::class, 'tbl_subject', 'subject_id', 'subject_id');
}


}

