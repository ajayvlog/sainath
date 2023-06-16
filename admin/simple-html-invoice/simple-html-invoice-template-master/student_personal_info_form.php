<?php 
include("../../../adminsession.php");
//echo $admission_id = $_GET['admission_id'];die;
// $company_name = $obj->getvalfield("company_setting","company_name","1=1");
// $caddress = $obj->getvalfield("company_setting","address","1=1");
// $emailc = $obj->getvalfield("company_setting","email","1=1");
// $mobilec = $obj->getvalfield("company_setting","mobile","1=1");
if(isset($_GET['m_student_reg_id']))
$m_student_reg_id = $_GET['m_student_reg_id'];
else
$m_student_reg_id = 0;
    $res = $obj->executequery("select * from m_student_reg where m_student_reg_id='$m_student_reg_id'");
    foreach($res as $rowget)
    {

    //$company_id = $_SESSION['company_id'];
    
    $m_student_reg_id= $rowget['m_student_reg_id'];
    $imgname= $rowget['imgname'];
    $class_id= $rowget['class_id'];
    $class_name = $obj->getvalfield("m_class","class_name","class_id=$class_id");
    $admission_year= $rowget['admission_year'];
    $stu_name= $rowget['stu_name'];
    $dob= $rowget['dob'];
    $admission_date = $rowget['admission_date'];
    $gender= $rowget['gender'];
     $father_name= $rowget['father_name'];
     $mother_name= $rowget['mother_name'];
     $aadhar_no= $rowget['aadhar_no'];
     $parent_aadhar_no= $rowget['parent_aadhar_no'];
     $category_id= $rowget['category_id'];
     $cat_name = $obj->getvalfield("m_category","cat_name","category_id='$category_id'");
     $cast= $rowget['cast'];
     $f_income= $rowget['f_income'];
     $address= $rowget['address'];
     $district= $rowget['district'];
     $dis_name = $obj->getvalfield("m_district","dis_name","dis_id='$district'");
     $pincode= $rowget['pincode'];
     $mobile= $rowget['mobile'];
     $parent_mobile= $rowget['parent_mobile'];
     $bank_name= $rowget['bank_name'];
     $ifsc= $rowget['ifsc'];
     $account_no= $rowget['account_no'];
     $enrollment= $rowget['enrollment'];
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
     //$percent_10 = $obtain_mark_10/$tot_mark_10*100;
     $board_name_12 = $rowget['board_name_12'];
     $pass_year_12 = $rowget['pass_year_12'];
     $roll_12 = $rowget['roll_12'];
     $subject_12 = $rowget['subject_12'];
     $tot_mark_12 = $rowget['tot_mark_12'];
     $obtain_mark_12 = $rowget['obtain_mark_12'];
     

     $other_course_name = $rowget['other_course_name'];
     $other_board_name = $rowget['other_board_name'];
     $other_roll  = $rowget['other_roll'];
     $other_pass_year = $rowget['other_pass_year'];
     $other_subject = $rowget['other_subject'];
     $other_tot_mark = $rowget['other_tot_mark'];
     $other_obtain_mark = $rowget['other_obtain_mark'];
     //$percent_12 = $obtain_mark_12/$tot_mark_12*100;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sainath - Student personal information form</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-responsive.min.css">
    <style>
        h5{
            margin: 0px 0;
        }
        .text-center{
            text-align: center !important;
        }
        .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        h3{
            margin: 2px 0;
            line-height: 25px;

        }
        /* .table td,h5 {
            padding:10px;
            line-height: 12px;
            font-size: 12px;
            vertical-align: inherit;
        } */
    </style>
</head>
<!-- onload="window.print()" -->
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="card" style="border: 1px solid rgb(212, 212, 212);padding:5px;">
                   
                        <?php 
                            $qry = $obj->executequery("select * from college_setting");
                            foreach($qry as $key)
                            { ?>
                                <center>
                                <h3 style="font-weight:800;"><?php echo strtoupper($key['college_name']); ?></h3>
                                <h5 style="font-weight:800;"><?php echo strtoupper($key['city']); ?></h4>
                                <h5 style="width:50%;margin-bottom:10px;">
                                    <u>STUDENT PERSONAL INFORMATION FORM</u>
                                </h5> 
                            </center>
                            <!-- <span style="float: right;">Admission Date:- <?php //echo $obj->dateformatindia($admission_date); ?></span> -->
                        <?php } ?>
                    
                    <!-- <div class="row-fluid" style="margin-top: 30px;">
                        <div class="span4">Course : ..................................</div>
                        <div class="span4">Session : ..................................</div>
                        <div class="span4">Cast : .....................................</div>
                    </div> -->
                    <table class="table table-bordered">
                        <tr>
                            <td width="210px">Course</td>
                            <td></td>
                            <td>Session</td>
                            <td></td>
                            <td>Cast</td>
                            <td></td>
                        </tr>
                    </table>
                    <hr>
                    <table class="table table-bordered">
                        <tr>
                            <td width="210px"><b>Scholarship ID</b></td>
                            <td></td>
                            <td><b>Password</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>MPMSU ID</b></td>
                            <td></td>
                            <td><b>Password</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><h5>Student Name:</h5></td>
                            <td><?php echo $stu_name; ?></td>
                            <td width="200px"><h5>Aadhar No. of student</h5></td>
                            <td><?php echo $aadhar_no; ?></td>
                        </tr>
                        <tr>
                            <td><h5>Father's Name:</h5></td>
                            <td colspan="3"><?php echo $father_name; ?></td>
                        </tr>
                        <tr>
                            <td><h5>Mother's Name:</h5></td>
                            <td><?php echo $mother_name; ?></td>
                            <td><h5>DOB:</h5></td>
                            <td><?php echo $obj->dateformatindia($dob); ?></td>
                        </tr>
                        <tr>
                            <td><h5>Last Qualification:</h5></td>
                            <td><?php echo $mother_name; ?></td>
                            <td><h5>Sex:</h5></td>
                            <td><?php echo $gender; ?></td>
                        </tr>
                        <tr>
                            <td><h5>Samagra ID No.:</h5></td>
                            <td><?php echo $mother_name; ?></td>
                            <td><h5>Aadhar No. of father:</h5></td>
                            <td><?php echo $parent_aadhar_no; ?></td>
                        </tr>
                        <tr>
                            <td><h5>Email ID:</h5></td>
                            <td>omprakashkashyap@gmail.com</td>
                            <td><h5>Pin Code</h5></td>
                            <td><?php echo $pincode; ?></td>
                        </tr>
                        <tr>
                            <td><h5>Permanent Address</h5></td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td colspan="5"><b>Mobile No. Compulsory a any two from (B,C,D)</b></td>
                        </tr>
                        <tr>
                            <td>Personal Mobile No.</td>
                            <td></td>
                            <td rowspan="6" colspan="2" style="text-align: center;">
                               <h5> <b>वचन पत्र</b></h5><br>
                                मेरे द्वारा प्रपत्र में उल्लेखित सूचनाएं पढ़ी गई है। उक्त जानकारी जो  मेरे द्वारा  दी गई है पूर्णतः सही एवं सत्य हैं। <br>
                                <img src="../../uploaded/studentimg/<?php echo $imgname; ?>" alt="" style="width:150px;height:auto;border: 1px solid black;">
                            </td>
                        </tr>
                        <tr>
                            <td>Father Mobile No.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Home Mobile No.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Local Guardian Mobile No.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h5><b>विशेष सूचना</b> </h5>
                                <ul>
                                    <li>फॉर्म में चाही जानकारी को विद्यार्थी सही एवं  सत्य के आधार पर अनिवार्य रूप से भरें। </li>
                                    <li>विध्यार्थी द्वारा भरी गई जानकारी के आधार पर संस्था द्वारा समय समय पर महत्वपूर्ण सूचना (जैसे - परीक्षा, नामांकन ) आदि प्रेषित  की जावेगी। </li>
                                    <li>यदि विद्यार्थी द्वारा उपरोक्त जानकारी भरी और संस्था द्वारा
                                        इसी  भरी गई जानकारी के आधार पर प्रेषित सूचना समय पर या नहीं मिले तो  विद्यार्थी स्वयं जिम्मेदार होगा। संस्था का कोई दायित्व नहीं होगा। </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.min.js"></script>
    <script src="jquery.min.js"></script>
</body>
</html>
