<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_student extends Model
{
    protected $table = "tbl_students";
    protected $fillable = [
'student_name',
'student_email',
'student_address',
'student_password'
];

}
