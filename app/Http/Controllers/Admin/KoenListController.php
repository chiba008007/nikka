<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KoenParticipantForm;
use App\Services\KoenFormService;
use App\Models\KoenParticipantAuthorOption;

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
}
