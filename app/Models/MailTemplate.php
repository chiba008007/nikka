<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    // 使用するテーブル名
    protected $table = 'mail_templates';

    // 一括登録・更新を許可する項目
    protected $fillable = [
        'mail_type',
        'create_subject',
        'update_subject',
        'body',
        'status',
    ];

    // 型変換
    protected $casts = [
        'status' => 'integer',
    ];
}
