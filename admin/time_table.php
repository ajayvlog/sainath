<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "time_table.php";
$module = "TIME TABLE SETTING MASTER";
$submodule = "Time Table Setting Master";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "time_table_setting";
$tblpkey = "time_table_id";
$dup = "";
$sessionid = $_SESSION['sessionid'];
if (isset($_GET['time_table_id']))
  $keyvalue = $_GET['time_table_id'];
else
  $keyvalue = 0;
if (isset($_GET['action']))
  $action = $obj->test_input($_GET['action']);
else
  $action = "";
$status = "";
$dup = "";
$start_time = "";
$end_time = "";
//$class_id = '';
$subject_id = '';
$week_id = '';
if (isset($_POST['submit'])) { //print_r($_POST); die;

  $class_id = $obj->test_input($_POST['class_id']);
  $start_time = $obj->test_input($_POST['start_time']);
  $end_time = $obj->test_input($_POST['end_time']);
  $subject_id = $obj->test_input($_POST['subject_id']);
  $week_id = $obj->test_input($_POST['week_id']);

  //check Duplicate
  /* $cwhere = array("class_id"=>$_POST['class_id']);
  $count = $obj->count_method("m_class",$cwhere);*/
  $count = $obj->getvalfield("time_table_setting", "count(*)", "class_id='$class_id' and subject_id='$subject_id' and week_id='$week_id' and time_table_id!='$keyvalue'");
  if ($count > 0) {
    /*$dup = " Error : Duplicate Record";*/
    $dup = "<div class='alert alert-danger'>
     <strong>Error!</strong> Error : Duplicate Record.
     </div>";
  } else {
    //insert
    if ($keyvalue == 0) {
      $form_data = array('class_id' => $class_id, 'start_time' => $start_time, 'end_time' => $end_time, 'subject_id' => $subject_id, 'week_id' => $week_id, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate);
      $obj->insert_record($tblname, $form_data);
      $action = 1;
      $process = "insert";
      echo "<script>location='$pagename?action=$action'</script>";
    } else {
      //update
      $form_data = array('class_id' => $class_id, 'start_time' => $start_time, 'end_time' => $end_time, 'subject_id' => $subject_id, 'week_id' => $week_id, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate);
      $where = array($tblpkey => $keyvalue);
      $keyvalue = $obj->update_record($tblname, $where, $form_data);
      $action = 2;
      $process = "updated";
    }
    echo "<script>location='$pagename?action=$action'</script>";
  }
}
if (isset($_GET[$tblpkey])) {

  $btn_name = "Update";
  $where = array($tblpkey => $keyvalue);
  $sqledit = $obj->select_record($tblname, $where);
  $class_id =  $sqledit['class_id'];
  $start_time =  $sqledit['start_time'];
  $end_time =  $sqledit['end_time'];
  $subject_id =  $sqledit['subject_id'];
  $week_id =  $sqledit['week_id'];
} else {

  $class_id = $obj->getvalfield("time_table_setting", "class_id", "1=1 order by time_table_id desc limit 0,1");
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
          <?php include("../include/alerts.php"); ?>
          <form method="post" action="">
            <?php echo  $dup;  ?>
            <table class="table table-bordered table-condensed">
              <tr>
                <th>Course Name<span style="color:#F00;">*</span></th>
                <th>Subject Name<span style="color:#F00;">*</span></th>
                <th>Start Time<span style="color:#F00;">*</span></th>

                <!-- <th>Address</th> -->
              </tr>
              <tr>

                <td>
                  <select name="class_id" id="class_id" class="chzn-select input-xlarge" autofocus autocomplete="off" onchange="getid(this.value);">
                    <option value="">Select Class</option>
                    <?php
                    $sql = $obj->executequery("select * from m_class order by class_name asc");
                    foreach ($sql as $row_get) {
                    ?>
                      <option value="<?php echo $row_get['class_id']; ?>"><?php echo $row_get['class_name']; ?></option>
                    <?php } ?>
                  </select>
                  <script>
                    document.getElementById('class_id').value = '<?php echo $class_id; ?>'
                  </script>
                </td>

                <td>
                  <select name="subject_id" id="subject_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select---</option>
                    <?php
                    $slno = 1;
                    $res = $obj->executequery("select * from m_subject WHERE class_id = '$class_id' order by subject asc");
                    foreach ($res as $row_get) {
                    ?>
                      <option value="<?php echo $row_get['subject_id']; ?>"> <?php echo $row_get['subject']; ?></option>
                    <?php } ?>
                  </select>
                  <script>
                    document.getElementById('subject_id').value = '<?php echo $subject_id; ?>';
                  </script>
                </td>
                <td>
                  <input type="time" name="start_time" id="start_time" class="input-xlarge" value="<?php echo $start_time; ?>" autofocus autocomplete="off" placeholder="Enter Start Time" />
                </td>
              </tr>
              <tr>
                <th>End Time<span style="color:#F00;">*</span></th>
                <th>Days<span style="color:#F00;">*</span></th>
              </tr>
              <tr>
                <td>
                  <input type="time" name="end_time" id="end_time" class="input-xlarge" value="<?php echo $end_time; ?>" autofocus autocomplete="off" placeholder="Enter End Time" />
                </td>
                <td>
                  <select name="week_id" id="week_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select Day---</option>

                    <?php
                    $res = $obj->executequery("select * from weeks_name order by week_id asc");
                    foreach ($res as $row_get) {
                    ?>
                      <option value="<?php echo $row_get['week_id']; ?>"> <?php echo $row_get['days_name']; ?></option>
                    <?php } ?>
                  </select>
                  <script>
                    document.getElementById('week_id').value = '<?php echo $week_id; ?>';
                  </script>

              </tr>
              <tr>

                <td colspan="3"><input type="submit" name="submit" class="btn btn-success" value="<?php echo $btn_name; ?>" onClick="return checkinputmaster('class_id,subject_id,start_time,end_time,day_name'); ">
                  <a href="time_table.php" class="btn btn-success">Reset</a>
                </td>
              </tr>
            </table>
            <div>
          </form>
          <br>
          <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="simple-html-invoice/simple-html-invoice-template-master/pdf_all_student_reg_report.php?class_id=<?php //echo $class_id; 
                                                                                                                                                                                      ?>&s_sessionid=<?php //echo $s_sessionid; 
                                                                                                                                                                                                                            ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>


          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
        </p> -->

          <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
          <table class="table table-bordered" id="dyntable">
            <colgroup>
              <col class="con0" style="text-align: center; width: 4%" />
              <col class="con1" />
              <col class="con0" />
              <col class="con1" />
              <col class="con0" />
              <col class="con1" />
            </colgroup>
            <thead>
              <tr>

                <th width="11%" class="head0 nosort">Sno.</th>
                <th width="18%" class="head0">Course Name</th>
                <th width="18%" class="head0">Subject / Semester Name</th>
                <th width="18%" class="head0">Start Time</th>
                <th width="18%" class="head0">End Time</th>
                <th width="18%" class="head0">Days</th>
                <?php $chkedit = $obj->check_editBtn("time_table.php", $loginid);

                if ($chkedit == 1 || $loginid == 1) {  ?>
                  <th width="9%" class="head0">Edit</th>
                <?php  }
                $chkdel = $obj->check_delBtn("time_table.php", $loginid);

                if ($chkdel == 1 || $loginid == 1) {  ?>
                  <th width="10%" class="head0">Delete</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>

              <?php
              $slno = 1;
              $res = $obj->executequery("select * from time_table_setting order by time_table_id desc");
              foreach ($res as $row_get) {

                $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$row_get[class_id];'");
                $days_name = $obj->getvalfield("weeks_name", "days_name", "week_id='$row_get[week_id];'");
                $subject_name = $obj->getvalfield("m_subject", "subject", "subject_id='$row_get[subject_id];'");
                $sem_id = $obj->getvalfield("m_subject", "sem_id", "subject_id='$row_get[subject_id];'");
                $sem_name = $obj->getvalfield("m_semester", "sem_name", "sem_id='$sem_id;'");

              ?>
                <tr>
                  <td><?php echo $slno++; ?></td>
                  <td><?php echo $course_name; ?></td>
                  <td><?php echo $subject_name . " / " . $sem_name; ?></td>
                  <td><?php echo $row_get['start_time']; ?></td>
                  <td><?php echo $row_get['end_time']; ?></td>
                  <td><?php echo $days_name; ?></td>
                  <?php

                  if ($chkedit == 1 || $loginid == 1) {  ?>
                    <td><a class='icon-edit' title="Edit" href='time_table.php?time_table_id=<?php echo $row_get['time_table_id']; ?>'></a></td>
                  <?php  }
                  if ($chkdel == 1 || $loginid == 1) {  ?>
                    <td>
                      <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['time_table_id']; ?>);' style='cursor:pointer'></a>
                    </td>
                  <?php } ?>
                </tr>

              <?php
              }
              ?>
            </tbody>
          </table>


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
  <!-- Modal -->
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

    function funDel(id) {
      tblname = '<?php echo $tblname; ?>';
      tblpkey = '<?php echo $tblpkey; ?>';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';
      //alert(tblname);alert(tblpkey);alert(pagename);alert(submodule);alert(module);
      if (confirm("Are you sure! You want to delete this record.")) {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax/delete_master.php',
          data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
          dataType: 'html',
          success: function(data) {
            //alert(data);
            location = '<?php echo $pagename . "?action=3"; ?>';
          }

        }); //ajax close
      } //confirm close
    } //fun close

    function getid(class_id) {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax_getsubject.php',
        data: 'class_id=' + class_id,
        dataType: 'html',
        success: function(data) {
          //alert(data);
          jQuery('#subject_id').html(data);

          jQuery("#subject_id").val('').trigger("liszt:updated");
          document.getElementById('subject_id').focus();
          jQuery(".chzn-single").focus();

        }

      }); //ajax close
    }
  </script>
</body>

</html>