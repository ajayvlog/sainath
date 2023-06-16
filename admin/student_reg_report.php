<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "student_reg_report.php";
$module = "Student Registration Report ";
$submodule = "Student Registration Report";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "m_student_reg";
$tblpkey = "m_student_reg_id";
$crit = " where 1 = 1 ";
$counselor_name = "";
if (isset($_GET['class_id'])) {
  $class_id = trim(addslashes($_GET['class_id']));
  if ($class_id != "") {
    $crit .= " and m_student_reg.class_id='$class_id' ";
    $class_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
  } else
    $class_name = "";
} else
  $class_id = 0;

if (isset($_GET['s_sessionid'])) {
  $s_sessionid = trim(addslashes($_GET['s_sessionid']));
  if ($s_sessionid != "") {
    $crit .= " and class_transfer.sessionid='$s_sessionid' ";
    $session_name_s = $obj->getvalfield("m_session", "session_name", "sessionid='$s_sessionid'");
  } else
    $session_name_s = "";
} else
  $s_sessionid = 0;


if (isset($_GET['sem_id'])) {
  $sem_id = trim(addslashes($_GET['sem_id']));
  if ($sem_id != "") {
    $crit .= " and class_transfer.sem_id='$sem_id' ";
    $sem_name = $obj->getvalfield("m_semester", "sem_name", "sem_id='$sem_id'");
  } else
    $sem_name = "";
} else
  $sem_id = 0;


if (isset($_GET['con_id'])) {
  $con_id = trim(addslashes($_GET['con_id']));
  if ($con_id != "") {
    $crit .= " and m_student_reg.con_id='$con_id' ";
    $counselor_name = $obj->getvalfield("counselor_master", "counselor_name", "con_id='$con_id'");
  } else
    $counselor_name = "";
} else
  $con_id = 0;

if (isset($_GET['district'])) {
  $district = trim(addslashes($_GET['district']));
  if ($district != "") {
    // $crit .=" and m_student_reg.district like '%$district%' "; 
    $crit .= " and m_student_reg.district='$district' ";
    $dis_name = $obj->getvalfield("m_district", "dis_name", "dis_id='$district'");
  } else
    $dis_name = "";
} else
  $district = "";

if (isset($_GET['category_id'])) {
  $category_id = trim(addslashes($_GET['category_id']));
  if ($category_id != "") {
    // $crit .=" and m_student_reg.category_id like '%$category_id%' "; 
    $crit .= " and m_student_reg.category_id='$category_id' ";
    $cat_name = $obj->getvalfield("m_category", "cat_name", "category_id='$category_id'");
  } else
    $cat_name = "";
} else
  $district = "";

if (isset($_GET['status'])) {
  $status = trim(addslashes($_GET['status']));
  $crit .= " and m_student_reg.status like '%$status%' ";
  //$status = $obj->getvalfield("m_student_reg","status","status='$status'");

}
//else
//$status = "";


