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

Requirements:
 - PHP7+
 - MySql/MariaDB/Percona 5.6+
 - Nginx/Apache 
 
  
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
    
Make sure _storage_ folder is writable by http server. E.g:

    chgrp -R www-data storage bootstrap/cache
    chmod -R g+w+r storage bootstrap/cache  

For __production only__, run the optimizations:
 
 Change APP_ENV to production and APP_DEBUG to false, then
 
    
    php artisan config:cache
    php artisan route:cache
    
    composer install --no-dev
    composer dumpautoload -o
    
Install cron:

    * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1


For hostings with only Apache server make sure:
 - _mod_rewrite__ enabled 
 - directory root is set to _public_ folder

Nginix vhost file example:

    server {
        listen 80;
        listen 443 ssl http2;
        server_name publishr.online;
        root "/home/user/publishr-online/public";
    
        index index.html index.htm index.php;
    
        charset utf-8;
    
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
    
        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }
    
        #access_log off;
        access_log  /home/user/publishr-online/storage/logs/www-access.log;
        error_log  /home/user/publishr-online/storage/logs/www-error.log error;
    
        sendfile off;
    
        client_max_body_size 100m;
    
        location ~ \.php$ {
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
            fastcgi_index index.php;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            
    
            fastcgi_intercept_errors off;
            fastcgi_buffer_size 16k;
            fastcgi_buffers 4 16k;
            fastcgi_connect_timeout 300;
            fastcgi_send_timeout 300;
            fastcgi_read_timeout 300;
        }
    
        location ~ /\.ht {
            deny all;
        }
    
     #   ssl_certificate     /etc/nginx/ssl/publishr.local.crt;
     #   ssl_certificate_key /etc/nginx/ssl/publishr.local.key;
    }
