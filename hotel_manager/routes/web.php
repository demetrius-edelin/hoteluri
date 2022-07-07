<?php

use App\Http\Controllers\Display;
use App\Http\Controllers\Form;
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

Route::get('/', [Display::class, 'show']);
Route::post('/getOcupare', [Form::class, 'getOcupare']);
Route::post('/salvareOcupare', [Form::class, 'salvareOcupare']);
Route::post('/stergereOcupare', [Form::class, 'stergereOcupare']);
Route::post('/modificaZiuaCurenta', [Form::class, 'modificaZiuaCurenta']);
