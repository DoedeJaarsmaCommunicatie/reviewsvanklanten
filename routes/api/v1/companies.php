<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Api\\V1\\Companies\\Fetch')->name('fetch');
Route::middleware('auth:api')
    ->post('', 'Api\\V1\\Companies\\Create')->name('create');

Route::get('own', 'Api\\V1\\Companies\\Own')->name('own');

Route::get('single/{id}', 'Api\\V1\\Companies\\Single')->name('single.id');
