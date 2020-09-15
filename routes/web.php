<?php

use App\Models\Invitation;
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

Route::prefix('mail-test')->group(static function () {
    Route::get('/invitation/company', static function () {
        $invitation = Invitation::notSent()->maybeSendToday()->first();

        return new \App\Mail\Invitations\CompanyInvitation($invitation);
    });

    Route::get('/invitation/properties', static function () {
        $invitation = Invitation::notSent()->maybeSendToday()->get()[1];

        return new \App\Mail\Invitations\PropertyInvitation($invitation);
    });
});

Route::prefix('guest')->group(static function () {
    Route::prefix('review')->group(static function () {
        Route::get('company/{id}', [\App\Http\Controllers\Web\Guests\Reviews\Post\CreateCompanyReview::class, 'showForm'])
            ->name('guest.review.company');

        Route::post('company/{id}', [\App\Http\Controllers\Web\Guests\Reviews\Post\CreateCompanyReview::class, 'storeInvitation'])
            ->name('guest.review.company.create');

        Route::match(['GET', 'POST'],'company/quick/{id}', [ \App\Http\Controllers\Web\Guests\Reviews\Post\CreateCompanyReview::class, 'quickReview'])
             ->name('guest.review.company.create.quick');


        Route::get('property/{id}', [\App\Http\Controllers\Web\Guests\Reviews\Post\CreatePropertyReview::class, 'showForm'])
             ->name('guest.review.property');

        Route::post('property/{id}', [\App\Http\Controllers\Web\Guests\Reviews\Post\CreatePropertyReview::class, 'storeInvitation'])
             ->name('guest.review.property.create');

        Route::match(['GET', 'POST'],'property/quick/{id}', [ \App\Http\Controllers\Web\Guests\Reviews\Post\CreatePropertyReview::class, 'quickReview'])
             ->name('guest.review.property.create.quick');
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
