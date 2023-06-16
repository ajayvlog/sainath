<?php include("../adminsession.php");
if (isset($_GET['m_student_reg_id']))
    $m_student_reg_id = $_GET['m_student_reg_id'];
else
    $m_student_reg_id = "";


$certificate_type = "complication";
$complication_data = $obj->select_record("complicaction_certificate", array('m_student_reg_id' => $m_student_reg_id, "certificate_type" => $certificate_type));
$session = $obj->getvalfield("m_session", "session_name", "status=1");
$date = $complication_data['t_day'];
$stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
$father_name = $complication_data['father_name'];
$address = $complication_data['address'];
$district = $complication_data['district'];
$admission_year = $complication_data['admission_year'];
$course_name = $complication_data['course_name'];
$app_no = $complication_data['app_no'];
$enroll_no = $complication_data['enroll_no'];
$d_o_m_issue = $complication_data['d_o_m_issue'];
// print_r($complication_data);
// die;

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Completion Certificate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.css">

    <style>
        body {
            border: 2px solid black;
            height: 1120px;
            padding: 20px;
        }

        .container {
            justify-content: center;
            margin: auto;
            font-size: 18px;

        }

        .center {
            text-align: center;
        }

        p {
            width: 85%;
            margin: auto;
            text-align: justify;
            line-height: 35px;
            letter-spacing: 1px;
            font-size: 20px;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <div class="container center">
            <h2 style="line-height:0px;" class="center">सांईनाथ पैरामेडिकल महाविद्यालय,उमरिया (म0प्र0)</h2>
            <small class="center">आर.सी. स्कूल के पास कछरवार रोड उमरिया (म.प्र.) </small><br>
            <small class="center">Email- sainathcollege2012@gmail.com, snpc2013@refiffmail.com</small>
            <br><br><br>
            <span style="float:left;">पत्र क्र./<?php echo $admission_year; ?>/</span>
            <span style="float:right;">उमरिया, दिनांक:<?php echo $obj->dateformatindia($date); ?></span>
            <br><br>
            <h2 style="margin-top: 8%;"><u>Completion Certificate</u></h2>
            <br>
            <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; प्रमाणित किया जाता है कि <b><?php echo $stu_name; ?></b> पिता <b><?php echo $father_name; ?></b> निवासी <?php echo $address; ?>, जिला- <?php echo $district; ?> (म0प्र0) ने सत्र <?php echo $admission_year; ?> बैच के <?php echo $course_name; ?> पाठ्यक्रम के नियमित
                छात्र थे/छात्रा थी।
            </p>
            <br>
            <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; सह- चित्किसीय परिषद के अनुसार इनका <b>प्रवेश आवेदन क्रमांक <?php echo $app_no; ?></b> है, तथा मध्यप्रदेश आयुर्विज्ञान
                विश्वविद्यालय जबलपुर में इनका नामांकन हुआ, विश्वविद्यालय के अनुसार इनका <b>नामांकन क्र.
                    <?php echo $enroll_no; ?> </b> है।</p>
            <br>
            <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; मध्यप्रदेश आयुर्विज्ञान विश्वविद्यालय द्वारा आयोजित अंतिम वर्ष की परीक्षा में सम्मलित हुए तथा इनका परीक्षा
                परिणाम
                उत्तीर्ण रहा। परीक्षा उपरान्त विश्वविद्यालय द्वारा दिनांक <?php echo $obj->dateformatindia($d_o_m_issue); ?> को इनकी अंकसूची जारी की गई।</p>
            <p class="center" style="margin-top: 20px;"><b>संस्था इनके उज्जवल भविष्य की कामना करती है।</b></p>
            <br><br><br><br><br><br>
            <p class="center" style="float: right;margin-right: -20%; margin-top: 40px;line-height:23px;">प्राचार्य <br> सांईनाथ
                पैरामेडिकल कॉलेज उमरिया
                <br> जिला- उमरिया
                (म0प्र0)
            </p>
        </div>


    </div>

    <script src="js/jquery-3.3.1.min.js"></script>

    <!-- JQUERY STEP -->
    <script src="js/jquery.steps.js"></script>

    <script src="js/main.js"></script>
    <!-- Template created and distributed by Colorlib -->
</body>

</html>