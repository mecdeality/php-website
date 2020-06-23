<?php
require_once "connection/connector.php";
$status = "user";
//////////////////////////LOGIN////////////////////////////////////////

//if(isset($_POST['signin'])){
//    $email = $_POST['email'];
//    $pass = $_POST['password'];
//    $sql = "SELECT * FROM users WHERE email = '$email'AND password = '$pass'";
//    $run = mysqli_query($conn, $sql);
//    if(mysqli_num_rows($run) == 0) $wrong = "There is no such user. If you don't have an account, sign up for free.";
//    if(mysqli_num_rows($run) > 0){
//        $arr = mysqli_fetch_assoc($run);
//        $id = $arr['id'];
//        $_SESSION['name_user'] = $arr['name'];
//        $_SESSION['user_id'] = $id;
//        $_SESSION['user_status'] = $arr['status'];
//        $_SESSION['surname_user'] = $arr['surname'];
//        if($arr['status']=='admin') header('Location:index_admin.php');
//        if($arr['status']=='user') header('Location:index.php');
//    }
//}

//////////////////////////////////////////////////////////////////////
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Login</title>
</head>
<script>
    $(document).ready(function () {
        $("#submit").click(function () {
            var email = $("#email").val();
            var pass = $("#password").val();
            event.preventDefault()
            if(email.length > 0 && pass.length > 0 ){
                $.ajax("login_methods.php", {
                    type: "POST",
                    data: {
                        email: $("#email").val(),
                        pass: $("#password").val()
                    },
                    // contentType: 'application/json',
                    success: function (data) {
                        if(data === '"success"') window.location.href = "index.php";
                        else if(data ==="email") $("#wrong").text("Please, make sure your email is correct.");
                        else{
                            $("#wrong").text("Email or password is wrong, please check the correctness of the fields.");
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
<div class="header">
    <a href="<?php ($status=='user' ? print "index.php" : print "index_admin.php"); ?>" class="text">NEWS<span style="font-size: 20px">.com</span></a>
    <div class="header-right">
        <a class="aa" href="">Contact</a>
        <a class="aa" href="">About US</a>
    </div>
</div>
<div class="login">
    <div class="login-form">
        <h4 style="text-align: center; font-family: Noto Serif">Sign In</h4>
        <form method="post" action="">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="Email">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" minlength="6">
            <div class="sign">
                <input id="submit" type="submit" name="signin" value="Sign In">
                <a href="registration.php" style="width: 100%"><input type="button" name="signup" value="Sign Up"></a>
            </div>
            <h6 style="color:red; text-align: center; font-family: Noto Serif" id="wrong"></h6>
        </form>
    </div>
</div>
</body>
</html>