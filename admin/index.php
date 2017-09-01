<?php 
    require_once('include/top.php'); 
    
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }

    $comment_tag_query = "SELECT status FROM comments WHERE status = 'pending'";
    $category_tag_query = "SELECT category FROM categories";
    $users_tag_query = "SELECT id FROM users";
    $post_tag_query = "SELECT id FROM posts";

    $comm_tag_run = mysql_query($comment_tag_query);
    $cat_tag_run = mysql_query($category_tag_query);
    $user_tag_run = mysql_query($users_tag_query);
    $post_tag_run = mysql_query($post_tag_query);

    $comm_rows = mysql_num_rows($comm_tag_run);
    $cat_rows = mysql_num_rows($cat_tag_run);
    $user_rows = mysql_num_rows($user_tag_run);
    $post_rows = mysql_num_rows($post_tag_run);

?>
 
 
  </head>
  <body>
   <div id="wrapper">
    <?php require_once('include/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php require_once('include/sidebar.php'); ?>
            </div>
            <div class="col-md-9">
                <h1><i class="fa fa-tachometer" aria-hidden="true"></i>
                    Dashboard <small>statistical overview</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                  <li class="active"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</li>
                  
                </ol>
                <div class="row tag-boxes">
                  <div class="col-md-6 col-lg-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                         <i class="fa fa-comment fa-5x"></i>   
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="text-right huge"><?php echo $comm_rows; ?></div>
                                        <div class="text-right">New comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comment.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View all comments</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                                
                            </a>
                        </div>
                    </div>
                    
                  <div class="col-md-6 col-lg-3">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                         <i class="fa fa-file-text fa-5x"></i>   
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="text-right huge"><?php echo $post_rows; ?></div>
                                        <div class="text-right">All Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="allposts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View all posts</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                                
                            </a>
                        </div>
                    </div>
                    
                   <div class="col-md-6 col-lg-3">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                         <i class="fa fa-folder-open fa-5x"></i>   
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="text-right huge"><?php echo $cat_rows; ?></div>
                                        <div class="text-right">All categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="category.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View all categories</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                                
                            </a>
                        </div>
                    </div>
                    
                   <div class="col-md-6 col-lg-3">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                         <i class="fa fa-users fa-5x"></i>   
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="text-right huge"><?php echo $user_rows; ?></div>
                                        <div class="text-right">All users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View all comments</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                                
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <?php 
                    $get_users_query = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
                    $get_users_run = mysql_query($get_users_query);
                    if(mysql_num_rows($get_users_run) > 0){
                        
                    
                ?>
                <h3>New Users</h3>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                            while($get_users_row = mysql_fetch_array($get_users_run)){
                                $user_id = $get_users_row['id'];
                                $fname = $get_users_row['first_name'];
                                $lname = $get_users_row['last_name'];
                                $fullname = "$fname $lname";
                                $username = $get_users_row['username'];
                                $user_role = $get_users_row['role'];
                                $date = getdate($get_users_row['date']);
                                $day = $date['mday'];
                                $month = substr($date['month'], 0, 3);
                                $year = $date['year'];
                                
                            
                        ?>
                        <tr>
                            <td><?php echo $user_id; ?></td>
                            <td><?php echo "$day $month $year"; ?></td>
                            <td><?php echo ucwords($fullname); ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo ucfirst($user_role); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="users.php" class="btn btn-primary">View all users</a>
                <?php } ?>
                <hr>
                
                <?php 
                    $get_post_query = "SELECT * FROM posts ORDER BY id DESC LIMIT 5";
                    $get_post_run = mysql_query($get_post_query);
                    if(mysql_num_rows($get_post_run) > 0){
                        
                    
                ?>
                <h3>New Posts</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Date</th>
                            <th>Post title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                            while($get_post_row = mysql_fetch_array($get_post_run)){
                                $post_id = $get_post_row['id'];
                                $post_title = $get_post_row['title'];
                                $category = $get_post_row['categories'];
                                $author = $get_post_row['author'];
                                $views = $get_post_row['views'];
                                $post_date = getdate($get_post_row['date']);
                                $post_day = $post_date['mday'];
                                $post_month = substr($post_date['month'], 0, 3);
                                $post_year = $date['year'];
                                
                            
                        ?>

                        <tr>
                            <td><?php echo $post_id; ?></td>
                            <td><?php echo "$post_day $post_month $post_year"; ?></td>
                            <td><?php echo ucwords($post_title); ?></td>
                            <td><?php echo ucwords($category); ?></td>
                            <td><?php echo $author; ?></td>
                            <td><i class="fa fa-eye"></i> <?php echo $views; ?></td>
                        </tr>
                        
                       
                        <?php } ?>
                        
                    </tbody>
                </table>
                <a href="allposts.php" class="btn btn-primary">View all posts</a>
                <?php } ?>
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