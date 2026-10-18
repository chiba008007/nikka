<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoenParticipantAuthorOption extends Model
{
    use HasFactory;

    protected $table = 'koen_participant_author_option';

    protected $fillable = [
        'type',
        'note_ja',
        'note_en',
        'status',
        'required',
    ];

    protected $casts = [
        'status' => 'boolean',
        'required' => 'boolean',
    ];
}
