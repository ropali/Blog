<?php require_once('include/top.php'); ?>
 
 <?php 
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }
    else if(isset($_SESSION['username']) and $_SESSION['role'] == 'author'){
        header('Location: error.php');
    }

    if(isset($_GET['del'])){
        $del_id = $_GET['del'];
        $del_query = "DELETE FROM `users` WHERE `users`.`id` = $del_id";
        if(isset($_SESSION['username']) and $_SESSION['role'] == 'admin'){
            if(mysql_query($del_query)){
            $msg = "User has been removed";
            }
            else{
                $error = "Unable to remove the user";
            }
        }
    }

    if(isset($_POST['checkboxes'])){
        foreach($_POST['checkboxes'] as $user_id){
            $bulk_option = $_POST['bulk-options'];
            
            if($bulk_option == 'delete'){
                $bulk_del_query = "DELETE FROM `users` WHERE `users`.`id` = $user_id";
                
                mysql_query($bulk_del_query);
            }
            else if($bulk_option == 'author'){
                $bulk_author_query = "UPDATE `users` SET `role` = 'author' WHERE `users`.`id` = '$user_id'";
                mysql_query($bulk_author_query);
            }
            else if($bulk_option == 'admin'){
                $bulk_admin_query = "UPDATE `users` SET `role` = 'admin' WHERE `users`.`id` = '$user_id'";
                mysql_query($bulk_admin_query);
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
                <h1><i class="fa fa-users" aria-hidden="true"></i>
                    Users <small>View All Users</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                  <li class="active"><a href="index.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-users" aria-hidden="true"></i> Users</li>
                  
                </ol>
                
                <?php 
                    $query = "SELECT * FROM users ORDER BY id DESC";
                    $run = mysql_query($query);
                    if(mysql_num_rows($run) > 0){
                ?>
                <div class="row">
                    <div class="col-sm-8">
                        <form action="users.php" method="post">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <select name="bulk-options" id="bulk-options" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="author">Change to author</option>
                                            <option value="admin">Change to admin</option>
                                        </select>
                                    </div>
                                </div><!--col-xs-4 close-->
                                <div class="col-xs-8">
                                    <input type="submit" class="btn btn-success" value="Apply">
                                    <a href="add-user.php" class="btn btn-primary">Add new</a>
                                </div><!--col-xs-8 close-->
                            </div><!--row close-->
                        
                        
                    </div><!--row close-->
                </div>
                
                <?php
                    if(isset($error)){
                        echo "<span class='pull-right' style='color:red;'>$error</span>";
                    }
                    else if(isset($msg)){
                        echo "<span class='pull-right' style='color:green;'>$msg</span>";
                    }
                ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                           <th></th>
                            <th>Id#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Password</th>
                            <th>Role</th>
                            
                            <th>Edit</th>
                            <th>Del</th>
                        </tr>
                    </thead>
                    <?php 
                        while($row = mysql_fetch_array($run)){
                            $id = $row['id'];
                            $fname = $row['first_name'];
                            $lname = $row['last_name'];
                            $email = $row['email'];
                            $username = $row['username'];
                            $role = $row['role'];
                            $image = $row['image'];
                            $date = getdate($row['date']);
                            $day = $date['mday'];
                            $month = substr($date['month'],0,3);
                            $year = $date['year'];
                    ?>
                    <tbody>
                        <tr>
                           <td><input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $id; ?>"></td>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $day." ".$month." ".$year; ?></td>
                            <td><?php echo "$fname $lname"; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><img src="img/<?php echo $image; ?>" width="30px"></td>
                            <td>**********</td>
                            <td><?php echo ucfirst($role); ?></td>
                            
                            <td><a href="edit-user.php?edit=<?php echo $id; ?>"><i class="fa fa-pencil" title="edit user"></i></a></td>
                            <td><a href="users.php?del=<?php echo $id; ?>"><i class="fa fa-times" title="remove user"></i></a></td>
                        </tr>
                        <?php } ?>
                   </tbody>
                </table>
                </form>
                <?php 
                    }
                    else{
                        echo "<h2>No Users Available...</h2>";
                    }
                ?>
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