<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'error_message_ja',
        'error_message_en',
        'error_flag',
        'status',
        'checkbox_note_description',
        'checkbox_note_description_en',
    ];

    protected $casts = [
        'required' => 'boolean',
        'error_flag' => 'boolean',
        'status' => 'boolean',
    ];

    public function options()
    {
        // 選択肢を取得
        return $this->hasMany(SankaFormItemOption::class);
    }
}
