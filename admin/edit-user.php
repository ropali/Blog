<?php require_once('include/top.php'); ?>
 <?php 
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }
    else if(isset($_SESSION['username']) and $_SESSION['role'] == 'author'){
        header('Location: error.php');
    }

    if(isset($_GET['edit'])){
        $edit_id = $_GET['edit'];
        $edit_query = "SELECT * FROM users WHERE id = '$edit_id'";
        $edit_run = mysql_query($edit_query);
        
        if(mysql_num_rows($edit_run) > 0){
            $edit_row = mysql_fetch_array($edit_run);
            
            $edit_fname = $edit_row['first_name'];
            $edit_lname = $edit_row['last_name'];
            $edit_role = $edit_row['role'];
            $edit_image = $edit_row['image'];
            $edit_email = $edit_row['email'];
            $edit_details = $edit_row['details'];
        }
        else{
            header('Location: index.php');
        }
        
    }
    else{
        header('Location: index.php');
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
                <h1><i class="fa fa-pencil-square" aria-hidden="true"></i>
                    Edit Users <small>Edit User Details</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                  <li><a href="index.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit Users</li>
                  
                </ol>
                <?php
                    if(isset($_POST['submit'])){
                        $fname = mysql_real_escape_string($_POST['fname']);
                        $lname = mysql_real_escape_string($_POST['lname']);
                        $email = mysql_real_escape_string($_POST['email']);
                        $password = mysql_real_escape_string($_POST['password']);
                        $role = $_POST['role'];
                        $details = mysql_real_escape_string($_POST['details']);
                        
                        
                        $image = $_FILES['image']['name'];
                        $image_tmp = $_FILES['image']['tmp_name'];
                        
                        //if image is empty then apply the previous image
                        if(empty($image)){
                            $image = $edit_image;
                        }
                        
                        //fetching salt for password
                        $salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                        $salt_run = mysql_query($salt_query);
                        $salt_row = mysql_fetch_array($salt_run);
                        $salt = $salt_row['salt'];
                        $insert_password = crypt($password, $salt);
                        
                        if(empty($fname) or empty($lname) or empty($email) or empty($password) or empty($details) or empty($image)){
                            $error_msg = "All (*) fields are mendatory...";
                        }
                        else{
                            $update_query = "UPDATE `users` SET `first_name` = '$fname', `last_name` = '$lname', `email` = '$email', `image` = '$image', `password` = '$insert_password', `role` = '$role', `details` = '$details' WHERE `users`.`id` = $edit_id";
                            
                            if(mysql_query($update_query)){
                                $msg = "User has been updated...";
                                header("refresh:1 url='edit-user.php?edit=$edit_id'");
                                if(!empty($image)){
                                    move_uploaded_file($image_tmp,"img/$image");
                                }
                            }
                            else{
                                $error = "Unable to update the uaser...";
                            }
                        }
                    }
                ?>
                <div class="col-md-8">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                           <?php 
                                if(isset($error_msg)){
                                    echo "<span class='pull-right' style='color:red;'>$error_msg</span>";
                                }
                                else if(isset($msg)){
                                    echo "<span class='pull-right' style='color:green;'>$msg</span>";
                                }
                            ?>
                            <label for="fname">First Name*</label>
                            <input type="text" id="lname" name="fname" class="form-control" placeholder="First Name" value="<?php echo $edit_fname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name*</label>
                            <input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $edit_lname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email*</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email address" value="<?php echo $edit_email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password*</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Profile Picture*</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="role">Role*</label>
                            <select name="role" id="role" class="form-control">
                                <option value="author" <?php if($edit_role == 'author'){ echo "selected"; } ?>>Author</option>
                                <option value="admin" <?php if($edit_role == 'admin'){ echo "selected"; } ?>>Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="details">Details*</label>
                            <textarea name="details" id="details" cols="30" rows="10" placeholder="Add details about users" class="form-control"><?php echo $edit_details; ?></textarea>
                        </div>
                        <input type="submit" name="submit" value="Update User" class="btn btn-primary" >
                    </form>
                </div>
                <div class="col-md-4">
                    <?php 
                            echo "<img src='img/$edit_image' width='100%' />";
                        
                    ?>
                </div>
                
            </div>
        </div>
    </div>
    <?php require_once('include/footer.php'); ?>
    </div>
    
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>