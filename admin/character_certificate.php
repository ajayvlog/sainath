<?php
include("../adminsession.php");
$current_date = date('d-m-Y');
$stu_name = "";
$father_name  = "";
$address  = "";
$course_name  = "";
$admission_date  = "";

if (isset($_GET['m_student_reg_id'])) {
    $m_student_reg_id = $_GET['m_student_reg_id'];
} else {
    $m_student_reg_id = "";
}
$qry = $obj->executequery("select * from m_student_reg where m_student_reg_id='$m_student_reg_id'");
foreach ($qry as $key) {
    $stu_name = $key['stu_name'];
    $father_name = $key['father_name'];
    $address = $key['address'];
    $class_id = $key['class_id'];
    $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
    $admission_date = $obj->getvalfield("class_transfer", "admission_date", "m_student_reg_id='$m_student_reg_id' order by transferid desc");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Charater Certificate (Umariya)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0px;
            padding: 0px;
            font-family: kruti dev;
            font-size: 20px;

        }

        @font-face {
            font-family: kruti dev;
            src: url('../../fonts/k010.ttf') format("truetype");
        }

        .container {
            padding: 20px;
            padding-bottom: 200px;
            border: 2px solid black;
            height: 800px;
            width: auto;

        }

        /* 
        * {
            font-family: 'Times New Roman', Times, serif;
        } */

        p {
            letter-spacing: 1px;
            text-align: center;
            line-height: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <center>
            <h2 style="line-height:0px;">साईनाथ पैरामेडिकल
                महाविद्यालय, उमरिया</h2>
            <span>आर. सी. स्कूल के पास से , कछवार रोड उमरिया (म.प्र.)</span><br>
            <small style="font-weight:bold;">Email- sainathcollege2012@gmail.com, snpc2013@refiffmail.com</small>
        </center>
        <hr style="height: 2px;background-color: black;"><br>
        <span style="float: right;">दिनांक <?php echo $current_date; ?></span>
        <br><br><br>
        <h3 style="text-align: center;"><u>चरित्र-प्रमाण पत्र</u> </h3>
                <p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;प्रमाणित किया जाता है कि छात्र/छात्रा <b><?php if ($stu_name != "") {
                echo $stu_name;
                } else {
                echo "...............";
                } ?></b> पिता <b> <?php if ($father_name != "") {
                echo $father_name;
                } else {
                echo "...............";
                }  ?></b> निवासी ग्राम <b><?php if ($address != "") {
                echo $address;
                } else {
                echo "..............";
                }  ?></b>ने हमारी संस्था में कोर्स <b> <?php echo $course_name; ?></b> में दिनांक <b><?php if ($admission_date != "") {
                echo $admission_date;
                } else {
                echo ".............";
                }  ?> </b>को प्रवेश लिया था। &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br><span>इनका परीक्षा परिणाम उत्तीर्ण है।</span> <br> <span style="font-weight: 600;margin-left:-10px;">शिक्षा अवधि के दौरान संस्था में इनका चरित्र उत्तम एवं सराहनीय रहा है।</span>
                <center>
                <b> संस्था इनके उज्जवल भविष्य की कामना करती है।</b>
                </center>
                </p>
                <br><br><br><br><br>
                <p style="float: right;text-align: center; line-height:23px;">
                <span>प्राचार्य</span><br>
                <span>साईनाथ पैरामेडिकल कॉलेज, उमरिया</span><br>
                <span>जिला - उमरिया (म. प्र.)</span>
                </p>
                </div>

                </body>

                </html>