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
        Route::get('logout','LogonController@logout')->name('admin.logout');

            ########## Shipping's  ##############
        Route::group(['prefix' => 'settings'],function(){

            Route::get('shipping-method/{type}','SettingsController@editShippingmethod')->name('shipping.method');
            Route::post('shipping-method/{id}','SettingsController@updateShippingmethod')->name('update.shipping.method');
        });
             ######### Edit profile #############
        Route::group(['prefix' => 'profile'],function(){

            Route::get('edit','ProfileController@editProfile')->name('edit.profile');
            Route::put('update','ProfileController@updateProfile')->name('update.profile');
            Route::get('edit/password','ProfileController@editpassword')->name('edit.password');
            Route::put('update/password','ProfileController@updatpassword')->name('update.password');
        });

             ############ Categories ############
        Route::group(['prefix'=>'categories'],function (){
                ############## CRUD ############
            Route::get('/','MainCategoriesController@index')->name('admin.mainCategories.all');
            Route::get('create','MainCategoriesController@create')->name('admin.mainCategories.create');
            Route::post('store','MainCategoriesController@store')->name('admin.mainCategories.store');
            Route::get('edit/{id}','MainCategoriesController@edit')->name('admin.mainCategories.edit');
            Route::post('update/{id}','MainCategoriesController@update')->name('admin.mainCategories.update');
            Route::get('delete/{id}','MainCategoriesController@delete')->name('admin.mainCategories.delete');

        });

    });



    Route::group(['namespace' => 'Dashboard','middleware' => 'guest:admin','prefix' => 'admin'],function(){

        Route::get('login','LogonController@login')->name('admin.login');
        Route::post('login','LogonController@postlogin')->name('admin.post.login');
    });

});




