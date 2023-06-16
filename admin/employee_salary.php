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
if(isset($_GET['salary_id']))
$keyvalue = $_GET['salary_id'];
else
$keyvalue = 0;

if(isset($_GET['msg']))
$msg = addslashes(trim($_GET['msg']));
else
$msg = "";


$basic_salary = $present = $days = $presentdays = $netsalary = $employee_id = $absentdays = $cl = $no_of_holiday = "";
$paydate = date('d-m-Y');

if(isset($_GET['s_sessionid']))
{
  $s_sessionid = trim(addslashes($_GET['s_sessionid']));  
  
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
  // $count = $obj->getvalfield("m_employee","count(*)","employee_id = '$employee_id'");
  // //print_r($count);die();
  // if ($count=0) {
    
  // }
  // else
  $searh_year_month = $year.'-'.$month;
  $employee_id = trim(addslashes($_GET['employee_id']));  
  $basic_salary = $obj->getvalfield("m_employee","basic_salary","employee_id='$employee_id'");
 

  $presentday_arr = $obj->executequery("select count(distinct(emp_attendance_date)) from emp_attendance_entry  where employee_id='$employee_id' and DATE_FORMAT(emp_attendance_date,'%Y-%m') = '$searh_year_month' group by emp_attendance_date");
    $present = sizeof($presentday_arr);
   
  $tot_amt = $basic_salary / $days;
 
    
  $no_of_holiday = $obj->getvalfield("m_holiday","count(holiday_date)","DATE_FORMAT(holiday_date,'%Y-%m')='$searh_year_month'");
  $count_sunday = $obj->total_sundays($month,$year);
  $sumholiday = $no_of_holiday + $count_sunday;
  //$presentdays =  $presentday + $sumholiday;
   $netamttot_day = $present + $sumholiday;
   $netsalary = round($tot_amt) * $netamttot_day;
   $absent = $days - $present - $sumholiday;
  $presentdays =  $days - $absent;
}
else
$employee_id = 0;

