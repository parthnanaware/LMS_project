<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_section extends Model
{
    use HasFactory;

    protected $table = 'section';

    protected $fillable = ['tital', 'dis', 'sub_id'];

    public function subject()
    {
        return $this->belongsTo(tbl_subject::class, 'subject_id');
    }
}
