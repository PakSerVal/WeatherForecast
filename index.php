<?php

//ini_set("display_errors",1);
//error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
define('CUBE', 'courses');
require_once(ROOT.'/classes/Autoload.php');

session_start();

$router = new Router();
$router->run();