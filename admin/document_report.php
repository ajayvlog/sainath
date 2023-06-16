<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "document_report.php";
$module = "  All Student  Document Report ";
$submodule = " All Student Document Report";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "";
$tblpkey = "";
$crit = " where class_transfer.sessionid='$sessionid'";
$college_name = $obj->getvalfield("college_setting", "college_name", "college_id=1");

if (isset($_GET['class_id']) && $_GET['class_id'] != "") {
  $class_id = trim(addslashes($_GET['class_id']));
  $crit .= " and m_student_reg.class_id='$class_id' ";
} else {
  $class_id = "";
}

if (isset($_GET['sem_id']) && $_GET['sem_id'] != "") {
  $sem_id = trim(addslashes($_GET['sem_id']));
  $crit .= " and class_transfer.sem_id='$sem_id' ";
} else {
  $sem_id = "";
}
?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
  <script type="text/javascript">
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

                <th>Class Name:</th>
                <th>Sem/Year Name:</th>
              </tr>
              <tr>


                <td>
                  <select name="class_id" id="class_id" class="chzn-select" style="width:283px;">
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
                  <select name="sem_id" id="sem_id" class="chzn-select" style="width:283px;">
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

                <td><input type="submit" name="search" class="btn btn-success" value="Search">
                  <a href="document_report.php" class="btn btn-success">Reset</a>
                </td>
              </tr>
            </table>
            <div>
          </form>
          <?php if ($class_id > 0 || $sem_id > 0) {

          ?>
            <br>
            <p align="right" style="margin-top:7px; margin-right:10px;">
              <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
            </p>

            <hr>
            <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>

            <table class="table table-bordered" id="tblData">
              <thead>
                <tr>
                  <th colspan="5"> </th>
                  <th colspan="2"> College Name : </th>
                  <td style="font-weight: bold;" colspan="5"><?php echo $college_name; ?></td>

                </tr>
                <tr>
                  <th colspan="5"> </th>
                  <th colspan="2">Course Name : </th>
                  <td style="font-weight: bold;" colspan="5"><?php $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
                                                              echo $course_name;
                                                              ?></td>

                </tr>
                <tr>

                  <th>Student Name</th>

                  <?php
                  $sql = "select * from m_document order by document_id desc";
                  $res = $obj->executequery($sql);
                  foreach ($res as $row_get2) {
                    $document_id = $row_get2['document_id'];
                  ?>
                    <th><?php echo $row_get2['document_name']; ?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody id="record">

                <?php
                $sql = "select * from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit and sessionid='$sessionid' order by stu_name asc";
                $res = $obj->executequery($sql);
                foreach ($res as $row_get1) {
                  $m_student_reg_id = $row_get1['m_student_reg_id'];
                  $stu_name = $row_get1['stu_name'];
                ?>
                  <tr>
                    <td><?php echo $stu_name; ?></td>
                    <?php
                    $sql = "select * from m_document order by document_id desc";
                    $res = $obj->executequery($sql);
                    foreach ($res as $row_get) {

                      $document_id = $row_get['document_id'];
                      $m_student_reg_id = $row_get1['m_student_reg_id'];
                      $status_doc = $obj->getvalfield("document_upload", "document_id", "document_id='$document_id' and m_student_reg_id='$m_student_reg_id'");


                      if ($status_doc != "") {
                        $status = "<span style='color: green;'>YES</span>";
                      } else {
                        $status = "<span style='color: red;'>NO</span>";
                      }

                    ?>

                      <td><?php echo $status; ?></td>
                    <?php
                    } //outer looop close
                    ?>
                  </tr>
                <?php
                } //inner looop close
                ?>
              </tbody>
            </table>
          <?php } ?>
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

</body>

</html>