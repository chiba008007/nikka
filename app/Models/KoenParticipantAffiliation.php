<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoenParticipantAffiliation extends Model
{
    protected $table = 'koen_participant_affiliations';

    protected $fillable = [
        'koen_participant_id',
        'affiliation_number',
        'organization',
        'department',
        'short_name',
        'english',
        'english_short',
    ];

    public function koenParticipant()
    {
        return $this->belongsTo(KoenParticipant::class);
    }
}
