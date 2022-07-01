<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\DetailTransaksi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/verify', [AuthController::class, 'verify']);
    Route::get('/getRole', [AuthController::class, 'getRole']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']); 

    Route::get('/getAllUser',[UserController::class, 'index']);
    
    Route::resource('/outlet',OutletController::class);
    Route::resource('/paket',PaketController::class);
    Route::resource('/transaksi',TransaksiController::class);
    Route::resource('/detailTransaksi',DetailTransaksi::class);
    Route::resource('/user',UserController::class);
    Route::resource('/laporan',LaporanController::class);

    // Route::resource('view_user','viewUserController');
    Route::post('searchOut',[OutletController::class,'search']);
    Route::post('searchPak',[PaketController::class,'search']);
    Route::post('searchPen',[UserController::class,'search']);
    Route::post('searchTran',[TransaksiController::class,'search']);
    Route::post('ubahStatus',[TransaksiController::class,'ubahStatus']);
    Route::post('searchingKode',[TransaksiController::class,'searchingKode']);
    Route::post('bayar',[TransaksiController::class,'bayar']);
    // Route::post('idhis','HistoryController@idhis');
    // Route::post('searchHistory','HistoryController@search');
        
});