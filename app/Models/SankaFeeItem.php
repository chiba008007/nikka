<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SankaFeeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label_ja',
        'label_en',
        'type',
        'description_ja',
        'description_en',
        'currency_label_ja',
        'currency_label_en',
        'sort_order',
        'status',
    ];

    public function options()
    {
        // 料金選択肢
        return $this->hasMany(SankaFeeOption::class);
    }
}
