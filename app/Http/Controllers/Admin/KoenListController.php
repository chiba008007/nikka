<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KoenParticipantForm;
use App\Services\KoenFormService;
use App\Models\KoenParticipantAuthorOption;
use App\Models\Setting;
use App\Models\SankaFormItem;
use App\Services\SankaFormService;
use App\Models\SankaParticipant;
use App\Models\KoenParticipant;
use Illuminate\Support\Facades\DB;
use App\Models\KoenParticipantAffiliation;
use App\Models\KoenParticipantAuthor;
use App\Services\FileUploadService;
use App\Services\TemplateMailService;
use Illuminate\Support\Facades\Storage;

class KoenListController extends Controller
{
    public const MANUAL_FORM_ARRAY = [
        "manualformtitle",
        "manualformexplain",
        "manualflash",
        "manualflashdelete",
        "manualflashlink",
        "manualflashregistbutton",
        "manualflasherrormessage",
        "manualcopy",
        "manualcopydelete",
        "manualcopylink",
        "manualcopyregistbutton",
        "manualcopyerrormessage",
        "manualfile",
        "manualfiledelete",
        "manualfilelink",
        "manualfileregistbutton",
        "manualfileerrormessage",
        "manualfinish",
        "manualfinishmessage",
        "manualfinishback",

    ];
    public const MANUAL_ARRAY = [
        "manuallogintitle",
        "manualloginexplain",
        "manualloginid",
        "manualloginplaceholder",
        "manualloginpassword",
        "manualloginpasswordplacdholder",
        "manualloginbutton",
        "manualloginbuttonback",
        "manualloginerrormessage",
    ];
    public const KOEN_ARRAY = [
        "editlogin",
        "editlogintitle",
        "editloginexplain",
        "editloginid",
        "editloginidplaceholder",
        "editloginpassword",
        "editloginpasswordplacdholder",
        "editloginbutton",
        "editloginbuttonback",
        "editloginerrormessage",
    ];
    public const FINISH_ARRAY = [
        "finishform",
        "finishtitle",
        "finishid",
        "finishnextbutton",
    ];
    public const CONFIRM_ARRAY = [
        "confirmform"
    ];
    public const AUTHOR_ARRAY = [
        'author_title',
        'author_count',
        'author_explain',
        'author_number',
        'author_kikan',
        'author_kikan_placeholder',
        'author_kikan_gakubu_placeholder',
        'author_ryaku',
        'author_ryaku_placeholder',
        'author_english',
        'author_english_placeholder',
        'author_english_ryaku_placeholder',
        'author_name',
        'author_name_count',
        'author_name_explain',
        'author_speak',
        'author_contact',
        'author_speak_ja',
        'author_speak_ja_sei',
        'author_speak_ja_mei',
        'author_speak_en_sei',
        'author_speak_en_mei',
        'author_speak_syozoku_number',
        'author_speak_en',
        'author_connect_number',
        'author_other',
        'author_draft',
    ];


    public function list()
    {

        $headers = KoenParticipantForm::query()
            ->with(['options' => function ($query) {
                $query->where('status', 1);
            }])
            ->select('*')
            ->selectRaw("TRIM(REGEXP_REPLACE(label_ja, '\\\\[[^]]*\\\\]', '')) AS label_ja_clean")
            ->where('page_type', 'koenform')
            ->where('status', 1)
            ->where('list_display', 1)
            ->orderBy('sort_order')
            ->get();

        $lists = KoenParticipant::query()
            ->with([
                'participant:id,reception_number,add_column_1,add_column_2'
            ])
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        return view('admin.koen.list', compact('lists', 'headers'));

    }

