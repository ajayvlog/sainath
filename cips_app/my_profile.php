<?php
include("adminsession.php");

//$first_name = $obj->getvalfield("ecounter","first_name","eno=$loginid");
$row = $obj->executequery("select * from ecounter where eno=$loginid");
$memcode = $row['memcode'];
$first_name = $row['first_name'];
$middle_name = $row['middle_name'];
$last_name = $row['last_name'];
$father_name = $row['father_name'];

$present_address = $row['present_address'];
$present_city = $row['present_city'];
$present_state = $row['present_state'];
$present_pin_code = $row['present_pin_code'];
$present_country = $row['present_country'];
$present_address = $row['present_address'];
$present_district = $row['present_district'];

$perm_address = $row['perm_address'];
$perm_city = $row['perm_city'];
$perm_district = $row['perm_district'];
$perm_state = $row['perm_state'];
$perm_pin_code = $row['perm_pin_code'];
$perm_country = $row['perm_country'];

$sex = $row['sex'];
$dob = $row['dob'];
$martial_status = $row['martial_status'];
$pan_number = $row['pan_number'];

$mobile_no = $row['mobile_no'];
$tel_phone_no = $row['tel_phone_no'];
$Email = $row['Email'];
$reg_date = $row['reg_date'];


?>
<!DOCTYPE html>
<html>
<?php  include 'headerfiles.php'; ?>
<body class="w3-light-grey">

<!-- Top container -->
<?php include 'top_menu.php'; ?>

<!-- Sidebar/menu -->

<?php include 'side_menu.php'; ?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <!-- <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-user"></i> My Profile</b></h5>
  </header> -->

  
  <hr>
 <div class="w3-container w3-animate-zoom">
    <div class="w3-card w3-round w3-white">
        <div class="w3-container">
         <h4 class="w3-center">My Profile</h4>
         <p class="w3-center"><img src="w3images/avatar3.png" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
         <hr>
         <!-- <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>
         <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> London, UK</p>
         <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> April 1, 1988</p> -->
         <table class="w3-table w3-striped w3-white" style="font-size: 12px;">
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
            <td>Member Code</td>
            <td><i><?php echo $memcode; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
            <td>First Name</td>
            <td><i><?php echo $first_name; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
            <td>Middle Name</td>
            <td><i><?php echo $middle_name; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
            <td>Last Name</td>
            <td><i><?php echo $last_name; ?></i></td>
          </tr>
           <tr>
            <td><i class="fa fa-calendar w3-text-yellow w3-large"></i></td>
            <td>Date of Birth</td>
            <td><i><?php echo $obj->dateformatindia($dob); ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-comment w3-text-red w3-large"></i></td>
            <td>Father's Name</td>
            <td><i><?php echo $father_name; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-mobile w3-text-blue w3-large"></i></td>
            <td>Mobile Number</td>
            <td><i><?php echo $mobile_no; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-envelope w3-text-blue w3-large"></i></td>
            <td>Email</td>
            <td><i><?php echo $Email; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-home w3-text-red w3-large"></i></td>
            <td>Present Address</td>
            <td><i><?php echo $present_address; ?></i></td>
          </tr>
           <tr>
            <td><i class="fa fa-home w3-text-red w3-large"></i></td>
            <td>Present City</td>
            <td><i><?php echo $present_city; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-map w3-text-green w3-large"></i></td>
            <td>Present District</td>
            <td><i><?php echo $present_district; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-train w3-text-green w3-large"></i></td>
            <td>Present State</td>
            <td><i><?php echo $present_state; ?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-barcode w3-text-green w3-large"></i></td>
            <td>Present Pincode</td>
            <td><i><?php echo $present_pin_code; ?></i></td>
          </tr>
        </table>
        </div>
      </div>
  </div>
  <hr>

  
  <!-- <div class="w3-container">
    <h5>Recent Users</h5>
    <ul class="w3-ul w3-card-4 w3-white">
      <li class="w3-padding-16">
        <img src="w3images/avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Mike</span><br>
      </li>
      <li class="w3-padding-16">
        <img src="w3images/avatar5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Jill</span><br>
      </li>
      <li class="w3-padding-16">
        <img src="w3images/avatar6.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Jane</span><br>
      </li>
    </ul>
  </div>
  <hr> -->

  <!-- <div class="w3-container">
    <h5>Recent Comments</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="w3images/avatar3.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
        <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="w3images/avatar1.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>
  </div>
  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Demographic</h5>
        <p>Language</p>
        <p>Country</p>
        <p>City</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">System</h5>
        <p>Browser</p>
        <p>OS</p>
        <p>More</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">Target</h5>
        <p>Users</p>
        <p>Active</p>
        <p>Geo</p>
        <p>Interests</p>
      </div>
    </div>
  </div> -->

  <!-- Footer -->
  <?php include 'footer.php'; ?>

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
