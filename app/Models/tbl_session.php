<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_session extends Model
{
    protected $table = 'session';

    protected $fillable = [
        'titel',
        'type',
        'section_id',
        'video',
        'pdf',
        'task',
        'exam',
        'is_locked',
    ];

    public function section()
    {
        return $this->belongsTo(tbl_section::class, 'section_id');
    }


    public function session()
{
    return $this->belongsTo(tbl_session::class, 'session_id');
}
}
