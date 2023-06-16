<?php
include("../../../adminsession.php");

$m_student_reg_id = "";
$imgname = "";
$class_id = "";
$class_name = "";
$admission_year = "";
$stu_name = "";
$dob = "";
$admission_date = "";
$gender = "";
$father_name = "";
$mother_name = "";
$aadhar_no = "";
$parent_aadhar_no = "";
$category_id = "";
$cat_name = "";
$cast = "";
$f_income = "";
$address = "";
$district = "";
$dis_name = "";
$pincode = "";
$mobile = "";
$parent_mobile = "";
$bank_name = "";
$ifsc = "";
$account_no = "";
$provisional_date = "";
$enrollment = "";
$rollno = "";
$email = "";
$samgra_id = "";
$remark = "";
$biometric_code = "";
$board_name_10 = "";
$pass_year_10 = "";
$roll_10 = "";
$stu_mobile = "";
$subject_10 = "";
$tot_mark_10 = "";
$obtain_mark_10 = "";
$board_name_12 = "";
$pass_year_12 = "";
$roll_12 = "";
$subject_12 = "";
$tot_mark_12 = "";
$obtain_mark_12 = "";
$other_course_name = "";
$other_board_name = "";
$other_roll  = "";
$other_pass_year = "";
$other_subject = "";
$other_tot_mark = "";
$other_obtain_mark = "";
$sem_id = 0;
if (isset($_GET['m_student_reg_id'])) {
    $m_student_reg_id = $_GET['m_student_reg_id'];
} else {
    $m_student_reg_id = "";
    header("location:../../m_student_reg.php");
}