?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
  <style type="text/css">
    .anyClass {
      height: 150px;
      overflow-y: scroll;
    }
  </style>
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
                <th>Class Name:</th>
                <th>Semester</th>
                <th>Session Name:</th>
                <th>Counselor Name</th>
                <th>District Name</th>
                <th>Category</th>
                <th>Status</th>
              </tr>
              <tr>


                <td>
                  <select name="class_id" id="class_id" style="width:150px;" class="chzn-select">
                    <option value="">-select-</option>
                    <?php

                    $res = $obj->fetch_record("m_class");
                    foreach ($res as $row) {
                    ?>
                      <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <script>
                    document.getElementById('class_id').value = '<?php echo $class_id; ?>';
                  </script>
                </td>
                <td>
                  <select name="sem_id" id="sem_id" style="width:150px;" class="chzn-select">
                    <option value="">-select-</option>
                    <?php
                    $res = $obj->fetch_record("m_semester");
                    foreach ($res as $row) {
                    ?>
                      <option value="<?php echo $row['sem_id']; ?>"><?php echo $row['sem_name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <script>
                    document.getElementById('sem_id').value = '<?php echo $sem_id; ?>';
                  </script>
                </td>

                <td>
                  <select name="s_sessionid" id="s_sessionid" style="width:150px;" class="chzn-select">
                    <option value="">-select-</option>
                    <?php

                    $res = $obj->fetch_record("m_session");
                    foreach ($res as $row) {
                    ?>
                      <option value="<?php echo $row['sessionid']; ?>"><?php echo $row['session_name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <script>
                    document.getElementById('s_sessionid').value = '<?php echo $s_sessionid; ?>';
                  </script>
                </td>

                <td>
                  <select name="con_id" id="con_id" style="width:150px;" class="chzn-select">
                    <option value="">-select-</option>
                    <?php

                    $res = $obj->fetch_record("counselor_master");
                    foreach ($res as $row) {
                    ?>
                      <option value="<?php echo $row['con_id']; ?>"><?php echo $row['counselor_name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <script>
                    document.getElementById('con_id').value = '<?php echo $con_id; ?>';
                  </script>
                </td>

                <td>
                  <select name="district" id="district" style="width:150px;" class="chzn-select">
                    <option value="">-select-</option>
                    <?php

                    $res = $obj->executequery("select * from m_district");
                    foreach ($res as $row) {
                      //$district=$obj->getvalfield("m_student_reg","count(distinct(district))","1=1");
                    ?>
                      <option value="<?php echo $row['dis_id']; ?>"><?php echo $row['dis_name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <script>
                    document.getElementById('district').value = '<?php echo $district; ?>';
                  </script>
                </td>
                <td>
                  <select name="category_id" id="category_id" style="width:150px;" class="chzn-select">
                    <option value="">-select-</option>
                    <?php

                    $res = $obj->executequery("select * from m_category");
                    foreach ($res as $row) {
                      //$category_id=$obj->getvalfield("m_student_reg","count(distinct(category_id))","1=1");
                    ?>
                      <option value="<?php echo $row['category_id']; ?>"><?php echo $row['cat_name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <script>
                    document.getElementById('category_id').value = '<?php echo $category_id; ?>';
                  </script>
                </td>

                <td>
                  <select name="status" id="status" style="width:150px;" class="chzn-select">
                    <option value="">--Select--</option>
                    <option value="0">Enable</option>
                    <option value="1">Disable</option>
                  </select>
                  <script>
                    document.getElementById('status').value = '<?php echo $status; ?>';
                  </script>
                </td>
              </tr>
              <tr>

                <td colspan="7"><input type="submit" name="search" class="btn btn-success" value="Search">&nbsp;&nbsp;
                  <a href="student_reg_report.php" class="btn btn-success">Reset</a>
                </td>
              </tr>
            </table>
            <div>
          </form>
          <br>


          <?php if ($class_id != '' && $s_sessionid != '') {

          ?>
            <p align="right" style="margin-top:7px; margin-right:10px;">
              <!-- <a href="simple-html-invoice/simple-html-invoice-template-master/pdf_all_student_reg_report.php?class_id=<?php //echo $class_id; 
                                                                                                                            ?>&s_sessionid=<?php //echo $s_sessionid; 
                                                                                                                                            ?>&con_id=<?php //echo $con_id; 
                                                                                                                                                      ?>&sem_id=<?php //echo $sem_id; 
                                                                                                                                                                ?>&district=<?php //echo $district; 
                                                                                                                                                                            ?>" class="btn btn-info" target="_blank">
                    <span style="#000; color:#FFF">Print PDF</span></a> -->


              <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
            </p>
            <hr>
            <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
            <div style="overflow-x:auto;">
              <table class="table table-bordered" id="tblData">
                <thead>
                  <tr>
                    <th colspan="8">Studnet Report For:- <?php echo $class_name . " ($sem_name) / $session_name_s / $counselor_name / $dis_name / $cat_name"; ?></th>
                  </tr>
                  <tr>
                    <th>S.No.</th>
                    <th style="text-align: center;">Student_name</th>
                    <th style="text-align: center;">Biometric_Code</th>
                    <th style="text-align: center;">Admission Year</th>
                    <th style="text-align: center;">Class Name</th>
                    <th style="text-align: center;">Counselor Name</th>
                    <th style="text-align: center;">District Name</th>
                    <th style="text-align: center;">Gender</th>
                    <th style="text-align: center;">Mobile No1</th>
                    <th style="text-align: center;">Mobile No2</th>
                    <th style="text-align: center;">Semester Name</th>
                    <th style="text-align: center;">Enrollment No.</th>
                    <th style="text-align: center;">DOB</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Aadhar Card No</th>
                    <th style="text-align: center;">Category</th>
                    <th style="text-align: center;">Cast</th>
                    <th style="text-align: center;">Attendence Type</th>
                    <th style="text-align: center;">Correspondence Address</th>
                    <th style="text-align: center;">Pincode</th>
                    <th style="text-align: center;">Stu_Admission Date</th>
                    <th style="text-align: center;">Bank/Branch Name</th>
                    <th style="text-align: center;">IFSC Code</th>
                    <th style="text-align: center;">Bank Account No</th>
                    <th style="text-align: center;">Roll No</th>
                    <th style="text-align: center;">Remark</th>
                    <th style="text-align: center;">Father Name</th>
                    <th style="text-align: center;">Mother's Name</th>
                    <th style="text-align: center;">Parents Aadhar No</th>
                    <th style="text-align: center;">Annual Family Income</th>
                    <th style="text-align: center;">Parents Contact No</th>
                    <th style="text-align: center;">10th Board</th>
                    <th style="text-align: center;">10th Passing Year</th>
                    <th style="text-align: center;">10th Roll No.</th>
                    <th style="text-align: center;">10th Subject</th>
                    <th style="text-align: center;">10th Total Marks</th>
                    <th style="text-align: center;">10th Obtain Marks</th>
                    <th style="text-align: center;">12th Board</th>
                    <th style="text-align: center;">12th Passing Year</th>
                    <th style="text-align: center;">12th Roll No.</th>
                    <th style="text-align: center;">12th Subject</th>
                    <th style="text-align: center;">12th Total Marks</th>
                    <th style="text-align: center;">12th Obtain Marks</th>
                    <!-- <th class="head0">Action</th> -->
                  </tr>
                </thead>
                <tbody id="record">

                  <?php
                  $slno = 1;
                  $totalqty = 0;
                  $sql = "select * from class_transfer left join m_student_reg
                  on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit";
                  $res = $obj->executequery($sql);
                  foreach ($res as $row_get) {
                    $m_student_reg_id = $row_get['m_student_reg_id'];
                    $stu_name = $row_get['stu_name'];
                    $district = $row_get['district'];
                    $district_name = $obj->getvalfield("m_district", "dis_name", "dis_id='$district'");
                    $class_id = $row_get['class_id'];
                    $class_name = $obj->getvalfield("m_class", "class_name", "class_id=$class_id");
                    $con_id = $row_get['con_id'];
                    $counselor_name = $obj->getvalfield("counselor_master", "counselor_name", "con_id=$con_id");
                    $sem_id = $row_get['sem_id'];
                    $sem_name = $obj->getvalfield("m_semester", "sem_name", "sem_id=$sem_id");
                    $father_name = $row_get['father_name'];
                    $enrollment = $row_get['enrollment'];
                    $gender = $row_get['gender'];
                    $status = $row_get['status'];
                    $dob = $obj->dateformatindia($row_get['dob']);
                    $mobile = $row_get['mobile'];
                    $stu_mobile = $row_get['stu_mobile'];
                    $biometric_code = $row_get['biometric_code'];
                    $admission_year = $row_get['admission_year'];
                    $category_id = $row_get['category_id'];
                    $cat_name = $obj->getvalfield("m_category", "cat_name", "category_id=$category_id");
                    $admission_date = $obj->dateformatindia($row_get['admission_date']);
                    if ($status == "0") {
                      $status1 = "<span style='color: green;'>Enable</span>";
                    } else {
                      $status1 = "<span style='color: red;'>Disable</span>";
                    }
                  ?>
                    <tr>

                      <td><?php echo $slno++; ?></td>
                      <td style="text-align: center;"><?php echo $stu_name; ?></td>
                      <td style="text-align: center;"><?php echo $biometric_code; ?></td>
                      <td style="text-align: center;"><?php echo $admission_year; ?></td>
                      <td style="text-align: center;"><?php echo $class_name; ?></td>
                      <td style="text-align: center;"><?php echo $counselor_name; ?></td>
                      <td style="text-align: center;"><?php echo $district_name; ?></td>
                      <td style="text-align: center;"><?php echo $gender; ?></td>
                      <td style="text-align: center;"><?php echo $mobile; ?></td>
                      <td style="text-align: center;"><?php echo $stu_mobile; ?></td>
                      <td style="text-align: center;"><?php echo $sem_name; ?></td>
                      <td style="text-align: center;"><?php echo $enrollment; ?></td>
                      <td style="text-align: center;"><?php echo $dob; ?></td>
                      <td style="text-align: center;"><?php echo $status1; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['aadhar_no']; ?></td>
                      <td style="text-align: center;"><?php echo $cat_name; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['cast']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['atten_type']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['address']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['pincode']; ?></td>
                      <td style="text-align: center;"><?php echo $admission_date; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['bank_name']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['ifsc']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['account_no']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['rollno']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['remark']; ?></td>
                      <td style="text-align: center;"><?php echo $father_name; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['mother_name']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['parent_aadhar_no']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['f_income']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['parent_mobile']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['board_name_10']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['pass_year_10']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['roll_10']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['subject_10']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['tot_mark_10']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['obtain_mark_10']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['board_name_12']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['pass_year_12']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['roll_12']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['subject_12']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['tot_mark_12']; ?></td>
                      <td style="text-align: center;"><?php echo $row_get['obtain_mark_12']; ?></td>
                      <!-- <td><a class="btn btn-danger" href="simple-html-invoice/simple-html-invoice-template-master/pdf_viewadmission.php?m_student_reg_id=<?php //echo $row_get['m_student_reg_id']; 
                                                                                                                                                              ?>" target="_blank">Print</a></td>  -->
                    </tr>
                  <?php
                    // $totalqty += $row_get['paid_amt'];
                  }
                  ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
          <!--  <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php //echo number_format($totalqty,2); 
                                                                                              ?></h3></div>  -->
        </div>
      </div>
      <!--contentinner-->
    </div>
    <!--maincontent-->
  </div>
  <!--mainright-->
  <!-- END OF RIGHT PANEL -->

  <div class="clearfix"></div>
  <?php include("inc/footer.php"); ?>
  <!--footer-->

  </div>
  <!--mainwrapper-->

  <script type="text/javascript">
    function exportTableToExcel(tableID, filename = '') {
      var downloadLink;
      var dataType = 'application/vnd.ms-excel';
      var tableSelect = document.getElementById(tableID);
      var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

      // Specify file name
      filename = filename ? filename + '.xls' : 'excel_data.xls';

      // Create download link element
      downloadLink = document.createElement("a");

      document.body.appendChild(downloadLink);

      if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
      } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
      }
    }

    jQuery(document).ready(function() {

      jQuery('#menues').click();

    });
  </script>
</body>

</html>