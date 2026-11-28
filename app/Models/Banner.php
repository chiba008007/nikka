<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sort',
        'status',
        'image',
        'url',
    ];

    protected $casts = [
        'sort' => 'integer',
        'status' => 'boolean',
    ];
}
