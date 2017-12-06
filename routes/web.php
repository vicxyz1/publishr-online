<?php

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



Route::group(['middleware' => ['web']], function () {

    /** Photos */
    //Index page
    Route::get('/', 'PhotosController@index');

    Route::post('/', 'PhotosController@store');
    Route::delete('/', 'PhotosController@destroy');

    //simple contact page
    Route::get('/contact', 'HomeController@contact');
    Route::post('/contact', ['as'=>'contact.send', 'uses'=>'HomeController@contactSend']);


    Route::get('/faq','HomeController@faq');
    Route::get('/terms','HomeController@terms');


    Route::get('/stats','HomeController@stats');
    /**
     * Authentication with Flickr
     */
    Route::get('/auth', 'HomeController@auth');
    Route::get('/logout', 'HomeController@logout');


}
);