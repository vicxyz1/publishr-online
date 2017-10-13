<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotosController extends Controller
{
    //
    public function index() {
        $site_name = env('APP_NAME');

        if (!isset($_SESSION['phpFlickr_oauth_token'])) {
            return view('index', compact('site_name'));
        }


        return view('home');
    }


    public function logout() {
        unset($_SESSION['phpFlickr_oauth_token']);
        unset($_SESSION['phpFlickr_oauth_secret_token']);
        return view('index', compact('site_name'));
    }
}
