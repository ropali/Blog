                    <div class="widgets">
                        <form action="index.php" method="post">
                         <div class="input-group">
                          <input type="text" name="search-title" class="form-control" placeholder="Search for...">
                          <span class="input-group-btn">
                           <input type="submit" class="btn btn-default" value="GO" name="search">
                          </span>
                          </div><!-- /input-group -->
                        </form>
                     </div><!--widgets close-->
                     
                     <div class="widgets">
                         <div class="popular">
                             <h4>popular posts</h4>
                             <hr>
                             <?php
                                $p_query = "SELECT * FROM posts WHERE status = 'publish' ORDER BY views DESC LIMIT 5";
                                $p_run = mysql_query($p_query);
                                if(mysql_num_rows($p_run) > 0){
                                    while($p_row = mysql_fetch_array($p_run)){
                                        $p_id = $p_row['id'];
                                        $p_title = $p_row['title'];
                                        $p_image = $p_row['image'];
                                        $p_date = getdate($p_row['date']);
                                        $p_day = $p_date['mday'];
                                        $p_month = $p_date['month'];
                                        $p_year = $p_date['year'];
                             ?>
                             
                             <div class="row">
                                 <div class="col-xs-4">
                                     <a href="post.php?post_id=<?php echo $p_id;?>"><img src="img/<?php echo $p_image;?>" alt=""></a>
                                 </div>
                                 <div class="col-xs-8 details">
                                     <a href="post.php?post_id=<?php echo $p_id;?>"><h4><?php echo $p_title;?></h4></a>
                                     <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $p_day." ".$p_month.",".$p_year ?></p>
                                 </div>
                             </div>
                             <?php 
                                    }
                                }
                                else{
                                    echo "<h3>No Post Avaialable</h3>";
                                }
                             
                             ?>
                             
                         </div>
                     </div><!--widgets close-->
                     
                     <div class="widgets">
                         <div class="popular">
                             <h4>recent posts</h4>
                             <hr>
                             <?php
                                $p_query = "SELECT * FROM posts WHERE status = 'publish' ORDER BY id DESC LIMIT 5";
                                $p_run = mysql_query($p_query);
                                if(mysql_num_rows($p_run) > 0){
                                    while($p_row = mysql_fetch_array($p_run)){
                                        $p_id = $p_row['id'];
                                        $p_title = $p_row['title'];
                                        $p_image = $p_row['image'];
                                        $p_date = getdate($p_row['date']);
                                        $p_day = $p_date['mday'];
                                        $p_month = $p_date['month'];
                                        $p_year = $p_date['year'];
                             ?>
                             
                             <div class="row">
                                 <div class="col-xs-4">
                                     <a href="post.php?post_id=<?php echo $p_id;?>"><img src="img/<?php echo $p_image;?>" alt=""></a>
                                 </div>
                                 <div class="col-xs-8 details">
                                     <a href="post.php?post_id=<?php echo $p_id;?>"><h4><?php echo $p_title;?></h4></a>
                                     <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $p_day." ".$p_month.",".$p_year ?></p>
                                 </div>
                             </div>
                             <?php 
                                    }
                                }
                                else{
                                    echo "<h3>No Post Avaialable</h3>";
                                }
                             
                             ?>
                             
                         </div>
                     </div><!--widgets close-->
                     
                     <div class="widgets">
                        <div class="popular">
                            <h4>Categories</h4>
                            <hr>
                            <div class="row">
                            <div class="col-xs-6">
                                <ul>
                                    <?php 
                                        $c_query = "SELECT * FROM categories";
                                        $c_run = mysql_query($c_query);
                                        if(mysql_num_rows($c_run) > 0){
                                            $count = 2;
                                            while($c_row = mysql_fetch_array($c_run)){
                                                
                                                $c_id = $c_row['id'];
                                                $c_cat = $c_row['category'];
                                                $count+=1;
                                                
                                                if($count % 2 == 1){
                                                    echo "<li><a href='index.php?cat_id=".$c_id."'>$c_cat</a></li>";
                                                }
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <ul>
                                    <?php 
                                        $c_query = "SELECT * FROM categories";
                                        $c_run = mysql_query($c_query);
                                        if(mysql_num_rows($c_run) > 0){
                                            $count = 2;
                                            while($c_row = mysql_fetch_array($c_run)){
                                                
                                                $c_id = $c_row['id'];
                                                $c_cat = $c_row['category'];
                                                $count+=1;
                                                
                                                if($count % 2 == 0){
                                                    echo "<li><a href='index.php?cat_id=".$c_id."'>$c_cat</a></li>";
                                                }
                                            }
                                        }
                                    ?>                                </ul>
                            </div>
                        </div>
                        </div>
                     </div><!--widgets close-->
                     
                     <div class="widgets">
                        <div class="category">
                            <h4>Social Media</h4>
                            <hr>
                            <div class="row">
                               <div class="col-xs-4">
                                   <a href="#"><img src="img/Facebook.png" alt="Facebook">Facebook</a>
                               </div>
                               <div class="col-xs-4">
                                   <a href="#"><img src="img/Twitter.png" alt="Twitter">Twitter</a>
                               </div>
                               <div class="col-xs-4">
                                   <a href="#"><img src="img/google-plus.png" alt="g+">Google+</a>
                               </div>                                
                            </div>
                            
                            <div class="row">
                               <div class="col-xs-4">
                                   <a href="#"><img src="img/1492284796_linkedin.png" alt="Facebook">LinkedIn</a>
                               </div>
                               <div class="col-xs-4">
                                   <a href="#"><img src="img/1492284814_Skype.png" alt="Skype">Skype</a>
                               </div>
                               <div class="col-xs-4">
                                   <a href="#"><img src="img/1492284831_Youtube.png" alt="youtube">Youtube</a>
                               </div>
                                
                            </div>

                        </div>
                     </div><!--widgets close-->
