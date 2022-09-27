<?php 
 session_set_cookie_params([
            'lifetime' => 60*60,
            'path' => '/~gmb285/MC',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => true,
            'httponly' => true,
            'samesite' => 'lax'
        ]);
session_start();
//echo var_export(session_get_cookie_params(), true); 
$sidvalue = session_id(); 
//echo "<br>Your session id: " . $sidvalue . "<br>";
require(__DIR__ . "/../lib/myFunctions.php");//GOTTA GRAB THIS AND CHANGE TO REQUIRE NAVIGATE.PHP SO IT SITS OVER THE GAME LIKE A MENU
?>
<ul>
<li><a href="authenticate.php">Login</a></li>
<li><a href="register.php">Make a New Account</a></li>
<li><a href="logout.php">Logout</a></li>
<li><a href="../thegame.php">Chase the Box</a></li>

</ul>
