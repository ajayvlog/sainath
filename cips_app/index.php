<?php
include("../action.php");
 
if(isset($_COOKIE['cipsusername']))
{
    //print_r($_COOKIE);
   // die;
    $username = $_COOKIE['cipsusername'];
    $password = $_COOKIE['cipspassword'];
}
else 
{    
    $username = "";
    $password = "";
}


if(isset($_POST['login']))
{
  //login check
  //print_r($_POST);die;
  $username = $_POST['username'];
  $password = $_POST['password'];
  if($username != "" && $password != "" )
  {
  $is_exist = $obj->login_method_app("m_employee",$username,$password);
  //echo $is_exist;
  //die;
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script src="commonfun.js"></script>
  <link rel="stylesheet" type="text/css" href="inc/style.css">
  <link href="https://fonts.googleapis.com/css?family=Play&display=swap" rel="stylesheet">

  <style type="text/css">
    body{
      background-image: url("img/bg3.jpg");
    }
  </style>
</head>
<body>

<div class="container" style="padding-top: 20px;">
  <center><img src="../img/cips_logo.png"></center>
	<!-- <center><img src="img/logo.png" class="w3-round w3-sand"></center> -->
	<br><br>
  <div class="card w3-sand w3-round">
  		
  	<div class="card-body">

  <form action="" method="post">
    <div class="form-group">
      <label for="username" class="text-info-clr" style="font:20px solid cursive;">Username:</label><br>
      <input type="text" name="username" id="username" class="form-control w3-brown w3-large"  required="required" value="<?php echo $username; ?>">
    </div>
    <div class="form-group">
      <label for="password" class="text-info-clr" style="font:20px solid cursive;">Password:</label><br>
      <input type="password" name="password" id="password" class="form-control w3-brown w3-large" required="required" value="<?php echo $password; ?>">
    </div>
    <div class="form-group form-check" style="text-align: right;">
      <label class="form-check-label w3-large">
        <input class="form-check-input" type="checkbox" name="remember"> Remember me
      </label>
    </div>
    <input type="submit" name="login" class="btn-sub w3-round btn btn-primary w3-black w3-xlarge" style="width: 100%;" value="submit" onClick="return checkinputmaster('usernames,password');">
  </form>

  </div>
</div>
</div>

</body>
</html>
