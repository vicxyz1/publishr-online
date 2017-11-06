<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Photos;


class publish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the photos to due date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start publishing the photos');


        $photos = DB::table('photos')->whereRaw('UNIX_TIMESTAMP() > publish_time')->get();


        $Photos = new Photos();
//        $Photos->db = $db;
//
//
        foreach ($photos as $photo) {
//            dd($photo);
            $this->info("Publish photo id: {$photo->photo_id}");
            $Photos->setToken(array('token' => $photo->auth_token, 'secret' => $photo->auth_secret));
            $Photos->publish($photo);
        }

        $this->info(count($photos) . ' photos published');


    }
}
