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

Route::group(['middleware' => ['web']], function () {

    /** Photos */
    //Index page
    Route::get('/', 'PhotosController@index');

    Route::post('/', 'PhotosController@store');

    //simple contact page
    Route::get('/contact', function () {
        $site_name = env('APP_NAME');

        return view('contact', compact('site_name'));
    });

    Route::delete('/', 'PhotosController@destroy');





    /**
     * Authentication with Flickr
     */
    Route::get('/auth', function (\Illuminate\Http\Request $request) {


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
        if ($request->session()->has('phpFlickr_oauth_token')) {

            return redirect($default_redirect);

        }


        if (!isset($_GET['oauth_token'])) {


            $f->getRequestToken($callback, $permissions);


            $request->session()->put('redirect', $site_url);
            die();

        }


        $f->getAccessToken();
        $OauthToken = $f->getOauthToken();
        $OauthSecretToken = $f->getOauthSecretToken();
        $request->session()->put('phpFlickr_oauth_token', $OauthToken);
        $request->session()->put('phpFlickr_oauth_secret_token', $OauthSecretToken);

//    $data = $request->session()->all();
//    dd($data);

        $redirect = $request->session()->has('redirect') ? session('redirect') : '';


        if (empty($redirect)) {
            return redirect($default_redirect);

        }
        return redirect($redirect);


    });


}
);