<?php
include 'action.php';
$ipaddress = $obj->get_client_ip();
$createdate = date('Y-m-d H:i:s');  
$pagename = "bank_details.php";

If(isset($_GET['action']))
{
  $action = $obj->test_input($_GET['action']);
}
else
{
  $action = "";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bank Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:title" content="Registration Form Session - 2020-21" />
  <meta property="og:description" content="For Registration click on below link" />
  <meta property="og:url" content="https://akshatinfotech.com/myprojects/cipssoft/online_student_reg.php" />
  <meta property="og:image" content="https://akshatinfotech.com/myprojects/cipssoft/images/cips_logo_08.jpg" />
  <link rel="stylesheet" href="library/css/bootstrap.min.css">
  <script src="library/js/jquery.min.js"></script>
  <script src="library/js/popper.min.js"></script>
  <script src="library/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="library/wizard.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style type="text/css">
    body{
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
  li a:hover {
  background-color:#178ea0f7;
  border-radius:5px;
  color:white !important;
  } 
    div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 180px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}

.sansserif {
  font-family: Arial, Helvetica, sans-serif;
}

  </style>
</head>
<body>
<!--   menu -->

<!--   menu -->
  <center>
    <div class="container">
      <img src="images/cips_logo_08.jpg" width="800" height="150" class="img-fluid p-2" alt="Responsive image">
      <h3>Bank details of Our Institution</h3>
      <!-- <h6><?php //echo $dup; ?></h6> -->
    </div>
  </center>
  <section class="signup-step-container">
        <!-- <div class="text-center">
              <img src="images/cips_logo_08.jpg" width="800" height="150" class="img-fluid" alt="Responsive image">
              <h2>Registration Form<h3>Session-2020-21</h3></h2>
              <span><?php //echo $dup; ?> </span>
        </div> -->
         <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                   <div class="row">
                    <br><br>
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                          <img class="img-responsive " style="width:200px; height:200px;" src="images/qrcode.jpg">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <p><b>BANK NAME</b>:&nbsp; Canara Bank (Branch Sunder Nagar)</p>
                      <p><b>NAME</b>:&nbsp; NARENDRA KUMAR PANDEY</p>
                      <p><b>AC</b>:&nbsp; 5647201000118</p>
                      <p><b>IFCI CODE</b>:&nbsp; CNRB0005647</p>
                      
                    </div>
                     
                   </div> 
                </div>
            </div>
        </div>
    </section>
<!-- <div class="jumbotron text-center text-white bg-dark" style="padding:1rem 1rem;border-radius:0px;margin-bottom:0;">
        <p>@2020 copyright. All Rights Reserved</p>
</div> -->
<script src="library/js/sweetalert.min.js"></script>
<!--  ------------step-wizard------------- -->
<?php if($action == 1)
{ ?>
<script type="text/javascript">
 swal({
  title: "Registered Successfully",
  text: "",
  icon: "success",
  button: "Ok",
});
</script>
<?php }?>

</body>
</html>
