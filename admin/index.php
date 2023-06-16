<?php include("../adminsession.php");
$pagename = "index.php";
$module = "Dashboard";
$submodule = "Dashboard";
$delivery_date = "";
$curr_date = date('Y-m-d');
//echo $curr_date; die;
//print_r($_SESSION);die;
$sessionid = $_SESSION['sessionid'];
$session_name = $obj->getvalfield("m_session", "session_name", "sessionid='$sessionid'");
$tot_student = $obj->getvalfield("class_transfer", "count(*)", "sessionid='$sessionid'");

$tot_enquiry = $obj->getvalfield("enquiry_master", "count(*)", "sessionid='$sessionid' and 1=1");
$tot_employee = $obj->getvalfield("m_employee", "count(*)", "1=1 and status=0");
$tot_hostler = $obj->getvalfield("transfer_hostel", "count(*)", "sessionid='$sessionid'");
$tot_expanse = $obj->getvalfield("expanse", "sum(exp_amount)", "exp_date='$curr_date' and type='expense'");
$tot_income = $obj->getvalfield("expanse", "sum(exp_amount)", "exp_date='$curr_date' and type='income'");

$session_name = $obj->getvalfield("m_session", "session_name", "status=1 and sessionid='$sessionid'");

if ($tot_expanse == "") {
  $tot_expanse = '0';
}
if ($tot_income == "") {
  $tot_income = '0';
}
$today_fee = $obj->getvalfield("fee_payment", "sum(paid_amt)", "pay_date = '$curr_date'");
if ($today_fee == "") {
  $today_fee = '0';
}

$bithday = date('m-d');
$tot_birthday = $obj->getvalfield("m_student_reg", "count(*)", "DATE_FORMAT(dob,'%m-%d')='$bithday'");

