<?php include("../adminsession.php");
//print_r($_SESSION);die;
$loginid = $_SESSION['userid'];
$pagename = "scholership_form.php";
$module = "SCHOLARS REGISTRATION";
$submodule = "Scholars Registration";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "scholer_ship";
$tblpkey = "scholership_id";
$dup = "";
$scholer_no  = "";
$father_name = "";
$mother_name = "";

$dob = "";
$category_id = "";
$gender = "";
$address = "";
$last_qualification = "";
$course_name  = "";
$doa = "";
$enrollment = "";
$result = "";
$tc_issue_date = "";
$admissionno = "";
$imgname = "";
$imgname1  = "";
$imgpath = "uploaded/scholer_stu_img/";

if (isset($_GET[$tblpkey]))
  $keyvalue = $_GET[$tblpkey];
else
  $keyvalue = 0;


if (isset($_GET['m_student_reg_id'])) {
  $m_student_reg_id = $_GET['m_student_reg_id'];
} else {
  $m_student_reg_id = "";
}
if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";


$scholer_no = $obj->getcode($tblname, 'scholer_no', "1=1");

if (isset($_POST['submit'])) {
  //print_r($_POST);die;
  //print_r($_POST);die;
  $scholer_no = $obj->test_input($_POST['scholer_no']);
  $m_student_reg_id  = $obj->test_input($_POST['m_student_reg_id']);
  $father_name = $obj->test_input($_POST['father_name']);
  $mother_name = $obj->test_input($_POST['mother_name']);
  $dob = $obj->dateformatusa($_POST['dob']);
  $category_id = $obj->test_input($_POST['category_id']);
  $gender = $obj->test_input($_POST['gender']);
  $address = $obj->test_input($_POST['address']);
  $last_qualification = $obj->test_input($_POST['last_qualification']);
  $course_name = $obj->test_input($_POST['course_name']);
  $doa = $obj->dateformatusa($_POST['doa']);
  $enrollment = $obj->test_input($_POST['enrollment']);
  $result = $obj->test_input($_POST['result']);
  $admissionno = $obj->test_input($_POST['admissionno']);
  if (isset($_POST['dis_id'])) {
    $dis_id = $obj->test_input($_POST['dis_id']);
  } else {
    $dis_id = 0;
  }

  $tc_issue_date = $obj->dateformatusa($_POST['tc_issue_date']);
  $imgname = $_FILES['imgname'];
  //check Duplicate
  //     $cwhere = array("scholer_no"=>$_POST['scholer_no']);
  //     // print_r($cwhere);die;
  //     $count = $obj->count_method("scholer_ship",$cwhere);
  //     if ($count > 0 )
  //     {
  //       $dup="<div class='alert alert-danger'>
  //       <strong>Error!</strong> Duplicate Record.
  //       </div>";
  //       //echo $dup; die;
  //     }
  // else
  //     {
  if ($keyvalue == 0) {
    //update
    $form_data = array('scholer_no' => $scholer_no, 'm_student_reg_id' => $m_student_reg_id, 'father_name' => $father_name, 'mother_name' => $mother_name, 'dob' => $dob, 'category_id' => $category_id, 'gender' => $gender, 'address' => $address, 'last_qualification' => $last_qualification, 'course_name' => $course_name, 'doa' => $doa, 'enrollment' => $enrollment, 'result' => $result, 'tc_issue_date' => $tc_issue_date, 'admissionno' => $admissionno, 'createdby' => $loginid, 'createdate' => $createdate, 'ipaddress' => $ipaddress, 'dis_id' => $dis_id);
    //print_r($form_data);die;
    $lastid = $obj->insert_record_lastid($tblname, $form_data);
    $uploaded_filename = $obj->uploadImage($imgpath, $imgname);
    $form_data = array('imgname' => $uploaded_filename);
    $where = array($tblpkey => $lastid);
    //print_r($where);die;
    $keyvalue = $obj->update_record($tblname, $where, $form_data);
    $action = 1;
    $process = "insert";
    echo "<script>location='scholership_form.php?action=$action&m_student_reg_id=$m_student_reg_id'</script>";
    // $obj->insert_record('transfer_certificate',$form_data);
    // $action=1;
    // $process = "insert";
  } else {
    $form_data = array('scholer_no' => $scholer_no, 'm_student_reg_id' => $m_student_reg_id, 'father_name' => $father_name, 'mother_name' => $mother_name, 'dob' => $dob, 'category_id' => $category_id, 'gender' => $gender, 'address' => $address, 'last_qualification' => $last_qualification, 'course_name' => $course_name, 'doa' => $doa, 'enrollment' => $enrollment, 'result' => $result, 'tc_issue_date' => $tc_issue_date, 'admissionno' => $admissionno, 'createdby' => $loginid, 'lastupdated' => $createdate, 'ipaddress' => $ipaddress, 'dis_id' => $dis_id);
    $where = array($tblpkey => $keyvalue);
    $obj->update_record($tblname, $where, $form_data);
    if ($_FILES['imgname']['tmp_name'] != "") {

      //delete old file
      $oldimg = $obj->getvalfield("$tblname", "imgname", "$tblpkey='$keyvalue'");
      if ($oldimg != "")
        @unlink("uploaded/scholer_stu_img/$oldimg");
      $uploaded_filename = $obj->uploadImage($imgpath, $imgname);
      // print_r($uploaded_filename);die;
      $form_data = array('imgname' => $uploaded_filename);
      $where = array($tblpkey => $keyvalue);
      $obj->update_record($tblname, $where, $form_data);
    }
    $action = 2;
    $process = "updated";
  }
  //}
  //}
}
if (isset($_GET['m_student_reg_id'])) {

  $btn_name = "Save";
  $m_student_reg_id = addslashes(trim($_GET['m_student_reg_id']));

  $where = array('m_student_reg_id' => $m_student_reg_id);
  $sqledit = $obj->select_record('m_student_reg', $where);
  $father_name =  $sqledit['father_name'];
  $mother_name =  $sqledit['mother_name'];
  $dob =  $sqledit['dob'];
  $doa =  $sqledit['admission_date'];
  $class_id =  $sqledit['class_id'];
  $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
  $category_id =  $sqledit['category_id'];
  $cat_name = $obj->getvalfield("m_category", "cat_name", "category_id='$category_id'");
  $enrollment =  $sqledit['enrollment'];
  $gender =  $sqledit['gender'];
  $address =  $sqledit['address'];
  $imgname1 =  $sqledit['imgname'];
  $dis_id =  $sqledit['district'];
}

