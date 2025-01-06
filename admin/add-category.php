<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add'])){//category added or not
                echo $_SESSION['add']; //displaying session message 
                unset($_SESSION['add']); //removing session message
            }
            if(isset($_SESSION['upload'])){//image uploaded or not
                echo $_SESSION['upload']; //displaying session message 
                unset($_SESSION['upload']); //removing session message
            }
        ?>

        <br><br>

        <!--Add Category form starts-->

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Category Title">

                </td>
            </tr>

            <tr>
                <td>Select Image:</td>
                <td>
                    <input type="file" name="image">
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
                    <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>

        <!--Add Category form ends-->

        <?php
            if(isset($_POST['submit']))
            {
                //1.get value from category form
                $title=$_POST['title'];

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
                
                //check image is selected or not and set value for image name
                //print_r($_FILES['image']);
                //die();//break code here

                if(isset($_FILES['image']['name']))
                {
                    //upload image
                    //to upload we need image name, source path, destination path
                    $image_name=$_FILES['image']['name'];
                    
                    //upload image only if image is selected
                    if($image_name != "")
                    {


                    //auto rename image
                    //get the extension of image(jpg,png,gif,etc) e.g. 'food1.jpg'
                    $ext=end(explode('.',$image_name));

                    $image_name="Food_Category_".rand(000,999).'.'.$ext;  ///rename like e.g. Food_Category_851.jpg
                    

                    $source_path=$_FILES['image']['tmp_name'];
                    $destination_path="../images/category/".$image_name;

                    //upload image
                    $upload=move_uploaded_file($source_path,$destination_path);

                    //check image uploaded or not
                    //if not uploaded stop the process and redirect
                    if($upload==false)
                    {
                        $_SESSION['upload']="<div class='error'>Failed to Upload Image</div>";
                        header('location:'.SITEURL.'admin/add-category.php');
                        die();
                    }
                }

                }
                else{
                    //dont upload
                    $image_name="";
                }

                //2.create sql query
                $sql="  INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                ";

                //execute query
                $res=mysqli_query($conn,$sql);

                if($res==true)
                {
                    //category added
                    $_SESSION['add']="<div class='success'>Category Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else{
                    //not added
                    $_SESSION['add']="<div class='error'>Failed to Add Category </div>";
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>