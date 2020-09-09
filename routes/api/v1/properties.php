<?php
use Illuminate\Support\Facades\Route;

Route::get('/' ,'Api\\V1\\Properties\\Fetch@index')->name('fetch');

Route::post('/', 'Api\\V1\\Properties\\Create@index')
    ->name('create');

Route::get('own', 'Api\\V1\\Properties\\Own@index')
    ->name('own');

Route::get('single/{id}', 'Api\\V1\\Properties\\Single@index')
    ->name('single.id');

Route::prefix('review')->group(static function () {
    Route::get('/', '')
         ->name('reviews.fetch');

    Route::post('/', 'Api\\V1\\Reviews\\Property\\CreateReviewController@index')
        ->name('review.create');

    Route::get('/latest', '')
        ->name('review.fetch.latest');
});
