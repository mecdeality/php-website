<?php
require_once "connection/connector.php";
$tite = $_REQUEST['title'];
$cat = $_REQUEST['cat'];
$img =  $_REQUEST['img'];
$text =  $_REQUEST['text'];

$sql_insert = "INSERT INTO news (title, text, categorie_id, img1, img2) VALUES (?,?,?,?,?)";

mysqli_query($conn, $sql_insert);

$res = "success";

$result = json_encode($res);
echo $result;
mysqli_close($conn);




$stmt_insert = mysqli_prepare($conn, $sql_insert);
mysqli_stmt_bind_param($stmt_insert, "sssss", $tite, $text, $cat, $img1, $img2);
mysqli_stmt_execute($stmt_insert);
$res = "success";

$result = json_encode($res);
echo $result;
mysqli_close($conn);



