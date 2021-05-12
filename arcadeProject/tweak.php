<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php 
require("navigate.php");
if(!is_logged_in()){
    die(header("Location: authenticate.php"));
}else if(get_role()=="user"){
    die(header("Location: authenticate.php"));
}
echo var_export($_SESSION, true);
echo "<h1>This is reserved for admins only.</h1>";
$speed = "";
$tbox = "";
$pbox = "";
$time = "";
if(isset($_POST["speed"])){
    $speed = $_POST["speed"];
    $tbox = $_POST["targetLength"];
    $pbox = $_POST["sideLength"];
    $time = $_POST["countdown"];    
}
?>


</body>
</html>

<form method="POST" action="api/game_settings.php">

<label>Speed</label>
<input type="text" name="speed"/>

<label>Target Box Size</label>
<input type="text" name="targetLength"/>

<label>Player Box Size</label>
<input type="text" name="sideLength"/>

<label>Max Time</label>
<input type="text" name="countdown"/>

<input type="submit" value="Change settings"/>

</form>
