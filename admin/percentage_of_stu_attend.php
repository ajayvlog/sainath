<?php include("../adminsession.php");
$pagename = "percentage_of_stu_attend.php";
$module = "Manual Attendance";
$submodule = "% Of Student Report";
$btn_name = "Search";
$keyvalue = 0;
$tblname = "attendance_entry";
$tblpkey = "attendance_id";

if (isset($_GET['attendance_id']))
  $keyvalue = $_GET['attendance_id'];
else
  $keyvalue = 0;

if (isset($_GET['action']))
  $action = $obj->test_input($_GET['action']);
else
  $action = "";

$month = "";
$class_id = "";
$sem_id = "";
$year = "";
$year_month = "";

$crit1 = " 1 = 1 ";
$crit2 = " where 1 = 1";

if (isset($_GET['month']) && isset($_GET['year'])) {
  $month = $obj->test_input($_GET['month']);
  $year = $obj->test_input($_GET['year']);
  $year_month = $year . '-' . $month;
  $crit1 .= " and DATE_FORMAT(attendance_date,'%Y-%m')='$year_month' ";
}

if (isset($_GET['class_id']) || $class_id != '') {
  $class_id = $obj->test_input($_GET['class_id']);
  $crit2 .= " and B.class_id='$class_id' ";
}

if (isset($_GET['sem_id']) || $sem_id != '') {
  $sem_id = $obj->test_input($_GET['sem_id']);
  $crit2 .= " and A.sem_id='$sem_id' ";
}


// $no_of_holiday = $obj->getvalfield("m_holiday", "count(holiday_date)", "DATE_FORMAT(holiday_date,'%Y-%m')='$year_month'", 1);
$holiday_date = $obj->executequery("select distinct holiday_date from m_holiday where DATE_FORMAT(holiday_date,'%Y-%m')='$year_month'");
$no_of_holiday = sizeof($holiday_date);
// $pday = $obj->getvalfield("attendance_entry", "distinct(attendance_date)", "$crit1 and transferid='$transferid' and WEEKDAY(attendance_date) <> 6");
// print_r($pday);
// die;

if ($month != '' && $year != '') {
  $sunday_date = $obj->total_sunday_dates($month, $year);
  //print_r($sunday_date);die;
  $count_sunday = sizeof($sunday_date);
  // die;
} else
  $count_sunday = 0;
