<?php include("../adminsession.php");
if (isset($_GET['m_student_reg_id']))
    $m_student_reg_id = $_GET['m_student_reg_id'];
else
    $m_student_reg_id = "";
$stu_data = $obj->select_record("student_info", array('m_student_reg_id' => $m_student_reg_id));
$m_student_reg_id = $stu_data['m_student_reg_id'];
$course_name = $stu_data['course_name'];
$admission_year = $stu_data['admission_year'];
$category = $stu_data['category'];
$scholer_no = $stu_data['scholer_no'];
$password = $stu_data['password'];
$app_no = $stu_data['app_no'];
$doa = $stu_data['doa'];
$dob = $stu_data['dob'];
$stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
$enrollment = $obj->getvalfield("m_student_reg", "enrollment", "m_student_reg_id='$m_student_reg_id'");
$father_name = $stu_data['father_name'];
$aadhar_no = $stu_data['aadhar_no'];
$mother_name = $stu_data['mother_name'];
$gender = $stu_data['gender'];
$domicile = $stu_data['domicile'];
$address = $stu_data['address'];
$ward_no = $stu_data['ward_no'];
$district = $stu_data['district'];
$post_office = $stu_data['post_office'];
$tehsil = $stu_data['tehsil'];
$pincode = $stu_data['pincode'];
$board_name_10 = $stu_data['board_name_10'];
$pass_year_10 = $stu_data['pass_year_10'];
$roll_10 = $stu_data['roll_10'];
$subject_10 = $stu_data['subject_10'];
$tot_mark_10 = $stu_data['tot_mark_10'];
$obtain_mark_10 = $stu_data['obtain_mark_10'];
$percent_10 = $stu_data['percent_10'];
$board_name_12 = $stu_data['board_name_12'];
$pass_year_12 = $stu_data['pass_year_12'];
$roll_12 = $stu_data['roll_12'];
$subject_12 = $stu_data['subject_12'];
$tot_mark_12 = $stu_data['tot_mark_12'];
$obtain_mark_12 = $stu_data['obtain_mark_12'];
$percent_12 = $stu_data['percent_12'];
$other_course_name = $stu_data['other_course_name'];
$other_board_name = $stu_data['other_board_name'];
$other_pass_year = $stu_data['other_pass_year'];
$other_roll = $stu_data['other_roll'];
$other_subject = $stu_data['other_subject'];
$other_tot_mark = $stu_data['other_tot_mark'];
$other_obtain_mark = $stu_data['other_obtain_mark'];
$other_percent = $stu_data['other_percent'];
$parent_mobile = $stu_data['mobile'];
$stu_mobile = $stu_data['stu_mobile'];
$other_mobile = $stu_data['other_mobile'];
$other_mobile1 = $stu_data['other_mobile1'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>STUDENT PERSONAL INFORMATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.css">

    <style>
        .container {
            justify-content: center;
            margin: auto;
        }

        .center {
            text-align: center;
        }

        .table,
        .tr,
        .tr>th,
        .tr>td {
            border: 1px solid grey;
            border-collapse: collapse;
            padding: 3px;
        }

        tr>td {
            border: 1px solid #e0e0e0;
            border-collapse: collapse;
            padding: 3px;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <div class="container" style="margin-left:50px;">
            <h2 class="center">Sainath Paramedical College, Umaria (MP)</h2>
            <h4 class="center"><u>STUDENT PERSONAL INFORMATION FORM</u></h4>
            <table class=" table container">

                <tr>
                    <td>
                        Course :
                    </td>
                    <td><?php echo $course_name; ?></td>
                    <td style="width:15%;">
                        Session :
                    </td>
                    <td><?php echo $admission_year ?></td>
                    <td style="width:15%;">
                        Category :
                    </td>
                    <td colspan="2"><?php echo $category
                                    ?></td>
                </tr>
                <tr>
                    <td>Scholarship ID : </td>
                    <td colspan="2"><?php echo $scholer_no ?></td>
                    <td>DOA : </td>
                    <td colspan="3"><?php echo $obj->dateformatindia($doa); ?></td>
                </tr>
                <tr>
                    <td>Application No. : <br>
                        <small>(Generate by mp online)</small>
                    </td>
                    <td colspan="2"><?php echo $app_no ?></td>

                    <td>Enrollment No.</td>
                    <td colspan="3"><?php echo $enrollment ?></td>
                </tr>
                <tr>
                    <td>
                        1. Student Name :
                    </td>
                    <td colspan="6"><?php echo ucfirst($stu_name); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        2. Father's Name :
                    </td>
                    <td colspan="2"><?php echo ucfirst($father_name); ?>
                    </td>
                    <!-- <td style="width: 2px;"></td> -->
                    <td colspan="2">
                        3. Aadhar No. :
                    </td>
                    <td colspan="2"><?php echo $aadhar_no; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        4. Mother's Name :
                    </td>
                    <td colspan="2"><?php echo ucfirst($mother_name); ?>
                    </td>
                    <!-- <td style="width: 2px;"></td> -->
                    <td>
                        5. DOB :
                    </td>
                    <td colspan="3"><?php echo $obj->dateformatindia($dob); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        6. Gender :
                    </td>
                    <td colspan="2"><?php echo ucfirst($gender) ?>
                    </td>
                    <!-- <td style="width: 2px;"></td> -->
                    <td>
                        7. Domicile :
                    </td>
                    <td colspan="3"><?php echo ucfirst($domicile) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Permanent Address Village/Mohalla:
                    </td>
                    <td colspan="6"><?php echo ucfirst($address); ?></td>
                </tr>
                <tr>
                    <td>
                        Ward No. :
                    </td>
                    <td colspan="2"><?php echo $ward_no ?></td>
                    <!-- <td style="width: 2px;"></td> -->
                    <td>
                        Tehsil :
                    </td>
                    <td colspan="3"><?php echo ucfirst($tehsil) ?></td>
                </tr>
                <tr>
                    <td>
                        Post Office :
                    </td>
                    <td><?php echo ucfirst($post_office); ?></td>
                    <!-- <td style="width: 2px;"></td> -->
                    <td>
                        District :
                    </td>
                    <td><?php echo ucfirst($district) ?></td>
                    <td >
                        Pin Code :
                    </td>
                    <td><?php echo $pincode ?></td>
                </tr>
                <tr>
                    <td colspan="7">
                        9. Educational Details :
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <table class=" table container" style="width: 100%;">
                            <thead>
                                <tr class="tr">
                                    <th>Exam Name</th>
                                    <th>Board Name</th>
                                    <th>Pass Year</th>
                                    <th>Roll No.</th>
                                    <th>Subject</th>
                                    <th>Total Marks</th>
                                    <th>Obtain Marks</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($board_name_10 != '') { ?>
                                    <tr class="tr">
                                        <td align="center"><?php echo "10th" ?></td>
                                        <td align="center"><?php echo strtoupper($board_name_10); ?></td>
                                        <td align="center"><?php echo $pass_year_10; ?></td>
                                        <td align="center"><?php echo $roll_10; ?></td>
                                        <td align="center"><?php echo ucfirst($subject_10); ?></td>
                                        <td align="center"><?php echo $tot_mark_10; ?></td>
                                        <td align="center"><?php echo $obtain_mark_10; ?></td>
                                        <td align="center"><?php echo $percent_10; ?></td>
                                    </tr><?php } ?>
                                <?php if ($board_name_12 != '') { ?>
                                    <tr class="tr">
                                        <td align="center"><?php echo "12th" ?></td>
                                        <td align="center"><?php echo strtoupper($board_name_12); ?></td>
                                        <td align="center"><?php echo $pass_year_12; ?></td>
                                        <td align="center"><?php echo $roll_12; ?></td>
                                        <td align="center"><?php echo ucfirst($subject_12); ?></td>
                                        <td align="center"><?php echo $tot_mark_12; ?></td>
                                        <td align="center"><?php echo $obtain_mark_12; ?></td>
                                        <td align="center"><?php echo $percent_12; ?></td>
                                    </tr><?php } ?>
                                <?php if ($other_course_name != '') { ?>
                                    <tr class="tr">
                                        <td align="center"><?php echo strtoupper($other_course_name); ?></td>
                                        <td align="center"><?php echo strtoupper($other_board_name); ?></td>
                                        <td align="center"><?php echo $other_pass_year; ?></td>
                                        <td align="center"><?php echo $other_roll; ?></td>
                                        <td align="center"><?php echo ucfirst($other_subject); ?></td>
                                        <td align="center"><?php echo $other_tot_mark; ?></td>
                                        <td align="center"><?php echo $other_obtain_mark; ?></td>
                                        <td align="center"><?php echo $other_percent; ?></td>
                                    </tr><?php } ?>

                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        10.Personal Mo. :
                    </td>
                    <td colspan="2"><?php echo $stu_mobile; ?></td>
                    <td colspan="2">
                        11.Father's Mo. :
                    </td>
                    <td colspan="2"><?php echo $parent_mobile; ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        12.Other Mo. :
                    </td>
                    <td colspan="2"><?php echo $other_mobile; ?></td>
                    <td colspan="2">
                        13.Other Mo. :
                    </td>
                    <td colspan="2"><?php echo $other_mobile1; ?>
                    </td>
                </tr>
            </table>

            <div class="container" style="margin: 10px;">
                <div style="width:45%;border:1px solid;float: left;margin-left: 1%;padding: 10px;">
                    <h3><u>विशेष सूचना</u></h3>
                    <ol>
                        <li> फार्म में चाही गई जानकारी को विद्यार्थी के एवं आधार कार्ड के आधार पर भरी गई है।
                        </li>
                        <!--   <li>
                            विद्यार्थी द्वारा भरी गई जानकारी के आधार पर संस्था द्वारा समय-समय पर महत्वपूर्ण सूचना
                            (जैसे- परीक्षा नामांकन) आदि की जानकारी भेजी जा सके।
                        </li> -->
                        <li>
                            यदि विद्यार्थी द्वारा उपरोक्त जानकारी गलत दी गई

                            जिसके आधार पर विद्यार्थियों को संस्था द्वारा दी गई

                            जानकारी प्राप्त नही हुई तो संस्था का कोई दायित्व नहीं

                            होगा।
                        </li>
                    </ol>
                </div>
                <div style="width:45%;border:1px solid;float: right;margin-right: 1%;padding: 10px; padding-bottom:9px;">
                    <h3 class="center"><u>वचन पत्र</u></h3>
                    <p class="center">
                        मेरे द्वारा प्रपत्र में उल्लेखित सूचनायें ध्यान पूर्वक पढ़ी गई हैं। उक्त जानकारी जो मेरे द्वारा दी
                        गई है पूर्णतः सही एवं सत्य है।
                    </p>
                    <div style="border:1px solid; width: 45%;height:150px;margin: auto;">

                    </div>
                </div>
            </div>

            <table class="container" style="width: 100%;padding-top: 50px;margin: 5% 0%;">
                <tr>
                    <th>Signature of CEO</th>
                    <th>Signature of Principal</th>
                    <th>Signature of Student</th>
                </tr>
            </table>


        </div>


    </div>

    <script src="js/jquery-3.3.1.min.js"></script>

    <!-- JQUERY STEP -->
    <script src="js/jquery.steps.js"></script>

    <script src="js/main.js"></script>
    <!-- Template created and distributed by Colorlib -->
</body>

</html>