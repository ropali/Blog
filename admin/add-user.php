<?php require_once('include/top.php'); ?>
 <?php 
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }
    else if(isset($_SESSION['username']) and $_SESSION['role'] == 'author'){
        header('Location: error.php');
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
                <h1><i class="fa fa-user-plus" aria-hidden="true"></i>
                    Add Users <small>Add new user</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                  <li><a href="index.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-user-plus" aria-hidden="true"></i> Users</li>
                  
                </ol>
                <?php
                    if(isset($_POST['submit'])){
                        $fname = mysql_real_escape_string($_POST['fname']);
                        $lname = mysql_real_escape_string($_POST['lname']);
                        $email = mysql_real_escape_string($_POST['email']);
                        $password = mysql_real_escape_string($_POST['password']);
                        $role = $_POST['role'];
                        $details = mysql_real_escape_string($_POST['details']);
                        $username = mysql_real_escape_string(strtolower($_POST['username']));
                        $username_trim = preg_replace('/\s+/', '', $username);
                        
                        $image = $_FILES['image']['name'];
                        $image_tmp = $_FILES['image']['tmp_name'];
                        $date = time();
                        
                        $check_query = "SELECT * FROM users WHERE username = '$username' or email = '$email'";
                        $check_run = mysql_query($check_query);
                        
                        //fetching salt for password
                        $salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                        $salt_run = mysql_query($salt_query);
                        $salt_row = mysql_fetch_array($salt_run);
                        $salt = $salt_row['salt'];
                        $password = crypt($password, $salt);
                        
                        if(empty($fname) or empty($lname) or empty($email) or empty($password) or empty($details) or empty($username) or empty($image)){
                            $error_msg = "All (*) fields are mendatory...";
                        }
                        else if($username != $username_trim){
                            $error_msg = "Don't use spaces in username";
                        }
                        else if(mysql_num_rows($check_run) > 0){
                            $error_msg = "Username or Email Already Exist...";
                        }
                        else{
                            
                            $insert_query = "INSERT INTO `users` (`id`, `date`, `first_name`, `last_name`, `username`, `email`, `image`, `password`, `role`, `details`) VALUES (NULL, $date, '$fname', '$lname', '$username', '$email', '$image', '$password', '$role', '$details')";
                            
                            if(mysql_query($insert_query)){
                                $msg = "A New User Has Been Added...";
                                
                                move_uploaded_file($image_tmp,"img/$image");
                                
                                $image_check = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                                $image_run = mysql_query($image_check);
                                $image_row = mysql_fetch_array($image_run);
                                $check_image = $image_row['image'];
                                
                                //if the data is submitted properli empty the variable
                                $fname = "";
                                $lname = "";
                                $email = "";
                                $username = "";
                                $details = "";
                            }
                            else{
                                $msg = "A User Has Not Been Added...";
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
                            <input type="text" id="lname" name="fname" class="form-control" placeholder="First Name" value="<?php if(isset($fname)){ echo $fname; } ?>">
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name*</label>
                            <input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name" value="<?php if(isset($lname)){ echo $lname; } ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email*</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email address" value="<?php if(isset($email)){ echo $email; } ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password*</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="username">Username*</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php if(isset($username)){ echo $username; } ?>">
                        </div>
                        <div class="form-group">
                            <label for="image">Profile Picture*</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="role">Role*</label>
                            <select name="role" id="role" class="form-control">
                                <option value="author">Author</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="details">Details*</label>
                            <textarea name="details" id="details" cols="30" rows="10" placeholder="Add details about users" class="form-control"><?php if(isset($details)){ echo $details; } ?></textarea>
                        </div>
                        <input type="submit" name="submit" value="Add User" class="btn btn-primary" >
                    </form>
                </div>
                <div class="col-md-4">
                    <?php 
                        if(isset($check_image)){
                            echo "<img src='img/$check_image' width='100%' />";
                        }
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