?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        <div class="contentinner">
          <?php include("../include/alerts.php"); ?>
          <!--widgetcontent-->
          <div class="widgetcontent  shadowed nopadding">
            <form class="stdform stdform2" method="get" action="">

              <div class="lg-12 md-12 sm-12">
                <table class="table table-bordered">
                  <tr>
                    <th width="22%">Month</th>
                    <th width="22%">Year</th>
                    <th width="22%">Course Name</th>
                    <th width="31%">Sem/Year </th>
                    <!-- <th width="31%">Action </th> -->
                  </tr>
                  <tr>
                    <td>
                      <select name="month" id="month" class="chzn-select" style="width: 200px;">
                        <option value="">-select-</option>
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

                      <script>
                        document.getElementById("month").value = "<?php echo $month; ?>";
                      </script>
                    </td>
                    <td>
                      <select name="year" id="year" class="chzn-select" style="width: 200px;">
                        <option value="">-select-</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                      </select>
                      <script>
                        document.getElementById("year").value = "<?php echo $year; ?>";
                      </script>
                    </td>
                    <td>
                      <select name="class_id" id="class_id" class="chzn-select" style="width:200px;">
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
                        document.getElementById("class_id").value = "<?php echo $class_id; ?>";
                      </script>
                    </td>

                    <td>
                      <select name="sem_id" id="sem_id" class="chzn-select" style="width:200px;">
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
                        document.getElementById("sem_id").value = "<?php echo $sem_id; ?>";
                      </script>

                    </td>
                  </tr>

                  <tr>
                    <td colspan="4">
                      <center><button type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster(''); ">
                          <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>" name="reset" id="reset" class="btn btn-success">Reset</a>
                      </center>

                    </td>
                  </tr>
                </table>
            </form>
          </div>

        </div>
        <?php if ($class_id > 0 and $sem_id > 0) {
        ?>
          <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_percen_stu_attend_report.php?month=<?php echo $month; ?>&year=<?php echo $year; ?>&class_id=<?php echo $class_id; ?>&sem_id=<?php echo $sem_id; ?>" class="btn btn-info" target="_blank">

              <span style="#000; color:#FFF">Print PDF</span></a></p>

          <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>

          <table class="table table-bordered" id="myTable1">
            <colgroup>
              <col class="con0" style="align: center; width: 4%" />
              <col class="con1" />
              <col class="con0" />
              <col class="con1" />
              <col class="con0" />
              <col class="con1" />
            </colgroup>
            <thead>
              <tr>

                <th class="head0 nosort">S.No.</th>
                <th class="head0">Student Name</th>
                <th class="head0">Biometric Code</th>
                <th class="head0">Father's Name</th>
                <th class="head0">Mobile</th>
                <th class="head0">Month_Day</th>
                <th class="head0">Present</th>
                <th class="head0">Holiday</th>
                <th class="head0">Sunday</th>
                <th class="head0">Attendance(%)</th>

              </tr>
            </thead>
            <tbody>
            
              <?php
              $slno = 1;
           
              $res = $obj->executequery("select * from class_transfer as A left join m_student_reg as B on A.m_student_reg_id=B.m_student_reg_id $crit2 and A.sessionid = '$sessionid'");
              foreach ($res as $rowget) {
                $transferid = $rowget['transferid'];
                $m_student_reg_id = $rowget['m_student_reg_id'];
                $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id=$m_student_reg_id");
                $biometric_code = $obj->getvalfield("m_student_reg", "biometric_code", "m_student_reg_id=$m_student_reg_id");
                $father_name = $obj->getvalfield("m_student_reg", "father_name", "m_student_reg_id=$m_student_reg_id");
                $mobile = $obj->getvalfield("m_student_reg", "mobile", "m_student_reg_id=$m_student_reg_id");

                //echo "select count(distinct(transferidIndex)) as pday from attendance_entry  $crit1 and transferid='$transferid'";die;

                //$res1 = $obj->executequery("select count(distinct(transferid)) as pday from attendance_entry where  $crit1 and transferid='$transferid' group by transferid,attendance_date");

                //echo "select * from attendance_entry where $crit1 and transferid='$transferid'";
                //die;
                $pday_date = $obj->executequery("select distinct attendance_date from attendance_entry where $crit1 and transferid='$transferid' and WEEKDAY(attendance_date) <> 6");
                $pday = sizeof($pday_date);
               // foreach ($pday_date as $pday_date1) {
                  $pday_date1 = $pday_date;
               // }

               $tot_pday = array_merge($pday_date, $sunday_date, $holiday_date);
              // $tot_pday = array_unique(array_merge($pday_date, $sunday_date, $holiday_date));
                
               /* $tot_pday = $tot_pday1 + $tot_pday2;*/
                // print_r($tot_pday);
                // die;

                $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                // $tot_pday = $pday + $no_of_holiday + $count_sunday;
                $tot_percen_stu = round(($tot_pday / $month_days) * 100);


              ?>
                <tr>
                  <td><?php echo $slno++; ?></td>
                  <td><a href="pdf_stuattend_report.php?month=<?php echo $month; ?>&year=<?php echo $year; ?>&transferid=<?php echo $transferid; ?>&class_id=<?php echo $class_id; ?>&sem_id=<?php echo $sem_id; ?>" target="_blank"><?php echo $stu_name . ' /' . $transferid; ?></a></td>
                  <td><?php echo $biometric_code; ?></td>
                  <td><?php echo $father_name; ?></td>
                  <td><?php echo $mobile; ?></td>
                  <td><?php echo $month_days; ?></td>
                  <td><?php echo $pday; ?></td>
                  <td><?php echo $no_of_holiday; ?></td>
                  <td><?php echo $count_sunday; ?></td>
                  <td><?php echo round($tot_percen_stu); ?>%</td>
                </tr>
              <?php
              } //inner loop
              ?>

            </tbody>
          </table>

        <?php
        }
        ?>

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

  <script>
    function funDel(id) { //alert(id);   
      tblname = '<?php echo $tblname; ?>';
      tblpkey = '<?php echo $tblpkey; ?>';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';
      //alert(module); 
      if (confirm("Are you sure! You want to delete this record.")) {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax/delete_master.php',
          data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
          dataType: 'html',
          success: function(data) {
            // alert(data);
            location = '<?php echo $pagename . "?action=3"; ?>';
          }

        }); //ajax close
      } //confirm close
    } //fun close
  </script>
</body>

</html>