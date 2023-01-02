<?php

use App\Http\Controllers\Auth\{EmailVerificationController, LogoutController};
use App\Http\Livewire\Auth\{Register, Login, Verify};
use App\Http\Livewire\Auth\Passwords\{Confirm, Email, Reset};
use App\Http\Livewire\Sources\{Index as SourcesIndex, Create as SourcesCreate};
use App\Http\Livewire\Dashboard\Index as DashboardIndex;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::view('/', 'pages.welcome.index')->name('home');

    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    // Auth
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');

    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');

    // Dashboard
    Route::get('/', DashboardIndex::class)->name('home');

    // Sources
    Route::get('/sources', SourcesIndex::class)->name('sources');
    Route::get('/sources/create', SourcesCreate::class)->name('sources.create');
});
