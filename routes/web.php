<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SankaFormController;
use App\Http\Controllers\Admin\SankaListController;
use App\Http\Controllers\Admin\SankaListCreateController;
use App\Http\Controllers\Admin\ParticipantController;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 参加者一覧
    Route::get('/sanka/list', [SankaListController::class, 'list'])->name('sanka.list.index');
    Route::get('/sanka/list/create', [SankaListController::class, 'create'])->name('sanka.list.create');
    Route::get('/sanka/list/create/form', [SankaListCreateController::class, 'editform'])->name('sanka.list.editform');
    Route::post('/sanka/list/create/form', [SankaListCreateController::class, 'update'])->name('sanka.list.editform.update');
    // 参加者登録処理
    Route::post('/sanka/list', [SankaListController::class, 'store'])
        ->name('sanka.list.store');


    // 参加者登録フォーム一覧
    Route::get('/sanka/form', [SankaFormController::class, 'index'])->name('sanka.form.index');
    // 参加者登録フォーム
    Route::get('/sanka/form/create', [SankaFormController::class, 'create'])->name('sanka.form.create');
    // 参加者登録フォーム編集
    Route::get('/sanka/form/edit', [SankaFormController::class, 'edit'])->name('sanka.form.edit');
    // 参加者登録フォーム削除
    Route::post('/sanka/form/delete', [SankaFormController::class, 'delete'])->name('sanka.form.delete');

    // Route::get('/sanka/list', [SankaController::class, 'list'])->name('sanka.list');

});

require __DIR__.'/auth.php';
