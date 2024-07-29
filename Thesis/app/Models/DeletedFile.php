<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'timestamped_name',
        'path',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];
}
