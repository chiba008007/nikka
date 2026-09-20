<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SankaParticipant extends Model
{
    use HasFactory;
    use SoftDeletes;

    // 使用するテーブル名
    protected $table = 'sanka_participants';

    // 一括登録を許可する項目
    protected $fillable = [
        'reception_serial',
        'reception_number',
        'status',
        'participation_status',
        'banquet_status',
        'participation_payment_status',
        'banquet_payment_status',
        'add_column_1',
        'add_column_2',
        'add_column_3',
        'add_column_4',
        'add_column_5',
        'add_column_6',
        'add_column_7',
        'add_column_8',
        'add_column_9',
        'add_column_10',
        'add_column_11',
        'add_column_12',
        'add_column_13',
        'add_column_14',
        'add_column_15',
        'add_column_16',
        'add_column_17',
        'add_column_18',
        'add_column_19',
        'add_column_20',
        'add_column_21',
        'add_column_22',
        'add_column_23',
        'add_column_24',
        'add_column_25',
        'add_column_26',
        'add_column_27',
        'add_column_28',
        'add_column_29',
        'add_column_30',
        'add_column_31',
        'add_column_32',
        'add_column_33',
        'add_column_34',
        'add_column_35',
        'add_column_36',
        'add_column_37',
        'add_column_38',
        'add_column_39',
        'add_column_40',
        'add_column_41',
        'add_column_42',
        'add_column_43',
        'add_column_44',
        'add_column_45',
        'add_column_46',
        'add_column_47',
        'add_column_48',
        'add_column_49',
        'add_column_50',
    ];

    // 型変換
    protected $casts = [
        'status' => 'integer',
        'participation_status' => 'integer',
        'banquet_status' => 'integer',
        'participation_payment_status' => 'integer',
        'banquet_payment_status' => 'integer',
    ];

    public function participationOption()
    {
        return $this->belongsTo(
            SankaFeeOption::class,
            'participation_status', // sanka_participants側
            'value'                 // sanka_fee_options側
        )
        ->where('sanka_fee_item_id', 1)
        ->where('status', 1);
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
