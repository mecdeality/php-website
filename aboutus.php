<?php
//require "sqlclass.php";
require_once "connection/connector.php";

session_start();
$name = $_SESSION['name_user'];
$user_id = $_SESSION['user_id'];
$status = $_SESSION['user_status'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@700&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>About Us</title>
</head>
<body>
<div class="header">
    <a href="index.php" class="text">NEWS<span style="font-size: 20px">.com</span></a>
    <div class="header-right">

        <a class="aaa" href="">Contact</a>
        <a class="aaa" href="">About US</a>
        <?php
        if($name==null) echo "<a id=\"login\" class=\"aaa\" href=\"login.php\">Log In</a>";
        else{
        echo "<a id =\"login\" class=\"aa\" href=\"\">Hi, $name</a>";
        echo "<a class=\"aaa\" href=\"logout.php\">Log Out</a>";
        }
        ?>
    </div>
</div>
<div class="main">
    <div class="container">
        <div class="about">
            <div class="about-us">
                <h3>News.com</h3>
                <h1>Utegen Asylzhan</h1>
                <h3>IT-1902</h3>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>