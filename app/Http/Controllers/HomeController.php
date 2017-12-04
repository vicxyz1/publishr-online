<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function contact(Request $request) {
        $site_name = env('APP_NAME');

        return view('contact', compact('site_name'));
    }

    public function contactSend(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        return back()->with('success', 'Thanks for contacting us!');


    }

}
