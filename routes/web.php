<?php

use App\Http\Controllers\Admin\MailEditController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SankaFormController;
use App\Http\Controllers\Admin\SankaListController;
use App\Http\Controllers\Admin\SankaListCreateController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\SankaParticipantHistoryController;
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
    Route::get('/home/list/mail', [MailEditController::class, 'edit'])->name('home.list.mail');
    Route::post('/home/list/mail', [MailEditController::class, 'update'])->name('home.list.mail.update');


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


    // Route::get('/sanka/list', [SankaController::class, 'list'])->name('sanka.list');
    // 講演一覧
    Route::get('/koen/list', [SankaListController::class, 'list'])->name('koen.list.index');
    // 履歴
    Route::get('/sanka/list/history', [SankaParticipantHistoryController::class, 'index'])->name('sanka.list.history');

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
