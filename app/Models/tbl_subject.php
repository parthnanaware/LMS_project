<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_subject extends Model
{
    protected $table = "tbl_subject";
    protected $primaryKey = 'subject_id';

    protected $fillable = [
        'subject_name',
        'subject_img',
        'subject_des'
    ];
    public function sections()
    {
        return $this->hasMany(tbl_section::class, 'sub_id');
    }
public function courses()
{
    return $this->belongsToMany(tbl_corse::class, 'course_subject', 'subject_id', 'course_id');
}
}
