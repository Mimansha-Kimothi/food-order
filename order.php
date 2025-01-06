<?php include('partials-front/menu.php'); ?>

    <?php

    if(isset($_GET['food_id']))
    {
        $food_id=$_GET['food_id'];

        //get details of selected food

        $sql= "SELECT * FROM tbl_food WHERE id=$food_id";
        $res= mysqli_query($conn,$sql);
        $count=mysqli_num_rows($res);

        if($count==1)
        {
            $row=mysqli_fetch_assoc($res);

            $title=$row['title'];
            $price=$row['price'];
            $image_name=$row['image_name'];
        }
        else
        {
            header('location:'.SITEURL);
        }
        
    }
    else
    {
        header('location:'.SITEURL);
    }

    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                            if($image_name=="")
                            {
                                echo "<div class='error'>Image not available</div>";
                            }
                            else
                            {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        <p class="food-price"><?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required min="1">
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Mimansha Kimothi" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 984327xxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@mimi.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                if(isset($_POST['submit']))
                {
                    $food=$_POST['food'];
                    $price=$_POST['price'];
                    $qty=$_POST['qty'];

                    $total=$price * $qty; 

                    $order_date=date("Y-m-d h:i:sa");

                    $status="Ordered";  //4 statuses: Ordered, On Delivery, Delivered, Cancelled
                    $customer_name=$_POST['full-name'];
                    $customer_contact=$_POST['contact'];
                    $customer_email=$_POST['email'];
                    $customer_address=$_POST['address'];

                    // Server-side validation
                    $errors = array();

                    if(!is_numeric($customer_contact) || strlen($customer_contact) != 10) {
                        $errors[] = "Please enter a valid 10-digit phone number.";
                    }
    
                    if(!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Please enter a valid email address.";
                    }

                    if(empty($errors)) {
                    $sql2= "INSERT INTO tbl_order SET 
                            food= '$food',
                            price=$price,
                            qty=$qty,
                            total=$total, 
                            order_date='$order_date',
                            status='$status',
                            customer_name='$customer_name',
                            customer_contact='$customer_contact',
                            customer_email='$customer_email',
                            customer_address='$customer_address'
                            ";

                        //echo $sql2; die();

                    $res2=mysqli_query($conn,$sql2);
                    if($res2==true)
                    {
                        $_SESSION['order']="<div class='success text-center'>Food Ordered Successfully</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        $_SESSION['order']="<div class='error text-center'>Failed to Order</div>";
                        header('location:'.SITEURL);
                    }
                }
                else {
                    // Display validation errors
                    $_SESSION['order'] = "<div class='error text-center'>" . implode("<br>", $errors) . "</div>";
                    header('location:'.SITEURL);
                }
            }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>