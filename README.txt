Uses PHP 5.2

www is built on top of Kohana_v2.3.4 

database is MySQL 5.1

twitteroauth module is http://github.com/abraham/twitteroauth 
commit 441e1fb5549e80c40d8f12838357994060550f45

Setup - 
mkdir www/application/config
and in this directory:
from system copy config.php, database.php
from modules/twitteroauth copy twitteroauth.php
lastly create a cron.php like
<?php
$config['sekrit'] = 't0k3n';
?>

These files should not be checked in and should have valid dev settings.

Deployment... ask me for the scripts...
build.php is for local machines deployment.php is for remote machines.
edit each and then run build which will create and deploy the code
