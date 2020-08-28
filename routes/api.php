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

Route::middleware('api')->prefix('v1')->name('api.v1.')->group(static function () {
    Route::prefix('companies')->name('company')->group(static function () {
        Route::get('/', 'Api\\V1\\Companies\\Fetch');
    });
});
