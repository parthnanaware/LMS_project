<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_corse extends Model
{
    protected $table      = 'tbl_corse';
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


    public function subjects()
    {
        $ids = $this->subject_id ?? [];
        if (!is_array($ids) || empty($ids)) {
            return collect([]);
        }

        return tbl_subject::whereIn('subject_id', $ids)->get();
    }

    public function enrolments()
    {
        return $this->hasMany(
            \App\Models\tbl_enrolment::class,
            'course_id',
            'course_id'
        );
    }
}
