<?php
require_once "connection/connector.php";
$tite = $_REQUEST['title'];
$cat = $_REQUEST['cat'];
$img1 = $_REQUEST['img1'];
$img2 =  $_REQUEST['img2'];
$text =  $_REQUEST['text'];
$id = $_REQUEST['id'];

$sql_update = "UPDATE news SET title = ?, text = ?, categorie_id = ?, img1 = ?, img2 = ? where id = ".$id;
$stmt_update = mysqli_prepare($conn, $sql_update);
mysqli_stmt_bind_param($stmt_update, "sssss", $tite, $text, $cat, $img1, $img2);
mysqli_stmt_execute($stmt_update);
$res = "success";

$result = json_encode($res);
echo $result;
mysqli_close($conn);



