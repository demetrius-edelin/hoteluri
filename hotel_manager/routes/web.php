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
Route::get('/exportaZiua', [Form::class, 'exportaZiua']);
Route::get('/exportaDB', [Form::class, 'exportaDB']);
Route::post('/uploadDB', [Form::class, 'uploadDB']);
Route::post('/getOcupare', [Form::class, 'getOcupare']);
Route::post('/salvareOcupare', [Form::class, 'salvareOcupare']);
Route::post('/stergereOcupare', [Form::class, 'stergereOcupare']);
Route::post('/ocupaTot', [Form::class, 'ocupaTot']);
Route::post('/muta', [Form::class, 'muta']);
Route::post('/copiaza', [Form::class, 'copiaza']);
Route::post('/modificaZiuaCurenta', [Form::class, 'modificaZiuaCurenta']);
Route::post('/getDateRangeLoc', [Form::class, 'getDateRangeLoc']);
Route::post('/getPersoane', [Form::class, 'getPersoane']);
Route::post('/getDatePersoana', [Form::class, 'getDatePersoana']);
Route::get('/exportLocuriLibere', [Form::class, 'exportLocuriLibere']);
