<?php
include("adminsession.php");

// $tot_inentry = $obj->getvalfield("vehicle_outentry","count(*)","1=1 and status=1"); 
// $tot_vehicle = $obj->getvalfield("vehicle_master","count(*)","1=1"); 
// $tot_outentry = $obj->getvalfield("vehicle_outentry","count(*)","1=1 and status=0"); 

?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="inc/style.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="https://fonts.googleapis.com/css?family=Play&display=swap" rel="stylesheet">

  <style type="text/css">
    body{
      background-image: url("img/bg3.jpg");
    }
  </style>
</head>
<?php  include 'headerfiles.php'; ?>
<body>
  <style>

.block {
  display: block;
  width: 100%;
  border: none;
  background-color: #4CAF50;
  color: white;
  padding: 10px 100px;
  font-size: 16px;
  cursor: pointer;
  text-align: center;
}
</style>
<!-- Top container -->
<?php include 'top_menu.php'; ?>

<!-- Sidebar/menu -->
<?php include 'side_menu.php'; ?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id=" "></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5 style="color: white"><b><i class="fa fa-dashboard w3-xlarge "></i> Hello</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">

   <a href="student_attendence_sub.php"> <div class="w3-half w3-animate-left" style="padding-right: 8px;">
      <div class="w3-container w3-sand w3-padding-16 w3-round" style="box-shadow: 0px 0px 10px grey !important;margin-bottom: 15px;">
        <div class="w3-left"><i class="fa fa-user w3-xxxlarge"></i></div>
        <div class="w3-right">
           <!-- <h3><?php echo $tot_outentry; ?></h3>  -->
        </div>
        <div class="w3-clear"></div>
        <h4>Add Student Attendence</h4>
      </div>
    </div></a>

    <!-- <a href="vehicle_inentry1.php"><div class="w3-half w3-animate-right" style="padding-right: 8px;">
      <div class="w3-container w3-sand w3-padding-16 w3-round" style="box-shadow: 0px 0px 10px grey !important">
        <div class="w3-left"><i class="fa fa-car w3-xxxlarge"></i></div>
        <div class="w3-right">
            <h3><?php echo $tot_inentry; ?></h3>  
        </div>
        <div class="w3-clear"></div>
        <h4>Manage In Vehicle</h4>
      </div>
    </div>
  </a> -->
  </div>
  <!-- Footer -->
  <br><br>
 <!--  <?php include 'footer.php'; ?> -->


  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
