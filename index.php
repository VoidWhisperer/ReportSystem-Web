<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/31/2016
 * Time: 3:07 PM
 */

include 'config.php';
include 'includes/global.inc.php';
spl_autoload_register(function ($class) {
   include 'classes/'.$class.'.class.php';
});


$router = new Router();
$router->insertRoute("/home","home.php");
$router->insertRoute("/login","login.php");
