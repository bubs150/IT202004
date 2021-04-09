<?php

function getDB()
{
  global $db;
  if(!isset($db)){
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set('display_errors' , 1);	
    include("account.php");
    $db=mysqli_connect($hostname,$username,$password,$project);
    if(mysqli_connect_errno()){
	    echo "Failed to connect to MySQL:".mysqli_connect_error();
	    exit();
    }
    print "You have successfully connected to MySQL database.<br>";
    mysqli_select_db($db,$project);
  }
  return $db;
}
?>
