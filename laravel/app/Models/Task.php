<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'task_name',
        'task_detail',
        'task_date_start',
        'task_date_end',
        'task_priority',
        'task_category_id',
        'task_tag_id',
        'task_status',
        'task_predicted_hours',
        'task_actual_hours',
        'task_requester_user_id',
        'task_requested_user_id',
    ];

    protected $casts = [
        'task_id'=>'integer',
        'task_priority'=>'integer',
        'task_category_id'=>'integer',
        'task_tag_id'=>'integer',
        'task_status'=>'integer',
        'task_predicted_hours'=>'integer',
        'task_actual_hours'=>'integer',
        'task_requester_user_id'=>'integer',
        'task_requested_user_id'=>'integer',
      ];
}
