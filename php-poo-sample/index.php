<?php

require_once("config/db.php");

// class autoloader function
function autoload($class) {
    require('classes/' . $class . '.class.php');
}

// automatically loads all needed classes
spl_autoload_register("autoload");


//create a database connection
$db = new Database();

// start the login object
$login = new Login($db);

// base structure
if ($login->displayRegisterPage()) {
    include("views/pages/register.php");
} else {
    // are we logged in ?
    if ($login->isUserLoggedIn()) {
        include("views/pages/home.php");
        // further stuff here
    } else {
        // not logged in, showing the login form
        include("views/pages/login.php");
    }
}