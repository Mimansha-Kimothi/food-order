<?php 

//include constsants .php file here
include('../config/constants.php');


//1.get the id of admin to be deleted
$id=$_GET['id'];

// 2. Check how many admins are in the database
$sql_check = "SELECT * FROM tbl_admin";
$res_check = mysqli_query($conn, $sql_check);
$count = mysqli_num_rows($res_check);

if($count <= 1) {
    // There is only one admin left, prevent deletion
    $_SESSION['delete'] = "<div class='error'>Cannot delete the last admin.</div>";
    header('location:' . SITEURL . 'admin/manage-admin.php');
}
else{
//2.create sql query to del admin
$sql="DELETE FROM tbl_admin WHERE id=$id ";

//execute query
$res=mysqli_query($conn, $sql);

//check whether query executed successfully or not
if($res==true){
    //echo "Admin Deleted";
    $_SESSION['delete']= "<div class='success'> Admin Deleted Successfully</div>";
    //redirect to manage-admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else{
    //echo "Failed to Delete Admin";
    $_SESSION['delete']= "<div class='error'>Failed to Delete Admin </div>";
    //redirect to manage-admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
}
//redirect to manage-admin page with msg (success/error)
?>