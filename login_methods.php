<?php
require_once "connection/connector.php";
$email = $_REQUEST['email'];
$pass =  $_REQUEST['pass'];

try{
    $check = strpos($email, '@');
    if($check === false){
        throw new Exception("email");
    }
}catch (Exception $e){
    echo $e->getMessage();
    exit();
}

$sql = "SELECT * FROM users WHERE email = ? AND password = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ss',$email,$pass);
mysqli_stmt_execute($stmt);
$run = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($run) != 1) {
    $res = "fail";
}else{
    $arr = mysqli_fetch_assoc($run);
    $id = $arr['id'];
    session_start();
    $_SESSION['name_user'] = $arr['name'];
    $_SESSION['user_id'] = $id;
    $_SESSION['user_status'] = $arr['status'];
    $_SESSION['surname_user'] = $arr['surname'];
    $res = "success";
}

$result = json_encode($res);
echo $result;
mysqli_close($conn);

