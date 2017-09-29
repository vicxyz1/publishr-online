Photo Publishr Online
================
_Upload now, publish when you want on Flickr_

v1.1


Description
-----------

Schedule when your Flickr photos will be published for public  





### INSTALLING

-   Download the source tarball or clone:
    
        git clone https://github.com/vicxyz1/publishr-online.git 

-   In __application__ folder:
        
        composer install

-   In __www__ folder:
    
        cp config.inc.dist.php config.inc.php

       Edit config.inc.php

-   In root folder:
    
        chmod a+w application/cache application/log

-   Create database, then create the schema:
    
        mysql -u user -p password < sql/flicker.sql
		
- 	Set document root to __www__

  
   



