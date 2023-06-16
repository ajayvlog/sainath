<?php include("../adminsession.php");
$pagename = "head_wise_fee_report_new.php";
$module = "Head Wise Fee Report New";
$submodule = "HEAD WISE FEE REPORT NEW";
$btn_name = "Update";
$keyvalue = 0;
$tblname = "course_fee_setting";
$tblpkey = "course_fee_set_id";
$college_name = $obj->getvalfield("college_setting", "college_name", "college_id=1");


// if(isset($_GET['class_id']))
// $class_id = $_GET['class_id'];
// else
// $class_id = 0;

// if(isset($_GET['sem_id']))
// $sem_id = $_GET['sem_id'];
// else
// $sem_id = 0;


$crit = " where class_transfer.sessionid='$sessionid'";

if (isset($_GET['class_id']) && $_GET['class_id'] != "") {
  $class_id = trim(addslashes($_GET['class_id']));
  $crit .= " and m_student_reg.class_id='$class_id' ";
} else {
  $class_id = "";
}

if (isset($_GET['sem_id']) && $_GET['sem_id'] != "") {
  $sem_id = trim(addslashes($_GET['sem_id']));
  $crit .= " and class_transfer.sem_id='$sem_id' ";
}

if (isset($_GET['status']) && $_GET['status'] != "") {
  $status = trim(addslashes($_GET['status']));
  $crit .= " and m_student_reg.status='$status' ";
}

if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
//$status = "";
$dup = "";
// $choosed=0;





