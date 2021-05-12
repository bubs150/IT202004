<?php
//arcade file
session_start();
require(__DIR__ . "/../../lib/myFunctions.php");
require(__DIR__ . "/../../lib/db.php");

if(!is_logged_in()){
    die(header("Location: authenticate.php"));
}
if(get_role()==="admin" && isset($_POST["speed"])){
    $c=(int)$_POST["countdown"];
    $s=(int)$_POST["speed"];
    $tb=(int)$_POST["targetLength"];
    $pb=(int)$_POST["sideLength"];
    $sql = "UPDATE gameSettings set speed = $s, countdown = $c, targetLength = $tb, sideLength = $pb where id = 1";
    $retVal = mysqli_query($db, $sql);
    if($sql){
        echo "Admin settings changed.";
    }    
}else{
    $sql = "SELECT * from gameSettings where id = 1";
    $retVal = mysqli_query($db, $sql);
        if($retVal){
            $result = mysqli_fetch_array($retVal, MYSQLI_ASSOC);
            $c=$result["countdown"];
            $s=$result["speed"];
            $tb=$result["targetLength"];
            $pb=$result["sideLength"]; 
        }
}

$response = [
	"status" => 200,
	"data" => [
    "countdown"=>$c,
		"speed"=>$s,
		"targetLength"=>$tb,
		"sideLength"=>$pb
	]
];


echo json_encode($response, JSON_PRETTY_PRINT);		
?>