if(isset($_POST['submit']))
{ //print_r($_POST); die;
  
   $no_of_holiday = $obj->test_input($_POST['no_of_holiday']);
   $employee_id = $obj->test_input($_POST['employee_id']);
   $month = $obj->test_input($_POST['month']);
   $year = $obj->test_input($_POST['year']);
   $paydate = $obj->dateformatusa($_POST['paydate']);
   $basic_salary = $obj->test_input($_POST['basic_salary']);
   $days = $obj->test_input($_POST['days']);
   $presentdays = $obj->test_input($_POST['presentdays']);
   $absentdays = $obj->test_input($_POST['absentdays']);
   $cl = $obj->test_input($_POST['cl']);
   $netsalary = $obj->test_input($_POST['netsalary']);
   $count = $obj->getvalfield("emp_salary","count(*)","employee_id = '$employee_id' and month='$month' and year='$year'");
 if($count > 0)
 {
  $msg = "Salary All Ready Generated!";
 }
  else{


       if($keyvalue == 0)
        {    
        $form_data = array('employee_id'=>$employee_id,'month'=>$month,'year'=>$year,'paydate'=>$paydate,'basic_salary'=>$basic_salary,'days'=>$days,'presentdays'=>$presentdays,'absentdays'=>$absentdays,'cl'=>$cl,'netsalary'=>$netsalary,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'no_of_holiday'=>$no_of_holiday);
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
  $absentdays = $sqledit['absentdays'];
  $cl = $sqledit['cl'];
  $netsalary = $sqledit['netsalary'];
 
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
                  <th style="width: 100px;">Month:</th>
                  <th style="width: 100px;">Year:</th>
                  <th>Payment Date:</th>
                </tr>
                <tr>

                  <td>
                    <select name="employee_id" id="employee_id" style="width:285px;" class="chzn-select">
                                <option value="" >---Select---</option>
                               <?php
                                    $slno=1;
                                    $res = $obj->executequery("select * from m_employee where status='0'");
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
                      <option value="01">JAN</option>
                      <option value="02">FEB</option>
                      <option value="03">MARCH</option>
                      <option value="04">APRIL</option>
                      <option value="05">MAY</option>
                      <option value="06">JUNE</option>
                      <option value="07">JULY</option>
                      <option value="08">AUG</option>
                      <option value="09">SEP</option>
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
                     <option value="2021">2021</option>
                   </select>
                   <script>document.getElementById('year').value = '<?php echo $year ; ?>' ;</script>
                 </td> 
                 <td>
                   <input type="text" name="paydate" id="paydate" value="<?php echo $paydate; ?>" class="input-xxlarge" style="width:200px;">
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
                <th>No. Of Holiday / Sunday</th>
                <th>Absent</th>
                <th>CL</th>
                <th>Present</th>
                <th>Net Salary</th>
              </tr>
              <tr>

                <td><input type="text" name="basic_salary" id="basic_salary" placeholder="Basic Salary" value="<?php echo $basic_salary; ?>" onkeyup="settotal()" style="width:120px;" readonly></td>

                <td><input type="text" name="days" id="days" placeholder="totalday" value="<?php echo $days; ?>" style="width:120px;" onkeyup="settotal()" readonly></td>

                <td><input type="text" name="no_of_holiday" id="no_of_holiday" placeholder="No. Of Holiday" value="<?php echo $sumholiday;?>" onkeyup="settotal()" style="width:120px;" readonly></td>
                
                <td><input type="text" name="absentdays" id="absentdays" placeholder="Absent" value="0" onkeyup="settotal()" style="width:60px;" ></td>
                
                <td><input type="text" name="cl" id="cl" placeholder="CL" value="<?php echo $cl;?>" style="width:60px;" ></td>
              
                <td><input type="text" name="presentdays" id="presentdays" placeholder="presentdays" value="<?php echo $presentdays;?>" style="width:60px;" onkeyup="settotal()"></td>

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
              <th>Employee Name</th>
              <th>Month/Year</th>
              <th>Payment Date</th>
              <th>Month_Days</th>
              <th>Present</th>
              <th>Absent</th>
              <th>CL</th>
              <th style="text-align: right;">Basic Salary</th>
              <th style="text-align: right;">Net Salary</th>
              <th style="text-align: center;" class="head0">Print</th>
              <?php $chkdel = $obj->check_delBtn("employee_salary.php",$loginid);             

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
          $sql = "select * from emp_salary where employee_id = '$employee_id' order by salary_id desc";
          $res = $obj->executequery($sql);
          foreach($res as $row_get)
          {  
            //print_r($row_get);die;
            $salary_id = $row_get['salary_id'];
            $netsalary = $row_get['netsalary'];
            $employee_id = $row_get['employee_id'];
            $emp_name = $obj->getvalfield("m_employee","emp_name","employee_id='$employee_id'");
            $advance_amount = $obj->getvalfield("emp_advance","sum(amount)","employee_id='$employee_id'");
            $paid_amt = $obj->getvalfield("emp_salary","netsalary","employee_id='$employee_id'");
            $payment_date = date('d-m-Y');
            $balance = $netsalary - $paid_amt - $advance_amount;

           ?> 
           <tr>

             <td><?php echo $slno++; ?></td> 
             <td><?php echo $emp_name; ?></td>
             <td><?php echo $row_get['month']." / ".$row_get['year']; ?></td>
             <td><?php echo $obj->dateformatindia($row_get['paydate']); ?></td>
             <td><?php echo $row_get['days']; ?></td>
             <td><?php echo $row_get['presentdays']; ?></td>
             <td><?php echo $row_get['absentdays']; ?></td>
             <td><?php echo $row_get['cl']; ?></td>
             <td style="text-align: right;"><?php echo number_format($row_get['basic_salary'],2); ?></td>
             <td style="text-align: right;"><?php echo number_format($row_get['netsalary'],2); ?></td>
             <td style="text-align: center;"><a class="btn btn-danger" href="pdf_emp_salary1.php?salary_id=<?php echo $salary_id; ?>" target="_blank">Print</a></td>
             <?php  if($chkdel == 1 || $loginid == 1){  ?>
            <td><a class='icon-remove' title="Delete" onclick='funDel(<?php echo $salary_id; ?>);' style='cursor:pointer'></a>
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
<!-- Modal -->
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
    // month = '<?php //echo $month; ?>';
    // year = '<?php //echo $year; ?>';
    // paydate = '<?php //echo $paydate; ?>';
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
           location='<?php echo $pagename."?action=3&month=$month&year=$year&paydate=$paydate" ; ?>';
        }
        
        });//ajax close
    }//confirm close
  } //fun close

function settotal()
{

  var basic_salary=parseFloat(jQuery('#basic_salary').val()); 
  var days=parseFloat(jQuery('#days').val()); 
  var no_of_holiday=parseFloat(jQuery('#no_of_holiday').val()); 
  var absentdays = parseFloat(jQuery('#absentdays').val());
 
    var presentdays = days - absentdays;

  
//alert(presentdays);
  if(!isNaN(basic_salary) && !isNaN(days) && !isNaN(presentdays))
  {
    totdays = basic_salary/days;
    netsalary = totdays*presentdays;
  } 
  jQuery('#presentdays').val(presentdays);
  jQuery('#netsalary').val(netsalary.toFixed(2));
} 
</script>
</body>
</html>
