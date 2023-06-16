<?php include("../adminsession.php");
if (isset($_GET['m_student_reg_id']))
    $m_student_reg_id = $_GET['m_student_reg_id'];
else
    $m_student_reg_id = "";

$complication_data = $obj->select_record("complicaction_certificate", array('m_student_reg_id' => $m_student_reg_id));
$date = $complication_data['t_day'];

// print_r($complication_data);
// die;

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Complication Certificate</title>
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

        p {
            width: 35%;
            margin: auto;
            text-align: justify;
            line-height: 30px;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <div class="container center">
            <h2 class="center">कार्यालय-प्राचार्य, सांईनाथ पैरामेडिकल कॉलेज, उमरिया (म०प्र०)</h2>
            <small class="center">Email- sainathcollege2012@gmail.com dr.vktripathi75@gmail.com</small>
            <hr style="width:50%;border: 2px solid;">
            <span style="float:left;margin-left: 25%;">पत्र क्र. /2021-22/</span>
            <span style="float:right;margin-right: 30%;">उमरिया, दिनांक:<?php echo $obj->dateformatindia($date); ?></span>
            <h2 style="margin-top: 5%;"><u>Complication Certificate</u></h2>
            <p>प्रमाणित किया जाता है कि <b>श्री राजेश कुमार बारी</b> पिता <b>श्री झल्लू लाल</b> निवासी ग्राम - तेंदुआ,
                पोस्टऑफिस - पथरहटा, तहसील-चंदिया, जिला- उमरिया (म0प्र0) ने सत्र 2019-20 बैच के DMLT पाठ्यक्रम के नियमित
                छात्र थे।
            </p>
            <p>सह- चित्किसीय परिषद के अनुसार इनका प्रवेश <b>आवेदन क्रमांक APP20264063</b> है तथा मध्यप्रदेश आयुर्विज्ञान
                विश्वविद्यालय जबलपुर (म0प्र0) में इनका नामांकन हुआ, विश्वविद्यालय के अनुसार इनका <b>नामांकन क्र.
                    PP027P070015019</b> है।</p>
            <p>मध्यप्रदेश आयुर्विज्ञान विश्वविद्यालय द्वारा आयोजित परीक्षा में सम्मलित हुए एवं इनका परीक्षा परिणाम
                उत्तीर्ण रहा। परीक्षा उपरान्त विश्वविद्यालय द्वारा दिनांक 26.09.2022 को इनकी अंकसूची जारी की गई।</p>
            <p class="center" style="margin-top: 20px;"><b>संस्था इनके उज्जवल भविष्य की कामना करती है।</b></p>
            <p class="center" style="float: right;margin-right: 20%; margin-top: 40px;">प्राचार्य <br> सांईनाथ
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