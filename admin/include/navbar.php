

<?php $session_role2 = $_SESSION['role']; ?>

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">TechBlog</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          
            <ul class="nav navbar-nav navbar-right">
            <li><a href="profile.php">Hi, <i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?></a></li>
            
            <li><a href="add-post.php"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Post</a></li>
            <?php 
                if($session_role2 == 'admin'){
                    //if admin is logged in then only show add-user button
            ?>
            <li><a href="add-user.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Add User</a></li>
            <?php } ?>
            <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
            <li><a href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>