<?php
require_once "connection/connector.php";

$id = $_GET['id'];
$text = $_GET['text'];
$user_id = $_GET['user_id'];

if($text!=null){
    $sql_comment = 'INSERT INTO comments (author_id, text, article_id) VALUES ("'.$user_id.'","'.$text.'","'.$id.'")';
    $run_comment = mysqli_query($conn, $sql_comment);
}

$array = array();
$sql_comments = "SELECT * FROM comments WHERE article_id = '$id'";
$run_comments = mysqli_query($conn, $sql_comments);
while($comments = mysqli_fetch_assoc($run_comments)) {
    $author_id = $comments['author_id'];
    $sql_comment_name = "SELECT name, surname FROM users JOIN comments ON users.id = comments.author_id where comments.author_id = '$author_id'";
    $run_comment_name = mysqli_query($conn, $sql_comment_name);
    $name = mysqli_fetch_assoc($run_comment_name);
    $full_name = $name['name'] . " " . $name['surname'];
    $comment = array(
            "name" => $full_name,
            "text" => $comments['text']
    );
    array_push($array, $comment);
}
$json = json_encode($array);
echo $json;
//<?php
//                    $sql_comments = "SELECT * FROM comments WHERE article_id = '$id'";
//                    $run_comments = mysqli_query($conn, $sql_comments);
//                    while($comments = mysqli_fetch_assoc($run_comments)){
//                        $author_id = $comments['author_id'];
//                        $sql_comment_name = "SELECT name, surname FROM users JOIN comments ON users.id = comments.author_id where comments.author_id = '$author_id'";
//                        $run_comment_name = mysqli_query($conn, $sql_comment_name);
//                        $name = mysqli_fetch_assoc($run_comment_name);
//                        $full_name = $name['name']." ".$name['surname'];
//