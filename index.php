<?php require_once('include/top.php'); ?>

    
  </head>
  <body>
    <?php require_once('include/header.php');
        $number_of_post = 3;
      
        if(isset($_GET['page'])){
            $page_id = $_GET['page'];
        }
        else{
          $page_id = 1;
        }
      
        //get the categories selected from navbar
        if(isset($_GET['cat_id'])){
            $cat_id = $_GET['cat_id'];
            $cat_query = "SELECT * FROM categories WHERE id = '$cat_id'";
            $cat_run = mysql_query($cat_query);
            $cat_row = mysql_fetch_array($cat_run);
            $cat_name = $cat_row['category'];
        }
        
        if(isset($_POST['search-title'])){
            $search = $_POST['search-title'];
            
            $all_post_query = "SELECT * FROM posts WHERE status = 'publish' AND  tags LIKE '%$search%'";
        
            $all_post_run = mysql_query($all_post_query);
            $all_post = mysql_num_rows($all_post_run);
            $total_pages = ceil($all_post / $number_of_post);
            $post_start_from = ($page_id - 1) * $number_of_post;

            
        }
        else{
            $all_post_query = "SELECT * FROM posts WHERE status = 'publish'";
            if(isset($cat_name)){
                $all_post_query .= " and categories = '$cat_name'";
            }
            
            $all_post_run = mysql_query($all_post_query);
            $all_post = mysql_num_rows($all_post_run);
            $total_pages = ceil($all_post / $number_of_post);
            $post_start_from = ($page_id - 1) * $number_of_post;

        }
        
              
    ?>


     <div class="jumbotron">
         <div class="container">
             <div id="details" class="animated fadeInLeft">
                 <h1>Rop<span>Ali</span></h1>
                 <p>A Tech Blog For The Daily Dose For Your Technology Love..</p>
             </div>
         </div>
         <img src="img/bg2.jpeg" alt="Top Image" height="200">
     </div>
     <section>
         <div class="container">
             <div class="row">
                 <div class="col-md-8">
                    
                     <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                          <!-- Indicators -->
                          <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
                          </ol>

                          <!-- Wrapper for slides -->
                          <div class="carousel-inner" role="listbox">
                            <div class="item active">
                              <img src="img/slider.png" alt="...">
                              <div class="carousel-caption">
                                <h3>Talk is cheap. Show me the code.” - Linus Torvalds </h3>
                              </div>
                            </div>
                            <div class="item">
                              <img src="img/slider3.jpeg" alt="...">
                              <div class="carousel-caption">
                                <h3>“I'm not a great programmer; I'm just a good programmer with great habits.”
                                                        ― Kent Beck</h3>
                              </div>
                            </div>
                            
                            <div class="item">
                              <img src="img/slider2.jpeg" alt="...">
                              <div class="carousel-caption">
                                <h3>“Give a man a program, frustrate him for a day.
                                    Teach a man to program, frustrate him for a lifetime.”
                                    ― Waseem Latif</h3>
                              </div>
                            </div>

                          </div>

                          <!-- Controls -->
                          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>                    
                    <?php
                        //}//
                     
                        if(isset($_POST['search-title'])){
                            $search = $_POST['search-title'];
                            $query = "SELECT * FROM posts WHERE status = 'publish'";
                            $query .= " and tags LIKE '%$search%'";
                            $query .= "ORDER BY id DESC LIMIT $post_start_from, $number_of_post";


                        }
                        else{
                            $query = "SELECT * FROM posts WHERE status = 'publish'";
                            //if category is selected then show posts of that category
                            if(isset($cat_name)){
                                $query .= " and categories = '$cat_name'";
                            }
                            //if category is not selected the show default posts
                            $query .= "ORDER BY id DESC LIMIT $post_start_from, $number_of_post";

                        }
                     
                        $run = mysql_query($query);
                        if(mysql_num_rows($run) > 0){
                            while($row = mysql_fetch_array($run)){
                                $id = $row['id'];
                                $date = getdate($row['date']);
                                $day = $date['mday'];
                                $month = $date['month'];
                                $year = $date['year'];
                                $title = $row['title'];
                                $author = $row['author'];
                                $author_image = $row['author_image'];
                                $image = $row['image'];
                                $categories = $row['categories'];
                                $tags = $row['tags'];
                                $post_data = $row['post_data'];
                                $views = $row['views'];
                                $status = $row['status'];
                                
                                //fetch the author information
                                 if(isset($author)){
                                    $get_author_query = "SELECT first_name, last_name FROM users WHERE username = '$author'";
                                    $get_author_run = mysql_query($get_author_query);
                                    $author_row = mysql_fetch_array($get_author_run);
                                    
                                    $author_fname = $author_row['first_name'];
                                    $author_lname = $author_row['last_name'];
                                    $author_fullname = "$author_fname $author_lname";
                                }
                        
                        
                        ?>            
                        
                 <div class="post">
                     <div class="row">
                         <div class="col-md-2 post-date">
                             <div class="day"><?php echo $day; ?></div>
                             <div class="month"><?php echo $month; ?></div>
                             <div class="year"><?php echo $year; ?></div>
                         </div>
                         <div class="col-md-8 post-title">
                             <a href="post.php?post_id=<?php echo $id; ?>">
                                 <h2><?php echo ucwords($title); ?></h2>
                             </a>
                             <p>Written by : <span><?php echo ucwords($author_fullname); ?></span></p>
                         </div>
                         <div class="col-md-2 profile-picture">
                             <img src="img/<?php echo $author_image ?>" alt="" class="img-circle">
                         </div>
                     </div> 
                     <a href="post.php?post_id=<?php echo $id; ?>"><img src="img/<?php echo $image; ?>" alt=""></a>
                     <div class="desc">
                         <?php echo substr($post_data,0,300) . "...."; ?>
                     
                     </div>
                     <a href="post.php?post_id=<?php echo $id; ?>" class="btn btn-primary">Read more..</a>
                     <div class="bottom">
                         <span class="first"><i class="fa fa-folder" aria-hidden="true"></i><a href="#">
                             <?php echo ucwords($categories); ?>
                         </a></span> <span class="second"><i class="fa fa-comment" aria-hidden="true"></i><a href="#">Comments</a></span>
                     </div>   
                 </div>
                <?php
                        } 
                        }
                        else{
                            echo "<center><h2>No Posts Available</h2></center>";
                        }
     
                ?>
                 <nav aria-label="Page navigation" id="pagination">
                      <ul class="pagination">
                        <?php
                            for($i = 1;$i <= $total_pages;$i++){
                                echo "<li class='".($page_id == $i ? 'active': '')."'><a href='index.php?page=".$i."&".(isset($cat_name)?"cat_id=$cat_id":"")."'>$i</a></li>";
                            }  
                        ?>
                      </ul>
                </nav>                
                 </div>
                 <div class="col-md-4 sidebar">
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