<?php
// directory list to include
$dirs = array("controllers","core","libs","models","libs/DBContext","utils/components");

// set time zone
date_default_timezone_set('America/Chicago');

// salt for hashing data
define('SALT', md5('mykeyforpassword'));

// key for crypting data
define('KEY', md5('mykeyfordata'));
