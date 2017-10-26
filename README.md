Photo Publishr Online
================
_Upload now, publish when you want on Flickr_

v2.0
__Project ported to Laravel framework__

Description
-----------

Schedule when your Flickr photos will be published for public

Available online:

http://publishr.online



Features
--------


* Flickr OAuth supported
* Schedule the publishing of private photos and make them as new
* Add photos to groups when they become public

Installation
-----------



Download the tarball or clone the source code:

    git clone https://github.com/vicxyz1/publishr-online.git 

If you don't have already installed __Composer__ (https://getcomposer.org/), you should do so. Then, in the project directory install the packages required: 
    
    composer install
    
    
Create the database and the user for the project using your choice (__mysql__ command line or __phpMyAdmin__)  
  
 Also, you should have already your Flickr API_KEY and API_SECRET for the application. 
 
Configure the application settings, but first copy the example file in the project directory:

    cp .env.example .env
    
  then edit the database settings and fill the API keys.    




Create the database tables:

    php artisan migrate
    
Generate the APP_KEY:

    php artisan key:generate
    
Make sure _storage_ folder is writable by http server.

For __production only__, run the optimizations:
 
    composer dumpautoload -o
    php artisan config:cache
    php artisan route:cache
    


For hostings with only Apache server make sure:
 - _mod_rewrite__ enabled 
 - directory root is set to _public_ folder
