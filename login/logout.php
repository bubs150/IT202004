<?php
session_start();
$sidvalue = session_id(); 
echo "<br>Your session id: " . $sidvalue . "<br>";
$_SESSION = array();        //Make $_SESSION  empty OR session_unset()
session_destroy();            //Terminate session on server
require("navigate.php");
setcookie("PHPSESSID", "", time()-3600); ;
echo "You have logged out.<br>";
echo "You will now be returned to the login page."; 

die(header( "refresh:5;url=authenticate.php"));

?>
