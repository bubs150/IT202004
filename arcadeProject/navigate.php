<?php 
//in arcade folder
 session_set_cookie_params([
            'lifetime' => 60*60,
            'path' => '/~gmb28/IT202004',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => true,
            'httponly' => true,
            'samesite' => 'lax'
        ]);
session_start();
//echo var_export(session_get_cookie_params(), true); 
$sidvalue = session_id(); 
//echo "<br>Your session id: " . $sidvalue . "<br>";
require(__DIR__ . "/../lib/myFunctions.php");
//this is the one for arcade project
?>
<style>

#grad1
{
color: white;
font-family: Arial, Helvetica, sans-serif;
}

nav{border: 1px solid black;
background-color: red; /* For browsers that do not support gradients */
background-image: linear-gradient(red, #85ccff
);}
</style>
<nav>
<ul>

<?php 
if(!is_logged_in())://this if statement allows whatever is between it and the endif to happen. without, the login/register links would not appear
?>

<li><a href="authenticate.php" id="grad1">Login</a></li>
<li><a href="register.php" id="grad1">Register</a></li>

<?php
elseif(get_role()=="admin"):
?>

<li><a href="home.php" id="grad1">Home</a></li>
<li><a href="profile.php" id="grad1">Profile</a></li>
<li><a href="logout.php" id="grad1">Logout</a></li>
<li><a href="thegame.php" id="grad1">Chase the Box</a></li>
<li><a href="tweak.php" id="grad1">Admin Settings</a></li>


<?php
else:
?>

<li><a href="home.php" id="grad1">Home</a></li>
<li><a href="profile.php" id="grad1">Profile</a></li>
<li><a href="logout.php" id="grad1">Logout</a></li>
<li><a href="thegame.php" id="grad1">Chase the Box</a></li>

<?php 
endif;
?>

</ul>
</nav>
