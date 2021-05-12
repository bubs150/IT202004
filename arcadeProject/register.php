<?php
//in arcade folder
//added line 7 and lines 64-70
    require("navigate.php");
    $email="";
    $user="";
    if(isset($_REQUEST["email"])){
        $email = $_REQUEST["email"];
        $user = $_REQUEST["user"];
        $password = $_REQUEST["password"];
        $confirm = $_REQUEST["confirm"];
        $v = $_REQUEST["vis"];
        $r = $_REQUEST["role"];
        $valid = true;
        if(is_empty_or_null($email) || is_empty_or_null($password) || is_empty_or_null($confirm) || is_empty_or_null($user)){
            echo "Something's missing here....";
            //exit();
            $valid = false;
        }
        
        $email = trim($email);
        $password = trim($password);
        $confirm = trim($confirm);
        $user = trim($user);
        
        if($password !== $confirm){
            echo "Passwords don't match...";
            //exit();
            $valid = false;
        }
        if($valid){
            require(__DIR__ . "/../lib/db.php");
            //$db = getDB();//invoked in db.php already
            //Note: mysqli doesn't support named parameters
            //use positional prepared statements or real_escape_string
            $email = mysqli_real_escape_string($db, $email);
            $user = mysqli_real_escape_string($db, $user);
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $password = mysqli_real_escape_string($db, $password);
            //mysqli still wants the single quotes in the query so can't just drop in the variables post-escape
            $sql = "INSERT INTO mt_users (email, username, password, rawPassword, visibility, role) VALUES ('$email', '$user', '$hash','$password', '$v', '$r')";
            $retVal = mysqli_query($db, $sql);
            if($retVal){
                echo "You are being redirected to the login page.";
                die(header("refresh:4;url=authenticate.php"));
            }else{

                if(mysqli_error($db) == "Duplicate entry '${user}' for key 'username'"){
                      echo "We already gots a ${user} buddy. Move along.";
                  
                  }else if(mysqli_error($db) == "Duplicate entry '${email}' for key 'unq_email'"){
                      echo "Buddy, you already made an account. Get outta here.";
                  }
            }
        //TODO: don't forget to close your connection, don't want resource leaks
            mysqli_close($db);
        }
    }
?>
<form method="POST">
<label>Email</label>
<input type="text" name="email" value="<?php echo $email;?>"/>
<label>Username</label>
<input type="text" name="user" value="<?php echo $user;?>"/>
    
<label>Password</label>
<input type="password" name="password"/>
<input type="password" name="confirm"/>
<input type="submit" value="Register"/>
<div>
    <label for="vis">Visibility</label>
    <select name="vis" id="vis" readonly>
        <option <?php echo ($result['visibility'] === "private"?'selected="selected"':'');?> value="private">Private</option>
        <option <?php echo ($result['visibility'] === "public"?'selected="selected"':'');?> value="public">Public</option>
    </select>
</div>

<div>
    <label for="role">Role</label>
    <select name="role" id="role" readonly>
        <option <?php echo ($result['role'] === "admin"?'selected="selected"':'');?> value="admin">Admin</option>
        <option <?php echo ($result['role'] === "user"?'selected="selected"':'');?> value="user">User</option>
    </select>
</div>

</form>
