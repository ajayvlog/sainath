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
    $admission_date = $obj->dateformatindia($key['admission_date']);
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

        }

        .container {
            padding: 50px;
            padding-bottom: 200px;
            border: 2px solid black;
            height: 250px;
            width: auto;
        }

        * {
            font-family: 'Times New Roman', Times, serif;
        }

        p {
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <div class="container">
        <center>
            <h2 style="line-height:0px;">साईनाथ पैरामेडिकल
                महाविद्यालय, उमरिया</h2>
            <span>आर. सी. स्कूल के बगल से , कछवार रोड उमरिया (म.प्र.)</span>
        </center>
        <hr style="height: 2px;background-color: black;">
        <span style="float: right;">दिनांक <?php echo $current_date; ?></span><br><br><br>
        <center>
            <h3><u>चरित्र-प्रमाण पत्र</u> </h3>
        </center>

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
                                                                                                                                            }  ?></b> ने हमारी संस्था में कोर्स <b> <?php echo $course_name; ?></b> में दिनांक <b><?php if ($admission_date != "") {
                                                                                                                                                                                                                                        echo $admission_date;
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo ".............";
                                                                                                                                                                                                                                    }  ?> </b>को प्रवेश लिया था। इनका परीक्षा परिणाम उत्तीर्ण है। शिक्षा अवधि के दौरान संस्था में इनका चरित्र उत्तम एवं सराहनीय रहा है। <b> संस्था इनके उज्जवल भविष्य की कामना करती है।</b> </p>

        <p style="float: right;text-align: center;">
            <span>प्राचार्य</span><br>
            <span>साईनाथ पैरामेडिकल कॉलेज, उमरिया</span><br>
            <span>जिला - उमरिया (म. प्र.)</span>
        </p>
    </div>

</body>

</html>