Photo Publishr Online
================
_Upload now, publish when you want on Flickr_


Description
-----------

Schedule when your Flickr photos will be published for public  


__FIXME:__ Need OAuth authentication 


## Features 

### Get photos
1.  Auth (DEPRECATED)
2.  Get private (non published) photos

-   flickr.photos.search:  
        privacy\_filter (Optional)  
        Return photos only matching a certain privacy level. This only applies
        when making an authenticated call to view photos you own. Valid values
        are:  
            1 public photos  
            2 private photos visible to friends  
            3 private photos visible to family  
            4 private photos visible to friends & family  
            5 completely private photos

### Schedule publishing

1.  Add to cron list
2.  Make the photo public

-   flickr.photos.setPerms:  
    is\_public (Required) 1

### Add to groups

1.  Get Groups
2.  Add to the group

-   flickr.groups.pools.add

<!-- -->

-   flickr.groups.pools.getGroups:
    https://www.flickr.com/services/api/flickr.groups.pools.getGroups.html

### Statistics

**check Flickr PRO : violation of terms?**


1.  Show Total no of Views, Favorites & Comments
2.  Show Most viewed photos
3.  Show Most faved photos
4.  Show Most commented photos

-   views in search, favs ?
-   flickr.photos.getFavorites total ..
-   flickr.photos.comments.getList �total

**favs + comments no real time**

Resources
---------

### Mockup

-   Balsamiq 3

### SQL

Maintainging database schema:

  * MySQL Workbench 
  * PhpMyAdmin          
  
ORM/DBAL:

 * ADODB       !
 
 

### Web

Colors: #EC008B #27A9E1 #286193

-   Bootstrap:
     * http://www.layoutit.com/build
     * https://www.boottheme.com   
     * https://jetstrap.com/demo    
     
- Image gallery
    * https://github.com/rvera/image-picker
     

### Flickr API

-   phpflickr: https://github.com/dan-coulter/phpflickr  **deprecated auth**
-   https://github.com/alchemy-fr/Phlickr ?

### Libraries  


* ADODb
* Savant
* Monolog

- composer


TODO LIST
----

-  __Fix the Auth with OAuth!__

### Fixes



### Enhacements



Planning
--------

### Alpha ReleaseD





### Feature WishList

* User Accounts  OK

* Preferences               OK, depends on user accounts
  - Notification when goes public
  - Publish Level: 
    * private ->family&friends
    * list private, family, friends -> public
* Statistics NOK - hidden. _May conflict with Flickr PRO_ 
  
   

### INSTALLING

-   Download the source tarball or clone:
    
        git clone 

-   In application folder:
        
        composer install

-   In www folder:
    
        cp config.inc.dist.php config.inc.php

       Edit config.inc.php

-   In root folder:
    
        chmod a+w application/cache application/log

-   Create databases, then create the schema:
    
        mysql -u root -p flicker < resources/flicker.sql


