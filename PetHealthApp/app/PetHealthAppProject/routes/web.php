<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\UserProcessController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\VetAccessController;
use App\Http\Controllers\VetProcessController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// testpage
Route::get('demo', function () {
    return view('demo');
})->name('demo');

// トップページ
Route::get('/', function () {
    return view('top');
})->name('top');

// ユーザー関連のページ
Route::prefix('user')->name('user.')->group(function () {
    // ホームページへ
    Route::get('{petId}/home',
        [UserAccessController::class, 'home']
    )->name('home');

    // ログインページへ
    Route::get('login',
        [UserAccessController::class, 'login']
    )->name('login');

    // 新規作成ページへ
    Route::get('create',
        [UserAccessController::class, 'create']
    )->name('create');

    // 会員情報ページへ
    Route::get('profile',
        [UserAccessController::class, 'profile']
    )->name('profile');

    // 会員情報編集ページへ
    Route::get('edit',
        [UserAccessController::class, 'edit']
    )->name('edit');

    // 有料会員登録ページへ
    Route::get('premium',
        [UserAccessController::class, 'premium']
    )->name('premium');

    // ログイン処理
    Route::post('login-process',
        [UserProcessController::class, 'loginProcess']
    )->name('login-process');

    // 新規作成処理
    Route::post('create-process',
        [UserProcessController::class, 'createProcess']
    )->name('create-process');

    // 会員情報編集処理
    Route::post('edit-process',
        [UserProcessController::class, 'editProcess']
    )->name('edit-process');

    // 会員情報消去処理
    Route::get('delete',
        [UserProcessController::class, 'deleteProcess']
    )->name('delete');

    // ログアウト処理
    Route::get('logout',
        [UserProcessController::class, 'logoutProcess']
    )->name('logout');

    // 有料会員登録処理
    Route::get('premium-process',
        [UserProcessController::class, 'premiumProcess']
    )->name('premium-process');

    // メッセージ送信処理
    Route::post('{vetId}/{petId}/send-process',
        [UserProcessController::class, 'sendProcess']
    )->name('send-process');

    Route::prefix('pet')->name('pet.')->group(function () {
        // ペット登録ページへ
        Route::get('create',
            [PetController::class, 'petCreate']
        )->name('create');

        // ペット追加登録ページへ
        Route::get('add',
            [PetController::class, 'petAdd']
        )->name('add');

        // ペット情報編集ページへ
        Route::get('{petId}/edit',
            [PetController::class, 'petEdit']
        )->name('edit');

        // ペット登録処理
        Route::post('create-process',
            [PetController::class, 'petCreateProcess']
        )->name('create-process');

        // ペット情報編集処理
        Route::post('{petId}/edit-process',
            [PetController::class, 'petEditProcess']
        )->name('edit-process');

        // ペット情報消去処理
        Route::get('{petId}/delete',
            [PetController::class, 'petDeleteProcess']
        )->name('delete');

        // 今日の健康状態更新処理
        Route::post('{petId}/todayHealth-process',
            [PetController::class, 'petTodayHealthProcess']
        )->name('todayHealth-process');
    });
});

// 獣医師関連のページ
Route::prefix('vet')->name('vet.')->group(function () {
    // ホームページへ
    Route::get('home/{petId}',
        [VetAccessController::class, 'home']
    )->name('home');

    // ログインページへ
    Route::get('login',
        [VetAccessController::class, 'login']
    )->name('login');

    // 新規作成ページへ
    Route::get('create',
        [VetAccessController::class, 'create']
    )->name('create');

    // 会員情報ページへ
    Route::get('profile',
        [VetAccessController::class, 'profile']
    )->name('profile');

    // 会員情報編集ページへ
    Route::get('edit',
        [VetAccessController::class, 'edit']
    )->name('edit');

    // メッセージ送信処理
    Route::post('{userId}/{petId}/send-process',
        [VetProcessController::class, 'sendProcess']
    )->name('send-process');

    // ログイン処理
    Route::post('login-process',
        [VetProcessController::class, 'loginProcess']
    )->name('login-process');

    // 新規作成処理
    Route::post('create-process',
        [VetProcessController::class, 'createProcess']
    )->name('create-process');

    // 会員情報編集処理
    Route::post('edit-process',
        [VetProcessController::class, 'editProcess']
    )->name('edit-process');

    // ログアウト処理
    Route::get('logout',
        [VetProcessController::class, 'logoutProcess']
    )->name('logout');

    // 会員情報消去処理
    Route::get('delete',
        [VetProcessController::class, 'deleteProcess']
    )->name('delete');
});
