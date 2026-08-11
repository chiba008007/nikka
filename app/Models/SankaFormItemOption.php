<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SankaFormItemOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'sanka_form_item_id',
        'label_ja',
        'label_en',
        'value',
        'sort_order',
        'status',
    ];

    public function item()
    {
        // 親フォーム項目を取得
        return $this->belongsTo(SankaFormItem::class, 'sanka_form_item_id');
    }
}