if (isset($_GET[$tblpkey])) {

  $btn_name = "Update";
  $where = array($tblpkey => $keyvalue);
  $sqledit = $obj->select_record($tblname, $where);
  $scholer_no =  $sqledit['scholer_no'];
  $m_student_reg_id =  $sqledit['m_student_reg_id'];
  $father_name =  $sqledit['father_name'];
  $mother_name =  $sqledit['mother_name'];
  $dob =  $sqledit['dob'];
  $category_id =  $sqledit['category_id'];
  $gender =  $sqledit['gender'];
  $address =  $sqledit['address'];
  $last_qualification =  $sqledit['last_qualification'];
  $course_name =  $sqledit['course_name'];
  $doa =  $sqledit['doa'];
  $enrollment =  $sqledit['enrollment'];
  $result =  $sqledit['result'];
  $tc_issue_date =  $sqledit['tc_issue_date'];
  $admissionno =  $sqledit['admissionno'];
  $imgname =  $sqledit['imgname'];
  $dis_id =  $sqledit['dis_id'];
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
            <form class="stdform stdform2" method="post" action="" enctype=multipart/form-data>
              <div id="wizard2" class="wizard tabbedwizard">
                <?php include("inc/certificate_tab.php"); ?>
                <div>
                  <h4>Scholar Form</h4>
                  <?php echo $dup; ?>
                  <div class="lg-12 md-12 sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <th>Scholar No.<span style="color:#F00;"></span></th>
                        <th>Student Name<span style="color:#F00;">*</span></th>
                        <th>Father's Name<span style="color:#F00;">*</span></th>

                      </tr>
                      <tr>
                        <td> <input type="text" autofocus="" readonly name="scholer_no" id="scholer_no" class="input-xlarge" value="<?php echo $scholer_no; ?>" autofocus autocomplete="off" placeholder="Scholar No." />
                        </td>

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
                      </tr>
                      <tr>
                        <th>Mother's Name<span style="color:#F00;">*</span></th>
                        <th>Date of Birth<span style="color:#F00;">*</span></th>
                        <th>Last Qualification<span style="color:#F00;">*</span></th>

                      </tr>
                      <tr>


                        <td> <input type="text" name="mother_name" id="mother_name" class="input-xlarge" value="<?php echo $mother_name; ?>" autofocus autocomplete="off" placeholder="Enter Mother's Name" />
                        </td>
                        <td> <input type="text" name="dob" id="dob" placeholder="dd-mm-yyyy" class="input-xlarge" value="<?php echo $obj->dateformatindia($dob); ?>" autofocus autocomplete="off" /></td>
                        <td> <input type="text" name="last_qualification" id="last_qualification" class="input-xlarge" value="<?php echo $last_qualification; ?>" autofocus autocomplete="off" placeholder="Enter Last Qualification" /></td>


                      </tr>
                      <tr>
                        <th>Cast<span style="color:#F00;">*</span></th>
                        <th>Gender<span style="color:#F00;">*</span></th>
                        <th>Student Photo</th>

                      </tr>
                      <tr>
                        <td>
                          <select class="chzn-select input-xlarge" name="category_id" id="category_id">
                            <option value="">Select Cast</option>
                            <?php
                            $qry = $obj->executequery("select * from m_category order by category_id");
                            foreach ($qry as $rowget) {

                            ?>

                              <option value="<?php echo $rowget['category_id'] ?>"><?php echo $rowget['cat_name']; ?></option>
                            <?php } ?>
                          </select>
                          <script type="text/javascript">
                            document.getElementById('category_id').value = '<?php echo $category_id; ?>'
                          </script>
                        </td>
                        <td>
                          <select class=" input-xlarge chzn-select" name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male">Male </option>
                            <option value="female">Female </option>
                            <option value="other">Other </option>
                          </select>
                          <script type="text/javascript">
                            document.getElementById('gender').value = '<?php echo $gender; ?>'
                          </script>
                        </td>

                        <td><input class="input-xlarge" type="file" name="imgname" id="imgname" value="<?php echo $imgname; ?>"><img id="blah" style="height:50px;" alt="" title='Text Image' src='<?php if ($imgname1 != "") {
                                                                                                                                                                                                      echo "uploaded/studentimg/" . $imgname1;
                                                                                                                                                                                                    } elseif ($imgname != "" && file_exists("uploaded/scholer_stu_img/" . $imgname)) {
                                                                                                                                                                                                      echo "uploaded/scholer_stu_img/" . $imgname;
                                                                                                                                                                                                    } ?>' /></td>


                      </tr>
                      <tr>
                        <th>Address<span style="color:#F00;">*</span></th>
                        <th>Course<span style="color:#F00;">*</span></th>
                        <th>DOA</th>


                      </tr>
                      <tr>
                        <td> <textarea name="address" id="address" placeholder="Enter Address"><?php echo $address; ?></textarea></td>
                        <td> <input type="text" name="course_name" id="course_name" class="input-xlarge" value="<?php echo $course_name; ?>" autofocus autocomplete="off" placeholder="Enter Course" />
                        </td>
                        <td> <input type="text" name="doa" id="doa" class="input-xlarge" value="<?php echo $obj->dateformatindia($doa); ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy" />
                        </td>


                      </tr>
                      <tr>
                        <th>Admission No.</th>
                        <th>TC Issue Date</th>
                        <th>Enrollment No.</th>



                      </tr>
                      <tr>
                        <td><input type="text" name="admissionno" id="admissionno" class="input-xlarge" value="<?php echo $admissionno; ?>" autofocus autocomplete="off" placeholder="Enter Admission No." />
                        <td><input type="text" name="tc_issue_date" id="tc_issue_date" class="input-xlarge" value="<?php echo $obj->dateformatindia($tc_issue_date); ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy" /></td>
                        <td><input type="text" name="enrollment" id="enrollment" class="input-xlarge" value="<?php echo $enrollment; ?>" autofocus autocomplete="off" placeholder="Enter Enrollment No." />
                        </td>



                      </tr>
                      <tr>
                        <th>City</th>
                        <th>Remark</th>
                        <th></th>
                      </tr>
                      <tr>

                        <td> <select name="dis_id" id="dis_id" style="width:280px;" class="chzn-select">
                            <option value="">--Select--</option>
                            <?php
                            $res = $obj->executequery("select * from m_district");
                            foreach ($res as $row) {
                            ?>
                              <option value="<?php echo $row['dis_id']; ?>"><?php echo $row['dis_name']; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <script>
                            document.getElementById('dis_id').value = '<?php echo $dis_id; ?>';
                          </script>
                        </td>
                        <td> <input type="text" name="result" id="result" class="input-xlarge" value="<?php echo $result; ?>" autofocus autocomplete="off" placeholder="Enter Remark" /></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('scholer_no,m_student_reg_id,father_name,mother_name,dob,last_qualification,category_id,gender,address,course_name'); ">
                            <?php echo $btn_name; ?></button>
                          <a href="<?php echo $pagename; ?>" name="reset" id="reset" class="btn btn-success">Reset</a>
                          <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                        </td>

                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <p align="right" style="margin-top:7px; margin-right:10px;"> <a href='pdf_scholarship.php' class="btn btn-info" target="_blank">
              <span>Print PDF</span></a>

          </p>

          <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
          <div style="width: auto; overflow:auto;">
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
                  <th class="head0 nosort">Scholar_No.</th>
                  <th class="head0 nosort">Name of Student</th>
                  <th class="head0 nosort">Father Name</th>
                  <th class="head0 nosort">Mother Name</th>
                   <th class="head0 nosort">Gender</th>
                  <th class="head0">DOB</th>
                  <th class="head0 nosort">Category</th>
                  <th class="head0">Address</th>
                  <th class="head0">Admission in Course</th>
                  <th class="head0">D O A</th>
                  <th class="head0">Admission No.</th>
                  <th class="head0">Enrollment No.</th>
                  <th class="head0">TC Issu Date</th>
                  <th class="head0">Photo</th>
                  <th width="5%" class="head0">Edit</th>
                  <?php $chkdel = $obj->check_delBtn("scholership_form.php", $loginid);

                  if ($chkdel == 1 || $loginid == 1) {  ?>
                    <th width="5%" class="head0">Delete</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>

                <?php
                $slno = 1;

                $res = $obj->executequery("select * from scholer_ship order by scholership_id desc");
                foreach ($res as $row_get) {
                  $scholership_id = $row_get['scholership_id'];
                  $imgname = $row_get['imgname'];
                  $category_id = $row_get['category_id'];
                  $dis_id = $row_get['dis_id'];
                  $m_student_reg_id = $row_get['m_student_reg_id'];
                  $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
                  $district_name = $obj->getvalfield("m_district", "dis_name", "dis_id='$dis_id'");
                  $cat_name = $obj->getvalfield("m_category", "cat_name", "category_id='$category_id'");
                ?>
                  <tr>
                    <td><?php echo $slno++; ?></td>
                    <td><?php echo $row_get['scholer_no']; ?></td>
					          <td><?php echo $stu_name; ?></td>
                    <td><?php echo $row_get['father_name']; ?></td>
                    <td><?php echo $row_get['mother_name']; ?></td>
                    <td><?php echo $row_get['gender']; ?></td>
                    <td><?php echo $obj->dateformatindia($row_get['dob']); ?><br></td>
                    <td><?php echo $cat_name; ?></td>
                    <td><?php echo $row_get['address']; ?></td>
                    <td><?php echo $row_get['course_name']; ?></td>
                    <td><?php echo $obj->dateformatindia($row_get['doa']); ?></td>
                    <td><?php echo $row_get['admissionno']; ?></td>
                    <td><?php echo $row_get['enrollment']; ?></td>
                    <td><?php echo $obj->dateformatindia($row_get['tc_issue_date']); ?>
                    </td>

                    <td><?php if ($imgname != "") { ?><img height="100" width="100" style="height: 50px;" src="uploaded/scholer_stu_img/<?php echo $imgname; ?>"><?php } ?></td>

                    <td><a class='icon-edit' title="Edit" href='scholership_form.php?scholership_id=<?php echo $scholership_id; ?>'></a></td>
                    <?php if ($chkdel == 1 || $loginid == 1) {  ?>
                      <td width="5%"><a class='icon-remove' title="Delete" onclick='funDel(<?php echo $scholership_id; ?>);' style='cursor:pointer'></a></td>
                    <?php } ?>
                  </tr>


                <?php
                }
                ?>
              </tbody>
            </table>
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
  <script>
    function funDel(id) { //alert(id);
      tblname = '<?php echo $tblname; ?>';
      tblpkey = '<?php echo $tblpkey; ?>';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      imgpath = '<?php echo $imgpath; ?>';
      module = '<?php echo $module; ?>';
      // alert(imgpath);
      if (confirm("Are you sure! You want to delete this record.")) {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax/delete_scholer_stu_img.php',
          data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module + '&imgpath=' + imgpath,
          dataType: 'html',
          success: function(data) {
            //alert(data);
            location = '<?php echo $pagename . "?action=3"; ?>';
          }

        }); //ajax close
      } //confirm close
    } //fun close


    jQuery('#dob').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#doa').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#tc_issue_date').mask('99-99-9999', {
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

      var $url = 'scholership_form.php?m_student_reg_id=' + m_student_reg_id;

      location = $url

    }
    jQuery(document).ready(function() {
      jQuery('#menues').click();
    });
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
</body>

</html>