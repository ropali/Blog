<?php 
    require_once('include/top.php'); 
    
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }

    $session_username = $_SESSION['username'];
    
    $query = "SELECT * FROM users WHERE username = '$session_username'";
    $run = mysql_query($query);
    $row = mysql_fetch_array($run);

    $image = $row['image'];
    $id = $row['id'];
    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $username = $row['username'];
    $email = $row['email'];
    $role = $row['role'];
    $details = $row['details'];
    $date = getdate($row['date']);
    $day = $date['mday'];
    $month = substr($date['month'] ,0 ,3);
    $year = $date['year'];



?>

 
 
  </head>
  <body id="profile">
   <div id="wrapper">
    <?php require_once('include/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php require_once('include/sidebar.php'); ?>
            </div>
            <div class="col-md-9">
                <h1><i class="fa fa-tachometer" aria-hidden="true"></i>
                    Profile <small>personal details</small>
                </h1>
                <hr>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-user" aria-hidden="true"></i> profile</li>
                  
                </ol>
                <div class="row">
                    <div class="col-xs-12">
                        <center><img src="img/<?php echo $image; ?>" class="img-circle img-thumbnail" width="200px" id="profile-image"></center><br>
                        <a href="edit-profile.php?edit=<?php echo $id; ?>" class="btn btn-primary pull-right">Edit profile</a><br><br>
                        <hr>
                        <center>
                            <h3>Profile details</h3>
                        </center>
                        <br>
                        <table class="table table-bordered">
                            <tr>
                                <td width="20%"><b>User Id</b></td>
                                <td width="30%"><?php echo $id; ?></td>
                                <td width="20%"><b>Signup date</b></td>
                                <td width="30%"><?php echo "$day $month $year"; ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><b>First Name :</b></td>
                                <td width="30%"><?php echo ucfirst($fname); ?></td>
                                <td width="20%"><b>Last Name : </b></td>
                                <td width="30%"><?php echo ucfirst($lname); ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><b>Username : </b></td>
                                <td width="30%"><?php echo $username; ?></td>
                                <td width="20%"><b>Email : </b></td>
                                <td width="30%"><?php echo $email; ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><b>Role : </b></td>
                                <td width="30%"><?php echo ucfirst($role); ?></td>
                                
                            </tr>
                        </table>
                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                                <b>Details : </b>
                                <div>
                                    <?php echo $details; ?>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
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
  </body>
</html>