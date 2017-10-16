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
        $site_name = env('APP_NAME');


        if (!$request->session()->has('phpFlickr_oauth_token')) {
            return view('index', compact('site_name'));
        }

        $auth = true;

        $token = array(
            'token' => session('phpFlickr_oauth_token'),
            'secret' => session('phpFlickr_oauth_secret_token'),
        );


        $action = 'none';
        $menu = 'home';


        $Photos = new Photos();

        //$Photos->db = $db;
        $Photos->setToken($token);

        $tags = array();

        $groups = $Photos->getGroups();

        $groups = (isset($groups['group'])) ? $groups['group'] : [];


        $tpl_param['groups'] = $groups;

        /*

        if (isset($_POST['action'])) {

            $action = $_POST['action'];



            $photos = isset($_POST['photos']) ? $_POST['photos'] : array();
            $usergroups = isset($_POST['groups']) ? $_POST['groups'] : array();



            if ($action == 'publish'):
                if (!count($photos)) {
                    $tpl_param['err1_msg'] = 'No photo selected.';
                }
                $datetime = $_POST['pub_time'];

                $pub_time = date('Y-m-d H:i:s', strtotime($datetime)+ 60*$_POST['tz']);

                //$pub_time = DateTime::createFromFormat('Y-m-d H:i T', $datetime, new DateTimeZone(SITE_TIMEZONE));
                //    $pub_time = date('Y-m-d H:i:s', $pub_time);
                logEval($pub_time, 'pub time');



                //everything ok
                if (!isset($tpl_param['err1_msg'])) {
                    $Photos->schedule($photos,  strtotime($pub_time) , $usergroups, $tags);
                }

            endif;

            if ($action == 'unpublish'):
                if (!count($photos)) {
                    $tpl_param['err2_msg'] = 'No photo selected.';
                }

                $Photos->unpublish($photos);

            endif;
        }

        */


        $spage = isset($_GET['spage']) ? $_GET['spage'] : 1;
        $upage = isset($_GET['upage']) ? $_GET['upage'] : 1;


        $unpublished = $Photos->getUnpublished($upage);


        if (empty($unpublished)) {
            $tpl_param['err1_msg'] = 'No private photos to display.';
        }
        $tpl_param['upages'] = $Photos->pages;

        $scheduled = $Photos->getScheduled($spage);


        if (empty($scheduled)) {
            $tpl_param['err2_msg'] = 'No scheduled photos to display.';
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $tpl_param['err1_msg'] = 'No photo selected.';
            //!TODO: with flash session
            return back()->withInput();
        }

        $datetime = $request->input( 'pub_time');

        $pub_time = date('Y-m-d H:i:s', strtotime($datetime)+ 60*$request->input('tz'));

        $Photos = new Photos();

        $Photos->setToken($token);

        $Photos->schedule($photos,  strtotime($pub_time) , $usergroups, $tags);


//        $site_name = env('APP_NAME');
//
//
//        if (!$request->session()->has('phpFlickr_oauth_token')) {
//            return view('index', compact('site_name'));
//        }
//
//        $menu = 'home';
//        $auth = true;
//
//        $tpl_param = [];
//        $tpl_param['auth'] = $auth;
//        $tpl_param['site_name'] = $site_name;
//        $tpl_param['menu'] = $menu;

//        dd($request->all());


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
    public function destroy($id)
    {
        //
    }

    public function logout()
    {
        //!TODO: rewrite sessions
        unset($_SESSION['phpFlickr_oauth_token']);
        unset($_SESSION['phpFlickr_oauth_secret_token']);
        return view('index', compact('site_name'));
    }
}
