<?php include("../adminsession.php");
//print_r($_SESSION);die;
 $pagename = "employee_advance.php";
 $module = "Employee Advance";
 $submodule = "Employee Advance";
 $btn_name = "Save";
 $keyvalue =0 ;
 $tblname = "emp_advance";
 $tblpkey = "advance_id";

 if(isset($_GET['advance_id']))
$keyvalue = $_GET['advance_id'];
else
$keyvalue = 0;
 
$employee_id = "";
$paydate = date('d-m-Y');
$amount = "";
$ref_no = "";


if(isset($_POST['submit']))
{ //print_r($_POST); die;
  
   $employee_id = $obj->test_input($_POST['employee_id']);
   $paydate = $obj->dateformatusa($_POST['paydate']);
   $paymode = $obj->test_input($_POST['paymode']);
   $amount = $obj->test_input($_POST['amount']);
   $ref_no = $obj->test_input($_POST['ref_no']);



       if($keyvalue == 0)
        {    
        $form_data = array('employee_id'=>$employee_id,'paydate'=>$paydate,'paymode'=>$paymode,'amount'=>$amount,'ref_no'=>$ref_no,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
        $obj->insert_record($tblname,$form_data); 
       //print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action'</script>";
        }

        else
        {
        //update
        $form_data = array('employee_id'=>$employee_id,'paydate'=>$paydate,'paymode'=>$paymode,'amount'=>$amount,'ref_no'=>$ref_no,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
        $where = array($tblpkey=>$keyvalue);
        $keyvalue = $obj->update_record($tblname,$where,$form_data);
        $action=2;
        $process = "updated";
          
               }
    echo "<script>location='$pagename?action=$action'</script>";
   
    
  }
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $employee_id =  $sqledit['employee_id'];
  $paymode =  $sqledit['paymode'];
  $paydate =  $obj->dateformatindia($sqledit['paydate']);
  $amount =  $sqledit['amount'];
  $ref_no =  $sqledit['ref_no'];
  
}
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
          <form method="post" action="">
              <table class="table table-bordered table-condensed">
                <tr>
                  <th>Employee Name:<span style="color:#F00;">*</span></th>
                  <th>Amount<span style="color:#F00;">*</span></th>
                  <th>Date</th>
                </tr>
                <tr>

                  <td>
                    <select name="employee_id" id="employee_id"  class="chzn-select">
                      <option value="">-select-</option>
                      <?php
                      
                      $res = $obj->executequery("select * from m_employee where status='0'");
                      foreach($res as $row)
                      {
                        ?> 
                        <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['emp_name']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <script>document.getElementById('employee_id').value = '<?php echo $employee_id ; ?>' ;</script>
                  </td> 
                  <td>
                   <input type="text" name="amount" id="amount" value="<?php echo $amount; ?>" placeholder='Enter Amount' class="input-xxlarge" style="width:200px;">
                 </td> 

                 <td>
                   <input type="text" name="paydate" id="paydate" placeholder='dd-mm-yyyy'
                     value="<?php echo $paydate; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask  class="input-xxlarge" style="width:200px;">
                 </td>  
               </tr>
                 <tr>
                  <th>Paymode:</th>
                  <th>NEFT No / CHEQUE No / TRANSACTION ID:</th>
                  <th></th>
                </tr>
                <tr>

                  <td>
                   <select class="chzn-select" name="paymode" id="paymode">
                     <option value="">--Select--</option>
                     <option value="CASH">CASH</option>
                     <option value="NEFT">NEFT</option>
                     <option value="CHEQUE">CHEQUE</option>
                     <option value="GOOGLE_PAY">GOOGLE PAY</option>
                   </select>
                   <script>document.getElementById('paymode').value = '<?php echo $paymode ; ?>' ;</script>
                 </td> 

                  <td>
                   <input type="text" name="ref_no" id="ref_no" value="<?php echo $ref_no; ?>" class="input-xxlarge" style="width:200px;" placeholder="Enter ID NO.">
                 </td>
             
                 <td><input type="submit" name="submit" class="btn btn-success" value="<?php echo $btn_name; ?>" onClick="return checkinputmaster('employee_id,amount'); ">
                  <a href="employee_advance.php" class="btn btn-success">Reset</a></td>
                 </tr>
               </table>
             <div>
             </form>
             <br>
         <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="simple-html-invoice/simple-html-invoice-template-master/pdf_all_student_reg_report.php?class_id=<?php //echo $class_id; ?>&s_sessionid=<?php //echo $s_sessionid; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>
          
          
          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
        </p> -->
        
        
         <hr>
         <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
         
         <table class="table table-bordered" id="dyntable">
          <thead>
            <tr>
              <th>S.No.</th>
              <th>Employee Name</th>
              <th>Date</th>
              <th>Paymode</th>
              <th>Transaction_id</th>
              <th style="text-align: right;">Advance_Amount</th>
             <!--  <th class="head0">Print</th> -->
             <?php  $chkedit = $obj->check_editBtn("employee_advance.php",$loginid);              

              if($chkedit == 1 || $loginid == 1){  ?>
              <th class="head0">Edit</th>
              <?php  } $chkdel = $obj->check_delBtn("employee_advance.php",$loginid);             

              if($chkdel == 1 || $loginid == 1){  ?>
              <th class="head0">Delete</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody id="record">
          </span>
          <?php
          $slno = 1;
          $totalqty = 0;
          $sql = "select * from emp_advance";
          $res = $obj->executequery($sql);
          foreach($res as $row_get)
          {  
            $advance_id = $row_get['advance_id'];
            $employee_id = $row_get['employee_id'];
            $emp_name=$obj->getvalfield("m_employee","emp_name","employee_id=$employee_id");
           ?> 
           <tr>

             <td><?php echo $slno++; ?></td> 
             <td><?php echo $emp_name; ?></td>
             <td><?php echo $obj->dateformatindia($row_get['paydate']); ?></td>
             <td><?php echo $row_get['paymode']; ?></td>
             <td><?php echo $row_get['ref_no']; ?></td>
             <td style="text-align: right;"><?php echo number_format($row_get['amount'],2); ?></td>
            
             <!-- <td><a class="btn btn-danger" href="pdf_emp_salary1.php?salary_id=<?php echo $salary_id; ?>" target="_blank">Print</a></td> -->
             <?php                

              if($chkedit == 1 || $loginid == 1){  ?>
             <td><a class='icon-edit' title="Edit" href='employee_advance.php?advance_id=<?php echo $row_get['advance_id'] ; ?>'></a></td>
             <?php  } if($chkdel == 1 || $loginid == 1){  ?>
            <td>
            <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $advance_id; ?>);' style='cursor:pointer'></a>
            </td>
            <?php } ?>
           </tr>
           <?php
         // $totalqty += $row_get['paid_amt'];
         }
         ?>
       </tbody>
     </table>
   
   <!--  <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php //echo number_format($totalqty,2); ?></h3></div>  --> 
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

function settotal()
{

  var basic_salary=parseFloat(jQuery('#basic_salary').val()); 
  var days=parseFloat(jQuery('#days').val()); 
  var presentdays=parseFloat(jQuery('#presentdays').val()); 

  if(!isNaN(basic_salary) && !isNaN(days) && !isNaN(presentdays))
  {
    totdays = basic_salary/days;
    netsalary = totdays*presentdays;
  } 
  jQuery('#netsalary').val(netsalary.toFixed(2));
} 

jQuery('#paydate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#paydate').focus();
  </script>
</body>
</html>
