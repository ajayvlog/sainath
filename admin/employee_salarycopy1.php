 <?php include("../adminsession.php");
//print_r($_SESSION);die;
 $pagename = "employee_salary.php";
 $module = "Employee Salary";
 $submodule = "Employee Salary";
 $btn_name = "Save";
 $keyvalue =0 ;
 $tblname = "emp_salary";
 $tblpkey = "salary_id";
 $is_bill_exist  = 0;
 $month  = '';
 $year = '';
 $id_no = "";
//$crit = " where 1 = 1 ";
  
if(isset($_GET['msg']))
$msg = addslashes(trim($_GET['msg']));
else
$msg = "";


$basic_salary = $present = $days = $presentdays = $netsalary = $employee_id = "";
$paydate = date('d-m-Y');


if(isset($_GET['paymode']))
{
  $paymode = trim(addslashes($_GET['paymode']));  
}
else
  $paymode = 0;

if(isset($_GET['id_no']))
{
  $id_no = trim(addslashes($_GET['id_no']));  
}
else
  $id_no = 0;

if(isset($_GET['s_sessionid']))
{
  $s_sessionid = trim(addslashes($_GET['s_sessionid']));  
  //$crit .=" and class_transfer.sessionid='$s_sessionid' "; 
}
else
  $s_sessionid = 0;

 if (isset($_GET['search']))
 {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $employee_id = $_GET['employee_id'];
    $days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
    $is_bill_exist = $obj->getvalfield("emp_salary","count(*)","employee_id='$employee_id' and month=$month and year = '$year'");
}

if(isset($_GET['employee_id']))
{
  $searh_year_month = $year.'-'.$month;
  $employee_id = trim(addslashes($_GET['employee_id']));  
  //$crit .=" and m_employee.employee_id='$employee_id' "; 
  $basic_salary = $obj->getvalfield("m_employee","basic_salary","employee_id='$employee_id'");
  $presentdays = $obj->getvalfield("emp_attendance_entry","count(emp_attendance_date)","employee_id='$employee_id' and DATE_FORMAT(emp_attendance_date,'%Y-%m') = '$searh_year_month'");
    $tot_amt = $basic_salary / $days;
    $netsalary = $tot_amt * $presentdays;

}
else
$employee_id = 0;

