<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoenParticipantAffiliationHistory extends Model
{
    protected $table = 'koen_participant_affiliation_histories';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'operated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
