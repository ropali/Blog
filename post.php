<?php require_once('include/top.php'); ?>
    
  </head>
  <body>
    <?php require_once('include/header.php'); ?>

    <?php
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
            
            
            $view_query = "UPDATE `posts` SET `views` = views + 1 WHERE `posts`.`id` = '$post_id'";
            mysql_query($view_query);
            
            $post_query = "SELECT * FROM posts WHERE status = 'publish' AND id = '$post_id'";
            $post_run = mysql_query($post_query);
            if(mysql_num_rows($post_run) > 0){
                $row = mysql_fetch_array($post_run);
                $id = $row['id'];
                $title = $row['title'];
                $author = $row['author'];
                $image = $row['image'];
                $author_image = $row['author_image'];
                $categories = $row['categories'];
                $post_data = $row['post_data'];
                $tags = $row['tags'];
                $date = getdate($row['date']);
                $day = $date['mday'];
                $month = $date['month'];
                $year = $date['year'];
            }
            else{
                header('Location:index.php');
            }
        }
      
      if(isset($author)){
          $get_author = "SELECT first_name, last_name,details FROM users WHERE username = '$author'";
          $get_author_run = mysql_query($get_author);
          $get_author_row = mysql_fetch_array($get_author_run);
          
          $author_fname = $get_author_row['first_name'];
          $author_lname = $get_author_row['last_name'];
          $author_details = $get_author_row['details'];
          $author_fullname = "$author_fname $author_lname";

      }
      
    ?>
    
    
     <div class="jumbotron">
         <div class="container">
             <div id="details" class="animated fadeInLeft">
                 <h1>Rop<span>Ali</span></h1>
                 <p>A Tech Blog For The Daily Dose For Your Technology Love</p>
             </div>
         </div>
         <img src="img/bg2.jpeg" alt="Top Image" height="200">
     </div>
     <section>
         <div class="container">
            
             <div class="row">
                 <div class="col-md-8">
                    <div class="post">
                     <div class="row">
                         <div class="col-md-2 post-date">
                             <div class="day"><?php echo $day; ?></div>
                             <div class="month"><?php echo $month; ?></div>
                             <div class="year"><?php echo $year; ?></div>
                         </div>
                         <div class="col-md-8 post-title">
                             <a href="#">
                                 <h2><?php echo $title; ?></h2>
                             </a>
                             <p>Written by : <span><?php echo ucwords($author_fullname); ?></span></p>
                         </div>
                         <div class="col-md-2 profile-picture">
                             <img src="img/<?php echo $author_image; ?>" alt="Author image" class="img-circle">
                         </div>
                     </div> 
                     <a href="#"><img src="img/<?php echo $image; ?>" alt="Image"></a>
                     <div class="desc">
                         <?php echo $post_data; ?>
                     </div>
                     
                     <div class="bottom">
                         <span class="first"><i class="fa fa-folder" aria-hidden="true"></i><a href="#"><?php echo ucfirst($categories); ?></a></span> <span class="second"><i class="fa fa-comment" aria-hidden="true"></i><a href="#">Comments</a></span>
                     </div>   
                 </div>
                   
                    <div class="related-post">
                       <h3>Related Post</h3>
                       <hr>
                        <div class="row">
                        <?php
                            $r_query = "SELECT * FROM posts WHERE status = 'publish' and tags LIKE '%$tags%' LIMIT 3";
                            $r_run = mysql_query($r_query);
                            while($r_row = mysql_fetch_array($r_run)){
                                $r_id = $r_row['id'];
                                $r_title = $r_row['title'];
                                $r_image = $r_row['image'];
                        ?>
                         <div class="col-sm-4">
                             <a href="post.php?post_id=<?php echo $r_id; ?>">
                                 <img src="img/<?php echo $r_image; ?>" alt="">
                                 <h4><?php echo $r_title; ?></h4>
                             </a>
                         </div>
                         <?php } ?>
                     </div>
                    </div>
                    
                    <div class="author">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="img/<?php echo $author_image; ?>" alt="" class="img-circle">
                            </div>
                            
                            <div class="col-sm-9">
                                <h4><?php echo ucwords($author_fullname); ?></h4>
                                <p>
                                    <?php echo $author_details; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                        $c_query = "SELECT * FROM comments WHERE status = 'approved' and post_id = '$post_id' ORDER BY id DESC LIMIT 10";
                        $c_run = mysql_query($c_query);
                        if(mysql_num_rows($c_run) > 0){
                            
    
                     ?>
                    
                    <div class="comment">
                       <h3>Comments</h3>
                       <hr>
                       <?php 
                            while($c_row = mysql_fetch_array($c_run)){
                                $c_id = $c_row['id'];
                                $c_name = $c_row['name'];
                                $c_username = $c_row['username'];
                                $c_image = $c_row['image'];
                                $c_comment = $c_row['comment'];
                            
                        ?>
                        <div class="row single-comment">
                            <div class="col-sm-2">
                                <img src="img/<?php echo $c_image; ?>" alt="">
                            </div>
                            <div class="col-sm-10">
                                <h4><?php echo ucfirst($c_name); ?></h4>
                                <p>
                                    <?php echo $c_comment; ?>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                        
                    </div>
                    <?php } ?>
                    
                    <?php
                        if(isset($_POST['comment-btn'])){
                            $cs_name = $_POST['name'];
                            $cs_email = $_POST['email'];
                            $cs_contactno = $_POST['contactno'];
                            $cs_comment = $_POST['comment'];
                            $cs_date = time();
                            
                            if(empty($cs_name) or empty($cs_email) or empty($cs_comment)){
                                $error_msg = "All (*) fields are mendatory";
                            }
                            else{
                                $cs_query = "INSERT INTO `comments` (`id`, `date`, `name`, `username`, `post_id`, `email`, `contactno`, `image`, `comment`, `status`) VALUES (NULL, '$cs_date', '$cs_name', 'user', '$post_id', '$cs_email', '$cs_contactno', 'Unknown_Person.png', '$cs_comment', 'pending')";
                                
                                if(mysql_query($cs_query)){
                                    $msg = "Comment Submitted And Waiting For Approval...";
                                    
                                    $cs_name = "";
                                    $cs_email = "";
                                    $cs_contactno = "";
                                    $cs_comment = "";

                                }
                                else{
                                    $error_msg = "Comment has not been submitted...";
                                }
                            }
                        }
                     ?>                
                    <div class="comment-box">
                        <div class="row">
                            <div class="col-xs-12">
                                <form action="" method="post">
                                 <div class="form-group">
                                     <label for="full-name">Full Name*</label>
                                     <input type="text" value="<?php if(isset($cs_name)){ echo $cs_name; } ?>" name="name" id="full-name" class="form-control" placeholder="Full Name">
                                 </div>
                                 <div class="form-group">
                                     <label for="email">Email*</label>
                                     <input type="text" value="<?php if(isset($cs_email)){ echo $cs_email;} ?>" name="email" id="email" class="form-control" placeholder="Email Address">
                                 </div>
                                 <div class="form-group">
                                     <label for="contactno">Contact No</label>
                                     <input type="text" value="<?php if(isset($cs_contactno)){ echo $cs_contactno;} ?>" name="contactno" id="contactno" class="form-control" placeholder="Contact No">
                                 </div>
                                 <div class="form-group">
                                     <label for="comment">Comments*</label>
                                     <textarea name="comment"  id="comment" cols="30" rows="10" class="form-control" placeholder="Write your comment here..."><?php if(isset($cs_comment)){ echo $cs_comment;} ?></textarea>
                                 </div>
                                 <input type="submit" value="Comment" name="comment-btn" class="btn btn-primary">
                                 <?php
                                    if(isset($error_msg)){
                                        echo "<span style='color:red;' class='pull-right'>$error_msg</span>";
                                    }
                                    else if(isset($msg)){
                                        echo "<span style='color:green;' class='pull-right'>$msg</span>";

                                    }
                                ?>
                             </form>
                            </div>
                        </div>
                    </div>                    

                 </div>
                 <div class="col-md-4">
                     <?php require_once('include/sidebar.php'); ?>
                 </div>
             </div>
         </div>
     </section>
     <?php require_once('include/footer.php'); ?>
      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>