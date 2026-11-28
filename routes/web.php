<?php

use App\Http\Controllers\Admin\MailEditController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SankaFormController;
use App\Http\Controllers\Admin\SankaListController;
use App\Http\Controllers\Admin\SankaListRegistController;
use App\Http\Controllers\Admin\SankaListCreateController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\SankaParticipantHistoryController;
use App\Http\Controllers\Admin\KoenParticipantHistoryController;
use App\Http\Controllers\Admin\KoenListController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\EditPageController;
use App\Http\Controllers\BannerController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 公開画面
Route::get('/top', [TopController::class, 'index'])->name('top');
Route::get('/top/koen', [TopController::class, 'koen'])->name('top.koen');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard2', function () {
    return view('dashboard2');
})->middleware(['auth', 'verified'])->name('dashboard2');

Route::get('/home/list', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('home.list');

Route::middleware('auth')->group(function () {
    Route::get('/setting', [SettingController::class, 'index'])->name('home.list.setting');
    Route::post('/setting/edit', [SettingController::class, 'edit'])->name('home.list.setting.edit');
    Route::get('/home/list/mail/{type?}', [MailEditController::class, 'edit'])->name('home.list.mail');
    Route::post('/home/list/mail/{type?}', [MailEditController::class, 'update'])->name('home.list.mail.update');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 参加者一覧
    Route::get('/sanka/list', [SankaListController::class, 'list'])->name('sanka.list.index');
    Route::get('/sanka/list/csv', [SankaListController::class, 'csv'])->name('sanka.list.csv');
    Route::get('/sanka/list/create', [SankaListController::class, 'create'])->name('sanka.list.create');
    // 参加者入力ページ
    Route::get('/sanka/list/create/form', [SankaListCreateController::class, 'editform'])->name('sanka.list.editform');
    Route::put('/sanka/list/create/form', [SankaListCreateController::class, 'update'])->name('sanka.list.editform.update');
    // 参加者確認ページ
    Route::get('/sanka/list/confirm/form', [SankaListCreateController::class, 'confirm'])->name('sanka.list.confirm');
    Route::post('/sanka/list/confirm/form', [SankaListCreateController::class, 'confirmUpdate'])->name('sanka.list.confirm.update');
    // 編集
    Route::get('/sanka/list/edit/{id}', [SankaListController::class, 'edit'])->name('sanka.list.edit');
    // 参加者情報編集実施
    Route::PUT('/sanka/list/edit/{id}', [SankaListController::class, 'update'])->name('sanka.list.update');
    // 削除
    Route::delete('/sanka/list/{id}', [SankaListController::class, 'destroy'])
    ->name('sanka.list.destroy');

    // 完了ページ
    Route::get('/sanka/list/complete/form', [SankaListCreateController::class, 'complete'])->name('sanka.list.complete');
    Route::post('/sanka/list/complete/form', [SankaListCreateController::class, 'completeUpdate'])->name('sanka.list.complete.update');

    // 参加費
    Route::get('/sanka/list/fee/form', [SankaListCreateController::class, 'fee'])->name('sanka.list.fee');
    Route::put('/sanka/list/fee/form', [SankaListCreateController::class, 'feeUpdate'])->name('sanka.fee.update');

    // 参加者ログインページ
    Route::get('/sanka/list/login/form', [SankaListCreateController::class, 'loginForm'])->name('sanka.list.loginform');
    Route::post('/sanka/list/login/form', [SankaListCreateController::class, 'loginUpdate'])->name('sanka.list.loginform.update');


    // 参加者登録処理
    Route::post('/sanka/list', [SankaListController::class, 'store'])->name('sanka.list.store');


    // 参加者登録フォーム一覧
    Route::get('/sanka/form', [SankaFormController::class, 'index'])->name('sanka.form.index');
    // 参加者登録フォーム
    Route::get('/sanka/form/create', [SankaFormController::class, 'create'])->name('sanka.form.create');
    // 参加者登録フォーム編集
    Route::get('/sanka/form/edit', [SankaFormController::class, 'edit'])->name('sanka.form.edit');
    // 参加者登録フォーム削除
    Route::post('/sanka/form/delete', [SankaFormController::class, 'delete'])->name('sanka.form.delete');

    Route::patch(
        '/sanka/list/{participant}/payment-status',
        [SankaListController::class, 'updatePaymentStatus']
    )->name('sanka.payment-status.update');

    // 履歴
    Route::get('/sanka/list/history', [SankaParticipantHistoryController::class, 'index'])->name('sanka.list.history');
    Route::get('/koen/list/history', [KoenParticipantHistoryController::class, 'index'])->name('koen.list.history');

    // Route::get('/sanka/list', [SankaController::class, 'list'])->name('sanka.list');
    // 講演一覧
    Route::get('/koen/list', [KoenListController::class, 'list'])->name('koen.list.index');
    // 講演登録
    Route::get('/koen/list/regist', [KoenListController::class, 'regist'])->name('koen.list.regist');
    Route::post('/koen/list/regist/koenRegists', [KoenListController::class, 'koenRegists'])->name('koen.list.regist.koenRegists');
    //講演編集
    Route::get('/koen/list/edit/{id}', [KoenListController::class, 'regist'])
    ->name('koen.list.edit');

    Route::delete('/koen/list/{id}', [KoenListController::class, 'destroy'])
        ->name('koen.list.destroy');
    // 講演CSVダウンロード
    Route::get('/koen/list/csv', [KoenListController::class, 'csv'])
        ->name('koen.list.csv');


    // ファイルのダウンロード
    Route::get('/koen/download/{id}/{file}', [KoenListController::class, 'download'])
    ->where('file', 'uploadfile[123]')
    ->name('koen.download');

    Route::get('/koen/participant/search', [SankaListCreateController::class, 'searchParticipant'])->name('koen.participant.search');

    // ログインフォーム
    Route::get('/koen/list/loginform', [KoenListController::class, 'loginform'])->name('koen.list.loginform');
    Route::post('/koen/list/loginform', [KoenListController::class, 'loginformUpdate'])->name('koen.list.loginform.update');
    // 講演申込フォーム
    Route::get('/koen/list/koenform', [KoenListController::class, 'koenform'])->name('koen.list.koenform');
    Route::post('/koen/list/koenform', [KoenListController::class, 'koenformUpdate'])->name('koen.list.koenform.update');
    // 講演著者
    Route::get('/koen/list/author', [KoenListController::class, 'author'])->name('koen.list.author');
    Route::post('/koen/list/author', [KoenListController::class, 'authorUpdate'])->name('koen.list.author.update');

    // 確認画面説明文
    Route::get('/koen/list/confirm', [KoenListController::class, 'confirm'])->name('koen.list.confirm');
    Route::post('/koen/list/confirm', [KoenListController::class, 'confirmUpdate'])->name('koen.list.confirm.update');

    // 完了画面
    Route::get('/koen/list/finish', [KoenListController::class, 'finish'])->name('koen.list.finish');
    Route::post('/koen/list/finish', [KoenListController::class, 'finishUpdate'])->name('koen.list.finish.update');

    // 完了画面
    Route::get('/koen/edit/login', [KoenListController::class, 'editlogin'])->name('koen.edit.login');
    Route::post('/koen/edit/login', [KoenListController::class, 'editloginUpdate'])->name('koen.edit.login.update');

    // 要旨原稿ログイン
    Route::get('/koen/manual/login', [KoenListController::class, 'manuallogin'])->name('koen.manual.login');
    Route::post('/koen/manual/login', [KoenListController::class, 'manualloginUpdate'])->name('koen.manual.login.update');

    // 要旨原稿画面
    Route::get('/koen/manual/form', [KoenListController::class, 'manualform'])->name('koen.manual.form');
    Route::post('/koen/manual/form', [KoenListController::class, 'manualformUpdate'])->name('koen.manual.form.update');

    // トップページedit
    Route::get('/edit/top', [EditPageController::class, 'top'])->name('edit.top');
    Route::post('/edit/top/edit', [EditPageController::class, 'edit'])->name('edit.top.edit');

    Route::get('/edit/top/koen', [EditPageController::class, 'koen'])->name('edit.top.koen');
    Route::post('/edit/top/koen/edit', [EditPageController::class, 'koenedit'])->name('edit.top.koen.edit');


    Route::prefix('edit/top/banner')
        ->name('edit.top.banner.')
        ->group(function () {
            Route::get('/', [BannerController::class, 'index'])
                ->name('index');

            Route::get('/create', [BannerController::class, 'create'])
            ->name('create');

            Route::post('/store', [BannerController::class, 'store'])
                ->name('store');

            Route::get('/{id}/edit', [BannerController::class, 'edit'])
            ->name('edit');

            Route::put('/{id}', [BannerController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [BannerController::class, 'destroy'])
                ->name('destroy');
        });

    Route::post('/language', function (Request $request) {
        // 選択した言語をセッションへ保存する
        session([
            'language' => $request->input('language', 'jp'),
        ]);

        return response()->json([
            'status' => 'ok',
        ]);
    })->name('language.set');

});

require __DIR__.'/auth.php';
