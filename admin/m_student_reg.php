<?php include("../adminsession.php");
$pagename = "m_student_reg.php";
$module = "Student Registration";
$submodule = "STUDENT REGISTRATION";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "m_student_reg";
$tblpkey = "m_student_reg_id";
$imgpath = "uploaded/studentimg/";
if (isset($_GET['m_student_reg_id'])) {
  $keyvalue = $_GET['m_student_reg_id'];
} else {
  $keyvalue = 0;
}

$sessionid = $obj->getvalfield("m_session", "sessionid", "status=1");
$session_name = $obj->getvalfield("m_session", "session_name", "sessionid=$sessionid");
if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$other_course_name = "";
$other_board_name = "";
$other_pass_year = "";
$other_roll = "";
$other_subject = "";
$other_tot_mark = "";
$other_obtain_mark = "";
$other_percent = "";
$status = "";
$dup = "";
$remark = "";
$admission_year = $class_id = $stu_name = $dob = $enrollment  = $gender = $aadhar_no = $cast = $address  = $pincode = $mobile = $samgra_id = $biometric_code = $sem_id = $admission_date = $con_id = $application_no = "";
$dis_id = "";
$stu_mobile = "";
$imgname = "";
$board_name_10 = "";
$pass_year_10 = "";
$roll_10 = "";
$subject_10 = "";
$tot_mark_10 = "";
$obtain_mark_10 = "";
$percent_10 = "";
$board_name_12 = "";
$pass_year_12 = "";
$roll_12 = "";
$subject_12 = "";
$tot_mark_12 = "";
$obtain_mark_12 = "";
$percent_12 = "";
$provisional_date = "";
$father_name = "";
$mother_name = "";
$parent_mobile = "";
$parent_aadhar_no = "";
$f_income = $ward_no = $tehsil = $post_office = $address2 = "";
$income_certif_expiry_date='';
if (isset($_POST['submit'])) {
  //print_r($_POST);die;
  $admission_year  = $_POST['admission_year'];
  $class_id = $_POST['class_id'];
  $dob = $obj->dateformatusa($_POST['dob']);
  $stu_name  = $_POST['stu_name'];
  $gender = $_POST['gender'];
  $enrollment = $_POST['enrollment'];
  $stu_mobile = $_POST['stu_mobile'];
  $aadhar_no = $_POST['aadhar_no'];
  $samgra_id = $_POST['samgra_id'];
  $provisional_date = $obj->dateformatusa($_POST['provisional_date']);
  $income_certif_expiry_date = $obj->dateformatusa($_POST['income_certif_expiry_date']);
  $board_name_10  = $_POST['board_name_10'];
  $pass_year_10 = $_POST['pass_year_10'];
  $roll_10 = $_POST['roll_10'];
  $subject_10 = $_POST['subject_10'];
  $tot_mark_10 = $_POST['tot_mark_10'];
  $obtain_mark_10 = $_POST['obtain_mark_10'];
  $percent_10 = $_POST['percent_10'];
  $board_name_12 = $_POST['board_name_12'];
  $roll_12  = $_POST['roll_12'];
  $pass_year_12 = $_POST['pass_year_12'];
  $subject_12 = $_POST['subject_12'];
  $tot_mark_12 = $_POST['tot_mark_12'];
  $obtain_mark_12 = $_POST['obtain_mark_12'];
  $percent_12 = $_POST['percent_12'];
  $other_course_name = $_POST['other_course_name'];
  $other_board_name = $_POST['other_board_name'];
  $other_roll  = $_POST['other_roll'];
  $other_pass_year = $_POST['other_pass_year'];
  $other_subject = $_POST['other_subject'];
  $other_tot_mark = $_POST['other_tot_mark'];
  $other_obtain_mark = $_POST['other_obtain_mark'];
  $other_percent = $_POST['other_percent'];
  $father_name  = $_POST['father_name'];
  $mother_name = $_POST['mother_name'];
  $parent_mobile  = $_POST['parent_mobile'];
  $parent_aadhar_no = $_POST['parent_aadhar_no'];
  $f_income = $_POST['f_income'];
  $application_no = $_POST['application_no'];
  $ward_no = $obj->test_input($_POST['ward_no']);
  $tehsil = $obj->test_input($_POST['tehsil']);
  $post_office = $obj->test_input($_POST['post_office']);
  $address2 = $obj->test_input($_POST['address2']);
  if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
  } else {
    $category_id = "";
  }
  if (isset($_POST['dis_id'])) {
    $dis_id = $_POST['dis_id'];
  } else {
    $dis_id = "";
  }
  if (isset($_POST['con_id'])) {
    $con_id = $_POST['con_id'];
  } else {
    $con_id = "";
  }
  $status = $_POST['status'];
  $address = $_POST['address'];
  $cast = $_POST['cast'];
  $pincode =  $_POST['pincode'];
  $mobile =  $_POST['mobile'];
  $biometric_code = $_POST['biometric_code'];
  $sem_id  = $_POST['sem_id'];
  $admission_date = $obj->dateformatusa($_POST['admission_date']);
  $remark = $_POST['remark'];
  $imgname = $_FILES['imgname'];



  if ($keyvalue == 0) {
    $form_data = array('admission_year' => $admission_year, 'class_id' => $class_id, 'dob' => $dob, 'stu_name' => $stu_name, 'gender' => $gender, 'con_id' => $con_id, 'enrollment' => $enrollment, 'aadhar_no' => $aadhar_no, 'category_id' => $category_id, 'address' => $address, 'cast' => $cast, 'district' => $dis_id, 'pincode' => $pincode, 'mobile' => $mobile, 'samgra_id' => $samgra_id, 'admission_date' => $admission_date, 'stu_mobile' => $stu_mobile, 'biometric_code' => $biometric_code, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate, 'remark' => $remark, 'status' => $status, 'board_name_10' => $board_name_10, 'pass_year_10' => $pass_year_10, 'roll_10' => $roll_10, 'subject_10' => $subject_10, 'tot_mark_10' => $tot_mark_10, 'obtain_mark_10' => $obtain_mark_10, 'percent_10' => $percent_10, 'board_name_12' => $board_name_12, 'roll_12' => $roll_12, 'pass_year_12' => $pass_year_12, 'subject_12' => $subject_12, 'tot_mark_12' => $tot_mark_12, 'obtain_mark_12' => $obtain_mark_12, 'percent_12' => $percent_12, 'other_course_name' => $other_course_name, 'other_board_name' => $other_board_name, 'other_roll' => $other_roll, 'other_pass_year' => $other_pass_year, 'other_subject' => $other_subject, 'other_tot_mark' => $other_tot_mark, 'other_obtain_mark' => $other_obtain_mark, 'other_percent' => $other_percent, 'provisional_date' => $provisional_date, 'father_name' => $father_name, 'mother_name' => $mother_name, 'parent_mobile' => $parent_mobile, 'parent_aadhar_no' => $parent_aadhar_no, 'f_income' => $f_income, 'application_no' => $application_no,'income_certif_expiry_date'=>$income_certif_expiry_date,'ward_no'=>$ward_no,'tehsil'=>$tehsil,'post_office'=>$post_office,'address2'=>$address2);
    //$obj->insert_record($tblname,$form_data);
    $lastid = $obj->insert_record_lastid("m_student_reg", $form_data);
    //print_r($form_data);die;
    $uploaded_filename = $obj->uploadImage($imgpath, $imgname);
    //print_r($uploaded_filename);die;
    $form_data1 = array('imgname' => $uploaded_filename);
    $where = array($tblpkey => $lastid);
    $obj->update_record($tblname, $where, $form_data1);

    $form_data2 = array('sem_id' => $sem_id, 'sessionid' => $sessionid, 'm_student_reg_id' => $lastid, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate);
    $obj->insert_record("class_transfer", $form_data2);
    $action = 1;
    $process = "insert";
    echo "<script>location='document_upload.php?m_student_reg_id=$lastid'</script>";
  } else {
    //update

    $form_data = array('admission_year' => $admission_year, 'class_id' => $class_id, 'dob' => $dob, 'stu_name' => $stu_name, 'con_id' => $con_id, 'gender' => $gender, 'enrollment' => $enrollment, 'aadhar_no' => $aadhar_no, 'category_id' => $category_id, 'address' => $address, 'cast' => $cast, 'district' => $dis_id, 'pincode' => $pincode, 'mobile' => $mobile, 'samgra_id' => $samgra_id, 'stu_mobile' => $stu_mobile, 'biometric_code' => $biometric_code, 'admission_date' => $admission_date, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate, 'remark' => $remark, 'status' => $status, 'board_name_10' => $board_name_10, 'pass_year_10' => $pass_year_10, 'roll_10' => $roll_10, 'subject_10' => $subject_10, 'tot_mark_10' => $tot_mark_10, 'obtain_mark_10' => $obtain_mark_10, 'percent_10' => $percent_10, 'board_name_12' => $board_name_12, 'roll_12' => $roll_12, 'pass_year_12' => $pass_year_12, 'subject_12' => $subject_12, 'tot_mark_12' => $tot_mark_12, 'obtain_mark_12' => $obtain_mark_12, 'percent_12' => $percent_12, 'other_course_name' => $other_course_name, 'other_board_name' => $other_board_name, 'other_roll' => $other_roll, 'other_pass_year' => $other_pass_year, 'other_subject' => $other_subject, 'other_tot_mark' => $other_tot_mark, 'other_obtain_mark' => $other_obtain_mark, 'other_percent' => $other_percent, 'provisional_date' => $provisional_date, 'father_name' => $father_name, 'mother_name' => $mother_name, 'parent_mobile' => $parent_mobile, 'parent_aadhar_no' => $parent_aadhar_no, 'f_income' => $f_income, 'application_no' => $application_no,'income_certif_expiry_date'=>$income_certif_expiry_date,'ward_no'=>$ward_no,'tehsil'=>$tehsil,'post_office'=>$post_office,'address2'=>$address2);
    $where = array($tblpkey => $keyvalue);
    $obj->update_record($tblname, $where, $form_data);
    if ($_FILES['imgname']['tmp_name'] != "") {

      //delete old file
      $oldimg = $obj->getvalfield("$tblname", "imgname", "$tblpkey='$keyvalue'");

      if ($oldimg != "")
        @unlink("uploaded/studentimg/$oldimg");

      $uploaded_filename = $obj->uploadImage($imgpath, $imgname);
      // print_r($uploaded_filename);die;
      $form_data = array('imgname' => $uploaded_filename);
      $where = array($tblpkey => $keyvalue);
      $obj->update_record($tblname, $where, $form_data);
    }
    $action = 2;
    $process = "updated";
  }

  echo "<script>location='$pagename?action=$action'</script>";
}
if (isset($_GET[$tblpkey])) {

  $btn_name = "Update";
  $where = array($tblpkey => $keyvalue);
  $sqledit = $obj->select_record($tblname, $where);
  $admission_year =  $sqledit['admission_year'];
  $class_id =  $sqledit['class_id'];
  $dob =  $sqledit['dob'];
  $con_id =  $sqledit['con_id'];
  $gender =  $sqledit['gender'];
  $stu_name =  $sqledit['stu_name'];
  $enrollment =  $sqledit['enrollment'];
  $aadhar_no =  $sqledit['aadhar_no'];
  $category_id = $sqledit['category_id'];
  $provisional_date = $sqledit['provisional_date'];
  $address =  $sqledit['address'];
  $cast = $sqledit['cast'];
  $dis_id = $sqledit['district'];
  $pincode =  $sqledit['pincode'];
  $mobile = $sqledit['mobile'];
  $admission_date = $sqledit['admission_date'];
  $imgname = $sqledit['imgname'];
  $sem_id = $obj->getvalfield("class_transfer", "sem_id", "m_student_reg_id=$keyvalue");
  $remark = $sqledit['remark'];
  $biometric_code = $sqledit['biometric_code'];
  $stu_mobile = $sqledit['stu_mobile'];
  $samgra_id = $sqledit['samgra_id'];
  $status = $sqledit['status'];
  $board_name_10 =  $sqledit['board_name_10'];
  $roll_10 =  $sqledit['roll_10'];
  $pass_year_10 =  $sqledit['pass_year_10'];
  $subject_10 =  $sqledit['subject_10'];
  $tot_mark_10 =  $sqledit['tot_mark_10'];
  $obtain_mark_10 =  $sqledit['obtain_mark_10'];
  $percent_10 =  $sqledit['percent_10'];
  $board_name_12 =  $sqledit['board_name_12'];
  $roll_12 =  $sqledit['roll_12'];
  $pass_year_12 = $sqledit['pass_year_12'];
  $subject_12 =  $sqledit['subject_12'];
  $tot_mark_12 = $sqledit['tot_mark_12'];
  $obtain_mark_12 = $sqledit['obtain_mark_12'];
  $percent_12 = $sqledit['percent_12'];
  $other_course_name = $sqledit['other_course_name'];
  $other_board_name =  $sqledit['other_board_name'];
  $other_roll =  $sqledit['other_roll'];
  $other_pass_year = $sqledit['other_pass_year'];
  $other_subject =  $sqledit['other_subject'];
  $other_tot_mark = $sqledit['other_tot_mark'];
  $other_obtain_mark = $sqledit['other_obtain_mark'];
  $other_percent = $sqledit['other_percent'];
  $father_name =  $sqledit['father_name'];
  $mother_name =  $sqledit['mother_name'];
  $parent_mobile =  $sqledit['parent_mobile'];
  $parent_aadhar_no =  $sqledit['parent_aadhar_no'];
  $f_income = $sqledit['f_income'];
  $application_no = $sqledit['application_no'];
  $income_certif_expiry_date = $sqledit['income_certif_expiry_date'];
  $ward_no = $sqledit['ward_no'];
  $tehsil = $sqledit['tehsil'];
  $post_office = $sqledit['post_office'];
  $address2 = $sqledit['address2'];
} else {
  $admission_date = date('Y-m-d');
}
?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script>
    function Numberin(input) {
      var num = /[^0-9]/g;
      input.value = input.value.replace(num, "");
    }
  </script>
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
            <form class="stdform stdform2" method="post" action="" enctype="multipart/form-data">
              <div id="wizard2" class="wizard tabbedwizard">
                <?php include("inc/tabmenu.php"); ?>
                <div>
                  <h4 style="color:blue">Step 1: Student Registration</h4>
                  <?php echo $dup; ?>
                  <div class="lg-12 md-12 sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <th>Admission Year<span style="color:#F00;">*</span></th>
                        <th>Course For<span style="color:#F00;">*</span></th>
                        <th>Semester Name <span style="color:#F00;">*</span></th>

                      </tr>
                      <tr>
                        <td> <input type="text" name="admission_year" id="admission_year" class="input-xlarge" value="<?php echo $session_name; ?>" autofocus autocomplete="off" placeholder="Enter Admission Year" /></td>

                        <td><select name="class_id" id="class_id" style="width:280px;" class="chzn-select">
                            <option value="">--Select--</option>
                            <?php
                            $res = $obj->executequery("select * from m_class");
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

                        <td><select name="sem_id" id="sem_id" style="width:280px;" class="chzn-select">
                            <option value="">--Select--</option>
                            <?php
                            $res = $obj->executequery("select * from m_semester");
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

                      </tr>
                      <tr>
                        <th>Student Name<span style="color:#F00;">*</span></th>
                        <th>Enrollment No.<span style="color:#F00;"></span></th>
                        <th>DOB.<span style="color:#F00;"></span></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="stu_name" id="stu_name" class="input-xlarge" value="<?php echo $stu_name; ?>" autofocus autocomplete="off" placeholder="Enter Student Name" /></td>

                        <td> <input type="text" name="enrollment" id="enrollment" class="input-xlarge" value="<?php echo $enrollment; ?>" autofocus autocomplete="off" placeholder="Enter Enrollment No" /></td>

                        <td> <input type="text" name="dob" id="dob" class="input-xlarge" value="<?php echo $obj->dateformatindia($dob); ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                      </tr>
                      <tr>
                        <th>Gender<span style="color:#F00;"></span></th>
                        <th>Category<span style="color:#F00;"></span></th>
                        <th>Application No. <span style="color:#F00;">(MP ONLINE)</span></th>

                      </tr>
                      <tr>
                        <td><select name="gender" id="gender" class="chzn-select" style="width:283px;">
                            <option value="">--Select--</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                          </select>
                          <script>
                            document.getElementById('gender').value = '<?php echo $gender; ?>';
                          </script>
                        </td>


                        <td><select name="category_id" id="category_id" style="width:280px;" class="chzn-select">
                            <option value="">--Select--</option>
                            <?php
                            $res = $obj->executequery("select * from m_category");
                            foreach ($res as $row) {
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
                        <td><input type="text" name="application_no" id="application_no" class="input-xlarge" value="<?php echo $application_no; ?>" placeholder="Enter Application No." /></td>


                      </tr>
                      <tr>

                        <th>Cast<span style="color:#F00;"></span></th>
                        <th>Biometric Code<span style="color:#F00;"></span></th>

                        <th>Passport size color photo (Max Size: 100 KB)</th>


                      </tr>
                      <tr>

                        <td> <input type="text" name="cast" id="cast" class="input-xlarge" value="<?php echo $cast; ?>" placeholder="Enter Cast" /></td>

                        <td> <input type="text" name="biometric_code" id="biometric_code" class="input-xlarge" value="<?php echo $biometric_code; ?>" placeholder="Enter IFSC Code" />
                        </td>

                        <td><input type="file" name="imgname" id="imgname"><img id="blah" alt="" height='50px;' width="50px;" title='Text Image' src='<?php if ($imgname != "" && file_exists("uploaded/studentimg/" . $imgname)) {
                        echo "uploaded/studentimg/" . $imgname;
                        } ?>' /> </td>
                        </tr>
                        <tr>
                        <th>Correspondence Address<span style="color:#F00;"></span></th>
                        <th>District<span style="color:#F00;"></span></th>
                        <th>Pincode<span style="color:#F00;"></span></th>
                        </tr>
                        <tr>
                        <td> <input type="text" name="address" id="address" class="input-xlarge" value="<?php echo $address; ?>" placeholder="Enter Address" />
                        </td>

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
                        <td> <input type="text" name="pincode" id="pincode" class="input-xlarge" value="<?php echo $pincode; ?>" placeholder="Enter Pincode" />
                        </td>

                      </tr>

                      <tr>
                        <th>Ward Number<span style="color:#F00;"></span></th>
                        <th>Tehsil<span style="color:#F00;"></span></th>
                        <th>Post Office<span style="color:#F00;"></span></th>
                        </tr>

                        <tr>
                          <td> <input type="text" name="ward_no" id="ward_no" placeholder="Enter Ward Number" class="input-xlarge" value="<?php echo $ward_no; ?>" autofocus autocomplete="off" />
                          </td>

                          <td> <input type="text" name="tehsil" id="tehsil" placeholder="Enter Tehsil" class="input-xlarge" value="<?php echo $tehsil; ?>" autofocus autocomplete="off" /></td>
                          <td> <input type="text" name="post_office" id="post_office" placeholder="Enter Post Office" class="input-xlarge" value="<?php echo $post_office; ?>" autofocus autocomplete="off" /></td>
                      </tr>
                      <tr>
                        <th>Village/Mohalla<span style="color:#F00;"></span></th>
                        <th>Student Mobile No.1<span style="color:#F00;"></span></th>
                        <th>Student Mobile No.2<span style="color:#F00;"></span></th>
                      </tr>

                      <tr>
                         <td> <input type="text" name="address2" id="address2" placeholder="Enter Tehsil" class="input-xlarge" value="<?php echo $address2; ?>" autofocus autocomplete="off" /></td>
                          <td> <input type="text" name="mobile" id="mobile" class="input-xlarge" maxlength="10" value="<?php echo $mobile; ?>" onkeyup="Numberin(this);" placeholder="Enter Student Mobile No" />
                        </td>
                        <td><input type="text" name="stu_mobile" id="stu_mobile" class="input-xlarge" maxlength="10" value="<?php echo $stu_mobile; ?>" onkeyup="Numberin(this);" placeholder="Enter Student Mobile No" />
                        </td>
                      </tr>
                      <tr>
                        
                        <th>Student Admission Date<span style="color:#F00;"></span></th>
                        <th>Counselor Name</th>
                        <th>Status</th>

                      </tr>
                      <tr>
                       
                        <td><input type="text" name="admission_date" id="admission_date" class="input-xlarge" value="<?php echo $obj->dateformatindia($admission_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask placeholder='dd-mm-yyyy' />
                        </td>

                        <td><select name="con_id" id="con_id" style="width:280px;" class="chzn-select">
                            <option value="">--Select--</option>
                            <?php
                            $res = $obj->executequery("select * from counselor_master");
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
                          <select name="status" id="status" style="width:280px;" class="chzn-select">
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

                        <th>Samagra ID<span style="color:#F00;"></span></th>
                        <th>Provisional Date</th>
                        <th>Aadhar No.</th>
                      </tr>
                      <tr>

                        <td><input type="text" name="samgra_id" id="samgra_id" class="input-xlarge" value="<?php echo $samgra_id; ?>" placeholder="Enter Samgra ID" /></td>
                        <td><input type="text" name="provisional_date" id="provisional_date" class="input-xlarge" value="<?php echo $obj->dateformatindia($provisional_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask placeholder='dd-mm-yyyy' />
                        </td>
                        <td><input type="text" name="aadhar_no" id="aadhar_no" class="input-xlarge" value="<?php echo $aadhar_no; ?>" autofocus autocomplete="off" placeholder="Enter Aadhar No." /></td>
                      </tr>

                       <tr>
                        
                        <th colspan="3">Remark</th>
                        

                      </tr>
                      <tr>
                        

                        <td colspan="3">
                          <textarea type="text" name="remark" id="remark" class="input-xlarge" placeholder="Enter Remark" style="width: 95%;"><?php echo $remark; ?></textarea>
                        </td>

                        

                      </tr>

                    </table>
                  </div>
                </div>
                <br>
                <div style="margin-top: 20px;">
                  <h4 style="color:blue">Step 2: 10th Details : </h4>

                  <div class="lg-12 md-12 sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <th>Name Of Board<span style="color:#F00;"></span></th>
                        <th>Passing Year<span style="color:#F00;"></span></th>
                        <th>Roll No. <span style="color:#F00;"></span></th>
                        <th>Subject<span style="color:#F00;"></span></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="board_name_10" id="board_name_10" class="input-large" value="<?php echo $board_name_10; ?>" autofocus autocomplete="off" placeholder="Enter Name Of 10th Board" /></td>

                        <td><input type="text" name="pass_year_10" id="pass_year_10" class="input-large" value="<?php echo $pass_year_10; ?>" autofocus autocomplete="off" placeholder="Enter Passing Year" /></td>

                        <td><input type="text" name="roll_10" id="roll_10" class="input-large" value="<?php echo $roll_10; ?>" autofocus autocomplete="off" placeholder="Enter Roll No." /></td>
                        <td> <input type="text" name="subject_10" id="subject_10" class="input-large" value="<?php echo $subject_10; ?>" autofocus autocomplete="off" placeholder="Enter Subject" /></td>
                      </tr>
                      <tr>
                        <th>Total Marks<span style="color:#F00;"></span></th>
                        <th>Obtain Mark<span style="color:#F00;"></span></th>
                        <th>Percent(%)<span style="color:#F00;"></span></th>
                        <th></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="tot_mark_10" id="tot_mark_10" onkeyup="calTenthper();" class="input-large" value="<?php echo $tot_mark_10; ?>" autofocus autocomplete="off" placeholder="Enter Total Marks" /></td>

                        <td> <input type="text" name="obtain_mark_10" id="obtain_mark_10" onkeyup="calTenthper();" class="input-large" value="<?php echo $obtain_mark_10; ?>" autofocus autocomplete="off" placeholder="Enter Obtain Marks" /></td>
                        <td> <input type="text" name="percent_10" maxlength="5" id="percent_10" class="input-large" value="<?php echo $percent_10; ?>" autofocus autocomplete="off" placeholder="Percent(%)" /></td>
                        <td></td>
                      </tr>
                    
                    </table>
                  </div>
                </div>

                <div style="margin-top: 20px;">
                  <h4 style="color:blue">Step 3: 12th Details : </h4>

                  <div class="lg-12 md-12 sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <th>Name Of Board<span style="color:#F00;"></span></th>
                        <th>Passing Year<span style="color:#F00;"></span></th>
                        <th>Roll No. <span style="color:#F00;"></span></th>
                        <th>Subject<span style="color:#F00;"></span></th>

                      </tr>
                      <tr>
                        <td> <input type="text" name="board_name_12" id="board_name_12" class="input-large" value="<?php echo $board_name_12; ?>" autofocus autocomplete="off" placeholder="Enter Name Of 12th Board" /></td>

                        <td><input type="text" name="pass_year_12" id="pass_year_12" class="input-large" value="<?php echo $pass_year_12; ?>" autofocus autocomplete="off" placeholder="Enter Passing Year" /></td>

                        <td><input type="text" name="roll_12" id="roll_12" class="input-large" value="<?php echo $roll_12; ?>" autofocus autocomplete="off" placeholder="Enter Roll No." /></td>

                        <td> <input type="text" name="subject_12" id="subject_12" class="input-large" value="<?php echo $subject_12; ?>" autofocus autocomplete="off" placeholder="Enter Subject" /></td>

                      </tr>


                      <tr>

                        <th>Total Marks<span style="color:#F00;"></span></th>
                        <th>Obtain Mark<span style="color:#F00;"></span></th>
                        <th>Percent(%)<span style="color:#F00;"></span></th>
                        <th></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="tot_mark_12" id="tot_mark_12" onkeyup="calTwelthper();" class="input-large" value="<?php echo $tot_mark_12; ?>" autofocus autocomplete="off" placeholder="Enter Total Marks" /></td>

                        <td> <input type="text" name="obtain_mark_12" id="obtain_mark_12" onkeyup="calTwelthper();" class="input-large" value="<?php echo $obtain_mark_12; ?>" autofocus autocomplete="off" placeholder="Enter Obtainboard_name_12 Marks" /></td>

                        <td> <input type="text" name="percent_12" id="percent_12" class="input-large" value="<?php echo $percent_12; ?>" autofocus autocomplete="off" placeholder="Percent(%)" /></td>

                        <td></td>
                      </tr>

                    </table>
                  </div>
                </div>
                <br>
                <div style="margin-top: 20px;">
                  <h4 style="color:blue">Step 4: Others Details : </h4>

                  <div class="lg-12 md-12 sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <th>Other Course Name<span style="color:#F00;"></span></th>
                        <th>Other Name Of Board<span style="color:#F00;"></span></th>
                        <th>Other Passing Year<span style="color:#F00;"></span></th>
                        <th>Other Roll No. <span style="color:#F00;"></span></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="other_course_name" id="other_course_name" class="input-large" value="<?php echo $other_course_name; ?>" autofocus autocomplete="off" placeholder="Enter Other Course Name" /></td>

                        <td> <input type="text" name="other_board_name" id="other_board_name" class="input-large" value="<?php echo $other_board_name; ?>" autofocus autocomplete="off" placeholder="Enter Other Name Of Board" /></td>

                        <td><input type="text" name="other_pass_year" id="other_pass_year" class="input-large" value="<?php echo $other_pass_year; ?>" autofocus autocomplete="off" placeholder="Enter Other Passing Year" /></td>

                        <td><input type="text" name="other_roll" id="other_roll" class="input-large" value="<?php echo $other_roll; ?>" autofocus autocomplete="off" placeholder="Enter Other Roll No." /></td>
                      </tr>
                      <tr>
                        <th>Other Subject<span style="color:#F00;"></span></th>
                        <th>Other Total Marks<span style="color:#F00;"></span></th>
                        <th>Other Obtain Mark<span style="color:#F00;"></span></th>
                        <th>Other Percent(%)<span style="color:#F00;"></span></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="other_subject" id="other_subject" class="input-large" value="<?php echo $other_subject; ?>" autofocus autocomplete="off" placeholder="Enter Other Subject" /></td>
                        <td> <input type="text" name="other_tot_mark" id="other_tot_mark" onkeyup="calOtherper();" class="input-large" value="<?php echo $other_tot_mark; ?>" autofocus autocomplete="off" placeholder="Enter Other Obtainboard_name Marks" /></td>

                        <td> <input type="text" name="other_obtain_mark" id="other_obtain_mark" onkeyup="calOtherper();" class="input-large" value="<?php echo $other_obtain_mark; ?>" autofocus autocomplete="off" placeholder="Enter Other Total Marks" /></td>

                        <td> <input type="text" name="other_percent" id="other_percent" class="input-large" value="<?php echo $other_percent; ?>" autofocus autocomplete="off" placeholder=" Other Percent(%)" /></td>
                      </tr>

                    </table>
                  </div>
                </div>

                <br>
                <div style="margin-top: 20px;">
                  <h4 style="color:blue">Step 5: Parent Details : </h4>

                  <div class="lg-12 md-12 sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <th>Father's Name<span style="color:#F00;">*</span></th>
                        <th>Mother's Name<span style="color:#F00;">*</span></th>
                        <th>Father's Aadhar No.<span style="color:#F00;">*</span></th>
                        <th>Annual Family Income<span style="color:#F00;">*</span></th>
                      </tr>
                      <tr>
                        <td> <input type="text" name="father_name" id="father_name" class="input-large" value="<?php echo $father_name; ?>" autofocus autocomplete="off" placeholder="Enter Father's Name" /></td>

                        <td> <input type="text" name="mother_name" id="mother_name" class="input-large" value="<?php echo $mother_name; ?>" autofocus autocomplete="off" placeholder="Enter Mother's Name" /></td>

                        <td><input type="text" name="parent_aadhar_no" id="parent_aadhar_no" class="input-large" value="<?php echo $parent_aadhar_no; ?>" autofocus autocomplete="off" placeholder="Enter Parents Aadhar No" /></td>

                        <td><input type="text" name="f_income" id="f_income" class="input-large" value="<?php echo $f_income; ?>" autofocus autocomplete="off" placeholder="Enter Annual Family Income" /></td>
                      </tr>
                      <tr>
                        <th>Parents Contact No<span style="color:#F00;"></span></th>
                        <th>Income Certificate Expiry Date<span style="color:#F00;"></span></th>
                        <th colspan="2"></th>

                      </tr>
                      <tr>
                        <td> <input type="text" name="parent_mobile" id="parent_mobile" class="input-large" value="<?php echo $parent_mobile; ?>" autofocus autocomplete="off" placeholder="Enter Mobile No." /></td>
                        <td><input type="text" name="income_certif_expiry_date" id="income_certif_expiry_date" class="input-large" value="<?php echo $obj->dateformatindia($income_certif_expiry_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask placeholder='dd-mm-yyyy' />
                        </td>
                        <td colspan="2"></td>

                      </tr>

                      <tr>
                        <td colspan="3">
                          <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('admission_year,class_id,sem_id,stu_name,father_name,mother_name,parent_aadhar_no,f_income'); ">
                            <?php echo $btn_name; ?></button>
                          <a href="m_student_reg.php" name="reset" id="reset" class="btn btn-success">Reset</a>
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
                <th class="head0">Biometric_Code</th>
                <th class="head0">Gender</th>
                <th class="head0">Mobile</th>
                <th class="head0">Action</th>
                <?php $chkedit = $obj->check_editBtn("m_student_reg.php", $loginid);

                if ($chkedit == 1 || $loginid == 1) {  ?>
                  <th width="4%" class="head0">Edit</th>
                <?php  }
                $chkdel = $obj->check_delBtn("m_student_reg.php", $loginid);

                if ($chkdel == 1 || $loginid == 1) {  ?>
                  <th width="5%" class="head0">Delete</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              
              <?php
              $slno = 1;

              $res = $obj->executequery("select * from class_transfer where sessionid=$sessionid order by m_student_reg_id desc");
              foreach ($res as $row_get) {
                $transferid = $row_get['transferid'];
                $m_student_reg_id = $row_get['m_student_reg_id'];
                $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id=$m_student_reg_id");
                //$college_name = $obj->getvalfield("m_student_reg", "college_name", "m_student_reg_id=$m_student_reg_id");
                $biometric_code = $obj->getvalfield("m_student_reg", "biometric_code", "m_student_reg_id=$m_student_reg_id");
                $gender = $obj->getvalfield("m_student_reg", "gender", "m_student_reg_id=$m_student_reg_id");
                // $rollno = $obj->getvalfield("m_student_reg", "rollno", "m_student_reg_id=$m_student_reg_id");
                $mobile = $obj->getvalfield("m_student_reg", "mobile", "m_student_reg_id=$m_student_reg_id");
              ?>
                <tr>
                  <td><?php echo $slno++; ?></td>
                  <td><?php echo $stu_name; ?></td>

                  <td><?php echo $biometric_code; ?></td>
                  <td><?php echo $gender; ?></td>

                  <td><?php echo $mobile; ?></td>
                  <td><a class="btn btn-danger" href="simple-html-invoice/simple-html-invoice-template-master/pdf_viewadmission.php?m_student_reg_id=<?php echo $row_get['m_student_reg_id']; ?>" target="_blank">Print</a></td>
                  <?php

                  if ($chkedit == 1 || $loginid == 1) {  ?>
                    <td><a class='icon-edit' title="Edit" href='m_student_reg.php?m_student_reg_id=<?php echo $row_get['m_student_reg_id']; ?>'></a></td>
                  <?php  }
                  if ($chkdel == 1 || $loginid == 1) {  ?>
                    <td>
                      <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $m_student_reg_id; ?>);' style='cursor:pointer'></a>
                    </td>
                  <?php } ?>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>

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
      //imgpath = '<?php echo $imgpath; ?>';
      module = '<?php echo $module; ?>';
      //alert(module); 
      if (confirm("Are you sure! You want to delete this record.")) {
        //ajax/delete_image_student_master.php
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


    jQuery('#admission_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#dob').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#provisional_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#income_certif_expiry_date').mask('99-99-9999', {
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
  </script>
  <script type="text/javascript">
    function calTenthper() {
      var tot_mark_10 = document.getElementById('tot_mark_10').value;
      var obtain_mark_10 = document.getElementById('obtain_mark_10').value;
      var percent_10 = obtain_mark_10 / tot_mark_10;
      var percent_10 = percent_10 * 100;
      var percent_10 = percent_10.toFixed(2);
      document.getElementById('percent_10').value = percent_10;
    }

    function calTwelthper() {
      var tot_mark_12 = document.getElementById('tot_mark_12').value;
      var obtain_mark_12 = document.getElementById('obtain_mark_12').value;
      var percent_12 = obtain_mark_12 / tot_mark_12;
      var percent_12 = percent_12 * 100;
      var percent_12 = percent_12.toFixed(2);
      document.getElementById('percent_12').value = percent_12;
    }

    function calOtherper() {
      var other_tot_mark = document.getElementById('other_tot_mark').value;
      var other_obtain_mark = document.getElementById('other_obtain_mark').value;
      var other_percent = other_obtain_mark / other_tot_mark;
      var other_percent = other_percent * 100;
      var other_percent = other_percent.toFixed(2);
      document.getElementById('other_percent').value = other_percent;
    }
  </script>
</body>

</html>