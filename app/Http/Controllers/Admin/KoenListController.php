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
        'author_speak_en',
        'author_connect_number',
        'author_other',
        'author_draft',
    ];
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
    public function regist(SankaFormService $sankaFormService)
    {
        $form = [];
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
                $query->where('status', 1)
                      ->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
        $koenFormItems = $sankaFormService->formatLabels($koenFormItems);
        return view(
            'admin.koen.registform',
            compact('form', 'code', 'endai', 'koenFormItems')
        );
    }


    public function koenRegists(Request $request)
    {
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

        DB::transaction(function () use ($request, $participantId, $items) {
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

            $koen = new KoenParticipant();
            $koen->participant_id = $participantId;
            $koen->koen_number = $koenNumber;
            $koen->status = 1;

            foreach ($items as $item) {
                $value = $request->input($item->name);

                $koen->{$item->name} = is_array($value)
                    ? json_encode($value, JSON_UNESCAPED_UNICODE)
                    : $value;
            }

            $koen->save();
        });

        return back()->with('success', '登録しました。');
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
