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
        'family_name',
        'first_name',
        'family_name_kana',
        'first_name_kana',
        'organization',
        'department',
        'laboratory',
        'address_type_id',
        'postal_code',
        'address',
        'telephone',
        'fax',
        'email',
        'password',
        'expertise_ids',
        'expertise_other',
        'society_ids',
        'society_other',
        'join_type_id',
        'travel_support_requested',
        'banquet_requested',
        'participation_fee',
        'banquet_fee',
        'total_amount',
        'remarks',
        'admin_remarks',
        'mail_sent',
        'is_selector',
        'status',
    ];

    // JSON項目を配列として扱う
    protected $casts = [
        'expertise_ids' => 'array',
        'society_ids' => 'array',
        'travel_support_requested' => 'boolean',
        'banquet_requested' => 'boolean',
        'mail_sent' => 'boolean',
        'is_selector' => 'boolean',
    ];
}
