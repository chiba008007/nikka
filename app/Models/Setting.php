<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $table = 'settings';

    protected $primaryKey = 'type';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'type',
        'name_ja',
        'name_en',
    ];
}