$res = $obj->executequery("select * from m_student_reg where m_student_reg_id='$m_student_reg_id'");
foreach ($res as $rowget) {

    //$company_id = $_SESSION['company_id'];

    $m_student_reg_id = $rowget['m_student_reg_id'];
    $imgname = $rowget['imgname'];
    $class_id = $rowget['class_id'];
    $sem_id = $obj->getvalfield("class_transfer", "sem_id", "m_student_reg_id='$m_student_reg_id' order by transferid desc");

    $class_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
    $sem_name = $obj->getvalfield("m_semester", "sem_name", "sem_id='$sem_id'");
    //$admission_year = $rowget['admission_year'];
    $sessionid = $obj->getvalfield("class_transfer", "sessionid", "m_student_reg_id='$m_student_reg_id' order by transferid desc");
    $admission_year = $obj->getvalfield("m_session", "session_name", "sessionid='$sessionid'");
    $stu_name = $rowget['stu_name'];
    $dob = $rowget['dob'];
    //$admission_date = $rowget['admission_date'];
     $admission_date = $obj->getvalfield("class_transfer", "admission_date", "m_student_reg_id='$m_student_reg_id' order by transferid desc");
    $application_no = $rowget['application_no'];
    $gender = $rowget['gender'];
    $father_name = $rowget['father_name'];
    $mother_name = $rowget['mother_name'];
    $aadhar_no = $rowget['aadhar_no'];
    $category_id = $rowget['category_id'];
    $cat_name = $obj->getvalfield("m_category", "cat_name", "category_id='$category_id'");
    $cast = $rowget['cast'];
    $f_income = $rowget['f_income'];
    $address = $rowget['address'];
    $district = $rowget['district'];
    $dis_name = $obj->getvalfield("m_district", "dis_name", "dis_id='$district'");
    $provisional_date = $rowget['provisional_date'];
    $pincode = $rowget['pincode'];
    $mobile = $rowget['mobile'];
    $stu_mobile = $rowget['stu_mobile'];
    $parent_aadhar_no = $rowget['parent_aadhar_no'];
    $parent_mobile = $rowget['parent_mobile'];
    $bank_name = $rowget['bank_name'];
    $ifsc = $rowget['ifsc'];
    $account_no = $rowget['account_no'];
    $enrollment = $rowget['enrollment'];
    $rollno = $rowget['rollno'];
    $email = $rowget['email'];
    $samgra_id = $rowget['samgra_id'];
    $remark = $rowget['remark'];
    $biometric_code = $rowget['biometric_code'];
    $board_name_10 = $rowget['board_name_10'];
    $pass_year_10 = $rowget['pass_year_10'];
    $roll_10 = $rowget['roll_10'];
    $subject_10 = $rowget['subject_10'];
    $tot_mark_10 = $rowget['tot_mark_10'];
    $obtain_mark_10 = $rowget['obtain_mark_10'];
    $percent_10 = $rowget['percent_10'];

    //$percent_10 = $obtain_mark_10/$tot_mark_10*100;
    $board_name_12 = $rowget['board_name_12'];
    $pass_year_12 = $rowget['pass_year_12'];
    $roll_12 = $rowget['roll_12'];
    $subject_12 = $rowget['subject_12'];
    $tot_mark_12 = $rowget['tot_mark_12'];
    $obtain_mark_12 = $rowget['obtain_mark_12'];
    $percent_12 = $rowget['percent_12'];


    $other_course_name = $rowget['other_course_name'];
    $other_board_name = $rowget['other_board_name'];
    $other_roll  = $rowget['other_roll'];
    $other_pass_year = $rowget['other_pass_year'];
    $other_subject = $rowget['other_subject'];
    $other_tot_mark = $rowget['other_tot_mark'];
    $other_obtain_mark = $rowget['other_obtain_mark'];
    $other_percent = $rowget['other_percent'];
    //$percent_12 = $obtain_mark_12/$tot_mark_12*100;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>PDF ADMISSION FORM</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-responsive.min.css">
    <style>
        h5 {
            margin: 0px 0;
        }

        .text-center {
            text-align: center !important;
        }

        .card {
            /* Add shadows to create the "card" effect */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        h3 {
            margin: 2px 0;
            line-height: 25px;

        }

        .table td,
        h5 {
            padding: 4px;
            line-height: 12px;
            font-size: 12px;
            vertical-align: inherit;
        }
    </style>
</head>

<body onload="window.print()">
    <br>
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="card" style="border: 1px solid rgb(212, 212, 212);padding:5px;">

                    <?php
                    $qry = $obj->executequery("select * from college_setting");
                    foreach ($qry as $key) { ?>
                        <center>
                            <h3 style="font-weight:800;"><?php echo strtoupper($key['college_name']); ?></h3>
                            <h5 style="font-weight:800;"><?php echo strtoupper($key['city']); ?></h4>
                                <h5 style="border:1px solid gray;width:50%;border-radius:10px;margin-bottom:2px;">APPLICATION FORM FOR ADMISSION </h5>
                        </center>
                        <span style="float: left;">Provisional Date:- <?php echo $obj->dateformatindia($provisional_date); ?></span>
                        <span style="float: right;">Admission Date:- <?php echo $obj->dateformatindia($admission_date); ?></span>
                    <?php } ?>


                    <table class="table table-bordered" style="margin-bottom: 1px;">
                        <tr>
                            <td width="50px">Samgra_Id:</td>
                            <td width="90px"><?php echo $samgra_id; ?></td>
                            <td width="50px">Admission_Year:</td>
                            <td width="90px"><?php echo $admission_year; ?></td>
                            <td width="50px">Semester:</td>
                            <td width="90px"><?php echo $sem_name; ?></td>
                            <td width="50px">Enrollment_No.:</td>
                            <td width="90px"><?php echo $enrollment; ?></td>
                            <td width="50px">Course: </td>
                            <td width="90px"><?php echo $class_name; ?></td>
                            <td width="50px">Application_No.</td>
                            <td width="90px"><?php echo $application_no; ?></td>
                        </tr>
                    </table>
                    <div class="row-fluid">
                        <div class="span12">
                            <table class="table table-bordered" style="margin-bottom:5px;">
                                <tr>
                                    <td width="250px">
                                        <h5>Student Name:</h5>
                                    </td>
                                    <td colspan="4"><?php echo $stu_name; ?></td>
                                    <td rowspan="3"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Father's Name:</h5>
                                    </td>
                                    <td colspan="4"><?php echo $father_name; ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        <h5>Mother's Name:</h5>
                                    </td>
                                    <td colspan="4"><?php echo $mother_name; ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        <h5>Date Of Birth:</h5>
                                    </td>
                                    <td colspan="2"><?php echo $obj->dateformatindia($dob); ?></td>
                                    <td>
                                        <h5>Gender:</h5>
                                    </td>
                                    <td><?php echo $gender; ?></td>
                                    <td rowspan="4" colspan="2" width="140px">
                                        <img style="width:100%;height:100px;float:right;" src="../../uploaded/studentimg/<?php echo $imgname; ?>" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Addhar Card Number:</h5>
                                    </td>
                                    <td colspan="4"><?php echo $aadhar_no; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Category</h5>
                                    </td>
                                    <td><?php echo $cat_name; ?></td>
                                    <td>
                                        <h5>Cast</h5>
                                    </td>
                                    <td colspan="2"><?php echo $cast; ?></td>

                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <h5><u>INCOME DETAILS:</u></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Total Annual Family Income:</h5>
                                    </td>
                                    <td colspan="4">
                                        <h5><?php echo $f_income; ?></h5>
                                    </td>
                                    <td rowspan="2" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Father's Aadhar No.</h5>
                                    </td>
                                    <td colspan="4">
                                        <h5><?php echo $parent_aadhar_no; ?></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7"><u>
                                            <h5>ADDRESS DETAILS:</h5>
                                        </u></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Correspondence Address: </h5>
                                    </td>
                                    <td colspan="7"><?php echo $address; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>District: </h5>
                                    </td>
                                    <td colspan="3"><?php echo $dis_name; ?></td>
                                    <td>
                                        <h5>Pin code: </h5>
                                    </td>
                                    <td colspan="3"><?php echo $pincode; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Fathers Mobile No.: </h5>
                                    </td>
                                    <td colspan="2"><?php echo $parent_mobile; ?></td>
                                    <td colspan="2">
                                        <h5>Student Mobile No.: </h5>
                                    </td>
                                    <td colspan="2"><?php echo $parent_mobile; ?></td>
                                </tr>

                                <!--  MENUAL DALNEGE BOLE THE NO. -->
                                <tr>
                                    <td>
                                        <h5>Fathers Mobile No1.: </h5>
                                    </td>
                                    <td colspan="2"></td>
                                    <td colspan="2">
                                        <h5>Student Mobile No1.: </h5>
                                    </td>
                                    <td colspan="2"><?php echo $stu_mobile; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="7"><u>
                                            <h5>EDUCATION DETAILS:</h5>
                                        </u></td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h5>Class</h5>
                                    </td>
                                    <td class="text-center" width="250px">
                                        <h5>Board</h5>
                                    </td>
                                    <td class="text-center" width="150px">
                                        <h5>Passing Year</h5>
                                    </td>
                                    <td class="text-center" width="200px">
                                        <h5>Roll No</h5>
                                    </td>
                                    <td class="text-center">
                                        <h5>Total Marks</h5>
                                    </td>
                                    <td class="text-center">
                                        <h5>Obtain Marks</h5>
                                    </td>
                                    <td class="text-center">
                                        <h5>Percent(%)</h5>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center"><b>10th</b></td>
                                    <td class="text-center"><?php echo $board_name_10; ?></td>
                                    <td class="text-center"><?php echo $pass_year_10; ?></td>
                                    <td class="text-center"><?php echo $roll_10; ?></td>
                                    <td class="text-center"><?php echo $tot_mark_10; ?></td>
                                    <td class="text-center"><?php echo $obtain_mark_10; ?></td>
                                    <td class="text-center"><?php echo $percent_10; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><b>12th</b></td>
                                    <td class="text-center"><?php echo $board_name_12; ?></td>
                                    <td class="text-center"><?php echo $pass_year_12; ?></td>
                                    <td class="text-center"><?php echo $roll_12; ?></td>
                                    <td class="text-center"><?php echo $tot_mark_12; ?></td>
                                    <td class="text-center"><?php echo $obtain_mark_12; ?></td>
                                    <td class="text-center"><?php echo $percent_12; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="7"><u>
                                            <h5>OTHER COURSE:</h5>
                                        </u></td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h5>Other Course Name</h5>
                                    </td>
                                    <td class="text-center" width="250px">
                                        <h5>Board/University</h5>
                                    </td>
                                    <td class="text-center" width="150px">
                                        <h5>Passing Year</h5>
                                    </td>
                                    <td class="text-center" width="200px">
                                        <h5>Roll No</h5>
                                    </td>
                                    <td class="text-center">
                                        <h5>Total Marks</h5>
                                    </td>
                                    <td class="text-center">
                                        <h5>Obtain Marks</h5>
                                    </td>
                                    <td class="text-center">
                                        <h5>Percent(%)</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?php echo $other_course_name; ?></td>
                                    <td class="text-center"><?php echo $other_board_name; ?></td>
                                    <td class="text-center"><?php echo $other_pass_year; ?></td>
                                    <td class="text-center"><?php echo $other_roll; ?></td>
                                    <td class="text-center"><?php echo $other_tot_mark; ?></td>
                                    <td class="text-center"><?php echo $other_obtain_mark; ?></td>
                                    <td class="text-center"><?php echo $other_percent; ?></td>
                                </tr>

                                <tr>
                                    <td colspan="7">
                                        <h5><u>DETAILS OF BANK ACCOUNT NUMBER:</u></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Name of the Bank/Brnach:</h5>
                                    </td>
                                    <td colspan="3"><?php echo $bank_name; ?></td>
                                    <td width="150px">
                                        <h5>IFSC Code:</h5>
                                    </td>
                                    <td colspan="3"><?php echo $ifsc; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Bank Account Number:</h5>
                                    </td>
                                    <td colspan="7"><?php echo $account_no;  ?></td>
                                </tr>
                            </table>
                            <div class="row-fluid">
                                <div class="span12">
                                    <center>
                                        <h5><b>Declaration</b></h5>
                                    </center>
                                    <p style="text-align: justify;">I <b><?php echo strtoupper($stu_name); ?></b> Declare that the particulars given above are true to my knowledge I pledge to follow the rules end regulation of the Institute, there for I am responsible and can be condemned for any material loses by me whether voluntarity or involutarily, I promised to abide by the condition in the prospectus and other terms regarding changes in govt. policy, if any and or periodical in well aware of the validity of the course and after being fully satisfied.I have opt. for the course. I am liable to despoint the full fees structured (as scheduled) in case. I remain absent for institute without any lave granted for more then 7 days as per the rule my seat will automatically transferred to the next eligible candidate without any prior notice.</p>
                                </div>
                            </div>
                            <div style="display:inline-flex;">
                                <span class="left">Signature of Parents.......................................................&nbsp;&nbsp;&nbsp;</span>
                                <span class="right">Signature of Student......................................................</span>
                            </div>
                            <!-- <div class="row-fluid">
                                <div class="span4">
                                    
                                </div>
                                <div class="span4">
                                   
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.min.js"></script>
    <script src="jquery.min.js"></script>
</body>

</html>