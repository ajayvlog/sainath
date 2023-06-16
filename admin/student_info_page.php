<?php include("../adminsession.php");
//print_r($_SESSION);die;
$loginid = $_SESSION['userid'];
$pagename = "student_info_page.php";
$module = "Student Personal Information";
$submodule = "STUDENT PERSONAL INFORMATION";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "student_info";
$tblpkey = "stu_id";
if (isset($_GET['stu_id']))
    $keyvalue = $_GET['stu_id'];
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
$district = "";
$dup = "";
$father_name = "";
$mother_name = "";
$m_student_reg_id = "";
$admission_year = "";
$date = date('Y-m-d');
$scholer_no = "";
$app_no = "";
$course_name = "";
$category = "";
$address = "";
$doa = "";
$aadhar_no = "";
$gender = "";
$dob = "";
$address = "";
$domicile = "";
$ward_no = "";
$tehsil = "";
$post_office = "";
$pincode = "";
$parent_mobile = "";
$stu_mobile = "";
$board_name_10 = "";
$pass_year_10 = "";
$roll_10 = "";
$tot_mark_10 = "";
$subject_10 = "";
$obtain_mark_10 = "";
$percent_10 = "";
$board_name_12 = "";
$pass_year_12 = "";
$roll_12 = "";

$tot_mark_12 = "";
$subject_12 = "";
$obtain_mark_12 = "";
$percent_12 = "";

$other_course_name = "";
$other_board_name = "";
$other_pass_year = "";
$other_roll = "";
$other_subject = "";
$other_tot_mark = "";
$other_obtain_mark = "";
$other_percent = "";

