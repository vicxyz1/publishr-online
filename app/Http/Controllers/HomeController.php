<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function contact(Request $request)
    {
        $site_name = env('APP_NAME');

        return view('contact', compact('site_name'));
    }

    public function contactSend(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);


        Mail::send('email.contact',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function ($message) use ($request) {
                $to = env('MAIL_ADMIN');
                $message->to($to, 'Admin')->subject('Publishr Feedback');
                $message->replyTo($request->get('email'),$request->get('name'));
            });

         return back()->with('success', 'Thanks for contacting us!');


    }

}
