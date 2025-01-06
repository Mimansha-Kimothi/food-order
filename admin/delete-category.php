<?php

include('../config/constants.php');

//echo "delete page";
//check whether the id and image name is set


if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //get value and delete
    //echo "Get value and Delete";
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    //remove physical image file if available
    if($image_name != "")
    {
        //image name available so remove it
        $path="../images/category/".$image_name;
        $remove=unlink($path);

        //if failed to remove add an error msg and stop the process
        if($remove==false)
        {
            //set session msg
            $_SESSION['remove']="<div clsss='error'>Failed to Remove Category Image</div>";
            //redirect to manage-category page
            header('location:'.SITEURL.'admin/manage-category.php');
            //stop the process
            die();
        }
        
    }

    //delete data from database
    $sql= "DELETE FROM tbl_category WHERE id=$id";
    $res= mysqli_query($conn,$sql);

    if($res==true)
    {
        $_SESSION['delete']="<div class='success'>Category Deleted Successfully</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        $_SESSION['delete']="<div class='error'>Failed to Delete Category </div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }

    
}
else
{
    //redirect to manage-category
    header('location:'.SITEURL.'admin/manage-category.php');
}

?>