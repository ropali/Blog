<?php 
    require_once('include/top.php'); 
    
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }
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
                <h1><i class="fa fa-database" aria-hidden="true"></i>
                    Media <small>view or add media</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-database" aria-hidden="true"></i> Media</li>
                  
                </ol>
                <?php
                    if(isset($_POST['submit'])){
                        if(count($_FILES['media']['name']) > 0){
                            for($i = 0;$i < count($_FILES['media']['name']);$i++){
                                $image = $_FILES['media']['name'][$i];
                                $tmp_name = $_FILES['media']['tmp_name'][$i];
                                
                                $query = "INSERT INTO media(images) VALUES('$image')";
                                if(mysql_query($query)){
                                    $path = "media/$image";
                                    if(move_uploaded_file($tmp_name,$path)){
                                        copy($path, "../$path");
                                    }
                                }
                            }
                        }
                    }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-4 col-xs-8">
                            <input type="file" name="media[]" required multiple>
                        </div>
                        <div class="col-sm-4 col-xs-4">
                            <input type="submit" name="submit" class="btn btn-primary" value="Add Media">
                        </div>
                        <br><br>
                        <hr>
                    </div>
                </form>
                <?php
                    $get_query = "SELECT * FROM media ORDER BY id DESC";
                    $get_run = mysql_query($get_query);
                
                    if(mysql_num_rows($get_run) > 0){
                        while($row = mysql_fetch_array($get_run)){
                            $image = $row['images'];   
                           
                    
                ?>
                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 thumb">
                    <a href="media/<?php echo $image; ?>" class="thumbnail">
                        <img src="media/<?php echo $image; ?>" width="100%" alt="">
                    </a>
                </div>
                <?php 
                        }
                    }
                    else{
                        echo "<center><h2>No Media Available</h2></center>";
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