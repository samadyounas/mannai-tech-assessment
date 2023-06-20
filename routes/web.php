<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Students;

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
Route::get('/students', Students::class);
Route::post('/upload/imageTemp', [UploadController::class, 'uploadImage']);
Route::get('/remove/imageTemp/{file}', [UploadController::class, 'removeImage']);
Route::get('/objective4', [CommonController::class, 'objective4']);
Route::get('/objective2', [CommonController::class, 'objective2']);
Route::get('/objective3', [CommonController::class, 'objective3']);

Route::get('/', function () {
    return redirect('/students');
});
