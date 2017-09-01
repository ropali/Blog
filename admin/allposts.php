<?php require_once('include/top.php'); ?>
 
 <?php 
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }


    $session_username = $_SESSION['username'];

    if(isset($_GET['del'])){
        $del_id = $_GET['del'];
        if($_SESSION['role'] == 'admin'){
            $del_check_query = "SELECT * FROM posts WHERE id = '$del_id'";
           
        }
        else if($_SESSION['role'] == 'author'){
            $del_check_query = "SELECT * FROM posts WHERE id = '$del_id' and author = '$session_username'";
            
        }
        $del_check_run = mysql_query($del_check_query);
        if(mysql_num_rows($del_check_run) > 0){
            $del_query = "DELETE FROM `posts` WHERE `posts`.`id` = $del_id";
            if(mysql_query($del_query)){
                $msg = "Post has been removed";
            }
            else{
                $error = "Unable to remove the post";
            }
        }
    }

    if(isset($_POST['checkboxes'])){
        foreach($_POST['checkboxes'] as $user_id){
            $bulk_option = $_POST['bulk-options'];
            
            if($bulk_option == 'delete'){
                $bulk_del_query = "DELETE FROM `posts` WHERE `posts`.`id` = $user_id";
                
                mysql_query($bulk_del_query);
            }
            else if($bulk_option == 'publish'){
                $bulk_author_query = "UPDATE `posts` SET `status` = 'publish' WHERE `posts`.`id` = '$user_id'";
                mysql_query($bulk_author_query);
            }
            else if($bulk_option == 'draft'){
                $bulk_admin_query = "UPDATE `posts` SET `status` = 'draft' WHERE `posts`.`id` = '$user_id'";
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
                <h1><i class="fa fa-file" aria-hidden="true"></i>
                    Posts <small>View All Posts</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                  <li><a href="index.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-file" aria-hidden="true"></i> Posts</li>
                  
                </ol>
                
                <?php 
                   if($_SESSION['role'] == 'admin'){
                        $query = "SELECT * FROM posts ORDER BY id DESC";
                        
                   }
                    else if($_SESSION['role'] == 'author'){
                        $query = "SELECT * FROM posts WHERE author = '$session_username' ORDER BY id DESC";
                    }
                    $run = mysql_query($query);
                    if(mysql_num_rows($run) > 0){
                ?>
                <div class="row">
                    <div class="col-sm-8">
                        <form action="allposts.php" method="post">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <select name="bulk-options" id="bulk-options" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="publish">Publish</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                    </div>
                                </div><!--col-xs-4 close-->
                                <div class="col-xs-8">
                                    <input type="submit" class="btn btn-success" value="Apply">
                                    <a href="add-post.php" class="btn btn-primary">Add new</a>
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
                            <th>Title</th>
                            <th>Author</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Del</th>
                        </tr>
                    </thead>
                    <?php 
                        while($row = mysql_fetch_array($run)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $author = $row['author'];
                            $views = $row['views'];
                            $image = $row['image'];
                            $category = $row['categories'];
                            $status = $row['status'];
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
                            <td><?php echo "$title"; ?></td>
                            <td><?php echo $author; ?></td>
                            <td><img src="../img/<?php echo $image; ?>" width="30px"></td>
                            <td><?php echo $category; ?></td>
                            <td><?php echo $views; ?></td>
                            <td><span style="color:<?php 
                                if($status == 'publish'){
                                    echo 'green';
                                } else if($status == 'draft'){ echo 'red'; }
                                
                                ?>"><?php echo ucfirst($status); ?></span></td>
                            
                            <td><a href="edit-post.php?edit=<?php echo $id; ?>"><i class="fa fa-pencil" title="edit user"></i></a></td>
                            <td><a href="allposts.php?del=<?php echo $id; ?>"><i class="fa fa-times" title="remove user"></i></a></td>
                        </tr>
                        <?php } ?>
                   </tbody>
                </table>
                </form>
                <?php 
                    }
                    else{
                        echo "<h2>No Posts Available...</h2>";
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