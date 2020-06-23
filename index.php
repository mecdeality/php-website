<?php
session_start();
require_once "connection/connector.php";
if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == "admin") {
    header("Location: index_admin.php");
    return;
}


$name = $_SESSION['name_user'];
$user_id = $_SESSION['user_id'];


$cat_id = $_REQUEST['cat_id'];
$cat_name = $_REQUEST['cat_name'];

if(isset($_COOKIE['cat_id'])){
    $page = 1;
    $cat_id = $_COOKIE["cat_id"];
    $cat_name = $_COOKIE['cat_name'];
}

///////////PAGINATION//////////////
$limit = 21;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$start = ($page - 1) * $limit;

if(isset($_REQUEST['search-btn'])){
    $search_banner = true;
    $search = $_REQUEST['search'];
    if ($cat_id == 7 || $cat_id == null) {
        $sql = "SELECT * FROM news WHERE title LIKE '%$search%' LIMIT $start, $limit ";
        $sql_page = "SELECT * FROM news";
    } else {
        $sql = "SELECT * FROM news WHERE title LIKE '%$search%' and categorie_id = '$cat_id' LIMIT $start, $limit ";
        $sql_page = "SELECT * FROM news WHERE title LIKE '%$search%' and categorie_id = '$cat_id'";
    }
}else {
    $search_banner = false;
    if ($cat_id == 7 || $cat_id == null) {
        $sql = "SELECT * FROM news LIMIT $start, $limit ";
        $sql_page = "SELECT * FROM news";
    } else {
        $sql = "SELECT * FROM news WHERE categorie_id = '$cat_id' LIMIT $start, $limit ";
        $sql_page = "SELECT * FROM news WHERE categorie_id = '$cat_id'";
    }
}
$run = mysqli_query($conn, $sql);
$run_page = mysqli_query($conn, $sql_page);


$pages = mysqli_num_rows($run_page)/$limit;
$page_num = ceil($pages);

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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"
            integrity="sha256-1A78rJEdiWTzco6qdn3igTBv9VupN3Q1ozZNTR4WE/Y=" crossorigin="anonymous"></script>
    <title>News.com</title>
</head>
<script>
    $(document).ready(function () {

        $("#cat").on('change',function () {
            var id = $("#cat").val();
            var cat_name = $("#cat option:selected").text();
            $.ajax("index.php", {
                type: "POST",
                data: {
                    cat_id: id,
                    cat_name: cat_name
                },
                // contentType: 'application/json',
                success: function () {
                    $.cookie("cat_id", id, { expires : 10 });
                    $.cookie("cat_name", cat_name, { expires : 10 });
                    window.location.href = "index.php";
                }
            })
        })
    })
</script>
<body>
<div class="header">
    <a href="index.php" class="text">NEWS<span style="font-size: 20px">.com</span></a>
    <div class="header-right">
        <a>
            <form method="post">
                <div style="display: flex">
                    <input type="text" name="search" id="search" placeholder="Search">
                    <input type="submit" name="search-btn" id="search-btn" value="&#xf002">
                </div>
            </form>
        </a>
        <a class="aaa" href="galleryfacts.php">MiniFacts<sup>&#946;</sup></a>
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
<div class="header-cat">
    <div class="categories">
        <select id="cat">
            <option selected><?php ($cat_name==null || $cat_name == "All") ? print "Categories" : print $cat_name ?> | In order not to get lost from the world, join our community. </option>
        <?php
        $run_categories = mysqli_query($conn, "SELECT * FROM categories WHERE id NOT IN ('$cat_id')");
        while ($cat = mysqli_fetch_assoc($run_categories)) {
            ?>
            <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
        <?php } ?>
        </select>
    </div>
</div>
<div class="main">
    <?php if(!$search_banner || strlen($search) == 0){ ?>
    <div class="col">
        <p>THE BEST WEBSITE TO READ NEWS. READ NEWS ONLY IN OUR WEBSITE</p>
    </div>
    <?php } ?>
    <div class="wrapper">
        <div class="container-fluid">
        <div class="news-left">
            <div class="news-left-back">
                <?php
//                $search_msg = true;
                if(mysqli_num_rows($run) == 0 && $search_banner){ ?>
                <div class="search-text-container">
                    <div class="search-text">
                        <i class="fa fa-search" style="font-size:36px"></i>
                        <h5>We're not getting any results. Try another search</h5>
                    </div>
                </div>
                <?php } ?>
                <div class="d-flex flex-wrap">
                    <?php while($news = mysqli_fetch_assoc($run)){ ?>
                    <a href="news.php?id=<?=$news['id']?>">
                        <div class="news">
                            <img src="<?=$news['img1']?>" class="img-responsive img-resize">
                            <div class="news-title">
                                <p><?=$news['title']?></p>
                            </div>
                            <div class="news-info">
                                <i class="fa fa-eye" style="font-size:12px"><?=$news['view']?></i>
                                <div class="vl-small"></div>
                                <i class="fa fa-comment" style="font-size:12px">
                                    <?php
                                    $news_id = $news['id'];
                                    $run_count = mysqli_query($conn, "SELECT * FROM comments JOIN news ON comments.article_id = news.id WHERE news.id = '$news_id'");
                                    if($run_count===false) echo "ERROR COUNT";
                                    $count_comment = mysqli_num_rows($run_count);
                                    echo $count_comment;
                                    mysqli_query($conn, "UPDATE news SET comment = '$count_comment' WHERE id = '$news_id'");
                                    ?>
                                </i>
                                <div class="vl-small"></div>
                                <i class="fa fa-book" style="font-size:12px;">
                                    <?php
                                    $id = $news['id'];
                                    $sql1 = "SELECT name FROM categories JOIN news ON categories.id = news.categorie_id WHERE news.id = '$id'";
                                    $run1 = mysqli_query($conn, $sql1);
                                    $news_cat = mysqli_fetch_assoc($run1);
                                    echo $news_cat['name'];
                                    ?>
                                </i>
                            </div>
                        </div>
                    </a>
                    <?php } ?>

                </div>
                <?php if($page_num > 1){ ?>
                <div class="pagination">
                    <a id="non" href="#">&laquo;</a>
                    <?php for($i = 1; $i <= $page_num; $i++){ ?>
                    <a class="page" id="<?php $page == $i ? print("active") : print($i); ?>" href="index.php?page=<?=$i?>"><?=$i?></a>
                    <?php } ?>
                    <a id="non" href="#">&raquo;</a>
                </div>
                <?php } ?>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $(".page").click(function () {
                    // var page = $(this).val();
                    $("#active").attr("id", "non");
                    $(this).attr("id", "active");
                    // $(this).attr("href", "index.php?page="+page);
                })
            })
        </script>
        <div class="news-right">
            <div class="news-right-back">
                <div class="add">
                    <img src="img/gif.gif" style="width: 70%; margin-bottom: 20px;">
                </div>
                <div>
                    <div class="top-text">
                        <h6>Top 5 News (<?=$cat_name?>):</h6>
                    </div>
                    <div class="news-top-list">
                        <?php
                        if($cat_id == 7 || $cat_id == null ) $sql_top = "SELECT * FROM news ORDER BY view DESC LIMIT 5";
                        else $sql_top = "SELECT * FROM news WHERE categorie_id = '$cat_id' ORDER BY view DESC LIMIT 5";
                        $run_top = mysqli_query($conn, $sql_top);
                        while ($top = mysqli_fetch_assoc($run_top)){
                        ?>
                        <a href="news.php?id=<?=$top['id']?>">
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
