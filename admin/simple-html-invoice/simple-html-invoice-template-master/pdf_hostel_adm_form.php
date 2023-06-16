<?php 
include("../../../adminsession.php");

if(isset($_GET['hostal_admission_id']))
$hostal_admission_id = $_GET['hostal_admission_id'];
else
$hostal_admission_id = 0;

$sql_get = mysql_query("select * from  hostal_admission_form where hostal_admission_id='$hostal_admission_id'");
while($rowget = mysql_fetch_assoc($sql_get))
{
    //$company_id = $_SESSION['company_id'];
    
    $hostal_admission_id= $rowget['hostal_admission_id'];
    $imgname = $rowget['imgname'];
    $fname = $rowget['fname'];
    $stu_mobile = $rowget['stu_mobile'];
    $gender = $rowget['gender'];
    $f_mobile = $rowget['f_mobile'];
    $address = $rowget['address'];
    $stu_name = $rowget['stu_name'];
    $adm_year= $rowget['adm_year'];
}


?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PDF HOSTAL ADMISSION FORM</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 12px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 1px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 5px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    #bill-table
    {
        width: 100%;
    }
    #bill-table tr{padding: 5px;}
    #bill-table tr td
    {
        padding: 0px;
        width: 50%;
    }
    .item td p{line-height: 5px;}
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td><h1><center>Hostel Admission Form</center></h1></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: #999 solid 1px;text-align:center;" class="title"><span class="title" style="text-align: center;"><img src="../../uploaded/hostalform_pic/<?php echo $imgname ;?>" style="width:100%; max-width:200px;"></span>
                            
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
           <!--  <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>

                            <td colspan="2">
                               <table style="width:100%;padding:0px;" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>Address</td>
                                        <td style="text-align:left;"><?php echo $caddress; ?></td>

                                    </tr>
                                    <tr>
                                        <td>Mobile No.</td>
                                        <td style="text-align:left;"><?php echo $mobilec; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email Id</td>
                                        <td style="text-align:left;"><?php echo $emailc; ?></td>
                                    </tr>
                                    
                               </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr> -->
            
        </table>

        <table id="bill-table">
            <tr class="heading">
                <td style="text-align: center;" colspan="2">
                    <h2>Student Details</h2>
                </td>
            </tr>
           
            <tr class="heading">
                <td style="text-align: left;">
                    Student Name : <?php echo strtoupper($stu_name); ?>
                </td>
                <td style="text-align: left;">
                     Admission Year :<?php echo $adm_year; ?>
                    
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                    Father's Name : <?php echo strtoupper($fname); ?>
                </td>
                <td style="text-align: left;">
                    Student Mobile No : <?php echo strtoupper($stu_mobile); ?>
                    
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                    Gender : <?php echo strtoupper($gender); ?>
                </td>
                <td style="text-align: left;">
                    Parents Mobile No : <?php echo $f_mobile; ?>
                    
                </td>
                
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                    Address : <?php echo strtoupper($address); ?>
                </td>
                <td style="text-align: left;">
                   Form Reg. Date : <?php echo $cmn->dateformatindia($createdate); ?>
                </td>
            </tr>
            

      </table>
      
         <center><h3> हॉस्टल एवं मेस के नियम</h3></center> 
<li> हॉस्टल की फीस रु1500 प्रति व्यक्ति/प्रति माह एवं मेस रु 2500 प्रति व्यक्ति प्रतिमाह है जिसमे मात्र दो समय का भोजन एवं सुबह का नाश्ता ही देय है।</li>

<li>हॉस्टल बुकिंग के लिए caution money (सुरक्षा निधि) रु 3000 मात्र एडवांस में जमा करना होगा ।</li>
<li>जिसका हॉस्टल एवं मेस की राशि प्रतिमाह 5 तारीख को जमा हो जाना चाहिए</li>
<li> एक बार हॉस्टल/मेस की सुविधा लेने पर पूरे 12 माह तक की फीस अनिवार्य रूप से देय होगी।</li>
<li>हॉस्टल में रात्रि 9 बजे के बाद बिना अनुमति बाहर जाने पर अनुसाशनात्मक कार्यवाही की जा सकती है</li>
<li>बहरी किसी भी व्यक्ति का हॉस्टल में प्रवेश पूर्णतः निषेध है , बिना वार्डन के अनुमति के बिना कोई छात्र / छात्रा किसी भी व्यक्ति को अपने कमरे में रोकता है तो उस पर दंडात्मक कार्यवाही हेतु प्रबंधन बाध्ह्या होगा</li>
<li>बिना सूचना के लम्बी अवधि तक हॉस्टल से गायब रहने वालो पर हॉस्टल से निष्कासन का कार्यवाही की जा सकती है</li>
<li>हॉस्टल में किसी भी प्रकार की अनुसाशन हीनता एवं अन्य गलत कृत्यों में लिपट पाए जाने वाले छात्र / छात्राओं को 24 घंटे की<br> समयावधि  देकर हॉस्टल खली करने को कहा जा सकता है</li>
<li>हॉस्टल में किसी भी प्रकार की छति में दोसी छात्र  / छात्राओं को अर्थ दंड द्वारा छति की पूर्ति करनी होगी</li>
<li>हॉस्टल/मेस के सभी नियम / अधिकार प्रबंधन के पास सुरछित है असुविधा होने पर कार्यालयीन दिवस /समय पर संपर्क करे अति आवश्यक होतो फ़ोन पर संपर्क करें </li><br><br>


<table>
    
    <tr >
       <td> <h3 style="text-align: left;">छात्र / छात्रा .........................</h3></td>
       <td> <h3 style="text-align: right;">प्रबंधन .........................</h3></td>
    </tr>
    <tr >
       <td> <h3 style="text-align: left;">अभिभावक .........................</h3></td>
       <td> <h3 style="text-align: right;">वार्डन .........................</h3></td>
    </tr>
</table>
    </div>

</body>
</html>
