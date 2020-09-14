<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\UpdateController;

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

Route::get('/', static function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('subscriptions')->group(static function() {
    Route::post('/subscribe', 'Web\Subscribe\NewSubscription@index')->name('subscriptions.new');
});

Route::prefix('dashboard')->group(static function() {
    Route::prefix('tokens')->group(static function () {
        Route::get('/', 'Web\Dashboard\Users\TokensOverview@index')->name('dashboard.tokens.overview');
        Route::post('/', 'Web\Dashboard\Users\CreateTokenController@index')->name('dashboard.token.create');
        Route::delete('/', 'Web\Dashboard\Users\DeleteTokenController@index')->name('dashboard.token.delete');
    });

    Route::prefix('companies')->group(static function() {
        Route::get('/', 'Web\Dashboard\Companies\OverviewController@index')->name('dashboard.companies.overview');
        Route::post('/', 'Web\Dashboard\Companies\CreateController@index')->name('dashboard.company.create');
        Route::delete('/', 'Web\Dashboard\Companies\DeleteController@fromOverview')->name('dashboard.company.delete');

        Route::prefix('{id}')->where(['id'=> '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}'])->group(static function () {
            Route::get('/', 'Web\Dashboard\Companies\SingleController@index')->name('dashboard.companies.single');
            Route::delete('/', 'Web\Dashboard\Companies\DeleteController@fromSingle')->name('dashboard.companies.single.delete');

            Route::prefix('properties')->group(static function () {
                Route::get('/', 'Web\\Dashboard\\Properties\\OverviewController@index')
                     ->name('dashboard.properties.overview');

//        Route::post('/', 'Web\\Dashboard\\Properties\\CreateController@index')
//            ->name('dashboard.property.create');

//        Route::delete('/')
//            ->name('dashboard.property.delete');

                Route::prefix('{property}')->where(['property' => '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}'])->group(static function () {
//            Route::get('/')
//                ->name('dashboard.properties.single');

//            route::delete('/')
//                ->name('dasboard.properties.single.delete');
                });
            });
        });
    });
});

Route::prefix('admin')->group(static function () {
    Route::prefix('updates')->group(static function () {
        Route::get('/', [UpdateController::class, 'index'])
            ->name('admin.updates.get');

        Route::post('/', [UpdateController::class, 'update'])
            ->name('admin.update');
    });
});
