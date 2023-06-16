<?php
include("action.php");
//$obj->getvalfield("","","eno=$loginid");

if(isset($_POST['login']))
{
  //login check
  $memcode = $_POST['memcode'];
  $Password = $_POST['Password'];
  $is_exist = $obj->login_method("ecounter",$memcode,$Password);
  if($is_exist > 0)
  {
    //redirect ot home page
    //header("Location: dashboard.php");
    echo "<script>location='dashboard.php'</script>";
  }
  else
  {
    //redirect to login
    echo "<script>location='index.php?msg=invalid login'</script>";
  }
}
?>
<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="inc/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="inc/css?family=Montserrat" rel="stylesheet">
<script src="inc/jquery.min.js"></script>
<script src="inc/bootstrap.min.js"></script>
<script src="commonfun.js"></script>

<style>
body,h1 {font-family: "Raleway", sans-serif}
body, html {height: 100%}
.bgimg {
  background-image: url('w3images/background2.png');
  min-height: 100%;
  background-position: center;
  background-size: cover;
}
</style>
<style type="text/css">
  .login-form {
    margin: 10px auto;
  }
    .login-form form {        
      margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 5px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .login-btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .input-group-addon .fa {
        font-size: 18px;
    }
    .login-btn {
        font-size: 15px;
        font-weight: bold;
    }
  .social-btn .btn {
    border: none;
        margin: 10px 3px 0;
        opacity: 1;
  }
    .social-btn .btn:hover {
        opacity: 0.9;
    }
  .social-btn .btn-primary {
        background: #507cc0;
    }
  .social-btn .btn-info {
    background: #64ccf1;
  }
  .social-btn .btn-danger {
    background: #df4930;
  }
    .or-seperator {
        margin-top: 5px;
        text-align: center;
        border-top: 1px solid #ccc;
    }
    .or-seperator i {
        padding: 0 10px;
        background: #f7f7f7;
        position: relative;
        top: -11px;
        z-index: 1;
    }   
</style>
<body>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
  <div class="w3-display-topleft w3-padding-large w3-xlarge">
  <br>
    <img src="w3images/logo-footer.png">
  </div>
  <div class="w3-display-middle">
    <!--<h1 class="w3-jumbo w3-animate-top">COMING SOON</h1>
    <hr class="w3-border-grey" style="margin:auto;width:40%">
    <p class="w3-large w3-center">35 days left</p>-->
  </div>
 

  <div class="w3-display-bottomleft w3-padding-large" style="width:100%">
  <div class="w3-container" style="margin-bottom:30px;">
        <button type="button" class="w3-btn w3-black" style="width:100%" data-toggle="modal" data-target="#myModal">Member Login</button>
    <?php //include 'footer.php'; ?>
</div>


<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:#333;">Member Login</h4>
        </div>
        <div class="modal-body">
        <div class="login-form">

       <form action="" method="post"> 
        <h2 class="text-center">Sign in</h2> 
        <div class="form-group">
          <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="memcode" id="memcode" placeholder="Enter Member Code or Email ID" required="required">        
            </div>
        </div>
    <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="Password" class="form-control" name="Password" id="Password" placeholder="Password" required="required">       
            </div>
        </div>        
        <div class="form-group">
            <button name="login" type="submit" class="btn btn-primary login-btn btn-block" onClick="return checkinputmaster('memcode,Password');" >Sign in</button>
        </div>
      </form>
      <p class="text-center text-muted small"><a href="#">Forgot Password?</a></p>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>