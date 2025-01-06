<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br/><br/>

        
        <?php //checking session is set or not
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; //displaying session message 
                unset($_SESSION['add']); //removing session message
            }
        ?>

        <?php //data being sent to current file?>

        <form action="" method="POST">  

        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
            </tr>

            <tr>
                <td>Username: </td>
                <td>
                    <input type="text" name="username" placeholder="Enter Your Username">
                </td>
            </tr>

            <tr>
                <td>Password: </td>
                <td>
                    <input type="password" name="password" placeholder="Enter Your Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                </td>
            </tr>
        </table>

    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php
//process the value from form and save it in database

//check whether the button is clicked or not

if(isset($_POST['submit'])){
    //button clicked
    //echo "Button Clicked";

    //1.get data from form

    $full_name=$_POST['full_name'];
    $username=$_POST['username'];
    $password=md5($_POST['password']); //password encryption using md5 

    //2.sql query to save the data into database

    $sql="INSERT INTO tbl_admin SET
        full_name='$full_name',
        username='$username',
        password='$password'
    ";

    //3.executing query and saving data in database
    $res=mysqli_query($conn,$sql) or die(mysqli_error());

    //4.check whether data is inserted or not and display appropriate message
    if($res==TRUE){
        //echo "data inserted";
        //create a session variable to display message
        $_SESSION['add']="Admin Added Successfully";
        //Redirect page to manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        //create a session variable to display message
        $_SESSION['add']="Failed to Add Admin";
        //Redirect page to manage admin
        header("location:".SITEURL.'admin/add-admin.php');
    }

}


?>