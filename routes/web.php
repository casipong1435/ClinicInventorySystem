<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Auth::routes(['register' => false]);

Route::get('/login', function(){
    if (auth()-> check()){
        return redirect('/');
    }
    return view('auth.login');
})->name('login');


Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/activity', 'storage')->name('storage');
    Route::get('/account', 'account')->name('account');
    Route::get('/log', 'log')->name('log');
    Route::get('/report/{date_from}/{date_to}', 'DownloadReport')->name('report');
});
