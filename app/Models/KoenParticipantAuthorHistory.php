<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoenParticipantAuthorHistory extends Model
{
    protected $table = 'koen_participant_author_histories';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'is_presenter' => 'boolean',
        'is_award_contact' => 'boolean',
        'operated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