if (isset($_POST['submit'])) {
    //print_r($_POST);die;
    $m_student_reg_id = $obj->test_input($_POST['m_student_reg_id']);
    $father_name  = $obj->test_input($_POST['father_name']);
    $mother_name  = $obj->test_input($_POST['mother_name']);
    $course_name = $obj->test_input($_POST['course_name']);
    $admission_year =  $obj->test_input($_POST['admission_year']);
    $app_no = $obj->test_input($_POST['app_no']);
    $category = $obj->test_input($_POST['category']);
    $scholer_no = $obj->test_input($_POST['scholer_no']);
    // $password = $obj->test_input($_POST['password']);
    $doa = $obj->dateformatusa($_POST['doa']);
    $dob = $obj->dateformatusa($_POST['dob']);
    $aadhar_no = $obj->test_input($_POST['aadhar_no']);
    $gender = $obj->test_input($_POST['gender']);
    $domicile = $obj->test_input($_POST['domicile']);
    $address = $obj->test_input($_POST['address']);
    $ward_no = $obj->test_input($_POST['ward_no']);
    $tehsil = $obj->test_input($_POST['tehsil']);
    $post_office = $obj->test_input($_POST['post_office']);
    $district = $obj->test_input($_POST['district']);
    $pincode = $obj->test_input($_POST['pincode']);
    $parent_mobile = $obj->test_input($_POST['parent_mobile']);
    $stu_mobile = $obj->test_input($_POST['stu_mobile']);
    $board_name_10 = $obj->test_input($_POST['board_name_10']);
    $pass_year_10 = $obj->test_input($_POST['pass_year_10']);
    $roll_10 = $obj->test_input($_POST['roll_10']);
    $tot_mark_10 = $obj->test_input($_POST['tot_mark_10']);
    $subject_10 = $obj->test_input($_POST['subject_10']);
    $obtain_mark_10 = $obj->test_input($_POST['obtain_mark_10']);
    $percent_10 = $obj->test_input($_POST['percent_10']);
    $board_name_12 = $obj->test_input($_POST['board_name_12']);
    $pass_year_12 = $obj->test_input($_POST['pass_year_12']);
    $roll_12 = $obj->test_input($_POST['roll_12']);
    $tot_mark_12 = $obj->test_input($_POST['tot_mark_12']);
    $subject_12 = $obj->test_input($_POST['subject_12']);
    $obtain_mark_12 = $obj->test_input($_POST['obtain_mark_12']);
    $percent_12 = $obj->test_input($_POST['percent_12']);
    $other_course_name =  $obj->test_input($_POST['other_course_name']);
    $other_board_name =  $obj->test_input($_POST['other_board_name']);
    $other_pass_year =  $obj->test_input($_POST['other_pass_year']);
    $other_roll =  $obj->test_input($_POST['other_roll']);
    $other_subject =  $obj->test_input($_POST['other_subject']);
    $other_tot_mark =  $obj->test_input($_POST['other_tot_mark']);
    $other_obtain_mark =  $obj->test_input($_POST['other_obtain_mark']);
    $other_percent =  $obj->test_input($_POST['other_percent']);
    $other_mobile =  $obj->test_input($_POST['other_mobile']);
    $other_mobile1 =  $obj->test_input($_POST['other_mobile1']);


    //check Duplicate
    $cwhere = array("m_student_reg_id" => $_POST['m_student_reg_id']);
    // print_r($cwhere);
    // die;
    $count =  $obj->count_method("student_info", $cwhere);
    if ($count > 0) {
        $dup = "<div class='alert alert-danger'>
     <strong>Error!</strong> Duplicate Record.
     </div>";
        //echo $dup; die;
    } else {

        //update
        $form_data = array('m_student_reg_id' => $m_student_reg_id, 'father_name' => $father_name, 'mother_name' => $mother_name, 'admission_year' => $admission_year, 'course_name' => $course_name, 'app_no' => $app_no, 'category' => $category, 'scholer_no' => $scholer_no, 'doa' => $doa, 'dob' => $dob, 'aadhar_no' => $aadhar_no, 'gender' => $gender, 'domicile' => $domicile, 'address' => $address, 'ward_no' => $ward_no, 'tehsil' => $tehsil, 'post_office' => $post_office, 'district' => $district, 'pincode' => $pincode,  'stu_mobile' => $stu_mobile, 'mobile' => $parent_mobile, 'board_name_10' => $board_name_10, 'pass_year_10' => $pass_year_10, 'roll_10' => $roll_10, 'subject_10' => $subject_10, 'tot_mark_10' => $tot_mark_10, 'obtain_mark_10' => $obtain_mark_10, 'percent_10' => $percent_10, 'board_name_12' => $board_name_12, 'pass_year_12' => $pass_year_12, 'roll_12' => $roll_12, 'subject_12' => $subject_12, 'tot_mark_12' => $tot_mark_12, 'obtain_mark_12' => $obtain_mark_12, 'percent_12' => $percent_12, 'other_course_name' => $other_course_name, 'other_board_name' => $other_board_name, 'other_pass_year' => $other_pass_year, 'other_roll' => $other_roll, 'other_subject' => $other_subject, 'other_tot_mark' => $other_tot_mark, 'other_obtain_mark' => $other_obtain_mark, 'other_percent' => $other_percent, 'createdate' => $createdate, 'ipaddress' => $ipaddress,'other_mobile'=>$other_mobile,'other_mobile1'=>$other_mobile1);
        // print_r($form_data);
        // die;
        $obj->insert_record('student_info', $form_data);
        $action = 1;
        $process = "insert";
        // die;
        echo "<script>location='student_info_page.php?action=$action'</script>";

        //}
    }
}
if (isset($_GET['m_student_reg_id'])) {

    $btn_name = "Save";
    $m_student_reg_id = addslashes(trim($_GET['m_student_reg_id']));

    $where = array('m_student_reg_id' => $m_student_reg_id);
    $sqledit = $obj->select_record('m_student_reg', $where);
    $father_name =  $sqledit['father_name'];
    $admission_year =  $sqledit['admission_year'];
    $class_id =  $sqledit['class_id'];
    $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
    $address = $sqledit['address'];
    $dis_id = $sqledit['district'];
   $district = $obj->getvalfield("m_district", "dis_name", "dis_id='$dis_id'");
    $app_no = $sqledit['application_no'];
    $mother_name = $sqledit['mother_name'];
    $category_id = $sqledit['category_id'];
    $category = $obj->getvalfield("m_category", "cat_name", "category_id='$category_id'");
    $scholership_id = $obj->getvalfield("scholer_ship", "scholership_id", "m_student_reg_id='$m_student_reg_id'");
    $scholer_no = $obj->getvalfield("scholer_ship", "scholer_no", "scholership_id='$scholership_id'");
    $dob = $sqledit['dob'];
    $aadhar_no = $sqledit['aadhar_no'];
    $gender = $sqledit['gender'];
    $pincode = $sqledit['pincode'];
    $parent_mobile = $sqledit['parent_mobile'];
    $stu_mobile = $sqledit['stu_mobile'];
    $board_name_10 = $sqledit['board_name_10'];
    $pass_year_10 = $sqledit['pass_year_10'];
    $roll_10 = $sqledit['roll_10'];
    $subject_10 = $sqledit['subject_10'];
    $tot_mark_10 = $sqledit['tot_mark_10'];
    $obtain_mark_10 = $sqledit['obtain_mark_10'];
    $percent_10 = $sqledit['percent_10'];
    $board_name_12 = $sqledit['board_name_12'];
    $pass_year_12 = $sqledit['pass_year_12'];
    $roll_12 = $sqledit['roll_12'];
    $subject_12 = $sqledit['subject_12'];
    $tot_mark_12 = $sqledit['tot_mark_12'];
    $obtain_mark_12 = $sqledit['obtain_mark_12'];
    $percent_12 = $sqledit['percent_12'];
    $other_course_name = $sqledit['other_course_name'];
    $other_board_name = $sqledit['other_board_name'];
    $other_pass_year = $sqledit['other_pass_year'];
    $other_roll = $sqledit['other_roll'];
    $other_subject = $sqledit['other_subject'];
    $other_tot_mark = $sqledit['other_tot_mark'];
    $other_obtain_mark = $sqledit['other_obtain_mark'];
    $other_percent = $sqledit['other_percent'];
    $doa = $sqledit['admission_date'];
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

                                <div>
                                    <h4>Student Personal Information</h4>
                                    <?php echo $dup; ?>
                                    <div class="lg-12 md-12 sm-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Student Name<span style="color:#F00;">*</span></th>
                                                <th>Father's Name<span style="color:#F00;">*</span></th>
                                                <th>Mother's Name<span style="color:#F00;"></span></th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select name="m_student_reg_id" id="m_student_reg_id" style="width:280px;" class="chzn-select" onChange="getid(this.value);">
                                                        <option value="">--Select--</option>
                                                        <?php


                                                        $res = $obj->executequery("select * from m_student_reg");
                                                        foreach ($res as $row) {
                                                        ?>
                                                            <option value="<?php echo $row['m_student_reg_id']; ?>"><?php echo $row['stu_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <script>
                                                        document.getElementById('m_student_reg_id').value = '<?php echo $m_student_reg_id; ?>';
                                                    </script>
                                                </td>

                                                <td> <input type="text" name="father_name" id="father_name" class="input-xlarge" value="<?php echo $father_name; ?>" autofocus autocomplete="off" placeholder="Enter Father's Name" /></td>

                                                <td> <input type="text" name="mother_name" id="mother_name" class="input-xlarge" value="<?php echo $mother_name; ?>" autofocus autocomplete="off" placeholder="Enter Mother Name" /></td>

                                            </tr>

                                            <tr>
                                                <th>Course Name<span style="color:#F00;"></span></th>
                                                <th>Session<span style="color:#F00;"></span></th>
                                                <th>Application Number<span style="color:#F00;"></span></th>

                                            </tr>
                                            <tr>

                                                <td> <input type="text" name="course_name" id="course_name" placeholder="Enter Course Name" class="input-xlarge" value="<?php echo $course_name; ?>" autofocus autocomplete="off" /></td>
                                                <td> <input type="text" name="admission_year" id="admission_year" placeholder="Enter Session" class="input-xlarge" value="<?php echo $admission_year; ?>" autofocus autocomplete="off" /></td>
                                                </td>
                                                <td>
                                                    <input type="text" name="app_no" id="app_no" placeholder="Enter Application Number" class="input-xlarge" value="<?php echo $app_no; ?>" autofocus autocomplete="off" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Category<span style="color:#F00;"></span></th>
                                                <th>Scholarship ID<span style="color:#F00;"></span></th>
                                                <th></th>
                                            </tr>
                                            <tr>

                                                <td> <input type="text" name="category" id="category" placeholder="Enter Category" class="input-xlarge" value="<?php echo $category; ?>" autofocus autocomplete="off" /></td>


                                                <td> <input type="text" name="scholer_no" id="scholer_no" placeholder="Enter Scholarship ID" class="input-xlarge" value="<?php echo $scholer_no; ?>" autofocus autocomplete="off" /></td>
                                                </td>
                                                <td></td>
                                            </tr>



                                            <tr>
                                                <th>Date of Admission<span style="color:#F00;"></span></th>
                                                <th>Date of Birth<span style="color:#F00;"></span></th>
                                                <th>Aadhar Number<span style="color:#F00;"></span></th>
                                            </tr>
                                            <tr>
                                                <td> <input type="text" name="doa" id="doa" placeholder="dd-mm-yyyy" class="input-xlarge" value="<?php echo $obj->dateformatindia($doa); ?>" autofocus autocomplete="off" /></td>
                                                <td> <input type="text" name="dob" id="dob" placeholder="dd-mm-yyyy" class="input-xlarge" value="<?php echo $obj->dateformatindia($dob); ?>" autofocus autocomplete="off" /></td>

                                                <td>

                                                    <input type="text" name="aadhar_no" id="aadhar_no" placeholder="Enter Aadhar Number" class="input-xlarge" value="<?php echo $aadhar_no; ?>" autofocus autocomplete="off" />

                                                </td>


                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <th>Domicile</th>
                                                <th>Address Village/Mohalla</th>
                                            </tr>
                                            <tr>
                                                <td> <input type="text" name="gender" id="gender" placeholder="Enter Gender" class="input-xlarge" value="<?php echo $gender; ?>" autofocus autocomplete="off" /></td>
                                                <td> <input type="text" name="domicile" id="domicile" placeholder="Enter Domocile" class="input-xlarge" value="<?php echo $domicile; ?>" autofocus autocomplete="off" /></td>

                                                <td>
                                                    <input type="text" name="address" id="address" placeholder="Enter Address Village/Mohalla" class="input-xlarge" value="<?php echo $address; ?>" autofocus autocomplete="off" />

                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Ward Number</th>
                                                <th>Tehsil</th>
                                                <th>Post Office</th>
                                            </tr>
                                            <tr>
                                                <td> <input type="text" name="ward_no" id="ward_no" placeholder="Enter Ward Number" class="input-xlarge" value="<?php echo $ward_no; ?>" autofocus autocomplete="off" />
                                                </td>

                                                <td> <input type="text" name="tehsil" id="tehsil" placeholder="Enter Tehsil" class="input-xlarge" value="<?php echo $tehsil; ?>" autofocus autocomplete="off" /></td>
                                                <td> <input type="text" name="post_office" id="post_office" placeholder="Enter Post Office" class="input-xlarge" value="<?php echo $post_office; ?>" autofocus autocomplete="off" /></td>
                                            </tr>

                                            <tr>
                                                <th>District</th>
                                                <th>PinCode</th>
                                                <th>Mobile No. Personal</th>
                                            </tr>
                                            <tr>
                                                <td> <input type="text" name="district" id="district" placeholder="Enter District" class="input-xlarge" value="<?php echo $district; ?>" autofocus autocomplete="off" /></td>
                                                <td> <input type="text" name="pincode" id="pincode" placeholder="Enter Pincode" class="input-xlarge" value="<?php echo $pincode; ?>" autofocus autocomplete="off" /></td>
                                                <td> <input type="text" maxlength="10" name="stu_mobile" id="stu_mobile" placeholder="Enter Personal Mobile No." class="input-xlarge" value="<?php echo $stu_mobile; ?>" autofocus autocomplete="off" /></td>

                                            </tr>
                                            <tr>
                                                <th>Mobile No. Father's</th>
                                                <th>Mobile No. Other</th>
                                                <th>Mobile No. Other</th>
                                            </tr>
                                            <tr>
                                                <td> <input type="text" name="parent_mobile" id="parent_mobile" placeholder="Enter Father's Mobile No." maxlength="10" class="input-xlarge" value="<?php echo $parent_mobile; ?>" autofocus autocomplete="off" /></td>
                                                 <td> <input type="text" name="other_mobile" id="other_mobile" placeholder="Enter Mobile No. Other" maxlength="10" class="input-xlarge"  autofocus autocomplete="off" /></td>
                                                 <td> <input type="text" name="other_mobile1" id="other_mobile1" placeholder="Enter Mobile No. Other" maxlength="10" class="input-xlarge" autofocus autocomplete="off" /></td>
                                            </tr>

                                        </table>
                                        <div style="margin-top: 20px;">
                                            <h4 style="color:blue">10th Details : </h4>

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
                                            <h4 style="color:blue"> 12th Details : </h4>

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
                                        <div style="margin-top: 20px;">
                                            <h4 style="color:blue"> Others Details : </h4>

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
                                                    <tr>
                                                        <td colspan="3">
                                                            <button type="submit" name="submit" class="btn btn-primary" onclick="return checkinputmaster('m_student_reg_id,father_name');">
                                                                <?php echo $btn_name; ?></button>
                                                            <a href="student_info_page.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                                                            <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>





                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    <table class="table table-bordered" id="dyntable">
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
                                <th class="head0 nosort">Sno.</th>
                                <th class="head0">Student Name</th>
                                <th class="head0">Father's Name</th>
                                <th class="head0">Addmission Year</th>
                                <th class="head0">Course Name</th>
                                <th class="head0">Address</th>
                                <th class="head0">District</th>

                                <th class="head0">Admission Number</th>

                                <!-- <th class="head0">Marksheet Issue Date</th> -->
                                <th width="10%" class="head0">Print</th>
                                <?php $chkdel = $obj->check_delBtn("student_info_page.php", $loginid);

                                if ($chkdel == 1 || $loginid == 1) {  ?>
                                    <th width="10%" class="head0">Delete</th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $slno = 1;
                            //$res = $obj->fetch_record("m_product");

                            $res = $obj->executequery("select * from student_info order by stu_id desc");
                            foreach ($res as $row_get) {
                                $stu_id = $row_get['stu_id'];
                                // $print_copy = $row_get['print_copy'];
                                $m_student_reg_id = $row_get['m_student_reg_id'];
                                $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
                            ?>
                                <tr>
                                    <td><?php echo $slno++; ?></td>
                                    <td><?php echo $stu_name; ?></td>
                                    <td><?php echo $row_get['father_name']; ?></td>
                                    <td><?php echo $row_get['admission_year']; ?></td>
                                    <td><?php echo $row_get['course_name']; ?></td>
                                    <td><?php echo $row_get['address']; ?></td>
                                    <td><?php echo $row_get['district']; ?></td>

                                    <td><?php echo $row_get['app_no']; ?></td>

                                    <!-- <td><?php echo $obj->dateformatindia($row_get['d_o_m_issue']); ?></td> -->
                                    <td width="10%"><a class="icon-print" style="text-align: center; cursor: pointer;" data-toggle="modal_party" title="Print" target="_blank" href="student_information.php?m_student_reg_id=<?php echo $row_get['m_student_reg_id'] ?>"></a></td>
                                    <?php if ($chkdel == 1 || $loginid == 1) {  ?>
                                        <td width="10%"><a class='icon-remove' title="Delete" onclick='funDel(<?php echo $stu_id; ?>);' style='cursor:pointer'></a></td>
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
        <!-- <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_party">
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
                <button class="btn btn-primary" name="s_save" id="s_save">Print</button>
                <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
        </div> -->
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
                        location = '<?php echo $pagename . "?action=3"; ?>';
                    }

                }); //ajax close
            } //confirm close
        } //fun close


        jQuery('#doa').mask('99-99-9999', {
            placeholder: "dd-mm-yyyy"
        });
        jQuery('#dob').mask('99-99-9999', {
            placeholder: "dd-mm-yyyy"
        });


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

        // function changetab(pagename) {
        //     //alert('hi');
        //     location = pagename;
        // }

        function getid(m_student_reg_id) {

            // alert("sshol");
            var $url = 'student_info_page.php?m_student_reg_id=' + m_student_reg_id;

            location = $url;

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
        // function copyofTc(m_student_reg_id, print_copy) {
        //     jQuery('#myModal_party').modal('show');
        //     jQuery('#mm_student_reg_id').val(m_student_reg_id);
        //     jQuery('#print_copy').val(print_copy);
        // }
    </script>
    <!-- <script type="text/javascript">
        function printTc() {
            var print_copy = document.getElementById('print_copy').value;
            var mm_student_reg_id = document.getElementById('mm_student_reg_id').value;
            if (print_copy == "") {
                alert("Print copy can't be blank");
                return false;
            } else {
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/print_cc.php',
                    data: 'mm_student_reg_id=' + mm_student_reg_id + '&print_copy=' + print_copy,
                    dataType: 'html',
                    success: function(data) {
                        //  alert(data);
                        jQuery('#myModal_party').modal('hide');
                        if (data == 1) {
                            print('noduse-certificate.php?cc_id=<?php echo $cc_id; ?>');
                        }


                    }

                }); //ajax close
            }

        }
    </script> -->
</body>

</html>