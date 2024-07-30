<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'timestamped_name',
        'path',
        'archived_at',
    ];

    protected $dates = ['archived_at'];
}
