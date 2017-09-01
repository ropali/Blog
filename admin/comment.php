<?php require_once('include/top.php'); ?>
 
 <?php 
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }
    else if(isset($_SESSION['username']) and $_SESSION['role'] == 'author'){
        header('Location: error.php');
    }

    $session_user = $_SESSION['username'];

    //deleting the comments
    if(isset($_GET['del'])){
        $del_id = $_GET['del'];
        $del_check_query = "SELECT * FROM comments WHERE id = '$del_id'";
        $del_check_run = mysql_query($del_check_query);
        if(mysql_num_rows($del_check_run) > 0){
            $del_query = "DELETE FROM `comments` WHERE `comments`.`id` = $del_id";
            if(isset($_SESSION['username']) and $_SESSION['role'] == 'admin'){
                if(mysql_query($del_query)){
                $msg = "Comment has been removed";
                }
                else{
                    $error = "Unable to remove the comment";
                }
            }

        }
        else{
            header('Location: logout.php');
            header('Location: login.php');
        }
    }

    //approve the comments
    if(isset($_GET['approve'])){
        $approve_id = $_GET['approve'];
        $approve_check_query = "SELECT * FROM comments WHERE id = '$approve_id'";
        $approve_check_run = mysql_query($approve_check_query);
        if(mysql_num_rows($approve_check_run) > 0){
            $approve_query = "UPDATE `comments` SET `status` = 'approved' WHERE `comments`.`id` = '$approve_id'";
            if(isset($_SESSION['username']) and $_SESSION['role'] == 'admin'){
                if(mysql_query($approve_query)){
                $msg = "Comment has been approved";
                }
                else{
                    $error = "Unable to approve the comment";
                }
            }

        }
        else{
            header('Location: logout.php');
            header('Location: login.php');
        }
    }

    //unapprove the comments
    if(isset($_GET['unapprove'])){
        $unapprove_id = $_GET['unapprove'];
        $unapprove_check_query = "SELECT * FROM comments WHERE id = '$unapprove_id'";
        $unapprove_check_run = mysql_query($unapprove_check_query);
        if(mysql_num_rows($unapprove_check_run) > 0){
            $unapprove_query = "UPDATE `comments` SET `status` = 'pending' WHERE `comments`.`id` = '$unapprove_id'";
            if(isset($_SESSION['username']) and $_SESSION['role'] == 'admin'){
                if(mysql_query($unapprove_query)){
                $msg = "Comment has been unapproved";
                }
                else{
                    $error = "Unable to unapprove the comment";
                }
            }

        }
        else{
            header('Location: logout.php');
            header('Location: login.php');
        }
    }



    if(isset($_POST['checkboxes'])){
        
        foreach($_POST['checkboxes'] as $user_id){
            $bulk_option = $_POST['bulk-options'];
            
            if($bulk_option == 'delete'){
                $bulk_del_query = "DELETE FROM `comments` WHERE `comments`.`id` = $user_id";
                
                mysql_query($bulk_del_query);
                $msg = "Comments has been removed";
            }
            else if($bulk_option == 'approved'){
                $bulk_author_query = "UPDATE `comments` SET `status` = 'approved' WHERE `comments`.`id` = '$user_id'";
                mysql_query($bulk_author_query);
                $msg = "Comment status has been updated";
            }
            else if($bulk_option == 'pending'){
                $bulk_admin_query = "UPDATE `comments` SET `status` = 'pending' WHERE `comments`.`id` = '$user_id'";
                mysql_query($bulk_admin_query);
                $msg = "Comment status has been updated";
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
                <h1><i class="fa fa-comments" aria-hidden="true"></i>
                    Comments <small>View All Comments</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                  <li><a href="index.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-comments" aria-hidden="true"></i> Comments</li>
                  
                </ol>
                <?php 
                    if(isset($_GET['reply_id'])){
                        $reply_id = $_GET['reply_id'];
                        $reply_check = "SELECT * FROM comments WHERE id = '$reply_id'";
                        $reply_check_run = mysql_query($reply_check);
                        if(mysql_num_rows($reply_check_run) > 0){
                            if(isset($_POST['reply'])){
                                $comment_data = $_POST['comment_data'];
                                if(empty($comment_data)){
                                    $comment_error = "Must Fill This Field";
                                }
                                else{
                                    $get_user_data = "SELECT * FROM users WHERE username = '$session_user'";
                                    $get_user_run = mysql_query($get_user_data);
                                    $get_user_row = mysql_fetch_array($get_user_run);
                                    
                                    $date = time();
                                    $fname = $get_user_row['first_name'];
                                    $lname = $get_user_row['last_name'];
                                    $fullname = "$fname $lname";
                                    $email = $get_user_row['email'];
                                    $image = $get_user_row['image'];
                                    
                                    $insert_comment_query = "INSERT INTO comments(date, name, username, post_id, email, image, comment, status) VALUES('$date', '$fullname', '$session_user', '$reply_id', '$email', '$image', '$comment_data', 'approved')";
                                    
                                    if(mysql_query($insert_comment_query)){
                                        $comment_msg = "Comment has been submitted";
                                    }
                                    else{
                                        $comment_error = "Unable to submit the comment";
                                    }
                                }
                            }
                        
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="comment_data" class="form-control">Comment:*</label>
                                <?php 
                                    if(isset($comment_error)){
                                        echo "<span class='pull-right' style='color:red;'>$comment_error</span>";
                                    }
                                    else if(isset($comment_msg)){
                                        echo "<span class='pull-right' style='color:green;'>$comment_msg</span>";
                                    }
                                ?>
                                <textarea name="comment_data" id="comment" cols="30" rows="10" placeholder="Your Comment Here" class="form-control"></textarea>
                            </div>
                            <input type="submit" name="reply" class="btn btn-primary" value="reply">
                        </form>
                    </div>
                </div>
                <hr>
                
                <?php 
                        }
                    }
                
                    $query = "SELECT * FROM comments ORDER BY id DESC";
                    $run = mysql_query($query);
                    if(mysql_num_rows($run) > 0){
                ?>
                <div class="row">
                    <div class="col-sm-8">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <select name="bulk-options" id="bulk-options" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="approved">Change to approved</option>
                                            <option value="pending">Change to unapproved</option>
                                        </select>
                                    </div>
                                </div><!--col-xs-4 close-->
                                <div class="col-xs-8">
                                    <input type="submit" class="btn btn-success" value="Apply">
                                    
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
                            <th>Post Id</th>
                            <th>Username</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Approved</th>
                            <th>Unapproved</th>
                            
                            <th>Reply</th>
                            <th>Del</th>
                        </tr>
                    </thead>
                    <?php 
                        while($row = mysql_fetch_array($run)){
                            $id = $row['id'];
                            $status = $row['status'];
                            $post_id = $row['post_id'];
                            $comment = $row['comment'];
                            $username = $row['username'];
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
                            <td><?php echo $post_id; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $comment; ?></td>
                            <td><span style="color:<?php 
                                if($status == 'approved'){
                                    echo 'green';
                                } else if($status == 'pending'){ echo 'red'; }
                                
                                ?>"><?php echo ucfirst($status); ?></span></td>
                            <td><a href="comment.php?approve=<?php echo $id; ?>">approved</a></td>
                            <td><a href="comment.php?unapprove=<?php echo $id; ?>">unapproved</a></td>                            
                            <td><a href="comment.php?reply_id=<?php echo $post_id; ?>"><i class="fa fa-reply" title="reply comment"></i></a></td>
                            <td><a href="comment.php?del=<?php echo $id; ?>"><i class="fa fa-times" title="remove comment"></i></a></td>
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