<?php
session_start();
require_once "connection/connector.php";
$name = $_SESSION['name_user'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM facts ";
$run = mysqli_query($conn, $sql);

//DELETE
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $run_delete = mysqli_query($conn, "DELETE FROM facts WHERE id = '$id'");
    header("Location:galleryfacts.php");
}
//EDIT
if(isset($_POST['edit'])){
    $id = $_POST['id'];
    header("Location:edit_galleryfacts.php?id=".$id);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="plugins/swiper/swiper.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@700&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="plugins/swiper/swiper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"
            integrity="sha256-1A78rJEdiWTzco6qdn3igTBv9VupN3Q1ozZNTR4WE/Y=" crossorigin="anonymous"></script>
    <title>News.com</title>
</head>
<style>
    body {
        /*background: #fff;*/
        /*background-image: url("img/slide.jpg");*/
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #000;
        margin: 0;
        padding: 0;
    }
    .background-img{
        position: fixed;
        left: 0;
        right: 0;
        z-index: 1;
        display: block;
        height:100%;
        width:100%;
        -webkit-filter: blur(10px);
        -ms-filter: blur(10px);
        filter: blur(5px);
        background-image: url("img/slide.jpg");
    }
    .swiper-container {
        width: 100%;
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .swiper-slide {
        position: relative;
        background-position: center;
        background-size: cover;
        margin-right: 50px;
        margin-left: 50px;
        width: 400px;

    }
    .edit_fact{
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .header{
        -webkit-filter: blur(3px);
        -ms-filter: blur(10px);
        transition: .2s ease;
    }
    .header:hover{
        -webkit-filter: blur(0px);
        -ms-filter: blur(10px);
    }
</style>
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
<div class="background-img"></div>
<div class="gallery">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php while($fact = mysqli_fetch_assoc($run)){ ?>
            <div class="swiper-slide">
                <div class="card">
                    <?php
                    if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == "admin"){
                    ?>
                    <div class="edit_fact">
                        <form method="post">
                            <input type="hidden" name="id" value="<?=$fact['id']?>">
                            <input id="factButton" type="submit" name="delete" value="&#xf00d">
                            <input id="factButton" type="submit" name="edit" value="&#xf044">
                        </form>
                    </div>
                    <?php } ?>
                    <div class="sliderImg">
                        <img class="slider-img" src="<?=$fact['url']?>">
                    </div>
                    <div class="sliderText">
                        <h5 class="slider-text"><?=$fact['text']?></h5>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == "admin"){
            ?>
                <a href="add_galleryfacts.php">
                    <div class="swiper-slide">
                        <div class="card-add">
                            <div style="position:absolute; margin-top: 100px; margin-left: 125px">
                            <h1 style="font-size: 100px">+</h1>
                            <h4>Add a new fact</h4>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
    <div style="display: flex; justify-content: center">
        <a href="index.php"><input style="width: 200px;" type="button" value="Back to the main page"></a>
    </div>
</div>
<script src="plugins/swiper/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 20,
            stretch: 0,
            depth: 300,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: '.swiper-pagination',
        },
    });
</script>
</body>
</html>