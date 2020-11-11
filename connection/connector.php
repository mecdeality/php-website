<?php
$conn = mysqli_connect("localhost", "root", "", "project");
if($conn===false){
    echo "Connection failed";
    echo mysqli_connect_error();
}
