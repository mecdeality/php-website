
<?php
require_once "connection/connector.php";

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
            var rpass = $("#rpassword").val();
            var name = $("#name").val();
            var sname = $("#surname").val();
            event.preventDefault()
            if(email.length > 0 && pass.length > 0 && name.length > 0 && sname.length > 0 && rpass.length > 0){
                if(pass != rpass){
                    $("#wrong").text("Please, make sure your passwords match.");
                }else {
                    $.ajax("registration_methods.php", {
                        type: "POST",
                        data: {
                            name: name,
                            sname: sname,
                            email: email,
                            pass: pass
                        },
                        // contentType: 'application/json',
                        success: function (data) {
                            if (data === '"success"') {
                                alert("Account is successfully created!");
                                window.location.href = "login.php";
                            }
                            else if(data ==="email") $("#wrong").text("Please, make sure your email is correct.");
                            else {
                                $("#wrong").text("This account already exists.");
                            }
                        }
                    })
                }
            }else{
                $("#wrong").text("You must fill in all of the fields.");
            }
        })
    })
</script>
<body>
<div class="header">
    <a href="index.php" class="text">NEWS<span style="font-size: 20px">.com</span></a>
    <div class="header-right">
        <a class="aa" href="">Contact</a>
        <a class="aa" href="">About US</a>
    </div>
</div>
<div class="login">
    <div class="login-form">
        <h4 style="text-align: center; font-family: Noto Serif">Registration</h4>
        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Name">
            <label for="surname">Surname:</label>
            <input type="text" name="surname" id="surname" placeholder="Surname">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="Email">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" minlength="8">
            <label for="password">Repeat your assword:</label>
            <input type="password" name="rpassword" id="rpassword" placeholder="Repeat your password" minlength="8">
            <div class="sign"><input type="submit" name="submit" id="submit" value="Create Account"></div>
            <h6 id="wrong" style="text-align: center; font-family: Noto Serif; color: red"></h6>
        </form>
    </div>
</div>
</body>
</html>