<?php 
$session_role1 = $_SESSION['role']; 

$get_comment = "SELECT status FROM comments WHERE status = 'pending'";
$get_comment_run = mysql_query($get_comment);
$num_of_pending_comments = mysql_num_rows($get_comment_run);

?>
               
                <div class="list-group">
                  <a href="index.php" class="list-group-item active">
                    <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
                  </a>
                  <a href="allposts.php" class="list-group-item">
                      
                      <i class="fa fa-file-text" aria-hidden="true"></i> All Posts
                  </a>
                  <a href="media.php" class="list-group-item">
                      
                      <i class="fa fa-database" aria-hidden="true"></i> Media
                  </a>
                  
                  <a href="comment.php" class="list-group-item">
                      <?php if($num_of_pending_comments > 0){
                            echo "<span class='badge'>$num_of_pending_comments</span>";  
                        } 
                      ?>
                      <i class="fa fa-comment" aria-hidden="true"></i> Comments
                  </a>
                  <?php
                        if($session_role1 == 'admin'){
                            
                    ?>
                  <a href="category.php" class="list-group-item">
                      
                      <i class="fa fa-folder-open" aria-hidden="true"></i> Categories
                  </a>
                  <a href="users.php" class="list-group-item">
                      
                      <i class="fa fa-users" aria-hidden="true"></i> Users
                  </a>
                  <?php } ?>
                </div>