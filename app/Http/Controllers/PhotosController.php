<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photos;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $site_name = config('app.name');


        if (!$request->session()->has('phpFlickr_oauth_token')) {
            return view('index', compact('site_name'));
        }

        $auth = true;




        $action = 'none';
        $menu = 'home';


        $Photos = new Photos();

        $tags = array();

        $groups = $Photos->getGroups();

        $groups = (isset($groups['group'])) ? $groups['group'] : [];


        $tpl_param['groups'] = $groups;


        $spage = isset($_GET['spage']) ? $_GET['spage'] : 1;
        $upage = isset($_GET['upage']) ? $_GET['upage'] : 1;


        $unpublished = $Photos->getUnpublished($upage);


        if (empty($unpublished)) {
            $request->session()->put('err1_msg', 'No private photos to display.');
        }
        $tpl_param['upages'] = $Photos->pages;

        $scheduled = $Photos->getScheduled($spage);


        if (empty($scheduled)) {
            $request->session()->flash('err2_msg', 'No scheduled photos to display.');
        }
        $tpl_param['spages'] = $Photos->pages;


        $tpl_param['action'] = $action;
        $tpl_param['unpublished'] = $unpublished;
        $tpl_param['scheduled'] = $scheduled;

        $tpl_param['auth'] = $auth;
        $tpl_param['site_name'] = $site_name;
        $tpl_param['menu'] = $menu;



        return view('home', $tpl_param);
    }


    /**
     * Schedule photos in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->session()->has('phpFlickr_oauth_token')) {

            return view('index', compact('site_name'));
        }

        $auth = true;

        $token = array(
            'token' => session('phpFlickr_oauth_token'),
            'secret' => session('phpFlickr_oauth_secret_token'),
        );


        $photos = $request->has('photos')?$request->input('photos'):[];
        $usergroups = $request->input('groups', []);
        $tags = [];

        if (!count($photos)) {
            $request->session()->flash('err1_msg', 'No photo selected.');
            return back()->withInput();
        }

        $datetime = $request->input( 'pub_time');

        $pub_time = date('Y-m-d H:i:s', strtotime($datetime)+ 60*$request->input('tz'));

        if (strtotime($pub_time) < time()) {
            $request->session()->flash('err1_msg', 'You cannot publish in the past.');
            return back()->withInput();
        }

        $Photos = new Photos();

        $Photos->setToken($token);
        $Photos->schedule($photos,  strtotime($pub_time) , $usergroups, $tags);

        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $photos = request('photos');
        if (!count($photos)) {

            $request->session()->flash('err2_msg', 'No photo selected.');
            return back();
        }

        $Photos = new Photos();

        $Photos->unpublish($photos);

        $request->session()->flash('err2_msg', 'Photo publishing canceled.');

        return back();


    }


}
