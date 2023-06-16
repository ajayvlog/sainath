<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "enquiry_report.php";
$module = "Enquiry Report ";
$submodule = "Enquiry Report";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "enquiry_master";
$tblpkey = "enq_id";




if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $obj->dateformatusa($_GET['from_date']);
    $to_date  =  $obj->dateformatusa($_GET['to_date']);
}
else
{
    $to_date =date('Y-m-d');
    $from_date =date('Y-m-d');
    
}

$crit = " where 1 = 1 and createdate between '$from_date' and '$to_date'"; 
if(isset($_GET['class_id']))
{
  $class_id = $_GET['class_id'];
  if($class_id != "")
    $crit .= " and class_id = '$class_id' ";
}
if(isset($_GET['category_id']))
{
  $category_id = $_GET['category_id'];
  if($category_id != "")
    $crit .= " and category_id='$category_id'";
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
                <th>From Date:<span style="color:#F00;">*</span></th>
                <th>To Date:<span style="color:#F00;">*</span></th>
                <th>Course</th>
                <th>Category</th>
              </tr>
              <tr>
                  
                 
                <td>
                  <input type="text" name="from_date" id="from_date" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                <td>
                  <input type="text" name="to_date" id="to_date" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> 
                   </td>
                 <td>
                      <select name="class_id" id="class_id" style="width:200px;" class="chzn-select">
                    <option value="" >---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("m_class");
                    foreach($res as $row_get)
                    {
                      ?> 
                      <option value="<?php echo $row_get['class_id']; ?>"> <?php echo $row_get['class_name']; ?></option>                                                     
                    <?php } ?>
                    </select>
                    <script>document.getElementById('class_id').value = '<?php echo $class_id ; ?>';
                  </script>
                 </td>


                 <td>
                  <select name="category_id" id="category_id" style="width:280px;" class="input-medium chzn-select">
                      <option value="">--Select--</option>
                      <?php
                      $res = $obj->executequery("select * from m_category");
                      foreach($res as $row)
                      {
                        ?>
                        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['cat_name']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <script> document.getElementById('category_id').value='<?php echo $category_id; ?>'; </script></td>
                <td><input type="submit" name="search" onClick="return checkinputmaster('from_date,to_date');" class="btn btn-success" value="Search"></td>
                 <td><a href="enquiry_report.php" class="btn btn-success">Reset</a></td>
              </tr>
            </table>
            <div>
            </form>
                <hr>
                <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_enquiry_report.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&class_id=<?php echo $class_id; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>
            </p>
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
            	<table class="table table-bordered" id="dyntable">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Mobile</th>
                            <th style="text-align: center;">District Name</th>
                            <th style="text-align: center;">Address</th>
                            <th style="text-align: center;">Previous_School/College</th>
                            <th style="text-align: center;">Course</th>
                            <th style="text-align: center;">Category</th>
                            <th style="text-align: center;">Date</th>
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
                  <?php
                  $slno = 1;
                  $totalqty = 0;
                  //echo "select * from fee_payment $crit and sessionid=$sessionid";die;
                  $sql = "select * from enquiry_master $crit order by createdate desc";
                  $res = $obj->executequery($sql);
                  foreach($res as $row_get)
          				{
                    $disid = $row_get['dis_id'];
                    $districtname=$obj->getvalfield("m_district","dis_name","dis_id='$disid'");
                    $course_name=$obj->getvalfield("m_class","class_name","class_id='$row_get[class_id]'");
                    $category_id = $row_get['category_id'];
                    $prv_schl = $row_get['prv_schl'];
                    $cat_name=$obj->getvalfield("m_category","cat_name","category_id='$category_id'");

					        ?> 
                    <tr>
                         <td><?php echo $slno++; ?></td> 
                         <td style="text-align: center;"><?php echo $row_get['enq_name']; ?></td>
                         <td style="text-align: center;"><?php echo $row_get['mobile']; ?></td>
                         <td style="text-align: center;"><?php echo $districtname; ?></td>
                         <td style="text-align: center;"><?php echo $row_get['address']; ?></td>
                         <td style="text-align: center;"><?php echo $prv_schl; ?></td>
                         <td style="text-align: center;"><?php echo $course_name; ?></td>
                         <td style="text-align: center;"><?php echo $cat_name; ?></td>
                        <td style="text-align: center;"><?php echo $obj->dateformatindia($row_get['createdate']); ?></td>
                    </tr>
                            <?php
                            // $totalqty += $row_get['paid_amt'];
                            }
                            ?>
                            </tbody>
                            </table>
                              <!-- <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php //echo number_format($totalqty,2); ?></h3></div>  --> 
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
