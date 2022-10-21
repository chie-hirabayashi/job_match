<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobOfferController;

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

Route::get('/', [JobOfferController::class, 'index'])
    ->middleware('auth')
    ->name('welcome');

Route::get('/welcome', function ()
{
    return view('welcome');
})->middleware('guest')
    ->name('welcom');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('company/register', function () {
    return view('company.register');
})->middleware('guest')
    ->name('company.register');

// 企業アカウントのみのルーティング
Route::resource('job_offers', JobOfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('can:company'); //ゲートでcompanyのみ許可

// ログインしている時にルーティング
Route::resource('job_offers', JobOfferController::class)
    ->only(['show', 'index'])
    ->middleware('auth');  //認証があれば許可
