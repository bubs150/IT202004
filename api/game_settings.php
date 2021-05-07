<?php
$response = [
	"status" => 200,
	"data" => [
    "countdown"=>2,
		"speed"=>5,
		"targetLength"=>50,
		"sideLength"=>50
	]
];

echo json_encode($response, JSON_PRETTY_PRINT);		
?>
