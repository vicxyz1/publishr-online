<?php

namespace App\Http\Controllers;

use App\Photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\phpFlickr;

class HomeController extends Controller
{
    public function contact(Request $request)
    {
        $menu = 'contact';
        $auth =$request->session()->has('phpFlickr_oauth_token');
        $site_name = config('app.name');

        return view('contact', compact('site_name', 'auth', 'menu'));
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
                $to = config('mail.to');
                $message->to($to, 'Admin')->subject('Publishr Feedback');
                $message->replyTo($request->get('email'), $request->get('name'));
            });

        return back()->with('success', 'Thanks for contacting us!');


    }

    public function auth(Request $request)
    {
        $api_key = config('auth.flickr.key');
        $api_secret = config('auth.flickr.secret');

        $f = new phpFlickr($api_key, $api_secret);

        $site_url = config('app.url');

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


        $redirect = $request->session()->has('redirect') ? session('redirect') : '';


        if (empty($redirect)) {
            return redirect($default_redirect);

        }
        return redirect($redirect);
    }


    public function faq(Request $request)
    {
        $menu = 'home';
        $auth =$request->session()->has('phpFlickr_oauth_token');
        $site_name = config('app.name');
        return view('faq', compact('site_name', 'auth', 'menu'));

    }

    public function terms(Request $request)
    {
        $menu = 'home';
        $auth =$request->session()->has('phpFlickr_oauth_token');


        $site_name = config('app.name');
        return view('terms', compact('site_name', 'auth', 'menu'));

    }

    public function stats(Request $request) {

        //check if logged
        if (!$request->session()->has('phpFlickr_oauth_token')) {
           return redirect('');
        }

        $site_name = config('app.name');
        $auth = true;
        $menu = 'statistics';

        $Photos = new Photos();
        $photos = $Photos->getMostViewed(24);
        $total = $Photos->total_views;

        return  view('stats', compact('photos', 'menu', 'total', 'site_name', 'auth'));

    }

    public function logout()
    {

        session()->forget('phpFlickr_oauth_token');
        session()->forget('phpFlickr_oauth_secret_token');
        return back();
    }

}
