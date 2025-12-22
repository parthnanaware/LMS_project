<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionProgress extends Model
{
    protected $table = 'tbl_session_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'subject_id',
        'section_id',
        'session_id',

        'video_file',
        'pdf_file',
        'task_file',
        'exam_file',

        'video_status',
        'pdf_status',
        'task_status',
        'exam_status',
    ];
}
