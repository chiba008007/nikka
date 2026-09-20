<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SankaFeeOptionPrice;

class SankaFeeOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'sanka_fee_item_id',
        'label_ja',
        'label_en',
        'value',
        'amount',
        'sort_order',
        'status',
    ];

    public function item()
    {
        // 親の料金項目
        return $this->belongsTo(SankaFeeItem::class, 'sanka_fee_item_id');
    }
    public function prices()
    {
        // 参加区分ごとの料金
        return $this->hasMany(SankaFeeOptionPrice::class);
    }

    public function banquetOption()
    {
        return $this->belongsTo(
            SankaFeeOption::class,
            'banquet_status',
            'value'
        )
        ->where('sanka_fee_item_id', 2)
        ->where('status', 1);
    }
}
