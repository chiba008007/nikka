<?php

namespace App\Services;

use App\Models\KoenParticipantForm;

class KoenFormService
{
    public function getFormData(): array
    {
        $form = KoenParticipantForm::query()
            ->where('page_type', 'koenform')
            ->with([
                'options' => function ($query) {
                    $query->where('status', 1)
                        ->orderBy('sort_order');
                },
            ])
            ->orderBy('sort_order')
            ->get()
            ->keyBy('name');

        return [
            'form' => $form,
        ];
    }
}
