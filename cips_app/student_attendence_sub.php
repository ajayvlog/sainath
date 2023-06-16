<?php
//print_r($_SESSION);die;
include("adminsession.php");
$pagename = "student_attendence_sub.php";
$employee_id = $_SESSION['employee_id'];


$sessionid = $obj->getvalfield("m_session","sessionid","status=1");
//$_SESSION['sessionid'] = $sessionid;

$crit = " where 1 = 1 ";

if(isset($_GET['class_id']))
{
  $class_id = trim(addslashes($_GET['class_id']));  
  $crit .=" and B.class_id='$class_id' "; 
}
else
$class_id = 0;

if(isset($_GET['sem_id']))
{
  $sem_id = trim(addslashes($_GET['sem_id']));  
  $crit .=" and A.sem_id='$sem_id' "; 
}
else
$sem_id = 0;

if(isset($_GET['attendate']))
{
    $attendate = $obj->dateformatusa($obj->test_input($_GET['attendate']));
        
}
else
{
    $attendate= date('Y-m-d');
}


if(isset($_GET['stu_subject_id']))
{
  $stu_subject_id = $_GET['stu_subject_id'];
}
else
$stu_subject_id = "";

?>
<!DOCTYPE html>

<html>
<head>
  <style>
    body{
      background-image: url("img/bg3.jpg");
    }
  </style>
  <script type="text/javascript">
  // function getid(class_id)
  // {
  // location = "student_attendence_sub.php?class_id="+class_id;
  // }

  function makeattendance(transferid)
  {

    var attendate=document.getElementById('attendate').value;
    var sem_id=document.getElementById('sem_id').value;
    var class_id=document.getElementById('class_id').value;
    var stu_subject_id=document.getElementById('stu_subject_id').value;

   jQuery("#btn").attr("disabled", true);

    jQuery.ajax({
    type: 'POST',
    url: 'appstu_attendance.php',
    data: 'transferid='+transferid+'&attendate='+attendate+'&sem_id='+sem_id+'&class_id='+class_id+'&stu_subject_id='+stu_subject_id,
    dataType: 'html',
    success: function(data){
    //alert(data);

      jQuery("#btn").attr("disabled", false);
      var btnid = "#btn" + transferid;
      
      if(data == 1)
        { 
          jQuery(btnid).prop('class', 'w3-button w3-green w3-round'); 
        }
        else
        {
          jQuery(btnid).prop('class', 'w3-button w3-grey w3-round'); 
        }
    }

    });//ajax close
  }
  </script>
</head>
<?php  include 'headerfiles.php'; ?>
<body class="w3-light-grey">

<!-- Top container -->
<?php include 'top_menu.php'; ?>
<script src="commonfun.js"></script>

<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

<!-- Sidebar/menu -->
<?php include 'side_menu.php'; ?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onClick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px; ">
    <h5 style="color: white"><b><i class="fa fa-dashboard w3-xlarge"></i>Student Attendence</b></h5>
  </header>


  <div class="w3-row-padding w3-margin-bottom w3-animate-top">
    <div class="w3-card-4 w3-sand w3-round">
    <form class="w3-container" action="" method="get">

     <p>      
      <label class="w3-text-brown"><b>Date</b></label>
      <input class="w3-input w3-border w3-brown" name="attendate" id="attendate" value="<?php echo $obj->dateformatindia($attendate); ?>" type="date">
    </p>

    <p>      
    	<label class="w3-text-brown"><b>Course Name</b></label>
    	<select class="w3-input w3-border w3-brown w3-round" name="class_id" id="class_id">
      <option value="">-select-</option>
      <?php

      $res = $obj->fetch_record("m_class");
      foreach($res as $row)
      {
      ?> 
      <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
      <?php
      }
      ?>
      </select>
      <script>document.getElementById("class_id").value="<?php echo $class_id; ?>" ;</script>
    </p>

    <p>      
      <label class="w3-text-brown"><b>Sem/Year</b></label>
      <select class="w3-input w3-border w3-brown w3-round" name="sem_id" id="sem_id">
      <option value="">-select-</option>
      <?php

      $res = $obj->fetch_record("m_semester");
      foreach($res as $row)
      {
      ?> 
      <option value="<?php echo $row['sem_id']; ?>"><?php echo $row['sem_name']; ?></option>
      <?php
      }
      ?>
      </select>
      <script>document.getElementById("sem_id").value="<?php echo $sem_id; ?>" ;</script>
    </p>

    <p>      
      <label class="w3-text-brown"><b>Subject Name</b></label>
      <select class="w3-input w3-border w3-brown w3-round" name="stu_subject_id" id="stu_subject_id">
          <option value="">--Select Subject--</option>
         <?php
        $res = $obj->executequery("select * from assign_subject where employee_id = '$employee_id'");
        foreach($res as $row_get)
        {   
          $stu_subject_id1 = $row_get['stu_subject_id'];
          $subject_name = $obj->getvalfield("student_subject_master","subject_name","stu_subject_id='$stu_subject_id1'");
        ?>
        <option value="<?php echo $row_get['stu_subject_id'];?>"><?php echo $subject_name; ?></option>
        <?php } ?>
        </select>
         <script> document.getElementById('stu_subject_id').value='<?php echo $stu_subject_id; ?>'; </script>  
    </p>
    
     <p><button class="w3-btn w3-black w3-round" name="Submit" type="Submit" style="width: 100%;" onClick="return checkinputmaster('attendate,class_id,sem_id,stu_subject_id'); ">Search</button></p> 
  </form>
</div>
<?php if($class_id > 0 and $sem_id > 0)
{
?>
<br>
<div class="w3-container" style="padding: 3px; margin-bottom: 50px;">
  <center><h3 class="w3-text-sand"><i>Student List</i></h3></center>
  
  <ul class="w3-ul w3-card-4">
    <?php
        $slno=1;
        $res = $obj->executequery("select A.*,B.stu_name from class_transfer as A left join m_student_reg as B on A.m_student_reg_id=B.m_student_reg_id $crit and A.sessionid = '$sessionid' group by A.m_student_reg_id");
        foreach($res as $row_get)
        {        
          $transferid=$row_get['transferid'];
          $m_student_reg_id=$row_get['m_student_reg_id'];
          $stu_name=$row_get['stu_name'];

          $count=$obj->getvalfield("app_subject_attendence","count(*)","attendate='$attendate' && transferid='$transferid' && employee_id='$employee_id'");

          ?>
    <li class="w3-bar w3-sand w3-round" style="padding-bottom:10px;margin-bottom: 30px;">
       <?php if($count > 0) {
              $btncls = "w3-green";
              $btnval = $stu_name;
             } 
             else
             {
              $btncls = "w3-grey";
              $btnval = $stu_name;
             }
             ?>
      
    <center>
    <button id="btn<?php echo $transferid; ?>" class="w3-button <?php echo $btncls; ?> w3-round"  onclick="makeattendance('<?php echo $transferid; ?>');" style="border-radius: 50px;width: 100%;">
    <?php echo $btnval; ?>
    </button>
    <center>
    </li>
  <?php } ?>
  </ul>
</div>
<?php } ?>

  </div>
  <!-- Footer -->
    <!-- <?php include 'footer.php'; ?>  -->
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
