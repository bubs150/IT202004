<?php
session_start();
require(__DIR__ . "/../../lib/myFunctions.php");
//set up a bunch of $variables = $_POST["yuh"]; where yuh is the specific details of the game to change under data like speed. 
//in another php file, it'll only allow admins to get in and change the rules of the game. by using the stuff at thegame.php, lines 126-127 or lines 156-159, we can
//send info that will be updated to here for when the game is next played, it'll use these new details at startGame in thegame.php
//in the new file, the values to be changed will be first called as a variable outside of php, like var score = 0; and then changed to whatever is in the 
//forms when called to by a submit button
if(!is_logged_in()){
    die(header("Location: authenticate.php"));
}
echo get_role() . "<br>";
echo var_export($_SESSION, true) . "<br>";
if(get_role()==="admin"){
    $c=$_POST["countdown"];
    $s=$_POST["speed"];
    $tb=$_POST["targetLength"];
    $pb=$_POST["sideLength"];
}else{
    $c=30;
    $s=5;
    $tb=50;
    $pb=50;
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

$sql = "UPDATE gameSettings set speed = $s and countdown = $c and targetLength = $tb and sideLength = $pb where id = 1";
$sql = mysqli_query($db, $sql);
if($sql){
    echo "Admin settings changed.";
}
echo json_encode($response, JSON_PRETTY_PRINT);		
?>
