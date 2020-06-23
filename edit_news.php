
<?php
require "query_class.php";
require_once "connection/connector.php";
///////////////////////JUST FOR SHOWING HOW CAN I USE CLASSES//////////////////////////////

$class = new Query("localhost", "root", "196422", "project");

session_start();

/////////////////////////////NAME&ID///////////////////////////////////

$name = null;
$name = $_SESSION['name_user'];
$user_id = $_SESSION['user_id'];
$news_id = $_GET['id'];
$news_cat = $_GET['cat_id'];

//////////////////////////EDIT-NEWS-METHOD////////////////////////////

//if(isset($_POST['edit'])){
//    $title = $_POST['title'];
//    $img1 = $_POST['img1'];
//    $img2 = $_POST['img2'];
//    $string = $_POST['text'];
//    $text = mysqli_real_escape_string($conn, $string);
//    $cat = $_POST['cat'];
//    if(empty($title) || empty($img1) || empty($img2) || empty($text) || empty($cat)){
//        $wrong = "All fields must be filled!";
//    }
//    $sql_edit = 'UPDATE news SET title = "'.$title.'", text = "'.$text.'", categorie_id = "'.$cat.'", img1 = "'.$img1.'", img2 = "'.$img2.'" WHERE id = '.$news_id;
//    if($class->Execute($sql_edit)){
//        header("Location:index_admin.php");
//    }else{
//        echo "ERROR";
//        echo mysqli_error($class->Execute($sql_edit));
//    }
//}

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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Edit News</title>
</head>
<script>
    $(document).ready(function () {
        $("#submit").click(function () {
            var title = $("#add-title").val();
            var cat = $("#categories").val();
            var img1 = $("#img1").val();
            var img2 = $("#img2").val();
            var text = $("#add-text").val();
            var id = $("#id").val();
            event.preventDefault()
            if(title.length > 0 && cat !=="cat" && img1.length > 0 && img2.length > 0 && text.length > 0){
                $.ajax("edit_news_methods.php", {
                    type: "POST",
                    data: {
                        title: title,
                        cat: cat,
                        img1: img1,
                        img2: img2,
                        text: text,
                        id: id
                    },
                    // contentType: 'application/json',
                    success: function (data) {
                        if (data === '"success"') {
                            alert("You have successfully edited the news!");
                            window.location.href = "index.php";
                        }
                    }
                })
            }else{
                $("#wrong").text("You must fill in all of the fields.");
            }
        })
    })
</script>
<body>
<div>
    <div class="header">
        <a href="index_admin.php" class="text">NEWS<span style="font-size: 20px">.com</span></a>
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
</div>
<div class="main">
    <div class="container">
        <div class="news-left">
            <div class="news-left-back">
                <div class="edit-news">
                    <h5></h5>
                    <form method="post">
                        <form method="post">
                            <label >Title:</label>
                            <?php
                            $run_news = mysqli_query($conn, "SELECT * FROM news WHERE id = '$news_id'");
                            $news = mysqli_fetch_assoc($run_news);
                            ?>
                            <div class="title-categorie">
                                <input id="id" type="hidden" name="id" value="<?=$news_id?>">
                                <input id="add-title" type="text" name="title" placeholder="Title of the news." value="<?=$news['title']?>">
                                <select id="categories" name="cat">
                                        <?php
                                        $run_cat_name = mysqli_query($conn, "SELECT name FROM categories WHERE id = '$news_cat'");
                                        $arr = mysqli_fetch_assoc($run_cat_name);
                                    echo "<option value='$news_cat'>";
                                        echo $arr['name'];
                                        ?>
                                    </option>
                                    <?php
                                    $run_categories = mysqli_query($conn, "SELECT * FROM categories WHERE id NOT IN(7,'$news_cat')");
                                    while ($cat = mysqli_fetch_assoc($run_categories)) {
                                        ?>
                                        <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label for="img1">Preview Image:</label>
                            <input type="text" id="img1" name="img1" placeholder="Link of the preview image. Ex: img/image.jpg." value="<?=$news['img1']?>">
                            <label for="img2">Image:</label>
                            <input type="text" id="img2" name="img2" placeholder="Link of the image. Ex: img/image.jpg." value="<?=$news['img2']?>">
                            <label for="text">Text:</label>
                            <textarea id="add-text" name="text" cols="30" rows="13" placeholder="Text here."><?=$news['text']?></textarea>
                            <input id="submit" type="submit" name="edit" value="Save">
                        </form>
                    </form>
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