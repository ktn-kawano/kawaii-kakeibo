<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\KakeiboController;
use App\Http\controllers\ChartController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kakeibo' , KakeiboController::class);

Route::get('/add', function(){
    return view('kakeibo.add');
});

Route::get('thisMonth',[KakeiboController::class,'this_month']);

Route::get('pastMonth',[KakeiboController::class,'past_month']);

Route::post('/store',[KakeiboController::class,"store"]);

Route::post('/kakeibo',[KakeiboController::class,"calc_debt"]);
Route::get('/kakeibo',[KakeiboController::class,"calc_debt"]);

Route::post('/complete',function(){
    return view('kakeibo.complete');
});

Route::get('/complete',function(){
    return view('kakeibo.complete');
});

Route::post('/date_set',[KakeiboController::class,"date_set"]);

Route::post('/repayment',[KakeiboController::class,"repayment"]);

Route::get('/chart_get',[ChartController::class,"chartGet"])->name('chart_get');