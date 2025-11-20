<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_corse extends Model
{
    protected $table = 'tbl_corse';
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'course_name',
        'course_description',
        'course_image',
        'mrp',
        'sell_price',
        'subject_id',
    ];

    protected $casts = [
        'subject_id' => 'array',
    ];

    public function getSubjectIdAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function subjects()
    {
        return tbl_subject::whereIn('subject_id', $this->subject_id ?? [])->get();
    }
    // inside tbl_corse model
public function enrolments()
{
    return $this->hasMany(\App\Models\tbl_enrolment::class, 'course_id', 'course_id');
}

}
