<?php
$conn = mysqli_connect("localhost", "root", "196422", "project");
if($conn===false){
    echo "Connection failed";
    echo mysqli_connect_error();
}