$bithday = date('m-d');
$tot_emp_birthday = $obj->getvalfield("m_employee", "count(*)", "DATE_FORMAT(dob,'%m-%d')='$bithday'");
$total_birth = $tot_birthday + $tot_emp_birthday;

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1'");
foreach ($res as $row_get) {
  $tot_session_stu = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and m_student_reg.status='0'");
foreach ($res as $row_get) {
  $tot_session_stuactive = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and m_student_reg.status='1'");
foreach ($res as $row_get) {
  $tot_session_stuinactive = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=1");
foreach ($res as $row_get) {
  $tot_dmlt = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=1 and m_student_reg.status='0'");
foreach ($res as $row_get) {
  $tot_dmltactive = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=1 and m_student_reg.status='1'");
foreach ($res as $row_get) {
  $tot_dmltinactive = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=2");
foreach ($res as $row_get) {
  $tot_bmlt = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=2 and m_student_reg.status='1'");
foreach ($res as $row_get) {
  $tot_bmltinactive = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=2 and m_student_reg.status='0'");
foreach ($res as $row_get) {
  $tot_bmltactive = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=3");
foreach ($res as $row_get) {
  $tot_ot_tech = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=3 and m_student_reg.status='0'");
foreach ($res as $row_get) {
  $tot_ot_techactive = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.admission_year='$session_name' and class_transfer.sem_id='1' and class_id=3 and m_student_reg.status='1'");
foreach ($res as $row_get) {
  $tot_ot_techinactive = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.status='0' and class_transfer.sessionid='$sessionid'");
foreach ($res as $row_get) {
  $tot_student_active = $row_get['total'];
}

$res = $obj->executequery("select count(*) as total from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where m_student_reg.status='1' and class_transfer.sessionid='$sessionid'");
foreach ($res as $row_get) {
  $tot_student_inactive = $row_get['total'];
}

?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <?php include("inc/top_files.php"); ?>

  <style>
    .thumbnail {
      padding: 15px;
    }

    .thumbnail img {
      width: 50px;
    }
  </style>

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
          <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Welcome!</strong> This alert needs your attention, but it's not super important.
          </div>
          <!--alert-->

          <div class="row-fluid">
            <div class="span12">
              <ul class="thumbnails">

                <li class="span3">
                  <a href="hostel_list.php" class="thumbnail" style="background: #faa61a36;">
                    <div class="row-fluid">
                      <div class="span8">
                        <h2><?php echo $tot_hostler; ?></h2>
                        <h6>Total Hosteller</h6>
                      </div>
                      <div class="span4">
                        <img src="images/member-icon.jpg" alt="Total Member">
                      </div>
                    </div>
                  </a>
                </li>

                <li class="span3">
                  <a href="employee_master.php" class="thumbnail" style="background: #faa61a36;">
                    <div class="row-fluid">
                      <div class="span8">
                        <h2><?php echo $tot_employee; ?></h2>
                        <h6>Total Employee</h6>
                      </div>
                      <div class="span4">
                        <img src="images/total-employee.png" alt="Total Member">
                      </div>
                    </div>
                  </a>
                </li>

                <li class="span3">
                  <a href="fee_report.php" class="thumbnail" style="background: #335ca71f;">
                    <div class="row-fluid">
                      <div class="span8">
                        <h2><?php echo $today_fee; ?></h2>
                        <h6>Today Fee</h6>
                      </div>
                      <div class="span4">
                        <img src="images/total-payment.png" alt="Total Member">
                      </div>
                    </div>
                  </a>
                </li>

                <li class="span3">
                  <a href="view_birthdaylist.php" class="thumbnail" style="background: #d5c29542;">
                    <div class="row-fluid">
                      <div class="span8">
                        <h2><?php echo $total_birth; ?></h2>
                        <h6>Today Birthday</h6>
                      </div>
                      <div class="span4">
                        <img src="images/bithday-icon.png" alt="Total Member">
                      </div>
                    </div>
                  </a>
                </li>
              </ul>

              <ul class="thumbnails">
                <li class="span3">
                  <a href="expanse_group_entry.php" class="thumbnail" style="background: #2b3b4e24;">
                    <div class="row-fluid">
                      <div class="span8">
                        <h2><?php echo $tot_expanse; ?></h2>
                        <h6>Today Expense</h6>
                      </div>
                      <div class="span4">
                        <img src="images/expenses-icon.png" alt="Total Member">
                      </div>
                    </div>
                  </a>
                </li>


                <!--  <li class="one_fifth"><a><small>&nbsp;</small><h1><span id="sms_bal_trans"></span></h1><strong>Credit SMS Balance</strong></a></li> -->

                <li class="span3">
                  <a href="income_group_entry.php" class="thumbnail" style="background: #1a80c32e;">
                    <div class="row-fluid">
                      <div class="span8">
                        <h2><?php echo $tot_income; ?></h2>
                        <h6>Today Income</h6>
                      </div>
                      <div class="span4">
                        <img src="images/rupee-sign.png" alt="Total Member">
                      </div>
                    </div>
                  </a>
                </li>

                <li class="span3">
                  <a href="enquiry_report.php" class="thumbnail" style="background: #ff453d29;">
                    <div class="row-fluid">
                      <div class="span8">
                        <h2><?php echo $tot_enquiry; ?></h2>
                        <h6>Total Enquiry</h6>
                      </div>
                      <div class="span4">
                        <img src="images/enquiry.png" alt="Total Member">
                      </div>
                    </div>
                  </a>
                </li>

                <li class="span3">
                  <a href="enquiry_report.php" class="thumbnail" style="background: #00947526;">
                    <div class="row-fluid">
                      <div class="span8">
                        <h2>0</h2>
                        <h6>SMS</h6>
                      </div>
                      <div class="span4">
                        <img src="images/sms.png" alt="Total Member">
                      </div>
                    </div>
                  </a>
                </li>

              </ul>

              <ul class="thumbnails">
                <li class="span6">
                  <a href="m_student_reg.php" class="thumbnail" style="background: #3978a326;">
                    <div class="row-fluid">
                      <div class="span4">
                        <h2><?php echo $tot_student; ?></h2>
                        <h6>Total Student</h6>
                      </div>
                      <div class="span4">
                        <h2><?php echo $tot_student_active; ?></h2>
                        <h6>Total Active</h6>
                      </div>
                      <div class="span4">
                        <h2><?php echo $tot_student_inactive; ?><h2>
                            <h6>Total Inactive</h6>
                      </div>
                    </div>
                  </a>
                </li>

                <li class="span6">
                  <a href="#" class="thumbnail" style="background: #d4dbb738;">
                    <div class="row-fluid">
                      <div class="span4">
                        <h2><?php echo $tot_session_stu; ?></h2>
                        <h6>student <?php echo $session_name; ?></h6>
                      </div>
                      <div class="span4">
                        <h2><?php echo $tot_session_stuactive; ?><h2>
                            <h6>Total Active</h6>
                      </div>
                      <div class="span4">
                        <h2><?php echo $tot_session_stuinactive; ?><h2>
                            <h6>Total Inactive</h6>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>

              <ul class="thumbnails">
                <li class="span6">
                  <a href="#" class="thumbnail" style="background: #c5797938;">
                    <div class="row-fluid">
                      <div class="span4">
                        <h2><?php echo $tot_dmlt; ?></h2>
                        <h6>Total D.M.L.T</h6>
                      </div>
                      <div class="span4">
                        <h2><?php echo $tot_dmltactive; ?><h2>
                            <h6>Total Active</h6>
                      </div>
                      <div class="span4">
                        <h2> <?php echo $tot_dmltinactive; ?><h2>
                            <h6>Total Inactive</h6>
                      </div>
                    </div>
                  </a>
                </li>

                <li class="span6">
                  <a href="#" class="thumbnail" style="background: #a07aa138;">
                    <div class="row-fluid">
                      <div class="span4">
                        <h2><?php echo $tot_bmlt; ?><h2>
                            <h6>Total B.M.L.T </h6>
                      </div>
                      <div class="span4">
                        <h2><?php echo $tot_bmltactive; ?><h2>
                            <h6>Total Active</h6>
                      </div>
                      <div class="span4">
                        <h2> <?php echo $tot_bmltinactive; ?><h2>
                            <h6>Total Inactive</h6>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
              <ul>
                <li class="span6">
                  <a href="#" class="thumbnail" style="background: #4f5e3238;">
                    <div class="row-fluid">
                      <div class="span4">
                        <h2><?php echo $tot_ot_tech; ?><h2>
                            <h6>Total O.T.TECH </h6>
                      </div>
                      <div class="span4">
                        <h2> <?php echo $tot_ot_techactive; ?><h2>
                            <h6>Total Active</h6>
                      </div>
                      <div class="span4">
                        <h2> <?php echo $tot_ot_techinactive; ?><h2>
                            <h6>Total Inactive</h6>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>

              </ul>
            </div>
            <!--span8-->
            <!--span4-->
          </div>

          <!--   graph -->
          <div class="maincontent">
            <div class="contentinner content-charts">

              <div class="row-fluid">
                <div class="span6">
                  <h4 class="widgettitle">Course Wise Student Chart</h4>
                  <div id="piechart" style="border: 1px solid #D3D3D3;"></div>

                </div>
                <div class="span6">
                  <h4 class="widgettitle">Session Wise Students Chart</h4>

                  <div id="chartContainer" style="height: 380px; width: 465px; border: 1px solid #D3D3D3;"></div>
                  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                </div>
              </div>
              <!--row-fluid-->




            </div>
          </div><!-- graph close -->
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
    jQuery(document).ready(function() {

      jQuery.ajax({
        type: 'POST',
        url: 'ajaxsms_trans.php',
        data: '',
        dataType: 'html',
        success: function(data) {
          //alert(data);
          jQuery("span#sms_bal_trans").html(parseInt(data));
          //jQuery('#sms_bal_trans').val(data);
        }


      });

    });
  </script>
  <?php
  $cour_arr = $obj->executequery("select * from m_class");
  if (sizeof($cour_arr) > 0) {
    foreach ($cour_arr as  $course) {
      $class_id = $course['class_id'];
      $class_name = $course['class_name'];

      $sql = "select count(*) as totalst  from class_transfer as A left join m_student_reg as B on A.m_student_reg_id = B.m_student_reg_id where class_id='$class_id' and A.sessionid='$sessionid'";
      $graphdata = $obj->executequery($sql);
      if (sizeof($graphdata) > 0) {
        foreach ($graphdata as $keydata) {
          $totalst = $keydata['totalst'];
        } //inner for each
      } else
        $totalst = 0;
      $arrayName[] = array('class_name' => $class_name, 'totalst' => $totalst);
    } //outer for each
  }
  //echo "<pre>";
  //print_r($arrayName);

  ?>


  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">
    // Load google charts
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        <?php
        if (sizeof($arrayName) > 0) {
          foreach ($arrayName as $grpinfo) {
        ?>['<?php echo $grpinfo['class_name']; ?>', <?php echo $grpinfo['totalst']; ?>],
        <?php
          } //for each close
        } //if close
        ?>
      ]);

      // Optional; add a title and set the width and height of the chart
      var options = {
        'title': 'My Average Day',
        'width': 465,
        'height': 380
      };

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
  </script>
  <?php
  $cour_arr1 = $obj->executequery("select * from m_session");
  if (sizeof($cour_arr1) > 0) {
    foreach ($cour_arr1 as  $course1) {
      $sessionid = $course1['sessionid'];
      $session_name = $course1['session_name'];

      $sql1 = "select count(*) as totalst  from class_transfer where sessionid='$sessionid'";
      $graphdata1 = $obj->executequery($sql1);
      if (sizeof($graphdata1) > 0) {
        foreach ($graphdata1 as $keydata1) {
          $totalst = $keydata1['totalst'];
        } //inner for each
      } else
        $totalst = 0;

      $arrayName1[] = array('session_name' => $session_name, 'totalst' => $totalst);
    } //outer for each
  }
  // echo "<pre>";
  // print_r($arrayName1);

  ?>

  <script>
    window.onload = function() {

      var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title: {
          text: ""
        },
        axisY: {
          title: "student count -->"
        },
        data: [{
          type: "column",
          showInLegend: true,
          legendMarkerColor: "grey",
          legendText: "session -->",

          dataPoints: [
            <?php
            if (sizeof($arrayName1) > 0) {
              foreach ($arrayName1 as $grpinfo1) {
            ?> {
                  y: <?php echo $grpinfo1['totalst']; ?>,
                  label: "<?php echo $grpinfo1['session_name']; ?>"
                },

              <?php } ?>

            ]
        }]
      });
    <?php }
    ?>

    chart.render();

    }
  </script>
</body>

</html>