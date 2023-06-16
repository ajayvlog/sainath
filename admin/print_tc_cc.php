<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "fee_report.php";
$module = "Date Wise Fee Report ";
$submodule = "Date Wise Fee Report";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "fee_payment";
$tblpkey = "fee_payid";
$crit = " where class_transfer.sessionid='$sessionid'";



if(isset($_GET['class_id']))
{
  $class_id = trim(addslashes($_GET['class_id']));  
  $crit .=" and m_student_reg.class_id='$class_id' "; 
}
else
{
  $class_id = "";
}

if(isset($_GET['sem_id']))
{
  $sem_id = trim(addslashes($_GET['sem_id']));  
  $crit .=" and class_transfer.sem_id='$sem_id' "; 
}

else
{
  $sem_id = "";
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
                <!-- <th>Vendor</th>
                <th>Party Name</th> -->
                <th>Course Name:</th>
                <th>Sem/Year:</th>
              </tr>
              <tr>
                <td>
                  <select class="input-medium" name="class_id" id="class_id">
                    <option value="">Select Course</option>
                    <?php 
                    $qry = $obj->executequery("select * from m_class");
                    foreach($qry as $key)
                    {
                    ?>
                    <option value="<?php echo $key['class_id'] ?>"><?php echo $key['class_name']; ?></option>
                  <?php } ?>
                  </select>
                  <script type="text/javascript">
                    document.getElementById('class_id').value = '<?php echo $class_id; ?>';
                  </script>
                </td>

                <td>
                  <select class="input-medium" name="sem_id" id="sem_id">
                    <option value="">Select Year/Sem</option>
                    <?php 
                    $qry = $obj->executequery("select * from m_semester");
                    foreach($qry as $key)
                    {
                    ?>
                  <option value="<?php echo $key['sem_id']; ?>"><?php echo $key['sem_name']; ?></option>
                 <?php }?>
                  </select>
                  <script type="text/javascript"> document.getElementById('sem_id').value = '<?php echo $sem_id; ?>'</script>
                </td>
                <td><input type="submit" name="search" class="btn btn-success" value="Search"></td>
                 <td><a href="print_tc_cc.php" class="btn btn-success">Reset</a></td>
              </tr>
            </table>
            <div>
            </form>
             <hr>
                 <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_datewise_fee.php?from_date=<?php //echo $from_date; ?>&to_date=<?php //echo $to_date; ?>&fee_head_id=<?php //echo $fee_head_id; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a></p> -->
          <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
            	<table class="table table-bordered" id="dyntable">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th style="text-align: center;">Student Name</th>
                            <th style="text-align: center;">Course Name</th>
                            <th style="text-align: center;">Year</th>
                            <th style="text-align: center;">Print CC</th>
                            <th style="text-align: center;">Print TC</th>
                        </tr>
                    </thead>
                    <tbody id="record">
                         
                           <?php
                           $slno = 1;
                        $sql = "select * from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit and sessionid=$sessionid";
                        $res = $obj->executequery($sql);
                        foreach($res as $row_get1)
                        {
                          $m_student_reg_id = $row_get1['m_student_reg_id'];
                          $stu_name = $row_get1['stu_name'];
                          $stu_name = $row_get1['stu_name'];
                          $sem_id = $row_get1['sem_id'];
                          $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id='$sem_id'");
                          $class_id = $row_get1['class_id'];
                          $course_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'");
                          ?> 
                        <tr>
                         <td><?php echo $slno++; ?></td> 
                         <td style="text-align: center;"><?php echo $stu_name; ?></td>
                         <td style="text-align: center;"><?php echo $course_name; ?></td>
                         <td style="text-align: center;"><?php echo $sem_name; ?></td>
                         <td style="text-align: center;"><a class="btn btn-md" target="_blank" href="character_certificate.php?m_student_reg_id=<?php echo $m_student_reg_id; ?>">Print</a></td>
                         <td style="text-align: center;"><a class="btn btn-md" target="_blank" href="transfer_certificate.php?m_student_reg_id=<?php echo $m_student_reg_id; ?>">Print</a></td>
                       </tr>
                  <?php } ?>
                            </tbody>
                            </table>
                          </div><!--contentinner-->
                        </div><!--maincontent-->
                      </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

</div><!--mainwrapper-->




          
          
    </div>
    <?php //include("modal_voucher_entry.php"); ?>
 
<script>

function funDel(id)
{  //alert(id);   
	tblname = '<?php echo $tblname; ?>';
	tblpkey = '<?php echo $tblpkey; ?>';
	pagename = '<?php echo $pagename; ?>';
	submodule = '<?php echo $submodule; ?>';
	module = '<?php echo $module; ?>';
	 //alert(module); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajax/delete_master.php',
		  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			   location='<?php echo $pagename."?action=3" ; ?>';
			}
			
		  });//ajax close
	}//confirm close
} //fun close

jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#from_date').focus();
	
 function deleterecord(saledetail_id)
  {
	 	tblname = 'saleentry_details';
		tblpkey = 'saledetail_id';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+saledetail_id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				 getrecord('<?php echo $keyvalue; ?>');
				 setTotalrate();
				}
				
			  });//ajax close
		}//confirm close
	
  }
   

jQuery('#sale_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#vdate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#sale_date').focus();






</script>
</body>
</html>