    public function destroy(int $id)
    {
        $koenParticipant = KoenParticipant::findOrFail($id);

        $koenParticipant->delete();

        return redirect()
            ->route('koen.list.index')
            ->with('success', '講演情報を削除しました。');
    }
    public function csv()
    {
        // 有効な講演フォーム項目を取得
        $headers = KoenParticipantForm::query()
            ->where('status', 1)
            ->where('name', 'like', 'add_column_%')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return preg_replace(
                    '/\[[^\]]*\]/u',
                    '',
                    $item->label_ja ?? ''
                );
            })
            ->all();

        $labels = SankaFormItem::where('status', 1)
            ->whereIn('name', [
                'reception_number',
                'title1',
                'title3',
                'title13',
                'title18',
            ])
            ->pluck('label_ja', 'name')
            ->map(fn ($label) => trim(preg_replace('/\[[^\]]*\]/u', '', $label)));

        $settingsLabels = Setting::whereIn('type', [
            'koennumber',
            'sankanumber',
        ])->pluck('name_ja', 'type');

        $authorLabels = KoenParticipantAuthorOption::where('status', 1)
            ->whereIn('type', [
                'author_count',
                'author_name',
                'author_contact',
                'author_speak',
                'author_name_count',
                'author_number',
                'author_kikan',
                'author_ryaku',
                'author_english',
                'author_speak_ja',
                'author_speak_en',
                'author_connect_number',
                'author_other',
            ])
            ->pluck('note_ja', 'type')
            ->map(fn ($label) => trim(
                preg_replace('/\[[^\]]*\]|\([^)]*\)|※.*/us', '', strip_tags($label))
            ));

        $headers = array_merge([
            $labels[ 'reception_number' ],
            $authorLabels[ 'author_name' ],
            $authorLabels[ 'author_contact' ],
            $settingsLabels[ 'koennumber' ],
            $settingsLabels[ 'sankanumber' ],
            $labels[ 'title1' ],
            $labels[ 'title3' ],
            $labels[ 'title13' ],

        ], $headers);

        $headers[] = $labels[ 'title18' ];
        $headers[] = $authorLabels[ 'author_count' ];
        for ($i = 1; $i <= 10; $i++) {
            $headers[] = $authorLabels[ 'author_kikan' ]."(大学/勤務先){$i}";
            $headers[] = $authorLabels[ 'author_kikan' ]."(学部/部署){$i}";
            $headers[] = $authorLabels[ 'author_ryaku' ]."{$i}";
            $headers[] = $authorLabels[ 'author_english' ]."(大学/勤務先){$i}";
            $headers[] = $authorLabels[ 'author_english' ]."(学部/部署){$i}";
        }

        $headers[] = $authorLabels[ 'author_name_count' ];

        for ($i = 1; $i <= 10; $i++) {
            $headers[] = $authorLabels[ 'author_speak_ja' ]."(姓){$i}";
            $headers[] = $authorLabels[ 'author_speak_ja' ]."(名){$i}";
            $headers[] = $authorLabels[ 'author_speak_en' ]."(姓){$i}";
            $headers[] = $authorLabels[ 'author_speak_en' ]."(名){$i}";
            $headers[] = $authorLabels[ 'author_connect_number' ]."{$i}";
        }

        $headers[] = $authorLabels[ 'author_other' ];

        $participants = KoenParticipant::with([
            'participant',
            'authors' => fn ($query) => $query->whereNull('deleted_at'),
            'affiliations' => fn ($query) => $query
                ->whereNull('deleted_at')
                ->orderBy('affiliation_number'),
        ])->orderBy('id')->get();

        $items = KoenParticipantForm::query()
            ->where('status', 1)
            ->where('name', 'like', 'add_column\_%')
            ->with(['options' => fn ($query) => $query->where('status', 1)])
            ->orderBy('sort_order')
            ->get();

        return response()->streamDownload(function () use ($headers, $participants, $items) {
            $stream = fopen('php://output', 'w');

            // Excelでの文字化け対策
            fwrite($stream, "\xEF\xBB\xBF");
            fputcsv($stream, $headers);

            foreach ($participants as $participant) {
                $presenter = $participant->authors->firstWhere('is_presenter', 1);
                $awardContact = $participant->authors->firstWhere('is_award_contact', 1);

                $row = [
                    $participant->announcenumber,
                    trim(($presenter?->family_name_ja ?? '') . ' ' . ($presenter?->given_name_ja ?? '')),
                    trim(($awardContact?->family_name_ja ?? '') . ' ' . ($awardContact?->given_name_ja ?? '')),
                    $participant->koen_number,
                    $participant->participant?->reception_number ?? '',
                    trim(
                        ($participant->participant?->add_column_1 ?? '') . ' ' .
                        ($participant->participant?->add_column_2 ?? '')
                    ),
                    trim(
                        ($participant->participant?->add_column_3 ?? '') . ' ' .
                        ($participant->participant?->add_column_4 ?? '')
                    ),
                    $participant->participant?->add_column_13 ?? '',

                ];
                foreach ($items as $item) {
                    $value = $participant->{$item->name} ?? '';
                    $option = $item->options->firstWhere('value', (string) $value);
                    $row[] = $option?->label_ja ?? $value;
                }
                // 備考
                $row[] = $participant->participant?->add_column_18 ?? '';

                $affiliations = $participant->affiliations->keyBy('affiliation_number');

                // 所属機関総数
                $row[] = $affiliations->count();

                for ($i = 1; $i <= 10; $i++) {
                    $affiliation = $affiliations->get($i);

                    $row[] = $affiliation?->organization ?? '';
                    $row[] = $affiliation?->department ?? '';
                    $row[] = $affiliation?->short_name ?? '';
                    $row[] = $affiliation?->english ?? '';
                    $row[] = $affiliation?->english_short ?? '';
                }

                $authors = $participant->authors->keyBy('author_number');

                // 著者総数
                $row[] = $authors->count();

                for ($i = 1; $i <= 10; $i++) {
                    $author = $authors->get($i);

                    $row[] = $author?->family_name_ja ?? '';
                    $row[] = $author?->given_name_ja ?? '';
                    $row[] = $author?->family_name_en ?? '';
                    $row[] = $author?->given_name_en ?? '';
                    $row[] = $author?->affiliation_numbers ?? '';
                }
                // 備考演題
                $row[] = $participant->othertext;

                fputcsv($stream, $row);
            }

            fclose($stream);
        }, 'endai_'.date('Ymdhis').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }


    public function download($id, $file)
    {
        $koen = KoenParticipant::findOrFail($id);
        $path = $koen->{$file};

        abort_unless($path && Storage::disk('local')->exists($path), 404);

        return response()->download(
            Storage::disk('local')->path($path)
        );
    }


    public function loginform()
    {
        $form = KoenParticipantForm::where('page_type', 'login')
            ->get()
            ->keyBy('name');
        return view('admin.koen.login', compact('form'));
    }
    public function loginformUpdate(Request $request)
    {
        foreach ($request->except('_token') as $name => $values) {

            if (!is_array($values)) {
                continue;
            }

            if (isset($values['note_ja'])) {
                $values['note_ja'] = $this->normalizeRichText($values['note_ja']);
            }

            if (isset($values['note_en'])) {
                $values['note_en'] = $this->normalizeRichText($values['note_en']);
            }

            KoenParticipantForm::where('name', $name)
                ->where('page_type', 'login')
                ->update($values);
        }

        return redirect()
            ->route('koen.list.loginform')
            ->with('success', '更新しました。');
    }

    private function normalizeRichText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = preg_replace('/<p[^>]*>/i', '', $value);
        $value = preg_replace('/<\/p>/i', '<br>', $value);
        $value = preg_replace('/(<br>\s*)+$/i', '', $value);

        return $value;
    }

    public function koenform(
        KoenFormService $koenFormService
    ) {
        $data = $koenFormService->getFormData();

        return view('admin.koen.koenform', $data);
    }

    public function koenformUpdate(Request $request)
    {
        foreach ($request->except('_token') as $name => $values) {

            if (!is_array($values)) {
                continue;
            }

            // 選択肢は別テーブルに保存するため取り出す
            $options = $values['options'] ?? [];
            unset($values['options']);

            $form = KoenParticipantForm::where('name', $name)
                ->where('page_type', 'koenform')
                ->first();

            if (!$form) {
                continue;
            }

            // koen_participant_form を更新
            $form->update($values);

            $form->options()->delete();
            // koen_participant_form_options を更新
            foreach ($options as $sortOrder => $option) {

                $labelJa = $option['label_ja'] ?? null;
                $labelEn = $option['label_en'] ?? null;

                // 空欄の選択肢は登録しない
                if (blank($labelJa) && blank($labelEn)) {
                    continue;
                }

                $form->options()->updateOrCreate(
                    [
                        'sort_order' => $sortOrder,
                    ],
                    [
                        'label_ja' => $labelJa,
                        'label_en' => $labelEn,
                        'value' => (string) $sortOrder,
                        'status' => 1,
                    ]
                );
            }
        }

        return redirect()
            ->route('koen.list.koenform')
            ->with('success', '更新しました。');
    }
    public function author()
    {
        $form = KoenParticipantAuthorOption::whereIn('type', self::AUTHOR_ARRAY)->get()->keyBy('type');

        return view('admin.koen.authorform', compact('form'));
    }

    public function authorUpdate(Request $request)
    {

        foreach (self::AUTHOR_ARRAY as $type) {
            KoenParticipantAuthorOption::where('type', $type)->update([
                'note_ja' => $request->input("authors.{$type}.note_ja"),
                'note_en' => $request->input("authors.{$type}.note_en"),
                'status' => $request->boolean('status'),
                'required' => $request->boolean('required'),
            ]);
        }

        return redirect()
            ->route('koen.list.author')
            ->with('success', '更新しました。');
    }

    public function confirm()
    {
        $form = KoenParticipantAuthorOption::whereIn('type', self::CONFIRM_ARRAY)->get()->keyBy('type');

        return view('admin.koen.confirmform', compact('form'));
    }

    public function confirmUpdate(Request $request)
    {

        foreach (self::CONFIRM_ARRAY as $type) {
            KoenParticipantAuthorOption::where('type', $type)->update([
                'note_ja' => $request->input("authors.{$type}.note_ja"),
                'note_en' => $request->input("authors.{$type}.note_en"),
                'status' => $request->boolean('status'),
                'required' => $request->boolean('required'),
            ]);
        }

        return redirect()
            ->route('koen.list.confirm')
            ->with('success', '更新しました。');
    }

    public function finish()
    {
        $form = KoenParticipantAuthorOption::whereIn('type', self::FINISH_ARRAY)->get()->keyBy('type');

        return view('admin.koen.finishform', compact('form'));
    }

    public function finishUpdate(Request $request)
    {

        foreach (self::FINISH_ARRAY as $type) {
            KoenParticipantAuthorOption::where('type', $type)->update([
                'note_ja' => $request->input("authors.{$type}.note_ja"),
                'note_en' => $request->input("authors.{$type}.note_en"),
                'status' => $request->boolean('status'),
                'required' => $request->boolean('required'),
            ]);
        }

        return redirect()
            ->route('koen.list.finish')
            ->with('success', '更新しました。');
    }

    public function editlogin()
    {
        $form = KoenParticipantAuthorOption::whereIn('type', self::KOEN_ARRAY)->get()->keyBy('type');

        return view('admin.koen.editloginform', compact('form'));
    }

    public function editloginUpdate(Request $request)
    {

        foreach (self::KOEN_ARRAY as $type) {
            KoenParticipantAuthorOption::where('type', $type)->update([
                'note_ja' => $request->input("authors.{$type}.note_ja"),
                'note_en' => $request->input("authors.{$type}.note_en"),
                'status' => $request->boolean('status'),
                'required' => $request->boolean('required'),
            ]);
        }

        return redirect()
            ->route('koen.edit.login')
            ->with('success', '更新しました。');
    }

    public function manuallogin()
    {
        $form = KoenParticipantAuthorOption::whereIn('type', self::MANUAL_ARRAY)->get()->keyBy('type');

        return view('admin.koen.manualloginform', compact('form'));
    }

    public function manualloginUpdate(Request $request)
    {

        foreach (self::MANUAL_ARRAY as $type) {
            KoenParticipantAuthorOption::where('type', $type)->update([
                'note_ja' => $request->input("authors.{$type}.note_ja"),
                'note_en' => $request->input("authors.{$type}.note_en"),
                'status' => $request->boolean('status'),
                'required' => $request->boolean('required'),
            ]);
        }

        return redirect()
            ->route('koen.manual.login')
            ->with('success', '更新しました。');
    }

    public function manualform()
    {
        $form = KoenParticipantAuthorOption::whereIn('type', self::MANUAL_FORM_ARRAY)->get()->keyBy('type');

        return view('admin.koen.manualform', compact('form'));
    }

    public function manualformUpdate(Request $request)
    {

        foreach (self::MANUAL_FORM_ARRAY as $type) {
            KoenParticipantAuthorOption::where('type', $type)->update([
                'note_ja' => $request->input("authors.{$type}.note_ja"),
                'note_en' => $request->input("authors.{$type}.note_en"),
                'status' => $request->boolean('status'),
                'required' => $request->boolean('required'),
            ]);
        }

        return redirect()
            ->route('koen.manual.form')
            ->with('success', '更新しました。');
    }


    //
    public function regist(
        SankaFormService $sankaFormService,
        ?int $id = null
    ) {
        $form = [];
        if ($id !== null) {
            $koenParticipant = KoenParticipant::with('participant')->findOrFail($id);

            $form = $koenParticipant->toArray();

            $form['authors'] = KoenParticipantAuthor::where('koen_participant_id', $id)
                ->whereNull('deleted_at')
                ->orderBy('author_number')
                ->get()
                ->keyBy('author_number')
                ->toArray();

            $authors = collect($form['authors']);

            $form['presenter_index'] = $authors
                ->firstWhere('is_presenter', 1)['author_number'] ?? 1;

            $form['award_contact_index'] = $authors
                ->firstWhere('is_award_contact', 1)['author_number'] ?? 0;

            $form['affiliations'] = KoenParticipantAffiliation::where('koen_participant_id', $id)
                ->whereNull('deleted_at')
                ->orderBy('affiliation_number')
                ->get()
                ->keyBy('affiliation_number')
                ->toArray();

            $form['reception_number'] = substr(
                $koenParticipant->participant->reception_number,
                1,
                4
            );
        }
        $code = Setting::get()->keyBy('type');
        // 演題登録画面表示用入力フォーム
        $endai = $sankaFormService->formatLabels(
            SankaFormItem::where('endai_regist_flag', 1)
        ->whereNotIn('name', function ($query) {
            $query->selectRaw("CONCAT('title', SUBSTRING(name, 12))")
                ->from('sanka_form_items')
                ->where('group_key', 'password')
                ->where('name', 'like', 'add_column_%');
        })
        ->orderByRaw('CAST(SUBSTRING(name, 6) AS UNSIGNED)')
        ->get()
        );


        $koenFormItems = KoenParticipantForm::where('page_type', 'koenform')
            ->where('status', 1)
            ->where('name', 'regexp', '^add_column_([1-9]|[1-4][0-9]|50)$')
            ->with(['options' => function ($query) {
                $query->where('status', 1)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
        $koenFormItems = $sankaFormService->formatLabels($koenFormItems);

        // 説明文
        $description = KoenParticipantForm::where('page_type', 'koenform')
            ->where('status', 1)
            ->where('name', 'koen_form_descript')
            ->first();

        $authorOptions = KoenParticipantAuthorOption::where('status', 1)
            ->get()
            ->map(function ($item) {
                if (in_array($item->type, ['author_title', 'author_name'], true)) {
                    $item->note_ja = new \Illuminate\Support\HtmlString(
                        str_replace(
                            '[必須]',
                            '<span class="required-label">必須</span>',
                            e($item->note_ja ?? '')
                        )
                    );
                }
                return $item;
            })
            ->keyBy('type');

        return view(
            'admin.koen.registform',
            compact('form', 'code', 'endai', 'koenFormItems', 'authorOptions', 'description')
        );

    }


    public function koenRegists(
        Request $request,
        FileUploadService $uploadService,
        TemplateMailService $mailService
    ) {
        $participantId = $request->session()->get('koen_participant_id');

        if (!$participantId ||
            !SankaParticipant::whereKey($participantId)->exists()) {
            return back()
                ->withErrors(['participant' => '参加者が確認できません。'])
                ->withInput();
        }

        $items = KoenParticipantForm::where('page_type', 'koenform')
            ->where('status', 1)
            ->where('name', 'regexp', '^add_column_([1-9]|[1-4][0-9]|50)$')
            ->get();

        $rules = [];
        $messages = [];
        $attributes = [];

        foreach ($items as $item) {
            $required = (int) $item->required === 1;

            if ($item->enable_source_name) {
                $source = $items->firstWhere('name', $item->enable_source_name);

                $sourceValue = $source?->options()
                    ->where('status', 1)
                    ->where('label_ja', $item->enable_source_value)
                    ->value('value');

                $required = $required
                    && $sourceValue !== null
                    && (string) $request->input($item->enable_source_name) === (string) $sourceValue;
            }

            $rules[$item->name] = $required ? 'required' : 'nullable';

            $attributes[$item->name] = preg_replace(
                '/\[[^\]]*\]/u',
                '',
                $item->label_ja ?? $item->name
            );

            if ($item->error_message) {
                $messages["{$item->name}.required"] = $item->error_message;
            }
        }


        $request->validate([
            'uploadfile1' => 'nullable|file|max:10240',
            'uploadfile2' => 'nullable|file|max:10240',
            'uploadfile3' => 'nullable|file|max:10240',
        ]);

        $authorCount = (int) $request->input('author_count', 1);

        $authorLabels = KoenParticipantAuthorOption::query()
            ->where('status', 1)
            ->pluck('note_ja', 'type');

        $rules = array_merge($rules, [
            'author_count' => 'required|integer|between:1,10',
            'presenter_index' => "required|integer|between:1,{$authorCount}",
            'award_contact_index' => "required|integer|between:1,{$authorCount}",
        ]);

        $authorFields = [
            'family_name_ja' => 'author_speak_ja_sei',
            'given_name_ja' => 'author_speak_ja_mei',
            'given_name_en' => 'author_speak_en_sei',
            'family_name_en' => 'author_speak_en_mei',
            'affiliation_numbers' => 'author_connect_number',
        ];
        $affiliationCount = (int) $request->input('affiliation_count', 1);
        for ($i = 1; $i <= $authorCount; $i++) {
            foreach ($authorFields as $field => $type) {
                $key = "authors.{$i}.{$field}";

                $rules[$key] = $field === 'affiliation_numbers'
                    ? [
                        'required',
                        function ($attribute, $value, $fail) use ($affiliationCount) {
                            foreach (explode(',', $value) as $number) {
                                if (!ctype_digit($number)
                                    || (int) $number < 1
                                    || (int) $number > $affiliationCount) {
                                    $fail("所属番号に誤りがあります。");
                                    return;
                                }
                            }
                        }
                    ]
                    : 'required';
                $attributes[$key] = "著者{$i}の"
                    . $authorLabels->get($type, $field);
            }
        }

        $request->validate(
            $rules,
            array_merge([
                'required' => ':attributeは必須です。',
                'integer' => ':attributeは数値で入力してください。',
                'between' => ':attributeの値が範囲外です。',
            ], $messages),
            array_merge([
                'author_count' => '著者数',
                'presenter_index' => '発表者',
                'award_contact_index' => '連絡担当者',
            ], $attributes)
        );

        try {
            $isUpdate = DB::transaction(function () use (
                $request,
                $participantId,
                $items,
                $uploadService
            ) {
                DB::statement('SET @koen_operation_id = UUID()');
                // 講演番号の設定を取得
                $codes = $this->getKoenCodeSettings();

                $prefix = $codes['koencode1'];
                $suffix = $codes['koencode2'] . '-' . $codes['koencode3'];

                // 最新の講演番号を取得
                $lastNumber = DB::table('koen_participants')
                    ->where('koen_number', 'like', "{$prefix}%-{$suffix}")
                    ->orderByDesc('id')
                    ->value('koen_number');

                $serial = 1;

                if ($lastNumber !== null) {
                    $head = explode('-', $lastNumber, 2)[0];
                    $serial = (int) substr($head, strlen($prefix)) + 1;
                }

                $koenNumber = $prefix
                    . str_pad((string) $serial, 4, '0', STR_PAD_LEFT)
                    . '-' . $suffix;

                $koen = KoenParticipant::firstOrNew([
                    'participant_id' => $participantId,
                ]);

                $wasUpdate = $koen->exists;

                if (!$koen->exists) {
                    $koen->koen_number = $koenNumber;
                }
                $koen->status = 1;

                foreach ($items as $item) {
                    $value = $request->input($item->name);

                    $koen->{$item->name} = is_array($value)
                        ? json_encode($value, JSON_UNESCAPED_UNICODE)
                        : $value;
                }

                $koen->othertext = $request->input('othertext');

                $koen->announcenumber = $request->input('announcenumber');
                $koen->save();


                // アップロードファイルを保存
                for ($i = 1; $i <= 3; $i++) {
                    $field = "uploadfile{$i}";

                    if ($request->hasFile($field)) {
                        $path = $request->file($field)
                            ->store("koen/{$koen->id}", 'local');

                        $koen->{$field} = $path;
                    }
                }

                $koen->save();


                for ($i = 1; $i <= 3; $i++) {
                    $field = "uploadfile{$i}";

                    if ($request->hasFile($field)) {
                        $koen->{$field} = $uploadService->upload(
                            $request->file($field),
                            "koen/upload{$i}",
                            "{$koen->announcenumber}-{$koen->koen_number}"
                        );
                    }
                }

                $koen->save();

                // 既存の所属機関を論理削除
                KoenParticipantAffiliation::where('koen_participant_id', $koen->id)
                    ->whereNull('deleted_at')
                    ->update(['deleted_at' => now()]);

                // 既存の著者名を論理削除
                KoenParticipantAuthor::where('koen_participant_id', $koen->id)
                    ->whereNull('deleted_at')
                    ->update(['deleted_at' => now()]);


                // 所属機関を保存
                foreach ($request->input('affiliations', []) as $number => $row) {
                    KoenParticipantAffiliation::create([
                        'koen_participant_id' => $koen->id,
                        'affiliation_number' => (int) $number,
                        'organization' => $row['organization'] ?? null,
                        'department' => $row['department'] ?? null,
                        'short_name' => $row['short_name'] ?? null,
                        'english' => $row['english'] ?? null,
                        'english_short' => $row['english_short'] ?? null,
                    ]);
                }

                // 著者名を保存
                foreach ($request->input('authors', []) as $number => $row) {
                    KoenParticipantAuthor::create([
                        'koen_participant_id' => $koen->id,
                        'author_number' => (int) $number,
                        'is_presenter' => (int) $request->input('presenter_index') === (int) $number,
                        'is_award_contact' => (int) $request->input('award_contact_index') === (int) $number,
                        'family_name_ja' => $row['family_name_ja'] ?? null,
                        'given_name_ja' => $row['given_name_ja'] ?? null,
                        'given_name_en' => $row['given_name_en'] ?? null,
                        'family_name_en' => $row['family_name_en'] ?? null,
                        'affiliation_numbers' => $row['affiliation_numbers'] ?? null,
                    ]);
                }

                return $wasUpdate;

            });
        } finally {
            DB::statement('SET @koen_operation_id = NULL');
        }
        // ここに管理者・参加者へのメール送信処理

        $adminEmail = config('mail.admin_address');
        // メールアドレスのキーを取得
        $mailColumn = SankaFormItem::where('group_key', 'mail')
            ->where('name', 'like', 'add_column_%')
            ->value('name');

        $participantEmail = $mailColumn
            ? SankaParticipant::find($participantId)?->{$mailColumn}
            : null;

        $mailTypes = [
            'presentation_application' => 'presentation_mail',
        //    'manuscript_registration' => 'manuscript_mail',
        ];

        foreach ($mailTypes as $type => $checkboxName) {
            // 管理者には必ず送信
            $mailService->send($type, $adminEmail, $isUpdate, $participantId);

            // 参加者にはチェックされた場合のみ送信
            if ($request->boolean($checkboxName) && $participantEmail) {
                $mailService->send($type, $participantEmail, $isUpdate, $participantId);
            }
        }


        return back()->withInput()->with('success', '登録しました。');
    }

    /**
     * 講演番号用の設定値を取得
     */
    private function getKoenCodeSettings(): array
    {
        $types = ['koencode1', 'koencode2', 'koencode3'];

        $settings = Setting::whereIn('type', $types)
            ->orderBy('type')
            ->lockForUpdate()
            ->pluck('name_ja', 'type')
            ->all();

        foreach ($types as $type) {
            if (blank($settings[$type] ?? null)) {
                throw new \RuntimeException("設定がありません: {$type}");
            }
        }

        return $settings;
    }

}
