<?php
/**
 * Configuration file
 */
define("HOST",""); //Your DB host
define("DB_USER",""); //Your DB user
define("DB_PASS",""); //Your DB password
define("DB_NAME",""); //Your DB name
define("DB_TYPE","mysql"); //Your DB type

define("CONTROLLER",'Controller');
define("MODEL",'Model');

define("HOME_URL","");//Your home URL

define("DEBUG",TRUE); //Set true if you want to activate debug mode

include "common/text.php"; //edit this file if you want to edit text
include "common/functions.php";

header('Content-Type: text/html; charset=utf-8');
Session::startSession();
?>