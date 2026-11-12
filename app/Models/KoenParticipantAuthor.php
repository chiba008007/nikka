<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoenParticipantAuthor extends Model
{
    protected $table = 'koen_participant_authors';

    protected $fillable = [
        'koen_participant_id',
        'author_number',
        'is_presenter',
        'is_award_contact',
        'family_name_ja',
        'given_name_ja',
        'given_name_en',
        'family_name_en',
        'affiliation_numbers',
    ];

    protected $casts = [
        'is_presenter' => 'boolean',
        'is_award_contact' => 'boolean',
    ];

    public function koenParticipant()
    {
        return $this->belongsTo(KoenParticipant::class);
    }
}
