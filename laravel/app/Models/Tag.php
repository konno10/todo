<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_id',
        'tag_name',
        'tag_detail',
    ];

    protected $casts = [
        'tag_id'=>'integer',
      ];
}