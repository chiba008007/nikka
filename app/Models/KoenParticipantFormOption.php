<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoenParticipantFormOption extends Model
{
    use HasFactory;

    protected $table = 'koen_participant_form_options';

    protected $fillable = [
        'koen_participant_form_id',
        'label_ja',
        'label_en',
        'value',
        'sort_order',
        'status',
    ];
}
