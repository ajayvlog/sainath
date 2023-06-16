 <?php include("../adminsession.php");
//print_r($_SESSION);die;
 $pagename = "employee_salary_1.php";
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
if(isset($_GET['salary_id']))
$keyvalue = $_GET['salary_id'];
else
$keyvalue = 0;

if(isset($_GET['msg']))
$msg = addslashes(trim($_GET['msg']));
else
$msg = "";


$basic_salary = $present = $days = $presentdays = $netsalary = $employee_id = "";
$paydate = date('d-m-Y');


// if(isset($_GET['paymode']))
// {
//   $paymode = trim(addslashes($_GET['paymode']));  
// }
// else
//   $paymode = 0;

// if(isset($_GET['id_no']))
// {
//   $id_no = trim(addslashes($_GET['id_no']));  
// }
// else
//   $id_no = 0;

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
  // $paymode = $obj->test_input($_POST['paymode']);
   //$id_no = $obj->test_input($_POST['id_no']);
 $count = $obj->getvalfield("emp_salary","count(*)","employee_id = $employee_id and month=$month and year=$year");
 if($count > 0)
 {
  $msg = "Salary All Ready Generated!";
 }
  else{


       if($keyvalue == 0)
        {    
        $form_data = array('employee_id'=>$employee_id,'month'=>$month,'year'=>$year,'paydate'=>$paydate,'basic_salary'=>$basic_salary,'days'=>$days,'presentdays'=>$presentdays,'netsalary'=>$netsalary,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
        $obj->insert_record($tblname,$form_data); 
       //print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action&month=$month&year=$year&employee_id=$employee_id&paydate=$paydate&search=Search'</script>";
        }
    }
 
}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $employee_id =  $sqledit['employee_id'];
  $month =  $sqledit['month'];
  $paydate =  $obj->dateformatindia($sqledit['paydate']);
  $year =  $sqledit['year'];
  $basic_salary =  $sqledit['basic_salary'];
  $days =  $sqledit['days'];
  $presentdays = $sqledit['presentdays'];
  $netsalary = $sqledit['netsalary'];
  $paymode = $sqledit['paymode'];
  $id_no = $sqledit['id_no'];
}
else
{
$paid_date = date('d-m-Y');
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
          <form method="get" action="">
              <table class="table table-bordered table-condensed">
                <tr>
                  <th>Employee Name:</th>
                  <th>Month:</th>
                  <th>Year:</th>
                </tr>
                <tr>

                  <td>
                    <select name="employee_id" id="employee_id" style="width:285px;" class="chzn-select">
                                <option value="" >---Select---</option>
                               <?php
                                    $slno=1;
                                    $res = $obj->fetch_record("m_employee");
                                    foreach($res as $row_get)
                                    {
                              ?> 
                                <option value="<?php echo $row_get['employee_id']; ?>"> <?php echo $row_get['emp_name']; ?></option>                                                     
                              <?php } ?>
                            </select>
                            <script>document.getElementById('employee_id').value = '<?php echo $employee_id ; ?>';</script>
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
                  <th>Payment Date:</th>
                  <th colspan="2"></th>
                  <!-- <th>Paymode:</th>
                   <th>NEFT No / CHEQUE No / TRANSACTION ID:</th> -->
                </tr>
                <tr>
                 <td>
                   <input type="text" name="paydate" id="paydate" value="<?php echo $paydate; ?>" class="input-xxlarge" style="width:200px;">
                 </td>  

                 <!--  <td>
                   <select class="chzn-select" name="paymode" id="paymode">
                     <option value="">--Select--</option>
                     <option value="CASH">CASH</option>
                     <option value="NEFT">NEFT</option>
                     <option value="CHEQUE">CHEQUE</option>
                     <option value="GOOGLE_PAY">GOOGLE PAY</option>
                   </select>
                   <script>document.getElementById('paymode').value = '<?php echo $paymode ; ?>' ;</script>
                 </td>  -->

                 <!--  <td>
                   <input type="text" name="id_no" id="id_no" value="<?php echo $id_no; ?>" class="input-xxlarge" style="width:200px;" placeholder="Enter ID NO.">
                 </td> -->  
               
               
                 <td colspan="5"><input type="submit" name="search" class="btn btn-success" value="Search" onClick="return checkinputmaster('employee_id,month,year'); ">
                  <a href="employee_salary_1.php" class="btn btn-success">Reset</a></td>
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
              <th>Employee Info</th>
              <!-- <th>Month/Year</th> 
              <th>Date</th> -->
              <th style="text-align: right;">Basic Salary</th>
              <th>Paymode</th>
              <th>Transaction_id</th>
              <th>Total Days</th>
              <th>Present</th>
              <th style="text-align: right;">Net_Salary</th>
              <th style="text-align: right;">Paid_Salary</th>
              <th style="text-align: right;">Bal_Salary</th>
              <th class="head0">Print</th>
              <th class="head0">Payment:</th>
              <th class="head0">Delete</th>
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
            $netsalary = $row_get['netsalary'];
            $employee_id = $row_get['employee_id'];
            $emp_name=$obj->getvalfield("m_employee","emp_name","employee_id=$employee_id");
            $paid_amt=$obj->getvalfield("emp_salary","sum(paid_amt)","employee_id=$employee_id");
            $payment_date = date('d-m-Y');
            $balance = $netsalary - $paid_amt;
           ?> 
           <tr>

             <td><?php echo $slno++; ?></td> 
             <td>Name:<?php echo $emp_name; ?>
               <br>Month/Year:
               <?php echo $row_get['month']." / ".$row_get['year']; ?>
               <br>Date:<?php echo $obj->dateformatindia($row_get['paydate']); ?>
             </td>
             <!-- <td><?php echo $row_get['month']." / ".$row_get['year']; ?></td>
             <td><?php echo $obj->dateformatindia($row_get['paydate']); ?></td> -->
             <td style="text-align: right;"><?php echo number_format($row_get['basic_salary'],2); ?></td>
             <td><?php echo $row_get['paymode']; ?></td>
             <td><?php echo $row_get['id_no']; ?></td>
             <td><?php echo $row_get['days']; ?></td>
             <td><?php echo $row_get['presentdays']; ?></td>
             <td style="text-align: right;"><?php echo number_format($netsalary,2); ?></td>
             <td style="text-align: right;"><?php echo number_format($paid_amt,2); ?></td>
             <td style="text-align: right;"><?php echo number_format($balance,2); ?></td>
             <td><a class="btn btn-danger" href="pdf_emp_salary1.php?salary_id=<?php echo $salary_id; ?>" target="_blank">Print</a></td>
             <td><a class="btn btn-success" onClick="getpayment('<?php echo $employee_id; ?>','<?php echo $netsalary; ?>');" >PaymentEntry</a></td>
            <td><a class='icon-remove' title="Delete" onclick='funDel(<?php echo $salary_id; ?>);' style='cursor:pointer'></a>
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
<!-- Modal -->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="payModal">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">Payment Entry</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <table class="table table-condensed table-bordered">
            <tr> 
            <th colspan="2">Net Amount<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
           <td colspan="2"> <input type="text" name="netsalary" id="bnetsalary" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus/></td></tr>
            <tr> 
            <th>Amount<span style="color:#F00;">*</span></th>
            <th>Date<span style="color:#F00;"> * </span> </th>
            </tr>
            <tr>
           <td> <input type="text" name="paid_amt" id="paid_amt" placeholder="Enter Amount" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus/>
            <input type="hidden" name="employee_id" id="bemployee_id" value="<?php echo $employee_id; ?>" /></td> 
          <td><input type="text" name="paid_date" id="paid_date" placeholder="dd-mm-yyyy" class="input-xxlarge" value="<?php echo $paid_date; ?>"  style="width:80%;" autocomplete="off" autofocus/></td>
          </tr>
            <tr> 
            <th>Payment Type<span style="color:#F00;">*</span></th> 
            <th>NEFT No / CHEQUE No / TRANSACTION ID</th>
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
          </td>
            <td> <input type="text" name="id_no" id="id_no" value="<?php echo $id_no; ?>" class="input-xxlarge" style="width:200px;" placeholder="Enter ID NO."></td> 
            </tr>
            
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_payment_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div>  
 
 
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

function getpayment(employee_id,netsalary,paid_date) {

     jQuery('#payModal').modal('show');
     jQuery("#bemployee_id").val(employee_id);
     jQuery("#bnetsalary").val(netsalary);
     jQuery("#paid_date").val(paid_date);
     
    
}

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
<script type="text/javascript">
  
  function save_payment_data()
  {

  var employee_id = document.getElementById('bemployee_id').value;
  var paid_date = document.getElementById('paid_date').value;
  var id_no = document.getElementById('id_no').value;
  var paymode = document.getElementById('paymode').value;
  var paid_amt = document.getElementById('paid_amt').value;


   if(paid_amt == "")
    {
      alert('Please Fill Amount');
      return false;
    }

    if(paid_date == "")
    {
      alert('Please Fill Date');
      return false;
    }
    
    if(paymode == "")
    {
      alert('Please Fill Payment Mode');
      return false;
    }

    if(id_no == "")
    {
      alert('Please Fill Transaction Id');
      return false;
    }
  
    else
    {
     jQuery.ajax({
        type: 'POST',
        url: 'save_payment.php',
        data: 'employee_id='+employee_id+'&paid_date='+paid_date+'&id_no='+id_no+'&paymode='+paymode+'&paid_amt='+paid_amt,
        dataType: 'html',
        success: function(data){
                 //alert(data);

        // jQuery("#employee_id").val('');
        // jQuery("#paid_date").val('');
        // jQuery("#id_no").val('');
        // jQuery("#paymode").val('');
        // jQuery("#paid_amt").val('');
        jQuery("#payModal").modal('hide');
        location = 'employee_salary_1.php';
                 }
                 
             });//ajax close
  }
  //alert("Your Payment Save successfully!");
}

jQuery('#paid_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#paid_date').focus();
</script>
        
</body>
</html>
