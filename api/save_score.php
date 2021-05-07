<?php

$response = ["status"=>400, "message"=>"Invalid Request"];
if(isset($_POST["score"])){
	session_start();
	require(__DIR__ . "/../lib/myFunctions.php");
	$user = get_user_id();
	$score = $_POST["score"];
	
	$response["status"]=200;
	$resposne["message"]="Recorded score of score $score for user $user";
}
echo json_encode($response);
?>
