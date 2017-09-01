<?php 
    session_start();
    require_once('../include/db.php');

    if(isset($_POST['login'])){
        $username = mysql_real_escape_string($_POST['username']);
        $password = mysql_real_escape_string($_POST['password']);
        
        $check_username_query = "SELECT * FROM users WHERE username = '$username'";
        
        $check_username_run = mysql_query($check_username_query);
        
        if(mysql_num_rows($check_username_run) > 0){
            $row = mysql_fetch_array($check_username_run);
            
            $db_username = $row['username'];
            $db_password = $row['password'];
            $db_role = $row['role'];
            $db_author_image = $row['image'];
            
            $password = crypt($password, $db_password);
            
            if($username == $db_username and $password == $db_password){
                $_SESSION['username'] = $db_username;
                $_SESSION['role'] = $db_role;
                $_SESSION['author_image'] = $db_author_image;
                header('Location: index.php');
            }
            else{
                $error = "Wrong Username or Password";    
            }
        }
        else{
            $error = "Wrong Username or Password";
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/r.jpeg">

    <title>Login | TechBlog Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <link rel="stylesheet" href="css/animated.css">

  </head>

  <body>

    <div class="container">

      <form class="form-signin animated swing" action="login.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="username" class="sr-only">Email address</label>
        <input type="text" name="username" class="form-control" placeholder="Username" >
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" >
        <div class="checkbox">
          <label>
            <?php 
              if(isset($error)){
                  echo $error; }
              ?>
          </label>
          
        </div>
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="login" value="Sign in">
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
