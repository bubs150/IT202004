<style>

.let{
font-family: Arial, Helvetica, sans-serif;
}

</style>

<?php
//in arcade folder
    require("navigate.php");
    if(isset($_REQUEST["email"])){
        $email = $_REQUEST["email"];
        $guy = $_REQUEST["use"];
        $password = $_REQUEST["password"];
        if((is_empty_or_null($email) && is_empty_or_null($guy)) || is_empty_or_null($password)){
        //   1st part = if email is empty and user is empty   2nd part = if password is empty
            echo "You are missing one or more of the forms. Please look over your forms.";
            exit();
        } 
        require(__DIR__ . "/../lib/db.php");
        //$db = getDB();//invoked in db.php already
        $email = mysqli_real_escape_string($db, $email);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        //mysqli still wants the single quotes in the query so can't just drop in the variables post-escape
        
        if(is_empty_or_null($email)){
            $sql = "SELECT id, email, password, username, role from mt_users where username = '$guy'";
            echo "a";
        }else if(is_empty_or_null($guy)){
            $sql = "SELECT id, email, password, username, role from mt_users where email = '$email'";
            echo "b";
        }else{
            $sql = "SELECT id, email, password, username, role from mt_users where email = '$email' and username = '$guy'";
            echo "c";
        }
        
        $retVal = mysqli_query($db, $sql);
        if($retVal){
            $result = mysqli_fetch_array($retVal, MYSQLI_ASSOC);
            var_export($result);
            if(password_verify($password, $result["password"])){
                unset($result["password"]);
                session_start();
                $_SESSION["user"] = $result;
                
                die(header("Location: profile.php"));
                //THIS IS GONNA TAKE US TO OUR PROFILE PAGE
                
                //echo "<br>";
                //var_export($_SESSION);
            }else{
                echo "You're not you, go away";//passwords don't match
            }
        }else{
            echo "Something didn't work out " . mysqli_error($db);
        }
        //TODO: don't forget to close your connection, don't want resource leaks
        mysqli_close($db);
    }
?>
<form method="POST">
<label class="let">Email</label>
<input type="text" name="email"/>
<label class="let">Username</label>
<input type="text" name="use"/>
<label class="let">Password</label>
<input type="password" name="password"/>
<input type="submit" value="Login"/>
</form>
