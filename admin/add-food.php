<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br/> <br/>

        <?php
        
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

        <tr>
            <td>Title: </td>
            <td>
                <input type="text" name="title" placeholder="Title of the food">
            </td>
        </tr>

        <tr>
            <td>Description: </td>
            <td>
                <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
            </td>
        </tr>

        <tr>
            <td>Price: </td>
            <td>
                <input type="number" name="price">
            </td>
        </tr>

        <tr>
            <td>Select Image:</td>
            <td>
                <input type="file" name="image">
            </td>
        </tr>

        <tr>
            <td>Category:</td>
            <td>
                <select name="category">

                <?php
                    //create php code to display categories from database
                    //1. create sql to get all active categories from database
                    $sql= " SELECT * FROM tbl_category WHERE active='Yes'";

                    //executing query
                    $res= mysqli_query($conn,$sql);

                    //count rows to check whether we have categories else we do not have categories
                    $count= mysqli_num_rows($res);

                    //if count greater than zero, we have categories 
                    if($count>0)
                    {
                        //we have categories
                        while($row=mysqli_fetch_assoc($res))
                        {
                            $id=$row['id'];
                            $title=$row['title'];
                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $title;?></option>
                            <?php
                        }
                    }
                    else
                    {
                        //we do not have categories
                        ?>
                        <option value="0">No Category Found</option>
                        <?php
                    }

                    //2.display on dropdown
                
                ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Featured: </td>
            <td>
                    <input type="radio" name="featured" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No
            </td>
        </tr>

        <tr>
            <td>Active: </td>
            <td>
                <input type="radio" name="active" value="Yes"> Yes
                <input type="radio" name="active" value="No"> No
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Add Food" class="btn-secondary">
            </td>
        </tr>


        </table>
        
        </form>

    <?php

    //check whether the button is clicked or not
    if(isset($_POST['submit']))
    {
        //add food in database

        //1.get data from form
        $title=$_POST['title'];
        $description=$_POST['description'];
        $price=$_POST['price'];
        $category=$_POST['category'];

        //check radio button clicked or not
        if(isset($_POST['featured']))
        {
            $featured=$_POST['featured'];
        }
        else
        {
            $featured="No";
        }

        if(isset($_POST['active']))
        {
            $active=$_POST['active'];
        }
        else
        {
            $active="No";
        }


        //2.upload the image if selected
        //check whether select image is clicked or not 
        if(isset($_FILES['image']['name']))
        {
            //get details of selected image
            $image_name=$_FILES['image']['name'];

            //check whether image selected or not
            if($image_name!="")
            {
                //A.image is selected

                //get the extension of selected image
                $ext=end(explode('.',$image_name));

                //create new name for image
                $image_name="Food-Name-".rand(0000,9999).".".$ext; //new name like Food-Name-657.jpg

                //B.upload image
                //get src and destination path

                //source path is current location of image
                $src= $_FILES['image']['tmp_name'];

                //destination path for the image
                $dst= "../images/food/".$image_name;

                //finally upload the food image
                $upload= move_uploaded_file($src,$dst);

                //check image uploaded or not
                if($upload==false)
                {
                    //failed to upload image
                    //redirect to add food page with error msg
                    $_SESSION['upload']= " <div class='error'>Failed to Upload Image</div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                    //stop the process
                    die();
                }

                
            }
        }
        else
        {
            $image_name= "";
        }

        //3.insert into database

        //create a sql query to save or add food
        $sql2= "INSERT INTO tbl_food SET
        title='$title',
        description= '$description',
        price= $price,
        image_name= '$image_name',
        category_id= $category,
        featured= '$featured',
        active= '$active' ";

        $res2= mysqli_query($conn,$sql2);

        //check whether data inserted or not
        //4.redirect with message to manage-food page
        if($res2==true)
        {
            $_SESSION['add']= " <div class='success'>Food Added Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            $_SESSION['add']= " <div class='error'>Failed to Add Food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }


    }

    
    
    ?>


    </div>
</div>


<?php include('partials/footer.php'); ?>