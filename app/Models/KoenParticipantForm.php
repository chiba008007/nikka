<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KoenParticipantFormOption;

class KoenParticipantForm extends Model
{
    use HasFactory;
    protected $table = 'koen_participant_form';

    protected $fillable = [
        'page_type',
        'type',
        'type_code',
        'name',
        'enable_source_name',
        'enable_source_value',
        'explain_jp',
        'explain_en',
        'label_ja',
        'label_en',
        'placeholder_ja',
        'placeholder_en',
        'required',
        'sort_order',
        'column',
        'note_ja',
        'note_en',
        'error_message',
        'error_message_en',
        'error_flag',
        'status',
        'list_display',
        'checkbox_note_description',
        'checkbox_note_description_en',
    ];

    public function options()
    {
        return $this->hasMany(
            KoenParticipantFormOption::class,
            'koen_participant_form_id'
        );
    }

}