if(isset($_POST['submit']))
{ //print_r($_POST); die;
  
   $employee_id = $obj->test_input($_POST['employee_id']);
   $month = $obj->test_input($_POST['month']);
   $year = $obj->test_input($_POST['year']);
   $paydate = $obj->dateformatusa($_POST['paydate']);
   $basic_salary = $obj->test_input($_POST['basic_salary']);
   $days = $obj->test_input($_POST['days']);
   $presentdays = $obj->test_input($_POST['presentdays']);
   $netsalary = $obj->test_input($_POST['netsalary']);
   $paymode = $obj->test_input($_POST['paymode']);
   $id_no = $obj->test_input($_POST['id_no']);
 $count = $obj->getvalfield("emp_salary","count(*)","employee_id = $employee_id and month=$month and year=$year");
 if($count > 0)
 {
  $msg = "Salary All Ready Generated!";
 }
  else{


       if($keyvalue == 0)
        {    
        $form_data = array('employee_id'=>$employee_id,'month'=>$month,'year'=>$year,'paydate'=>$paydate,'basic_salary'=>$basic_salary,'days'=>$days,'presentdays'=>$presentdays,'netsalary'=>$netsalary,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'paymode'=>$paymode,'id_no'=>$id_no);
        $obj->insert_record($tblname,$form_data); 
       //print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action&month=$month&year=$year&employee_id=$employee_id&paydate=$paydate&search=Search'</script>";
        }
    }
 
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
                  <th>Employee Name:</th>
                  <th>Month:</th>
                  <th>Year:</th>
                </tr>
                <tr>

                  <td>
                    <select name="employee_id" id="employee_id"  class="chzn-select">
                      <option value="">-select-</option>
                      <?php
                      
                      $res = $obj->fetch_record("m_employee");
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
                    <select class="chzn-select" name="month" id="month">
                      <option value="">--Select--</option>
                      <option value="1">JAN</option>
                      <option value="2">FAB</option>
                      <option value="3">MAR</option>
                      <option value="4">APRL</option>
                      <option value="5">MAY</option>
                      <option value="6">JUN</option>
                      <option value="7">JULY</option>
                      <option value="8">AUG</option>
                      <option value="9">SEP</option>
                      <option value="10">OCT</option> 
                      <option value="11">NOV</option>
                      <option value="12">DEC</option>

                    </select>
                    <script>document.getElementById('month').value = '<?php echo $month ; ?>' ;</script>
                  </td>

                  <td>
                   <select class="chzn-select" name="year" id="year">
                     <option value="">--Select--</option>
                     <option value="2018">2018</option>
                     <option value="2019">2019</option>
                     <option value="2020">2020</option>
                   </select>
                   <script>document.getElementById('year').value = '<?php echo $year ; ?>' ;</script>
                 </td>  
               </tr>
                 <tr>
                  <th>Date:</th>
                  <th>Paymode:</th>
                  <th>NEFT No / CHEQUE No / TRANSACTION ID:</th>
                </tr>
                <tr>
                 <td>
                   <input type="text" name="paydate" id="paydate" value="<?php echo $paydate; ?>" class="input-xxlarge" style="width:200px;">
                 </td>  

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
                   <input type="text" name="id_no" id="id_no" value="<?php echo $id_no; ?>" class="input-xxlarge" style="width:200px;" placeholder="Enter ID NO.">
                 </td>  
               </tr>
               <tr>
             
                 <td colspan="5"><input type="submit" name="search" class="btn btn-success" value="Search" onClick="return checkinputmaster('employee_id,month,year'); ">
                  <a href="employee_salary.php" class="btn btn-success">Reset</a></td>
                 </tr>
               </table>
             <div>
             </form>
             <br>
         <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="simple-html-invoice/simple-html-invoice-template-master/pdf_all_student_reg_report.php?class_id=<?php //echo $class_id; ?>&s_sessionid=<?php //echo $s_sessionid; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>
          
          
          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
        </p> -->
        
        <P>
          <?php if($is_bill_exist == 0 && isset($_GET['search'])) { ?>
          <form action="" method="post">
            <table class="table table-bordered table-condensed">
              <tr>
                <th>Basic Salary</th>
                <th>Total Days</th>
                <th>Present</th>
                <th>Net Salary</th>
              </tr>
              <tr>

                <td><input type="text" name="basic_salary" id="basic_salary" placeholder="Basic Salary" value="<?php echo $basic_salary; ?>" onkeyup="settotal()" style="width:120px;" readonly></td>

                <td><input type="text" name="days" id="days" placeholder="totalday" value="<?php echo $days; ?>" style="width:120px;" onkeyup="settotal()" readonly></td>
              
                <td><input type="text" name="presentdays" id="presentdays" placeholder="presentdays" value="<?php echo $presentdays;?>" style="width:120px;" onkeyup="settotal()"></td>

                <td><input type="text" name="netsalary" id="netsalary" value="<?php echo round($netsalary); ?>" placeholder="Net Salary" style="width:120px;"></td>
              
                <td colspan="4">
                  <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $employee_id; ?>">
                  <input type="hidden" id="month" name="month" value="<?php echo $month; ?>">
                  <input type="hidden" id="year" name="year" value="<?php echo $year; ?>">
                  <input type="hidden" id="paydate" name="paydate" value="<?php echo $paydate; ?>">
                   <input type="hidden" id="paymode" name="paymode" value="<?php echo $paymode; ?>">
                   <input type="hidden" id="id_no" name="id_no" value="<?php echo $id_no; ?>">
                  
                  <input type="submit" name="submit" value="Save" class="btn btn-primary">
                </td>
              </tr>
            </table>
          </form>
          <?php } ?>
          <span class="text-error"><?php echo $msg; ?></span>
        
        </p>
         <hr>
         <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
         
         <table class="table table-bordered" id="tblData">
          <thead>
            <tr>
              <th>S.No.</th>
              <th>Employee Name</th>
              <th>Month/Year</th> 
              <th>Date</th>
              <th style="text-align: right;">Basic Salary</th>
              <th>Paymode</th>
              <th>Transaction_id</th>
              <th>Total Days</th>
              <th>Present</th>
              <th style="text-align: right;">Net Salary</th>
              <th class="head0">Print</th>
              <th class="head0">Action</th>
            </tr>
          </thead>
          <tbody id="record">
          </span>
          <?php
          $slno = 1;
          $totalqty = 0;
          $sql = "select * from emp_salary";
          $res = $obj->executequery($sql);
          foreach($res as $row_get)
          {  
            $salary_id = $row_get['salary_id'];
            $employee_id = $row_get['employee_id'];
            $emp_name=$obj->getvalfield("m_employee","emp_name","employee_id=$employee_id");
           ?> 
           <tr>

             <td><?php echo $slno++; ?></td> 
             <td><?php echo $emp_name; ?></td>
             <td><?php echo $row_get['month']." / ".$row_get['year']; ?></td>
             <td><?php echo $obj->dateformatindia($row_get['paydate']); ?></td>
             <td style="text-align: right;"><?php echo number_format($row_get['basic_salary'],2); ?></td>
             <td><?php echo $row_get['paymode']; ?></td>
             <td><?php echo $row_get['id_no']; ?></td>
             <td><?php echo $row_get['days']; ?></td>
             <td><?php echo $row_get['presentdays']; ?></td>
             <td style="text-align: right;"><?php echo number_format($row_get['netsalary'],2); ?></td>
             <td><a class="btn btn-danger" href="pdf_emp_salary1.php?salary_id=<?php echo $salary_id; ?>" target="_blank">Print</a></td>
            <td>
            <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $salary_id; ?>);' style='cursor:pointer'></a>
            </td>
           </tr>
           <?php
         // $totalqty += $row_get['paid_amt'];
         }
         ?>
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
  </script>
</body>
</html>
