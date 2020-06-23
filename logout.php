<?php
session_start();
$a = session_destroy();
session_unset();
if($a) header("Location: index.php");