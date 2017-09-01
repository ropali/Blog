<?php require_once('include/top.php'); ?>

    
  </head>
  <body>
    <?php require_once('include/header.php'); ?>

     <div class="jumbotron">
         <div class="container">
             <div id="details" class="animated fadeInLeft">
                 <h1>Contact<span>Us</span></h1>
                 <p>We are available 24x7 here..</p>
             </div>
         </div>
         <img src="img/bg2.jpeg" alt="Top Image" height="200">
     </div>
     <section>
         <div class="container">
             <div class="row">
                 <div class="col-md-8">
                     <div class="row">
                         <div class="col-md-12">
                             <script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key= AIzaSyDkQO-Gfsb6aIopLU34kQWaNQfg7cXZGpg '></script><div style='overflow:hidden;height:400px;width:100%;'><div id='gmap_canvas' style='height:400px;width:100%;'></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div> <a href='https://indiatvnow.com/' style="color:#EEEDED">TV Soap from India</a> <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=54788819c6a3019dc6082ce565619f73c43deb04'></script><script type='text/javascript'>function init_map(){var myOptions = {zoom:13,center:new google.maps.LatLng(19.2167,73.14999999999998),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(19.2167,73.14999999999998)});infowindow = new google.maps.InfoWindow({content:'<strong>TechBlog Office</strong><br>ramchand bhatija nagar.<br>421003 Ulhasnagar<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
                         </div>
                         <?php 
                            if(isset($_POST['submit'])){
                                $name = mysql_real_escape_string($_POST['full-name']);
                                $email = mysql_real_escape_string($_POST['email']);
                                $contactno = mysql_real_escape_string($_POST['contactno']);
                                $msg = mysql_real_escape_string($_POST['msg']);
                                
                                $to = "ropali68@gmail.com";
                                $header = "From : $name <$email>";
                                $subject = "Message From $name";
                                $message = "Name: $name \n\nEmail: $email \n\nContact No:$contactno \n\n Message:$msg";
                                
                                if(empty($name) or empty($email) or empty($msg)){
                                    $error = "All (*) Fields Are Required";
                                }
                                else{
                                    if(mail($to, $subject, $message, $header)){
                                        $mail_msg = "Message Has Been Sent...";
                                    }
                                    else{
                                        $error = "Unable To Send The Message";
                                    }
                                }
                            }
                         ?>
                         <div class="col-md-12 contact-form">
                            <h2>Contact Form</h2>
                            <hr>
                             <form action="" method="post">
                                 <div class="form-group">
                                     <label for="full-name">Full Name*</label>
                                     <?php 
                                        if(isset($error)){
                                            echo "<span class='pull-right' style='color:red'>$error</span>";
                                        }
                                        else if(isset($mail_msg)){
                                            echo "<span class='pull-right' style='color:green'>$mail_msg</span>";   
                                        }
                                     ?>
                                     <input type="text" id="full-name" name="full-name" class="form-control" placeholder="Full Name">
                                 </div>
                                 <div class="form-group">
                                     <label for="email">Email*</label>
                                     <input type="email" id="email" name="email" class="form-control" placeholder="Email Address">
                                 </div>
                                 <div class="form-group">
                                     <label for="contactno">Contact no:</label>
                                     <input type="text" id="contactno" name="contactno" class="form-control" placeholder="Contact no." maxlength="12">
                                 </div>
                                 <div class="form-group">
                                     <label for="msg">Message*</label>
                                     <textarea name="msg" id="message" cols="30" rows="10" class="form-control" placeholder="Write your message here..."></textarea>
                                 </div>
                                 <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                             </form>
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