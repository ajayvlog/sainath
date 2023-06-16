<?php include("../adminsession.php");
//print_r($_SESSION);die;
$loginid = $_SESSION['userid'];
$pagename = "transfer_certificate_page.php";
$module = "Transfer Certificate";
$submodule = "TRANSFER CERTIFICATE";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "transfer_certificate";
$tblpkey = "tc_id";

if (isset($_GET['tc_id']))
  $keyvalue = $_GET['tc_id'];
else
  $keyvalue = 0;
if (isset($_GET['m_student_reg_id']))
  $m_student_reg_id = $_GET['m_student_reg_id'];
else
  $m_student_reg_id = "";

if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$status = "";
$dup = "";
$father_name = "";
$mother_name = "";
$m_student_reg_id = "";
$participation_date = "";
$status = "";
//$behavior = "उत्तम";
$feesdate = "";
$course_name = "";
$from_yearsem = "";
$to_yearsem = "";
if (isset($_POST['submit'])) {
  //print_r($_POST);die;
  $m_student_reg_id = $obj->test_input($_POST['m_student_reg_id']);
  $father_name  = $obj->test_input($_POST['father_name']);
  $mother_name = $obj->test_input($_POST['mother_name']);
  $course_name = $obj->test_input($_POST['course_name']);
  $from_yearsem = $obj->test_input($_POST['from_yearsem']);
  $to_yearsem = $obj->test_input($_POST['to_yearsem']);
  $participation_date = $obj->dateformatusa($_POST['participation_date']);
  $status = $obj->test_input($_POST['status']);
  $behavior = $obj->test_input($_POST['behavior']);
  $feesdate = $obj->dateformatusa($_POST['feesdate']);

  //check Duplicate
  $cwhere = array("m_student_reg_id" => $_POST['m_student_reg_id']);
  // print_r($cwhere);die;
  $count = $obj->count_method("transfer_certificate", $cwhere);
  if ($count > 0) {
    $dup = "<div class='alert alert-danger'>
     <strong>Error!</strong> Duplicate Record.
     </div>";
    //echo $dup; die;
  } else {

    //update
    $form_data = array('m_student_reg_id' => $m_student_reg_id, 'father_name' => $father_name, 'mother_name' => $mother_name, 'course_name' => $course_name, 'from_yearsem' => $from_yearsem, 'to_yearsem' => $to_yearsem, 'participation_date' => $participation_date, 'status' => $status, 'behavior' => $behavior, 'feesdate' => $feesdate, 'createdby' => $loginid, 'createdate' => $createdate, 'ipaddress' => $ipaddress);
    //print_r($form_data);die;
    $obj->insert_record('transfer_certificate', $form_data);
    $action = 1;
    $process = "insert";
    echo "<script>location='transfer_certificate_page.php?action=$action&m_student_reg_id=$m_student_reg_id'</script>";

    //}
  }
}
if (isset($_GET['m_student_reg_id'])) {

  $btn_name = "Save";
  $m_student_reg_id = addslashes(trim($_GET['m_student_reg_id']));

  $where = array('m_student_reg_id' => $m_student_reg_id);
  $sqledit = $obj->select_record('m_student_reg', $where);
  $father_name =  $sqledit['father_name'];
  $mother_name =  $sqledit['mother_name'];
  $class_id =  $sqledit['class_id'];
  $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
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
        <div class="contentinner">
          <?php include("../include/alerts.php"); ?>
          <!--widgetcontent-->
          <div class="widgetcontent  shadowed nopadding">
            <form class="stdform stdform2" method="post" action="">
              <div id="wizard2" class="wizard tabbedwizard">
                <?php include("inc/certificate_tab.php"); ?>
                <div>
                  <h4>Transfer Certificate</h4>
                  <?php echo $dup; ?>
                  <div class="lg-12 md-12 sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <th>Student Name<span style="color:#F00;"></span></th>
                        <th>Father's Name<span style="color:#F00;">*</span></th>
                        <th>Mother's Name<span style="color:#F00;">*</span></th>
                      </tr>
                      <tr>
                        <td>
                          <select name="m_student_reg_id" id="m_student_reg_id" style="width:280px;" class="chzn-select" onChange="getid(this.value);">
                            <option value="">--Select--</option>
                            <?php


                            $res = $obj->executequery("select * from class_transfer LEFT JOIN m_student_reg
                        ON class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where class_transfer.sessionid=$sessionid");
                            foreach ($res as $row) {
                              $m_student_reg_id1 = $row['m_student_reg_id'];
                              $stu_name = $row['stu_name'];
                              $class_id = $row['class_id'];
                              $class_name = $obj->getvalfield("m_class", "class_name", "class_id=$class_id");

                            ?>
                              <option value="<?php echo $m_student_reg_id1; ?>"><?php echo $stu_name . " / " . $class_name; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <script>
                            document.getElementById('m_student_reg_id').value = '<?php echo $m_student_reg_id; ?>';
                          </script>
                        </td>

                        <td> <input type="text" name="father_name" id="father_name" class="input-xlarge" value="<?php echo $father_name; ?>" autofocus autocomplete="off" placeholder="Enter Father's Name" /></td>

                        <td> <input type="text" name="mother_name" id="mother_name" class="input-xlarge" value="<?php echo $mother_name; ?>" autofocus autocomplete="off" placeholder="Enter Mother's Name" /></td>

                      </tr>
                      <tr>
                        <th>Course Name<span style="color:#F00;">*</span></th>
                        <th>From Year/Sem<span style="color:#F00;">*</span></th>
                        <th>To Year/Sem<span style="color:#F00;">*</span></th>

                      </tr>
                      <tr>

                        <td> <input type="text" name="course_name" id="course_name" placeholder="Enter Course Name" class="input-xlarge" value="<?php echo $course_name; ?>" autofocus autocomplete="off" /></td>

                        <td>
                          <select class="chzn-select input-xlarge" name="from_yearsem" id="from_yearsem">
                            <option value="">Select Year/Sem</option>
                            <?php
                            $qry = $obj->executequery("select * from m_semester");
                            foreach ($qry as $rowget) {
                            ?>
                              <option value="<?php echo $rowget['sem_id'] ?>"><?php echo $rowget['sem_name']; ?></option>
                            <?php } ?>
                          </select>
                          <script type="text/javascript">
                            document.getElementById('from_yearsem').value = '<?php echo $from_yearsem; ?>'
                          </script>
                        </td>

                        <td>
                          <select class="chzn-select input-xlarge" name="to_yearsem" id="to_yearsem">
                            <option value="">Select Year/Sem</option>
                            <?php
                            $qry = $obj->executequery("select * from m_semester order by sem_id");
                            foreach ($qry as $rowget) {

                            ?>

                              <option value="<?php echo $rowget['sem_id'] ?>"><?php echo $rowget['sem_name']; ?></option>
                            <?php } ?>
                          </select>
                          <script type="text/javascript">
                            document.getElementById('to_yearsem').value = '<?php echo $to_yearsem; ?>'
                          </script>
                        </td>
                      </tr>
                      <tr>
                        <th>Exam Participation Date<span style="color:#F00;"></span></th>
                        <th>Status<span style="color:#F00;">*</span></th>
                        <th>Student Behavior<span style="color:#F00;">*</span></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="participation_date" id="participation_date" placeholder="dd-mm-yyyy" class="input-xlarge" value="<?php echo $participation_date; ?>" autofocus autocomplete="off" /></td>

                        <td>
                          <select class=" input-xlarge chzn-select" name="status" id="status">
                            <option value="">Select Status</option>
                            <option value="असम्मिलित">असम्मिलित </option>
                            <option value="सम्मिलित">सम्मिलित </option>
                            <option value="उत्तीर्ण">उत्तीर्ण </option>
                            <option value="अनुत्तीर्ण">अनुत्तीर्ण </option>
                            <option value="प्रवेश">प्रवेश </option>
                          </select>
                          <script type="text/javascript">
                            document.getElementById(status).value = '<?php echo $status; ?>'
                          </script>
                        </td>
                        <td>

                          <select class=" input-xlarge chzn-select" name="behavior" id="behavior">
                            <option value="">Select Behavior</option>
                            <option value="उत्तम">उत्तम </option>
                            <option value="संतोष जनक">संतोष जनक</option>


                          </select>
                          <script type="text/javascript">
                            document.getElementById(behavior).value = '<?php echo $behavior; ?>'
                          </script>

                        </td>


                      </tr>
                      <tr>
                        <th>Last Fees Submission Date<span style="color:#F00;"></span></th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="feesdate" id="feesdate" class="input-xlarge" value="<?php echo $feesdate; ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy" /></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('m_student_reg_id,father_name,mother_name,course_name,from_yearsem,to_yearsem,status,behavior'); ">
                            <?php echo $btn_name; ?></button>
                          <a href="transfer_certificate_page.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                          <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </form>
          </div>
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
                <th class="head0 nosort">Sno.</th>
                <th class="head0">Student Name</th>
                <th class="head0">Father Name</th>
                <th class="head0">Mother Name</th>
                <th class="head0">Exam Participation</th>
                <th class="head0">Status</th>
                <th class="head0">Student Behavior</th>
                <th class="head0">Fees_Pay_Date</th>
                <th width="10%" class="head0">Print_TC</th>
                <?php $chkdel = $obj->check_delBtn("transfer_certificate_page.php", $loginid);

                if ($chkdel == 1 || $loginid == 1) {  ?>
                  <th width="10%" class="head0">Delete</th>
                <?php } ?>

              </tr>
            </thead>
            <tbody>

              <?php
              $slno = 1;
              //$res = $obj->fetch_record("m_product");

              $res = $obj->executequery("select * from transfer_certificate where m_student_reg_id='$m_student_reg_id'");
              foreach ($res as $row_get) {
                $tc_id = $row_get['tc_id'];
                $print_copy = $row_get['print_copy'];
                $m_student_reg_id = $row_get['m_student_reg_id'];
                $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
              ?>
                <tr>
                  <td><?php echo $slno++; ?></td>
                  <td><?php echo $stu_name; ?></td>
                  <td><?php echo $row_get['father_name']; ?></td>
                  <td><?php echo $row_get['mother_name']; ?></td>
                  <td><?php echo $obj->dateformatindia($row_get['participation_date']); ?></td>
                  <td><?php echo $row_get['status']; ?></td>
                  <td><?php echo $row_get['behavior']; ?></td>
                  <td><?php echo $obj->dateformatindia($row_get['feesdate']); ?></td>
                  <td width="10%"><a class="icon-print" style="text-align: center; cursor: pointer;" onClick="copyofTc('<?php echo $m_student_reg_id; ?>','<?php echo $row_get['print_copy']; ?>');" data-toggle="modal_party" title="Print"></a></td>
                  <?php if ($chkdel == 1 || $loginid == 1) {  ?>
                    <td width="10%"><a class='icon-remove' title="Delete" onclick='funDel(<?php echo $tc_id; ?>);' style='cursor:pointer'></a></td>
                  <?php } ?>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>

        </div><!--contentinner-->
      </div><!--maincontent-->
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    <div class="clearfix"></div>
    <?php include("inc/footer.php"); ?>
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_party">
      <div class="modal-header alert-info">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="myModalLabel">No of Copy</h3>
      </div>
      <div class="modal-body">
        <span style="color:#F00;" id="suppler_model_error"></span>
        <table class="table table-condensed table-bordered">
          <input type="hidden" name="mm_student_reg_id" id="mm_student_reg_id">
          <tbody>
            <tr>
              <td>Copy No.<span style="color: red;">*</span></td>
              <td><input type="text" name="print_copy" id="print_copy" class="input-large" placeholder="Enter Copy No"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" name="s_save" id="s_save" onClick="printTc();">Print</button>
        <button data-dismiss="modal" class="btn btn-danger">Close</button>
      </div>
    </div>
    <!--footer-->
  </div><!--mainwrapper-->
  <script>
    function funDel(id) { //alert(id);   
      tblname = '<?php echo $tblname; ?>';
      tblpkey = '<?php echo $tblpkey; ?>';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      m_student_reg_id = '<?php echo $m_student_reg_id; ?>';
      module = '<?php echo $module; ?>';
      //alert(module); 
      if (confirm("Are you sure! You want to delete this record.")) {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax/delete_master_reg.php',
          data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
          dataType: 'html',
          success: function(data) {
            //alert(data);
            location = '<?php echo $pagename . "?action=3&m_student_reg_id=$m_student_reg_id"; ?>';
          }

        }); //ajax close
      } //confirm close
    } //fun close


    jQuery('#participation_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#feesdate').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#admission_date').focus();

    jQuery(document).ready(function() {
      // Smart Wizard  
      jQuery('#wizard2').smartWizard({
        onFinish: onFinishCallback
      });

      function onFinishCallback() {
        alert('Finish Clicked');
      }

      jQuery(".inline").colorbox({
        inline: true,
        width: '60%',
        height: '500px'
      });
      jQuery('select, input:checkbox').uniform();
    });

    function changetab(pagename) {
      //alert('hi');
      location = pagename;
    }

    function getid(m_student_reg_id) {

      var $url = 'transfer_certificate_page.php?m_student_reg_id=' + m_student_reg_id;

      location = $url

    }
  </script>
  <script>
    let print = (doc) => {
      let objFra = document.createElement('iframe'); // Create an IFrame.
      objFra.style.visibility = 'hidden'; // Hide the frame.
      objFra.src = doc; // Set source.
      document.body.appendChild(objFra); // Add the frame to the web page.
      objFra.contentWindow.focus(); // Set focus.
      objFra.contentWindow.print(); // Print it.
    }
  </script>
  <script type="text/javascript">
    function copyofTc(m_student_reg_id, print_copy) {
      jQuery('#myModal_party').modal('show');
      jQuery('#mm_student_reg_id').val(m_student_reg_id);
      jQuery('#print_copy').val(print_copy);
    }
  </script>
  <script type="text/javascript">
    function printTc() {
      var print_copy = document.getElementById('print_copy').value;
      var mm_student_reg_id = document.getElementById('mm_student_reg_id').value;
      if (print_copy == "") {
        alert("Print copy can't be blank");
        return false;
      } else {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax/print_tc.php',
          data: 'mm_student_reg_id=' + mm_student_reg_id + '&print_copy=' + print_copy,
          dataType: 'html',
          success: function(data) {
            //alert(data);
            jQuery('#myModal_party').modal('hide');
            if (data == 1) {
              print('transfer_certificate.php?tc_id=<?php echo $tc_id; ?>');
            }


          }

        }); //ajax close
      }

    }
  </script>
</body>

</html>