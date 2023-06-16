<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "show_hostel_transfer_list.php";
$module = "Transfer Details";
$submodule = "TRANSFER DETAILS";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "transfer_hostel";
$tblpkey = "transfer_hostelid";
$crit = " where 1 = 1 ";

// if(isset($_GET['class_id']))
// {
//   $class_id = trim(addslashes($_GET['class_id']));  
//   $crit .=" and m_student_reg.class_id='$class_id' "; 
// }
// else
// $class_id = 0;

// if(isset($_GET['s_sessionid']))
// {
//   $s_sessionid = trim(addslashes($_GET['s_sessionid']));  
//   $crit .=" and class_transfer.sessionid='$s_sessionid' "; 
// }
// else
// $s_sessionid = 0;
$sql = "SELECT m_student_reg.stu_name FROM transfer_hostel LEFT JOIN class_transfer ON transfer_hostel.transferid = class_transfer.transferid LEFT JOIN m_student_reg on class_transfer.m_student_reg_id=m_student_reg.m_student_reg_id";
$res=$obj->executequery($sql);
//echo $res;die;

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
            
            <!-- <?php if($class_id!='' && $s_sessionid!='')
             {

             ?> -->

                <hr>
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
                  
                         <!--  <?php } ?> -->
            <div>
      
           <br>
           <table class="table table-bordered">
            <thead>
              <tr>
                <th>sno.</th>
                <th>Student Name</th>
             </tr>
            </thead>
            <tbody>
          <?php
          $sno=1;
          foreach ($res as $rowget) {
             # code...
           ?>
             <tr>
              <td><?php echo $sno++; ?></td>
               <td><?php echo $rowget['stu_name']; ?></td>
             </tr>
           <?php } ?>
         </tbody>
           </table>
                             <!--  <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php echo number_format($totalqty,2); ?></h3></div>  --> 

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

<script type="text/javascript">
  
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}


</script>
</body>
</html>
