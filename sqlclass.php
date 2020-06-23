<?php

class DateBase{
    public $conn;

    function __construct()
    {
        $conn = mysqli_connect("localhost", "root", "196422", "project");
    }

    function getConn(){
        return $this->conn;
    }
}
class News extends DateBase
{

}
class Comment extends DateBase
{
    private $bool;
    function __construct()
    {
        $this->bool = true;
    }

    function addComment($user_id, $comment, $news_id){
        $sql = "INSERT INTO comments (author_id, text, article_id) VALUES ('$user_id', '$comment', '$news_id')";
        $run_comment = mysqli_query(parent::getConn(), $sql);
        if($run_comment===false) return false;
        else return $this->bool;
    }
}