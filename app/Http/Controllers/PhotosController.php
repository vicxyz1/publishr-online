<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotosController extends Controller
{
    //
    public function index(Request $request) {
        $site_name = env('APP_NAME');


        if (!$request->session()->has('phpFlickr_oauth_token')) {
            return view('index', compact('site_name'));
        }
        
        $auth = true;




        return view('home', compact('auth'));
    }


    public function logout() {
        //!TODO: rewrite sessions
        unset($_SESSION['phpFlickr_oauth_token']);
        unset($_SESSION['phpFlickr_oauth_secret_token']);
        return view('index', compact('site_name'));
    }
}
