<?php
include("adminsession.php");
///print_r($_SESSION);die;
//print_r(expression)
$eno = $_SESSION['eno'];
 $total_pan = $obj->getvalfield("itr_detail_master","count(*)","created_by=$eno");
 $rejected = $obj->getvalfield("itr_detail_master","count(*)","created_by=$eno and vari_status='rejected'");

$panding = $obj->getvalfield("itr_detail_master","count(*)","created_by=$eno and vari_status='pending'");
$completed = $obj->getvalfield("itr_detail_master","count(*)","created_by=$eno and vari_status='complete'");

$processing = $obj->getvalfield("itr_detail_master","count(*)","created_by=$eno and vari_status='processing'");
$objection = $obj->getvalfield("itr_detail_master","count(*)","created_by=$eno and vari_status='objection'");


if($total_pan < 0){
  
if($rejected==0){
  $rejected_per = ($rejected * 100)/$total_pan; 
}
  $panding_per = ($panding * 100)/$total_pan; 
  $completed_per = ($completed * 100)/$total_pan;
  $processing_per = ($processing * 100)/$total_pan;
  $objection_per = ($objection * 100)/$total_pan;
}


//$first_name = $obj->getvalfield("ecounter","first_name","eno=$loginid");
$row = $obj->executequery("select * from ecounter where eno=$loginid");
$first_name = $row['first_name'];
$pan_wallet = $row['pan_wallet'];
$e_wallet = $row['e_wallet'];
$reward_wallet = $row['reward_wallet'];
//$vari_status = $row['vari_status'];


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
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i>Itr Details</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <!-- <div class="w3-quarter w3-animate-left">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $e_wallet; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Account Balance</h4>
      </div>
    </div>

    <div class="w3-quarter w3-animate-right">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $pan_wallet; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>PAN Balance</h4>
      </div>
    </div>

    <div class="w3-quarter w3-animate-left">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>00.00</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Commissions</h4>
      </div>
    </div>

    <div class="w3-quarter w3-animate-right">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $reward_wallet; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Reward</h4>
      </div>
    </div>
  </div> -->

  <!-- <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h5>Regions</h5>
        <img src="/w3images/region.jpg" style="width:100%" alt="Google Regional Map">
      </div>
      <div class="w3-twothird">
        <h5>Feeds</h5>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
            <td>New record, over 90 views.</td>
            <td><i>10 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bell w3-text-red w3-large"></i></td>
            <td>Database error.</td>
            <td><i>15 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-yellow w3-large"></i></td>
            <td>New record, over 40 users.</td>
            <td><i>17 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-comment w3-text-red w3-large"></i></td>
            <td>New comments.</td>
            <td><i>25 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bookmark w3-text-blue w3-large"></i></td>
            <td>Check transactions.</td>
            <td><i>28 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-laptop w3-text-red w3-large"></i></td>
            <td>CPU overload.</td>
            <td><i>35 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
            <td>New shares.</td>
            <td><i>39 mins</i></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <hr> -->
  <div class="w3-container  w3-animate-left">
    <!-- <h5>General Stats</h5> -->
    <p>Competed Itr</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-green"  style="width:<?php echo round($panding_per);  ?>%"><?php echo round($completed_per);  ?>%</div>
    </div>

    <p>Pending Itr</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-orange" style="width:<?php echo round($panding_per);  ?>%"> <?php echo  round($panding_per); ?>%</div>
    </div>

    <p>Rejected Itr</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-red"style="width:<?php echo round($rejected_per);  ?>%"> <?php echo  round($rejected_per) ?>% </div>
    </div>

  <p>Processing Itr</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-blue"style="width:<?php echo round($processing_per);  ?>%"> <?php echo  round($processing_per) ?>%</div>
    </div>

  <p>Objection Itr</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-red" style="width:<?php echo round($objection_per);  ?>%"> <?php echo  round($objection_per) ?>%</div>
    </div>
  <hr>

  <div class="w3-container  w3-animate-top">
    <h5>Recently posted itr details</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white" style="font-size: 10px;">
      <thead>
      <tr>
        <td>SNo</td>
        <td>Client Name</td>
        <td>Posted On</td>
        <td>Status</td>
      </tr>
     </thead>
     <tbody>
      <?php
      $where = array('created_by' =>  $loginid);
      $row = $obj->select_data("itr_detail_master",$where);
      $slno = 1;
      foreach ($row as $paninfo){
        $fullname = $paninfo['client_first_name'].' '.$paninfo['client_middle_name'].' '.$paninfo['client_last_name'];
         $status = $paninfo['vari_status'];
        
        
      ?>
      <tr >
        <td><?php echo $slno++; ?></td>
        <td><?php echo strtoupper($fullname);  ?></td>
        <td><?php echo $obj->dateformatindia($paninfo['created_on']); ?></td>
        <td><?php echo strtoupper($status);  ?></td>
        
      </tr>
     <?php
      }?>
      
    </tbody>
    </table><br>
    <button class="w3-button w3-dark-grey">More Information<i class="fa fa-arrow-right"></i></button>
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
