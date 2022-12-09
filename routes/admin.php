<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Admin" middleware group. Now create something great!
|
*/
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
{
    Route::group(['namespace' => 'Dashboard','middleware' => 'auth:admin','prefix' => 'admin'],function(){

        Route::get('/','DashboardController@index')->name('admin.dashboard');

        ########## Settings ##############
        Route::group(['prefix' => 'settings'],function(){

            Route::get('shipping-method/{type}','SettingsController@editShippingmethod')->name('shipping.method');
            Route::post('shipping-method/{id}','SettingsController@updateShippingmethod')->name('update.shipping.method');
        });

    });



    Route::group(['namespace' => 'Dashboard','middleware' => 'guest:admin','prefix' => 'admin'],function(){

        Route::get('login','LogonController@login')->name('admin.login');
        Route::post('login','LogonController@postlogin')->name('admin.post.login');
    });

});




