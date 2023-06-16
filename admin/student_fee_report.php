<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "student_fee_report.php";
$module = "Student Wise Fee Report ";
$submodule = "Student Wise Fee Report";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "fee_payment";
$tblpkey = "fee_payid";

$crit = " where 1 = 1 "; 

if(isset($_GET['transferid']) && $_GET['transferid']!="")
{
  $transferid = trim(addslashes($_GET['transferid']));  
  $crit .=" and transferid='$transferid' "; 
}
else
{
  $transferid = "";
}

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
</head>
<body onLoad="getrecord('<?php echo $keyvalue; ?>');">

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
            <form method="get" action="">
            <table class="table table-bordered table-condensed">
              <tr>
                <th>Student Name</th>
                <th>&nbsp</th>
              </tr>
              <tr>

                <td><select name="transferid" id="transferid" class="chzn-select" style="width:200px;">
                    <option value="">Select All</option>
                      <?php
                      $slno=1;

                      $res = $obj->executequery("select * from class_transfer where sessionid='$sessionid'");
                      foreach($res as $row_get)
                      {       
                         $m_student_reg_id = $row_get['m_student_reg_id'];
                         $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id='$m_student_reg_id'");       
                      ?>
                      <option value="<?php echo $row_get['transferid'];  ?>"> <?php echo $stu_name; ?></option>
                      <?php } ?>

                      </select>
                    <script>document.getElementById('transferid').value = '<?php echo $transferid ; ?>' ;</script></td>
                <td><input type="submit" name="search" class="btn btn-success" value="Search"></td>
                 <td><a href="student_fee_report.php" class="btn btn-success">Reset</a></td>
              </tr>
            </table>
            <div>
            </form>
<hr>
         <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_student_fee_report.php?transferid=<?php echo $transferid; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a></p>
                
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
            	<table class="table table-bordered" id="dyntable">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th style="text-align: center;">Receipt_no.</th>
                            <th style="text-align: center;">Payment_date</th>
                            <th style="text-align: center;">Fee_Head</th>
                            <th style="text-align: center;">Payment_Type</th>
                            <th style="text-align: right;">Paid_amount</th>
                            <th style="text-align: center;">Remark</th>
                           
                            
                        </tr>
                    </thead>
                    <tbody id="record">
                          
                  <?php
                  $slno = 1;
                  $totalqty = 0;
                  $sql = "select * from fee_payment $crit";
                  $res = $obj->executequery($sql);
                  foreach($res as $row_get)
          				{
                    $transferid = $row_get['transferid'];
                    $fee_head_id = $row_get['fee_head_id'];
                    $fee_head_name=$obj->getvalfield("m_fee_head","fee_head_name","fee_head_id='$fee_head_id'");
					        ?> 
                    <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td style="text-align: center;"><?php echo $row_get['reciept_no']; ?></td>
                        <td style="text-align: center;"><?php echo $obj->dateformatindia($row_get['pay_date']); ?></td>
                        <td style="text-align: center;"><?php echo $fee_head_name; ?></td>
                        <td style="text-align: center;"><?php echo $row_get['payment_type']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row_get['paid_amt'],2); ?></td>
                        <td style="text-align: center;"><?php echo $row_get['remark']; ?></td>
                            
                    </tr>
                            <?php
                            $totalqty += $row_get['paid_amt'];
                            }
                            ?>
                            </tbody>
                            </table>
                              <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php echo number_format($totalqty,2); ?></h3></div>  
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

</body>
</html>
