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

        ############ SubCategories ############
        Route::group(['prefix'=>'subcategories'],function (){
            ############## CRUD ############
            Route::get('/','SubCategoriesController@index')->name('admin.subcategories.all');
            Route::get('create','SubCategoriesController@create')->name('admin.subcategories.create');
            Route::post('store','SubCategoriesController@store')->name('admin.subcategories.store');
            Route::get('edit/{id}','SubCategoriesController@edit')->name('admin.subcategories.edit');
            Route::post('update/{id}','SubCategoriesController@update')->name('admin.subcategories.update');
            Route::get('delete/{id}','SubCategoriesController@delete')->name('admin.subcategories.delete');

        });

        ############ Brands ############
        Route::group(['prefix'=>'brands'],function (){
            ############## CRUD ############
            Route::get('/','BrandsController@index')->name('admin.brands.all');
            Route::get('create','BrandsController@create')->name('admin.brands.create');
            Route::post('store','BrandsController@store')->name('admin.brands.store');
            Route::get('edit/{id}','BrandsController@edit')->name('admin.brands.edit');
            Route::post('update/{id}','BrandsController@update')->name('admin.brands.update');
            Route::get('delete/{id}','BrandsController@delete')->name('admin.brands.delete');

        });

                ############ Tags ############
        Route::group(['prefix'=>'tags'],function (){
            ############## CRUD ############
            Route::get('/','TagsController@index')->name('admin.tags.all');
            Route::get('create','TagsController@create')->name('admin.tags.create');
            Route::post('store','TagsController@store')->name('admin.tags.store');
            Route::get('edit/{id}','TagsController@edit')->name('admin.tags.edit');
            Route::post('update/{id}','TagsController@update')->name('admin.tags.update');
            Route::get('delete/{id}','TagsController@delete')->name('admin.tags.delete');

        });

            ################# Products ##############
        Route::group(['prefix' => 'products'],function(){
                        ########### CRUD General Products ###############
            Route::get('/','ProductsController@index')->name('admin.products.all');
            Route::get('general-information','ProductsController@create')->name('admin.products.general.create');
            Route::post('store-general-information','ProductsController@store')->name('admin.products.general.store');

                        ########### CRUD Prices Products ###############
            Route::get('price/{id}','ProductsController@getPrice')->name('admin.products.price.create');
            Route::post('store-price','ProductsController@storePrice')->name('admin.products.price.store');

                        ########### CRUD Prices Inventory ###############
            Route::get('stock/{id}','ProductsController@getStock')->name('admin.products.stock.create');
            Route::post('store-stock','ProductsController@storeStock')->name('admin.products.stock.store');

                      ########### CRUD Images Products ###############
            Route::get('image/{id}','ProductsController@getImage')->name('admin.products.image.create');
            Route::post('store-image','ProductsController@storeimage')->name('admin.products.image.store');
            Route::post('image/db','ProductsController@saveimagedb')->name('admin.products.image.db');

        });

                     ############ Attributes ############
        Route::group(['prefix'=>'attributes'],function (){
            ############## CRUD ############
            Route::get('/','AttributesController@index')->name('admin.attributes.all');
            Route::get('create','AttributesController@create')->name('admin.attributes.create');
            Route::post('store','AttributesController@store')->name('admin.attributes.store');
            Route::get('edit/{id}','AttributesController@edit')->name('admin.attributes.edit');
            Route::post('update/{id}','AttributesController@update')->name('admin.attributes.update');
            Route::get('delete/{id}','AttributesController@delete')->name('admin.attributes.delete');

        });

                ############ options ############
        Route::group(['prefix'=>'options'],function (){
            ############## CRUD ############
            Route::get('/','optionController@index')->name('admin.options.all');
            Route::get('create','OptionController@create')->name('admin.options.create');
            Route::post('store','OptionController@store')->name('admin.options.store');
            Route::get('edit/{id}','OptionController@edit')->name('admin.options.edit');
            Route::post('update/{id}','OptionController@update')->name('admin.options.update');
            Route::get('delete/{id}','OptionController@delete')->name('admin.options.delete');

        });







    });



    Route::group(['namespace' => 'Dashboard','middleware' => 'guest:admin','prefix' => 'admin'],function(){

        Route::get('login','LogonController@login')->name('admin.login');
        Route::post('login','LogonController@postlogin')->name('admin.post.login');
    });

});




