<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
{

                #################################################
                ########### This route for user login ###########
                #################################################
    Route::group(['namespace' => 'Site','middleware' => 'auth:web'],function(){
        Route::get('profile',function (){
                 return "you Are Authenticated";
        });

    });
                #################################################
                ########### This route for guest  ###############
                #################################################
    Route::group(['namespace' => 'Site','middleware' => 'guest:web'],function(){

        Route::get('/home', 'HomeController@home')->name('home');
        Route::get('category/{slug}','CategoryController@productBySlug')->name('category');
    });

});




