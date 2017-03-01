<?php
/*
MySQL 5.5 database added.  Please make note of these credentials:

       Root User: adminAfHGV7d
   Root Password: ApapsbdibRPg
   Database Name: ama

Connection URL: https://ama-fras.rhcloud.com/phpmyadmin

You can manage your new MySQL database by also embedding phpmyadmin.
The phpmyadmin username and password will be the same as the MySQL credentials above.
*/

//ONLINE
//   define('SERVPATH','https://whosabsent.com/app/');
// define('DB_HOST','localhost');
// define('DB_UN','root');
// define('DB_PW','123qwe');
// define('DB_NAME','ama'); 
// 
// define('APIPATH','http://nodejsapi-incrm.rhcloud.com');



// LOCALHOST
define('SERVPATH','http://localhost/whosabsent/');
define('DB_HOST','localhost');
define('DB_UN','root');
define('DB_PW','');
define('DB_NAME','ama');

define('APIPATH','http://localhost:3000');
  
//define('APIPATH','http://nodejsapi-incrm.rhcloud.com'); 

define('PAGE_LOGIN',0);
define('PAGE_DIRECTORY',1);
define('MODE_VIEW',0);
define('MODE_UPDATE',2);
define('MODE_DELETE',3);
define('MODE_CREATE',1);
define('ROLE_STUDENT','Student');
define('ROLE_TEACHER','Teacher');
define('ROLE_ADMIN','Admin');

define('PHOTO_DIR','img/photos');

define('ATTR_USER_NAME','User');




 ?>