<?php
include("../adminsession.php");
$current_date = date('d-m-Y');

$stu_name = "";
$father_name = "";
$admission_date = "";
$course_name = "";
$participation_date  = "";
$behavior   = "";
$feesdate    = "";
$from_yearsem    = "";
$to_yearsem    = "";
$status    = "";

if (isset($_GET['tc_id'])) {
    $tc_id = $_GET['tc_id'];
} else {
    $tc_id = "";
}

$qry = $obj->executequery("select * from transfer_certificate where tc_id='$tc_id'");
foreach ($qry as $key) {
    $m_student_reg_id = $key['m_student_reg_id'];
    $class_id = $obj->getvalfield("m_student_reg", "class_id", "m_student_reg_id='$m_student_reg_id'");
    $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
    $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
    $father_name = $obj->getvalfield("m_student_reg", "father_name", "m_student_reg_id='$m_student_reg_id'");
    $admission_date = $obj->getvalfield("m_student_reg", "admission_date", "m_student_reg_id='$m_student_reg_id'");

    $print_copy = $key['print_copy'];
    $participation_date = $key['participation_date'];
    $status = $key['status'];
    $behavior = $key['behavior'];
    $feesdate = $key['feesdate'];
    $from_yearsem = $key['from_yearsem'];
    $from_yearsem = $obj->getvalfield("m_semester", "sem_name", "sem_id='$from_yearsem'");
    $to_yearsem = $key['to_yearsem'];
    $to_yearsem = $obj->getvalfield("m_semester", "sem_name", "sem_id='$to_yearsem'");
    //$address = $key['address'];
    //$class_id = $key['class_id'];
    //$course_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'");
    //$admission_date = $obj->dateformatindia($key['admission_date']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Transfer Certificate (Umariya)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0px;
            padding: 0px;

        }

        .container {
            padding: 50px;
            border: 2px solid black;
            height: 900px;
            width: auto;

        }

        p {
            font-size: 20px;
            line-height: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <page size="A4">
            <center>
                <h2 style="line-height:0px;">साईनाथ पैरामेडिकल
                    महाविद्यालय, उमरिया</h2>
                <span>आर. सी. स्कूल के पास से , कछवार रोड उमरिया (म.प्र.) </span><br>
                <small><b>Email- sainathcollege2012@gmail.com, snpc2013@refiffmail.com</b></small>
            </center><br>
            <span>क्रमांक - <?php echo $tc_id; ?> </span><br>
            <span>स्कालर नं. </span>
            <span style="float: right;">दिनांक <?php echo $current_date; ?></span>
            <center><br><br>
                <div>
                    <h3 style="line-height: 10px;"><u>स्थानांतरण प्रमाण पत्र</u></h3>
                </div>
            </center><br>
            <?php

            ?>
            <p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;प्रमाणित किया जाता है कि <?php echo strtoupper($stu_name); ?> आत्मज <?php echo strtoupper($father_name);  ?> दिनांक <?php echo $obj->dateformatindia($admission_date); ?> से दिनांक <?php echo $current_date; ?> तक कक्षा <?php echo $course_name . " " . $from_yearsem; ?> से <?php echo $course_name . " " . $to_yearsem; ?> कक्षा का अनवरत नियमित छात्र था /छात्रा थी। </p>
            <p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;यह साईनाथ पैरामेडिकल महाविद्यालय की, आयुर्विज्ञान विश्‍वविद्यालय द्वारा आयोजित वर्ष <?php echo $obj->dateformatindia($participation_date); ?> की परीक्षा में <b><?php echo $status; ?></b> होने के पश्चात् महाविद्यायलय छोड़ रहा / रही है। </p>
                <center>
                    <p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;जहाँ तक प्राचार्य को ज्ञात है इसका आचरण <b><?php echo $behavior ?></b> था, </p>
                </center><br><br><br><br><br>
                <!-- इसने <?php //echo $obj->dateformatindia($feesdate); 
                            ?> तक महाविद्यालय को देय समस्त शुल्कों आदि का भुगतान कर दिया गया है। </p> -->
                <p style="float: right;text-align: center;line-height:23px;">
                    <span>प्राचार्य</span><br>
                    <span>साईनाथ पैरामेडिकल महाविद्यालय</span><br>
                    <span>जिला - उमरिया (म. प्र.)</span>
                </p>
                <br>
                <br>
                <br>
        </page>
    </div>
</body>

</html>
Print copy No. : <?php echo $print_copy; ?>