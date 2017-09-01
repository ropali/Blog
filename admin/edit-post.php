<?php 
    require_once('include/top.php'); 
    
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }

    $session_username = $_SESSION['username'];
    $session_role = $_SESSION['role'];
    $session_author_image = $_SESSION['author_image'];


    //catch the id of the post to be edited
    if(isset($_GET['edit'])){
        $edit_id = $_GET['edit'];
        
        if($session_role == 'admin'){
            //fetch the post data of the give id
            $edit_query = "SELECT * FROM posts WHERE id = '$edit_id'";
            

        }
        else if($session_role == 'author'){
            //fetch the post data of the give id
            $edit_query = "SELECT * FROM posts WHERE id = '$edit_id' and author = '$session_username'";
        }
        
        $edit_run = mysql_query($edit_query);
        
        if(mysql_num_rows($edit_run) > 0){
            $get_row = mysql_fetch_array($edit_run);
            
            $title = $get_row['title'];
            $post_data = $get_row['post_data'];
            $tags = $get_row['tags'];
            $image = $get_row['image'];
            $status = $get_row['status'];
            $category = $get_row['categories'];
            
        }
        else{
            header('Location: allposts.php');
        }
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
                <h1><i class="fa fa-pencil" aria-hidden="true"></i>
                    Edit Post <small>Edit Post Details</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Post</li>                  
                </ol>
                <?php
                    if(isset($_POST['update'])){
                        $update_title = mysql_real_escape_string($_POST['title']);
                        $update_post_data = mysql_real_escape_string($_POST['post-data']);
                        $update_category = $_POST['categories'];
                        $update_tags = mysql_real_escape_string($_POST['tags']);
                        $update_status = $_POST['status'];
                        $update_image = $_FILES['image']['name'];
                        $update_tmp_image = $_FILES['image']['tmp_name'];
                        
                        //setting the $update_image to defualt image of the post
                        if(empty($update_image)){
                            $update_image = $image;
                        }
                        
                        if(empty($update_title) or empty($update_post_data) or empty($update_tags) or empty($update_image)){
                            $error = "All (*) Fields Are Mendatory";
                        }
                        else{
                            $update_query = "UPDATE posts SET title = '$update_title', image = '$update_image', categories = '$update_category', tags = '$update_tags', post_data = '$update_post_data', status = '$update_status' WHERE id = '$edit_id'";
                            
                            if(mysql_query($update_query)){
                                $msg = "Post Has Been Updated";
                                
                                //setting varibale values to none if post is submitted
                                $title = "";
                                $post_data = "";
                                $tags = "";
                                $path = "media/$update_image";
                                
                                if(!empty($update_image)){
                                    if(move_uploaded_file($update_tmp_image, $path)){
                                        copy($path, "../img/$update_image");
                                    }
                                }
                            }
                            else{
                                $error = "Unable To Update The Post";
                            }
                        }
                    }
                
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Title:*</label>
                                <?php 
                                    if(isset($error)){
                                        echo "<span class='pull-right' style='color:red;'>$error</span>";
                                    }
                                    else if(isset($msg)){
                                        echo "<span class='pull-right' style='color:green;'>$msg</span>";
                                    }
                                ?>
                                <input type="text" name="title" class="form-control" value="<?php if(isset($title)){ echo $title; } ?>" placeholder="Type Post Titlte Here...">
                            </div>
                            <div>
                                 <a href="media.php" class="btn btn-primary">Add Media</a>
                            </div>
                            <br>
                            <div>
                                 <textarea name="post-data" id="textarea"  rows="10" class="form-control"><?php if(isset($post_data)){ echo $post_data; } ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="file">Post Images:*</label>
                                        <input type="file" name="image">
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Categories:*</label>
                                        <select class="form-control" name="categories" id="categories">
                                           
                                           <?php
                                                $cat_query = "SELECT * FROM categories ORDER BY id DESC";
                                                $cat_run = mysql_query($cat_query);
                                                
                                                if(mysql_num_rows($cat_run) > 0){
                                                    while($cat_row = mysql_fetch_array($cat_run)){
                                                        $cat_name = $cat_row['category'];
                                                        
                                                        echo "<option value='".$cat_name."' ".((isset($category) and $category == $cat_name?"selected":"")).">".ucfirst($cat_name)."</option>";
                                                    }
                                                }
                                                else{
                                                    echo "<center><h6>No Categories Available</h6></center>";
                                                }
                                            ?>
                                            
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tags">Tags:*</label>
                                        <input type="text" name="tags" class="form-control" value="<?php if(isset($tags)){ echo $tags; } ?>" placeholder="Add tags for the post">
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Status:*</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="publish" <?php if(isset($status) and $status == 'publish'){ echo "selected"; } ?>>Publish</option>
                                            <option value="draft" <?php if(isset($status) and $status == 'draft'){ echo "selected"; } ?>>Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Update Post" name="update">
                        </form>
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
    <!--tinymce Text Editor-->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
          selector: "textarea#textarea",
          height: 500,
          plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
          ],

          toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
          toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
          toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",

          menubar: false,
          toolbar_items_size: 'small',

          style_formats: [{
            title: 'Bold text',
            inline: 'b'
          }, {
            title: 'Red text',
            inline: 'span',
            styles: {
              color: '#ff0000'
            }
          }, {
            title: 'Red header',
            block: 'h1',
            styles: {
              color: '#ff0000'
            }
          }, {
            title: 'Example 1',
            inline: 'span',
            classes: 'example1'
          }, {
            title: 'Example 2',
            inline: 'span',
            classes: 'example2'
          }, {
            title: 'Table styles'
          }, {
            title: 'Table row 1',
            selector: 'tr',
            classes: 'tablerow1'
          }],

          templates: [{
            title: 'Test template 1',
            content: 'Test 1'
          }, {
            title: 'Test template 2',
            content: 'Test 2'
          }],
          content_css: [
            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            '//www.tinymce.com/css/codepen.min.css'
          ],
            
          image_list: [
              <?php 
                $media_query = "SELECT * FROM media ORDER BY id DESC";
                $media_run = mysql_query($media_query);
                if(mysql_num_rows($media_run) > 0){
                    while($media_row = mysql_fetch_array($media_run)){
                        $media_name = $media_row['images']
                    
            ?>
            {title: '<?php echo $media_name; ?>', value: 'media/<?php echo $media_name; ?>'},
            <?php   } ?>
          ]
            <?php } ?>
        });   
    </script>
  </body>
</html>