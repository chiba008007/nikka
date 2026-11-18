<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SankaParticipant;

class KoenParticipantHistory extends Model
{
    protected $table = 'koen_participant_histories';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'status' => 'integer',
        'operated_at' => 'datetime',
        'participant_created_at' => 'datetime',
        'participant_updated_at' => 'datetime',
        'participant_deleted_at' => 'datetime',
    ];

    public function participant()
    {
        return $this->belongsTo(
            SankaParticipant::class,
            'participant_id',
            'id'
        )->withTrashed();
    }

    public function authorHistories()
    {
        return $this->hasMany(
            KoenParticipantAuthorHistory::class,
            'koen_participant_id',
            'koen_participant_id'
        );
    }

    public function affiliationHistories()
    {
        return $this->hasMany(
            KoenParticipantAffiliationHistory::class,
            'koen_participant_id',
            'koen_participant_id'
        );
    }

}
