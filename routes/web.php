<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
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


Route::post('/app/upload', [DataController::class, 'upload']);
Route::post('/app/delete_image', [DataController::class, 'deleteImage']);
Route::post('/app/create_data', [DataController::class, 'addData']);
Route::get('/app/get_data', [DataController::class, 'getData']);
Route::post('/app/edit_data', [DataController::class, 'editData']);
Route::post('/app/delete_data', [DataController::class, 'deleteData']);

Route::get('{slug}', function () {
    return view('welcome');
});
