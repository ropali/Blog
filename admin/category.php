<?php require_once('include/top.php'); ?>
 <?php 
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }
    else if(isset($_SESSION['username']) and $_SESSION['role'] == 'author'){
        header('Location: error.php');
    }

    //delete category
    if(isset($_GET['del'])){
        $del_id = $_GET['del'];
        $del_query = "DELETE FROM categories WHERE id = '$del_id'";
        //preventing the parameter tempering of del
        if(isset($_SESSION['username']) and $_SESSION['role'] == 'admin'){
            if(mysql_query($del_query)){
            $del_msg = "Category Has Been Removed...";
            }
            else{
                $del_error = "Unable to remove the category...";
            }
        }
        
    }

    //Submiting the category
    if(isset($_POST['submit'])){
        $cat_name = mysql_real_escape_string(strtolower($_POST['cat-name']));
        $check_query = "SELECT * FROM categories WHERE category = '$cat_name'";
        $check_run = mysql_query($check_query);
        if(mysql_num_rows($check_run) > 0){
            $error = "Category Already Existed...";
        }
        else if(empty($cat_name)){
            $error = "Please enter a category name";
        }
        else{
            $insert_query = "INSERT INTO categories (category) VALUES('$cat_name')";
            
            if(mysql_query($insert_query)){
                $msg = "Category Has Been Added Successfully...";
            }
            else{
                $error = "Unable to add category...";
            }
        }
    }

    if(isset($_GET['edit'])){
        $update_id = $_GET['edit'];
    }

    //update the category
    if(isset($_POST['update'])){
        $update_cat_name = mysql_real_escape_string(strtolower($_POST['update-cat-name']));
        $check_query = "SELECT * FROM categories WHERE category = '$update_cat_name'";
        $check_run = mysql_query($check_query);
        if(mysql_num_rows($check_run) > 0){
            $update_error = "Category Already Existed...";
        }
        else if(empty($update_cat_name)){
            $update_error = "Please enter a category name";
        }
        else{
            $update_query = "UPDATE `categories` SET `category` = '$update_cat_name' WHERE `categories`.`id` = '$update_id'";
            
            if(mysql_query($update_query)){
                $update_msg = "Category Has Been Updated Successfully...";
            }
            else{
                $update_error = "Unable to update category...";
            }
        }
    }

?>
 
  </head>
  <body>
   <div id="wrapper">
    <?php require_once('include/navbar.php'); ?>
    
    <div class="container-fluid body-section">
        <div class="row">
            <div class="col-md-3">
                <?php require_once('include/sidebar.php'); ?>
            </div>
            <div class="col-md-9">
                <h1><i class="fa fa-folder-open" aria-hidden="true"></i>
                    Categories <small>Different categories</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                    <li class="active"><a href="index.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li><i class="fa fa-folder-open" aria-hidden="true"></i> Categories</li>
                  
                </ol>
                <div class="row">
                    <div class="col-md-6">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="category">Category Name:</label>
                                <?php
                                    //check if category is added successfully or not
                                    if(isset($error)){
                                        echo "<span class='pull-right' style='color:red'>$error</span>";
                                    }
                                    else if(isset($msg)){
                                        echo "<span class='pull-right' style='color:green'>$msg</span>";

                                    }
                                    
                                ?>
                                <input type="text" placeholder="Category Name" class="form-control" name="cat-name">
                            </div><!--form-group close-->
                            <input type="submit" class="btn btn-primary" value="Add category" name="submit">
                        </form>
                        
                        <?php 
                            if(isset($_GET['edit'])){
                                
                                //check if the provided id exist
                                $edit_check_query = "SELECT * FROM categories WHERE id = '$update_id'";
                                $edit_check_run = mysql_query($edit_check_query);
                                
                                if(mysql_num_rows($edit_check_run) > 0){
                                    $edit_row = mysql_fetch_array($edit_check_run);
                                    $update_cat = $edit_row['category'];
                                    
                                
                        ?>
                        <hr>
                        <!--form for updating category-->
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="category">Category Name:</label>
                                <?php
                                    //check if category is added successfully or not
                                    if(isset($update_error)){
                                        echo "<span class='pull-right' style='color:red'>$update_error</span>";
                                    }
                                    else if(isset($update_msg)){
                                        echo "<span class='pull-right' style='color:green'>$update_msg</span>";

                                    }
                                    
                                ?>
                                <input type="text" placeholder="Update Category Name" class="form-control" value="<?php echo $update_cat; ?>" name="update-cat-name">
                            </div><!--form-group close-->
                            <input type="submit" class="btn btn-primary" value="Update category" name="update">
                        </form>
                        <?php 
                            }
                            }
                        ?>
                    </div><!--col-md-6 close-->
                    <div class="col-md-6">
                       <?php 
                            //check if category is deleted successfully or not
                            if(isset($del_error)){
                                echo "<span class='pull-right' style='color:red'>$del_error</span>";
                            }
                            else if(isset($del_msg)){
                                echo "<span class='pull-right' style='color:green'>$del_msg</span>";

                            }

                        ?>
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Category name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php 
                                    $get_query = "SELECT * FROM categories ORDER BY id DESC";
                                    $get_run = mysql_query($get_query);
                                    if(mysql_num_rows($get_run)){
                                        while($row = mysql_fetch_array($get_run)){
                                            $cat_id = $row['id'];
                                            $cat_name = $row['category'];
                                ?>
                                <tr>
                                    <td><?php echo $cat_id; ?></td>
                                    <td><?php echo ucfirst($cat_name); ?></td>
                                    <td><a href="category.php?edit=<?php echo $cat_id; ?>"><i class="fa fa-pencil"></i></a></td>
                                    <td><a href="category.php?del=<?php echo $cat_id; ?>"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php 
                                  }
                                    else{
                                        echo "<center><h3>No Categories Available</h3></center>";   
                                    }
                        ?>
                    </div>
                </div><!--row close-->
            </div><!--col-md-9 close-->
        </div><!--row close-->
    </div>
        <?php require_once('include/footer.php'); ?>
    </div>
    
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>