 <?php include("../adminsession.php");
//print_r($_SESSION);die;
 $pagename = "employee_salary.php";
 $module = "Employee Salary";
 $submodule = "Employee Salary";
 $btn_name = "Save";
 $keyvalue =0 ;
 $tblname = "m_employee";
 $tblpkey = "employee_id";
//$crit = " where 1 = 1 ";
$basic_salary = $present = "";

 if(isset($_GET['employee_id']))
 {
  $employee_id = trim(addslashes($_GET['employee_id']));  
  //$crit .=" and m_employee.employee_id='$employee_id' "; 
}
else
  $employee_id = 0;

if(isset($_GET['s_sessionid']))
{
  $s_sessionid = trim(addslashes($_GET['s_sessionid']));  
  //$crit .=" and class_transfer.sessionid='$s_sessionid' "; 
}
else
  $s_sessionid = 0;

if (isset($_GET['search']))
{
    //print_r($_GET);die;
    //$employeeid = trim(addslashes($_GET['employee_id']));
    //$basic_salary = $obj->getvalfield("m_employee","basic_salary","employee_id='$employeeid'");
    $month = $_GET['month'];
    $year = $_GET['year'];
    $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);

    //$emp_attendance_date = $obj->getvalfield("emp_attendance_entry ","emp_attendance_date","employee_id='$employeeid'");
   
    //echo $d; die;
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
                  <th>Date:</th>
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
                    <select class="chzn-select" name="month" id="month" style="width:100px;">
                      <option value="">--Select--</option>
                      <option value="1">JAN</option>
                      <option value="2">FAB</option>
                      <option value="3">MAR</option>
                      <option value="4">APRL</option>
                      <option value="5">MAY</option>
                      <option value="6">JUN</option>
                      <option value="7">JLY</option>
                      <option value="8">AUG</option>
                      <option value="9">SEP</option>
                      <option value="10">OCT</option> 
                      <option value="11">NOV</option>
                      <option value="12">DEC</option>

                    </select>
                  </td>

                  <td>
                   <select class="chzn-select" name="year" id="year" style="width:100px;">
                     <option value="">--Select--</option>
                     <option value="1">2018</option>
                     <option value="2">2019</option>
                     <option value="3">2020</option>
                   </select>
                 </td>  

                 <td>
                   <input type="text" name="date" id="date" class="input-xxlarge" style="width:120px;">
                 </td>  
               
              
                 <td colspan="4"><input type="submit" name="search" class="btn btn-success" value="Search">
                  <a href="employee_salary.php" class="btn btn-success">Reset</a></td>
                 </tr>
               </table>
             <div>
             </form>
             <br>
         <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="simple-html-invoice/simple-html-invoice-template-master/pdf_all_student_reg_report.php?class_id=<?php echo $class_id; ?>&s_sessionid=<?php echo $s_sessionid; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>
          
          
          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
        </p> -->
        
        <P>
          <form action="" method="post">
            <table class="table table-bordered table-condensed">
              <tr>
                <th>Total Days</th>
                <th>Present</th>
                <th>Basic Salary</th>
                <th>Net Salary</th>
              </tr>
              <tr>
                <td><input type="text" name="day" placeholder="totalday" value="<?php $d; ?>" style="width:120px;"></td>
              
                <td><input type="text" name="present" placeholder="present" value="<?php echo $present;?>" style="width:120px;" ></td>

                <td><input type="text" name="basic" placeholder="Basic Salary" value="<?php echo $basic_salary; ?>" style="width:120px;"></td>
                <td><input type="text" name="netsalary" placeholder="Net Salary" style="width:120px;"></td>
              
                <td colspan="4"><input type="submit" name="save" value="Save" class="btn btn-primary"></td>
              </tr>
            </table>
          </form>
        </P>

        <?php if($employee_id!='' && $s_sessionid!='')
        {

         ?>

         <hr>
         <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
         
         <table class="table table-bordered" id="tblData">
          <thead>
            <tr>
              <th>S.No.</th>
              <th style="text-align: center;">Student_name</th>
              <th style="text-align: center;">Father Name</th> 
              <th style="text-align: center;">Admission Year</th>
              <th style="text-align: center;">Class Name</th>
              <th style="text-align: center;">Enrollment No</th>
              <th style="text-align: center;">Gender</th>
              <th style="text-align: center;">Mobile No</th>
              <!-- <th class="head0">Action</th> -->
            </tr>
          </thead>
          <tbody id="record">
          </span>
          <?php
          $slno = 1;
          $totalqty = 0;
          
          
          $sql = "select * from class_transfer left join m_student_reg
          on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit";
          $res = $obj->executequery($sql);
          foreach($res as $row_get)
          {  
           $m_student_reg_id = $row_get['m_student_reg_id'];
           $stu_name = $row_get['stu_name'];
           $class_id=$row_get['class_id'];
           $class_name=$obj->getvalfield("m_class","class_name","class_id=$class_id");
           $father_name = $row_get['father_name'];
           $enrollment = $row_get['enrollment'];
           $gender = $row_get['gender'];
           $mobile = $row_get['mobile'];
           $admission_year = $row_get['admission_year'];

           ?> 
           <tr>

             <td><?php echo $slno++; ?></td> 
             <td style="text-align: center;"><?php echo $stu_name; ?></td>
             <td style="text-align: center;"><?php echo $father_name; ?></td>
             <td style="text-align: center;"><?php echo $admission_year; ?></td>
             <td style="text-align: center;"><?php echo $class_name; ?></td>
             <td style="text-align: center;"><?php echo $enrollment; ?></td>
             <td style="text-align: center;"><?php echo $gender; ?></td>
             <td style="text-align: center;"><?php echo $mobile; ?></td>
             <!-- <td><a class="btn btn-danger" href="simple-html-invoice/simple-html-invoice-template-master/pdf_viewadmission.php?m_student_reg_id=<?php echo $row_get['m_student_reg_id']; ?>" target="_blank">Print</a></td>  -->
           </tr>
           <?php
                           // $totalqty += $row_get['paid_amt'];
         }
         ?>
       </tbody>
     </table>
   <?php } ?>
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
