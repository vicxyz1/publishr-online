<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photos;

class PhotosController extends Controller
{
    //
    public function index(Request $request) {
        $site_name = env('APP_NAME');


        if (!$request->session()->has('phpFlickr_oauth_token')) {
            return view('index', compact('site_name'));
        }

        $auth = true;

        $token = array(
            'token' => session('phpFlickr_oauth_token'),
            'secret'=> session('phpFlickr_oauth_secret_token'),
        );



        $action = 'none';
        $menu = 'home';



        $Photos = new Photos();

        //$Photos->db = $db;
        $Photos->setToken($token );

        $tags = array();

        $groups = $Photos->getGroups();

        $groups = (isset($groups['group']))?$groups['group']:[];

        dd($groups);
        /*
        $tpl_param['groups'] = $groups;



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


        */
        return view('home', compact('auth', 'site_name', 'menu'));
    }


    public function logout() {
        //!TODO: rewrite sessions
        unset($_SESSION['phpFlickr_oauth_token']);
        unset($_SESSION['phpFlickr_oauth_secret_token']);
        return view('index', compact('site_name'));
    }
}
