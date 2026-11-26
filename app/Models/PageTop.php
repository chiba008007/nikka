<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageTop extends Model
{
    use SoftDeletes;

    protected $table = 'page_top';

    public const CREATED_AT = 'regist_at';
    public const UPDATED_AT = 'update_at';

    protected $fillable = [
        'num',
        'type',
        'note',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
