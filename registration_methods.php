<?php
require_once "connection/connector.php";
$name = $_REQUEST['name'];
$sname = $_REQUEST['sname'];
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

$sql = "SELECT * FROM users WHERE email = ?";

/////CHECK MAIL EXISTS OR NOT

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's',$email);
mysqli_stmt_execute($stmt);
$run = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($run) != 0) {
    $res = "fail";
}else{
    $sql_insert = "INSERT INTO users (name, surname, email, password) VALUES (?,?,?,?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "ssss", $name, $sname, $email, $pass);
    mysqli_stmt_execute($stmt_insert);
    $res = "success";
}

$result = json_encode($res);
echo $result;
mysqli_close($conn);


