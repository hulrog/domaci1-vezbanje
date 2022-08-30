<?php

    require "config.php";
    require "model/user.php";

    session_start();

    if(isset($_POST['username']) && isset($_POST['password'])){ 
        
        $uname = $_POST['username'];
        $upass = $_POST['password'];

        $user = new User(1, $uname, $upass);//id of admin is 1

        $res = User::logInUser($user, $conn);

        if($res->num_rows==1){

            $_SESSION['user_id']=$user->id;

            header('Location: home.php');
            exit();
        }else{
            echo 
            `<script>
            console.log("Failed.");
            </script>`; 
        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/login.css">
    <title>Login</title>

</head>
<body>
    <div><h1>A Song of Ice & Fire</h1></div>
    <div>
        <form action="" method="POST">
            <fieldset>
                <legend> Enter your login credentials: </legend>
                <label>Username</label> <br>
                <input type="text" name="username">
                <br>
                <label>Password</label><br>
                <input type="password" name="password">
                <br>
                <input type="submit" name="submit" value="SIGN IN">
            </fieldset>
        </form>
    </div>
    <div>
        <p>*The default login is admin, admin.</p>
    </div>
</body>
</html>