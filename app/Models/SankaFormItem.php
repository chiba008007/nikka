<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SankaFormItemOption;

class SankaFormItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_key',
        'name',
        'label_ja',
        'label_en',
        'type',
        'placeholder_ja',
        'placeholder_en',
        'required',
        'sort_order',
        'column',
        'error_flag',
        'error_messages',
        'status',
    ];
    protected $casts = [
        'required' => 'boolean',
        'error_messages' => 'array',
    ];

    public function options()
    {
        return $this->hasMany(SankaFormItemOption::class);
    }

}
