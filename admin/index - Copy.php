<?php include("../adminsession.php");
$pagename = "index.php";
$module = "Dashboard";
$submodule = "Dashboard";
$delivery_date="";
$curr_date=date('Y-m-d');
//echo $curr_date; die;
$tot_student = $obj->getvalfield("class_transfer","count(*)","sessionid='$sessionid'");
$tot_employee = $obj->getvalfield("m_employee","count(*)","1=1");
$tot_hostler = $obj->getvalfield("transfer_hostel","count(*)","sessionid='$sessionid'");

$today_fee = $obj->getvalfield("fee_payment","sum(paid_amt)","pay_date = '$curr_date' and sessionid='$sessionid'");
if($today_fee=="")
{
  $today_fee = '0';
}
 
$bithday = date('m-d');
$tot_birthday = $obj->getvalfield("m_student_reg","count(*)","DATE_FORMAT(dob,'%m-%d')='$bithday'");

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
</head>
<body>
<div class="mainwrapper">
    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
    <!-- START OF RIGHT PANEL -->
   <div class="rightpanel">
    	<?php include("inc/header.php"); ?>
        
        <div class="maincontent">
        	<div class="contentinner content-dashboard">
            	<div class="alert alert-info">
                	<button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Welcome!</strong> This alert needs your attention, but it's not super important.
                </div><!--alert-->
                
                <div class="row-fluid">
                	<div class="span12">
                      <ul class="widgeticons row-fluid">
                       
                       
                       <li class="one_fifth"><a href="m_student_reg.php" ><small>&nbsp;</small><h1><?php echo $tot_student; ?></h1><span>Total Student</span></a></li>
         
           
              <li class="one_fifth"><a href="fee_payment.php"><small>&nbsp;</small><h1><?php echo $tot_hostler; ?></h1><span>Total Hosteller</span></a></li>

              <li class="one_fifth"><a href="fee_payment.php"><small>&nbsp;</small><h1><?php echo $tot_employee; ?></h1><span>Total Employee</span></a></li>
         
            <li class="one_fifth"><a href="#"><small>&nbsp;</small><h1><?php echo $tot_birthday; ?></h1><span>Today's Birthday</span></a></li>

            <li class="one_fifth"><a href="#"><small>&nbsp;</small><h1><?php echo $today_fee; ?></h1><span>Today Fee</span></a></li>

              <!-- <li class="one_fifth"><a href="#"><small>&nbsp;</small><h1></h1><span> Balance Amount</span></a></li> -->

             <!-- <li class="one_fifth"><a><small>&nbsp;</small><h1><span id="sms_bal_trans"></span></h1><strong>Credit SMS Balance</strong></a></li> -->
                        </ul>
                    </div><!--span8-->
                    <!--span4-->
                </div>
                  
            </div><!--contentinner-->
        
        
        </div><!--maincontent-->
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
</div><!--mainwrapper-->
<!-- <script>

  jQuery(document).ready(function(){      

  jQuery.ajax({
          type: 'POST',
          url: 'ajaxsms_trans.php',
          data: '',
          dataType: 'html',
          success: function(data){
            //alert(data);
            jQuery("span#sms_bal_trans").html(parseInt(data));
            //jQuery('#sms_bal_trans').val(data);
          }
  
    
  });

}); 

</script> -->
</body>
</html>

