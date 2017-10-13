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

use App\phpFlickr;

Route::get('/', 'PhotosController@index');

Route::get('/contact', function () {
    $site_name = env('APP_NAME');

    return view('contact', compact('site_name'));
});

Route::get('/auth', function () {


    $site_name = env('APP_NAME');

    $api_key = env('API_KEY');
    $api_secret = env('API_SECRET');

    $f = new phpFlickr($api_key, $api_secret);

    $site_url = env('APP_URL');

    $default_redirect = $site_url;
    $permissions = "write";
    $callback = $site_url . '/auth';

    ob_start();

//already logged
    if (isset($_SESSION['phpFlickr_oauth_token'])) {
        redirect($default_redirect);
    }


    if (!isset($_GET['oauth_token'])) {


        $f->getRequestToken($callback, $permissions);


        $_SESSION['redirect'] = $site_url;
        die();

    }


    $f->getAccessToken();
    $OauthToken = $f->getOauthToken();
    $OauthSecretToken = $f->getOauthSecretToken();
    $_SESSION['phpFlickr_oauth_token'] = $OauthToken;
    $_SESSION['phpFlickr_oauth_secret_token'] = $OauthSecretToken;


    $redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : '';


    if (empty($redirect)) {
        redirect($default_redirect);

    }
    redirect($redirect);


    return view('contact', compact('site_name'));
});