?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
              <h4 class="widgettitle">Year / Semester Wise Fee Setting</h4>
              <table class="table table-bordered">
                <tr>
                  <th>Course Name <span class="text-error">*</span></th>
                  <td>
                    <select name="class_id" id="class_id" class="chzn-select">
                      <option value=""> Select</option>
                      <?php
                      $slno = 1;
                      $res = $obj->executequery("select * from m_class");
                      foreach ($res as $row_get) {
                      ?>
                        <option value="<?php echo $row_get['class_id'];  ?>"><?php echo $row_get['class_name']; ?></option>
                      <?php } ?>
                    </select>
                    <script>
                      document.getElementById('class_id').value = '<?php echo $class_id; ?>';
                    </script>
                  </td>
                  <th>Year / Semester<span class="text-error">*</span></th>
                  <td>
                    <select name="sem_id" id="sem_id" class="chzn-select">
                      <option value=""> Select</option>
                      <?php
                      $slno = 1;
                      $res = $obj->executequery("select * from m_semester");
                      foreach ($res as $row_get) {
                      ?>
                        <option value="<?php echo $row_get['sem_id'];  ?>"><?php echo $row_get['sem_name']; ?></option>
                      <?php } ?>
                    </select>
                    <script>
                      document.getElementById('sem_id').value = '<?php echo $sem_id; ?>';
                    </script>
                  </td>
                  <th>Status<span class="text-error"></span></th>
                  <td>
                    <select name="status" id="status" style="width:280px;" class="chzn-select">
                      <option value="">--Select--</option>
                      <option value="0">Enable</option>
                      <option value="1">Disable</option>
                    </select>
                    <script>
                      document.getElementById('status').value = '<?php echo $status; ?>';
                    </script>
                  </td>

                  <td><input type="submit" name="search" value="Get Details" class="btn btn-primary" onclick="return checkinputmaster('class_id,sem_id');"></td>
                </tr>
              </table>
            </form>

            <hr>
            <?php

            if ($class_id > 0 && $sem_id > 0) { ?>
              <br>
              <p align="right" style="margin-top:7px; margin-right:10px;">
                <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
              </p>
              <form class="stdform stdform2" method="post" action="">
                <table class="table table-bordered" id="tblData">
                  <thead>
                    <tr>
                    <tr>
                      <th colspan="5"> </th>
                      <th colspan="2"> College Name : </th>
                      <td style="font-weight: bold;" colspan="5"><?php echo $college_name; ?></td>

                    </tr>
                    <tr>
                      <th colspan="5"> </th>
                      <th colspan="2">Course Name : </th>
                      <td style="font-weight: bold;" colspan="9"><?php $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
                                                                  echo $course_name;
                                                                  ?></td>

                    </tr>
                    <th>Student Name</th>
                    <th>Previous year Balance</th>
                    <?php
                    $sql = "select * from m_fee_head order by fee_head_id desc ";
                    $res = $obj->executequery($sql);
                    foreach ($res as $row_get2) {
                      $fee_head_id = $row_get2['fee_head_id'];
                    ?>
                      <th style="text-align: right;"><?php echo $row_get2['fee_head_name']; ?></th>

                    <?php } ?>
                    <th>Total Amount</th>
                    <th>Total Paid</th>
                    <th>Total Balance</th>
                    </tr>
                  </thead>
                  <tbody id="record">

                    <?php
                    //$slno=1;

                    $sql = "select * from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit and sessionid='$sessionid' order by stu_name asc";
                    $res = $obj->executequery($sql);
                    foreach ($res as $row_get1) {
                      $m_student_reg_id = $row_get1['m_student_reg_id'];
                      $stu_name = $row_get1['stu_name'];
                      $transferid = $row_get1['transferid'];

                     /* $prev_year = $sessionid - 1;
                      $prev_year_total_fee = $obj->getvalfield("course_fee_setting", "sum(total_fee)", "class_id='$class_id' and sem_id='$sem_id' and sessionid='$prev_year'");
                      $prev_year_paid = $obj->getvalfield("fee_payment", "sum(paid_amt)", "transferid='$transferid' and sessionid='$prev_year'");*/
                      // $prev_years_sem = $sem_id - 1;
                       $total_payment_all_prev = $obj->getvalfield("hostel_fee_setting left join class_transfer on hostel_fee_setting.transferid = class_transfer.transferid", "sum(total_fee)", "sem_id < '$sem_id' and m_student_reg_id = '$m_student_reg_id'");

                    $total_paid_all_prev = $obj->getvalfield("fee_payment left join class_transfer on fee_payment.transferid = class_transfer.transferid", "sum(paid_amt)", "sem_id < '$sem_id' and class_transfer.m_student_reg_id = '$m_student_reg_id'");

                      $prev_year_bal = $total_payment_all_prev - $total_paid_all_prev;
                    ?>
                      <tr>
                        <td><?php echo $stu_name.' / '.$m_student_reg_id; ?></td>
                        <td><?php echo $prev_year_bal; ?></td>
                        <?php
                        $tot_paid_amt = 0;
                        $sql = "select * from m_fee_head order by fee_head_id desc";
                        $res = $obj->executequery($sql);
                        foreach ($res as $row_get) {

                          $fee_head_id = $row_get['fee_head_id'];
                          $transferid = $row_get1['transferid'];
                          $paid_amt = $obj->getvalfield("fee_payment", "sum(paid_amt)", "fee_head_id='$fee_head_id' and transferid='$transferid'");

                          if ($paid_amt == '')
                            $paid_amt = 0;


                        ?>

                          <td style="text-align: right;"><?php echo number_format($paid_amt, 2); ?></td>
                        <?php
                          $tot_paid_amt += $paid_amt;
                          $total_fee = $obj->getvalfield("hostel_fee_setting", "sum(total_fee)", "transferid='$transferid' and sessionid='$sessionid'");
                          //$total_fee = $obj->getvalfield("course_fee_setting", "sum(total_fee)", "class_id='$class_id' and sem_id='$sem_id' and sessionid='$sessionid'");
                          $bal_amt = $total_fee - $tot_paid_amt;
                        } //outer looop close
                        ?>
                        <td style="text-align: right;"><?php echo number_format($total_fee, 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format($tot_paid_amt, 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format($bal_amt, 2); ?></td>
                      </tr>
                    <?php
                    } //inner looop close
                    ?>
                  </tbody>
                </table>
              <?php } ?>
              </form>
          </div>
          </tbody>
          </table>
        </div><!-- contentinner -->

      </div> <!--maincontent-->

    </div> <!--rightpanel-->

    <!-- END OF RIGHT PANEL -->
    <!--footer-->

    <!--   footer -->
    <div class="clearfix"></div>
    <?php include("inc/footer.php"); ?>
  </div><!--mainwrapper-->

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
    function getid(class_id) {
      //var customer_id = document.getElementById('customer_id').value;
      location = 'coursefeesetting.php?class_id=' + class_id;
    }

    jQuery(document).ready(function() {

      jQuery('#menues').click();

    });

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
  </script>
</body>

</html>