<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Food Ordering System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; //displaying session message 
                    unset($_SESSION['login']); //removing session message
                }

                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message']; //displaying session message 
                    unset($_SESSION['no-login-message']); //removing session message
                }

            ?>
            <br> <br>

            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"> <br> <br>
                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"><br>
                    <br>
                <input type="submit" name="submit" value="Login" class="btn-primary"><br>
                <br><br>
            </form>
            
            <p class="text-center">Created By- <a href="www.mimanshakimothi.com">Mimansha Kimothi</a></p>
        </div>
    </body>
</html>

<?php

if(isset($_POST['submit'])){
    //process for login
    //1.get data from login
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $password=mysqli_real_escape_string($conn,md5($_POST['password']));

    //2.sql to check user exists
    $sql=" SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //3.execute query
    $res=mysqli_query($conn,$sql);

    //4.count rows to check user exists
    $count=mysqli_num_rows($res);

    if($count==1){
        //user available
        $_SESSION['login']="<div class='success'>Login Successfull</div>";
        $_SESSION['user']=$username; //to check user is logged in or not 
        
        header('location:'.SITEURL.'admin/');
    }
    else{
        //user not available
        $_SESSION['login']="<div class='error' 'text-center'>Username or Password did not match</div>";
        header('location:'.SITEURL.'admin/login.php');
    }

}

?>
