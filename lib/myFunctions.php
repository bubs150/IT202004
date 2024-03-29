
<?php
function is_empty_or_null($variable){
    return !isset($variable) || empty($variable);
}

function setDebug($data){
    $_SESSION["debug"] = $data;
}

function getDebug($dumpAll = false){
    if(isset($_SESSION["debug"]) && !$dumpAll){
        
        echo var_export($_SESSION["debug"], true);
        unset($_SESSION["debug"]);
    }
    else{
        echo var_export($_SESSION, true);
    }
}

function safe($var){
    echo htmlentities($var, ENT_QUOTES, "utf-8");
}

function is_logged_in(){
    return isset($_SESSION["user"]) && isset($_SESSION["user"]["id"]);
}

function get_user_id(){
    if(is_logged_in()){
        return $_SESSION["user"]["id"];
    }
    return "";
}


function get_role(){
    if(is_logged_in()){
        return $_SESSION["user"]["role"];
    }
    return "";
}

function get_email(){
    if(is_logged_in()){
        return $_SESSION["user"]["email"];
    }
    return "";
}

function get_username(){
    if(is_logged_in()){
        if(isset($_SESSION["user"]["username"])){
            return $_SESSION["user"]["username"];
        }
        return get_email();
    }
    return "";
}

function mysql_error_info($db){
    if ($db != null) {
        $code = mysqli_errno($db);
        $state = mysqli_sqlstate($db);
        $error = mysqli_error($db);
        $returnStr = "";
        switch ($code) {
            case 1062:
                $returnStr =  "This email is already in use";
                break;
            case 1054:
                $returnStr =  "Sorry folks, the developer forgot to add the column";
                break;
            default:
                $returnStr =  "An unhandled error occurred: $code - $state - $error";
                break;
        }
        return $returnStr;
    } else {
        return "Database is null???";
    }
}

function flash($msg)//better alert box
{
    if (isset($_SESSION['flash'])) {
        array_push($_SESSION['flash'], $msg);
    } else {
        $_SESSION['flash'] = array();
        array_push($_SESSION['flash'], $msg);
    }
}

function getMessages()//just a get, used in flash.php
{
    if (isset($_SESSION['flash'])) {
        $flashes = $_SESSION['flash'];
        $_SESSION['flash'] = array();
        return $flashes;
    }
    return array();
}

function getScores($db, $user_id = -1, $type = "lifetime"){
    $query = "SELECT s.score, u.username, u.id, s.created FROM mt_users u JOIN mt_scores s on u.id = s.user_id";
    if($user_id > -1){
        $user_id = mysqli_real_escape_string($db, $user_id);
        
        $query .= " WHERE user_id = $user_id";
    }
    
    switch($type){
    
        case "lifetime":
            break;
        case "weekly":
            $query .= " AND s.created >= DATE_SUB(NOW(), INTERVAL 1 WEEK) ";
            break;
        case "monthly":
            $query .= "  AND s.created >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
            break;
        default:
            break;                                        
    }
    $query .= " order by s.score desc, s.created desc LIMIT 10";
    $retVal = mysqli_query($db, $query);
    
    $results = [];
    if($retVal){
        
        if(mysqli_num_rows($retVal) > 0){
            while($row = mysqli_fetch_assoc($retVal)){
                array_push($results, $row);
            }                        
        }                        
    }
    return $results;                                                
}
?>
