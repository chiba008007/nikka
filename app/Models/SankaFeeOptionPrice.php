<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SankaFeeOptionPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sanka_fee_option_id',
        'join_type_id',
        'amount',
        'status',
    ];

    public function option()
    {
        // 親の料金選択肢
        return $this->belongsTo(SankaFeeOption::class, 'sanka_fee_option_id');
    }
}
