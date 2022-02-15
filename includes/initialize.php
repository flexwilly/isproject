<?php
//Define the core paths
//Define them as absolute paths to make sure require_once works as expected
//DIRECTORY SEPARATOR is a PHP pre_defined constant 
//((\ for Windows))
defined('DS')? null : define('DS',DIRECTORY_SEPARATOR);
//C:\xampp\htdocs\E-Commerce
defined('SITE_ROOT')? null: define('SITE_ROOT', DS.'xampp'.DS.'htdocs'.DS.'Gymnase');
//\xampp\htdocs\Pepea

defined('LIB_PATH')? null: define('LIB_PATH',SITE_ROOT.DS.'includes');


//load basic functions next so that everything after them can use them
//require_once(LIB_PATH.DS."functions.php");

//load core objects
require_once(LIB_PATH.DS."connection.php");
require_once(LIB_PATH.DS."session.php");



//load database related classses
require_once(LIB_PATH.DS."user.php");



?>

