
<?php
require_once "connection/connector.php";

session_start();
$status = $_SESSION['user_status'];
$name = $_SESSION['name_user'];
$surname = $_SESSION['surname_user'];
$user_id = $_SESSION['user_id'];

//$name = null;
//$user_id = $_GET['user_id'];
//if(!empty($user_id)) {
//    $name_query = mysqli_query($conn, "SELECT name FROM users WHERE id = '$user_id'");
//    $name_user = mysqli_fetch_assoc($name_query);
//    $name = $name_user['name'];
//}else{
//    $name = $_SESSION['name_user'];
//    $user_id = $_SESSION['user_id'];
//}

$id = $_GET['id'];
$sql = "SELECT * FROM news WHERE id = '$id'";
mysqli_query($conn, "UPDATE news SET view = view + 1 WHERE id = '$id'");
$run = mysqli_query($conn, $sql);
$news = mysqli_fetch_assoc($run);


//if(isset($_GET['addcomment'])){
//    $comment = $_GET['comment'];
//    $id = $_GET['getId'];
//    $user_id = $_GET['getUserId'];
//    if(empty($comment)) $wrong = "You didn't write any comment.";
//    else{
//        $sql_comment = 'INSERT INTO comments (author_id, text, article_id) VALUES ("'.$user_id.'","'.$comment.'","'.$id.'")';
//        $run_comment = mysqli_query($conn, $sql_comment);
////        exit($sql_comment);
//        header("Location:news.php?id=".$id);
//    }
//}

?>


<!DOCTYPE html>
<html>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>News.com</title>
</head>
<script>
    $(document).ready(function () {
        ShowAllComments();
        function ShowAllComments() {
            $.ajax('getcomments.php', {
                type: 'GET',
                data: {
                    id: $( "#getId" ).val()
                },
                contentType: 'application/json',
                // dataType: "json",
                success: function (data) {
                    // $("#aaaaa").text(data);
                    var obj = JSON.parse(data);
                    for(var i = 0; i < obj.length; i++) {

                        var txt = '              <div class="comment">\n' +
                            '                        <img src="img/user.jpg" class="img-responsive img-resize-comment">\n' +
                            '                        <div class="comment-info">\n' +
                            '                            <p style="font-weight: bold">' + obj[i]['name'] + '</p>\n' +
                            '                            <p>' + obj[i]['text'] + '</p>\n' +
                            '                        </div>\n' +
                            '                    </div>';
                        $(".allcomments").append(txt);
                    }
                },
            });
        }
        $("#addcomment").click(function () {
            event.preventDefault();
            if($("#comment").val().length > 0){
                $("#wrong").hide();
                $.ajax("getcomments.php", {
                    type: 'GET',
                    data: {
                        id: $( "#getId" ).val(),
                        text: $("#comment").val(),
                        user_id: $("#getUserId").val()
                    },
                    success: function () {
                        var txt = '              <div class="comment">\n' +
                            '                        <img src="img/user.jpg" class="img-responsive img-resize-comment">\n' +
                            '                        <div class="comment-info">\n' +
                            '                            <p style="font-weight: bold"><?= $name." ".$surname?></p>\n' +
                            '                            <p>' + $("#comment").val() + '</p>\n' +
                            '                        </div>\n' +
                            '                    </div>';
                        $(".allcomments").append(txt);
                    }
                })
            }else{
                $("#wrong").text("You didn't write anything.")
            }
        })

    })
</script>
<body>
<div class="header">
    <a href="index.php" class="text">NEWS<span style="font-size: 20px">.com</span></a>
    <div class="header-right">

        <a class="aaa" href="">Contact</a>
        <a class="aaa" href="aboutus.php?user_id=<?=$user_id?>">About US</a>
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
        <div class="news-left">
            <div class="news-left-back">
                <div class="news-page">
                    <div class="news-page-title">
                        <h1><?=$news['title']?></h1>
                    </div>
                    <div class="news-page-info">
                        <i class="fa fa-eye" style="font-size:16px"><?=$news['view']?></i>
                        <div class="news-page-info-vl"></div>
                        <i class="fa fa-book" style="font-size:16px;">
                            <?php
                            $id = $news['id'];
                            $sql1 = "SELECT name FROM categories JOIN news ON categories.id = news.categorie_id WHERE news.id = '$id'";
                            $run1 = mysqli_query($conn, $sql1);
                            $news_cat = mysqli_fetch_assoc($run1);
                            echo $news_cat['name'];
                            ?>
                        </i>
                    </div>
                    <div class="news-page-image">
                        <img src="<?=$news['img2']?>" class="img-responsive img-resize-news-page">
                    </div>
                    <p>
                        <?=$news['text']?>
                    </p>
                </div>
            </div>
            <div class="news-left-comment">
                <div class="news-page-comments">
                    <div class="comment-text">
                        <h5>Comments:</h5>
                    </div>
                    <div class="allcomments"></div>
                    <div class="comment">
                        <img src="img/user.jpg" class="img-responsive img-resize-comment">
                        <div class="comment-add">
                            <form method="get">
                                <textarea cols="60" rows="3" id="comment" name="comment" placeholder="Write comment."></textarea>
                                <p id="wrong" style="color: red"></p>
                                <input id="getId" type="hidden" name="getId" value="<?=$id?>">
                                <input id="getUserId" type="hidden" name="getUserId" value="<?=$user_id?>">
                                <input type="submit" name="addcomment" id="addcomment" class="btn btn-danger" value="Add">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="news-right">
            <div class="news-right-back">
                <div class="add">
                    <img src="img/gif.gif" style="width: 70%; margin-bottom: 20px;">
                </div>
                <div>
                    <div class="top-text">
                        <h6>Top 5 News:</h6>
                    </div>
                    <div class="news-top-list">
                        <?php
                        $run_top = mysqli_query($conn, "SELECT * FROM news ORDER BY view DESC LIMIT 5");
                        while ($top = mysqli_fetch_assoc($run_top)){
                            ?>
                        <a href="news.php?id=<?=$top['id'].'&user_id='.$user_id?>">
                            <div class="top-news">
                                <div class="top-news-image">
                                    <img src="<?=$top['img1']?>" class="img-responsive img-resize-top">
                                </div>
                                <div class="top-news-title">
                                    <p><?=$top['title']?></p>
                                    <div class="top-news-info">
                                        <i class="fa fa-eye" style="font-size:12px"><?=$top['view']?></i>
                                        <div class="vl-small"></div>
                                        <i class="fa fa-comment" style="font-size:12px"><?=$top['comment']?></i>
                                        <div class="vl-small"></div>
                                        <i class="fa fa-book" style="font-size:12px;">
                                            <?php
                                            $id = $top['id'];
                                            $sql1 = "SELECT name FROM categories JOIN news ON categories.id = news.categorie_id WHERE news.id = '$id'";
                                            $run1 = mysqli_query($conn, $sql1);
                                            $news_cat = mysqli_fetch_assoc($run1);
                                            echo $news_cat['name'];
                                            ?>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</div>
<div class="footer">
    <div class="innerfooter">
    </div>
    <div class="bottom">
        <div class="footeritem">
            <a href=""><h4>NEWS</h4></a>
            <blockquote>
                News is information about current events.<br> 
                This may be provided through many different media
            </blockquote>
            <p>Copyright&copy; News.com 2020. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
