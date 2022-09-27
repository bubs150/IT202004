<?php require("navigate.php"); ?>

<?php

if(!is_logged_in()){
    die(header("Location: authenticate.php"));
}

/*
$name=get_username();
$mail=get_email();
if($name!==""){
    if($name===$mail){
        echo "<h1>Hello User!</h1><p>Your online account is registered as: {$mail}</p><p>Here are our other awesome users, like you!</p>";
    }else{
        echo "<h1>Hello User!</h1><p>Your online account is registered as: {$mail}, {$name}</p><p>Here are our other awesome users, like you!</p>";
    }
}*/

$user_id = get_user_id();
if (isset($_GET["id"])) {
    $user_id = $_GET["id"];
}
$isMe = $user_id == get_user_id();
require(__DIR__ . "/../lib/db.php");
$user_id = mysqli_real_escape_string($db, $user_id);

if($isMe && isset($_POST["email"])){
    $u = $_POST["username"];
    $e = $_POST["email"];
    $v = mysqli_real_escape_string($db, $_POST["vis"]);
    $sql = "UPDATE mt_users set visibility = '$v' where id = $user_id";
    $sql = mysqli_query($db, $sql);

    if($sql){
        echo "Profile updated.";
    }
}
$query = "SELECT email, username, created, visibility, role FROM mt_users where id = $user_id";
if (!$isMe) {
    $query .= " AND visibility = 'public'";
}

$retVal = mysqli_query($db, $query);
$result = [];
if ($retVal) {
    $result = mysqli_fetch_array($retVal, MYSQLI_ASSOC);
}
?>
<h3>Profile</h3>
<?php if($result):?>
<form method="POST">
    <?php if($isMe):?>
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php safe($result['email']);?>" readonly/>
    </div>
    <?php endif;?>
    <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php safe($result['username']);?>" readonly/>
    </div>
    <div>
        <label for="created">Joined</label>
        <input type="text" id="created" value="<?php safe($result['created']);?>" readonly/>
    </div>
    <div>
        <label for="role">Role</label>
        <input type="text" id="role" value="<?php safe($result['role']);?>" readonly/>
    </div>
    <?php if($isMe):?>
    <div>
        <label for="vis">Visibility</label>
        <select name="vis" id="vis" readonly>
            <option <?php echo ($result['visibility'] === "private"?'selected="selected"':'');?> value="private">Private</option>
            <option <?php echo ($result['visibility'] === "public"?'selected="selected"':'');?> value="public">Public</option>
        </select>
    </div>
    <input type="submit" value="Save Settings"/>
    <?php endif;?>
</form>
<h5>Scores</h5>
<?php 
$results = getScores($db, $user_id);
?>
<?php if($results && count($results) > 0):?>
    <?php foreach($results as $score):?>
        <div><?php safe($score["score"]);?> - <?php safe($score["created"]);?></div>
    <?php endforeach;?>
<?php else: ?>
    <d>This user has no scores</div>
<?php endif;?>
<?php else:?>
<p>This profile is private</p>
<?php endif;?>
