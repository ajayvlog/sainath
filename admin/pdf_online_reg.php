<?php 
include("../adminsession.php");
//echo $admission_id = $_GET['admission_id'];die;
// $company_name = $obj->getvalfield("company_setting","company_name","1=1");
// $caddress = $obj->getvalfield("company_setting","address","1=1");
// $emailc = $obj->getvalfield("company_setting","email","1=1");
// $mobilec = $obj->getvalfield("company_setting","mobile","1=1");

if(isset($_GET['reg_id']))
$reg_id = $_GET['reg_id'];
else
$reg_id = 0;
    $res = $obj->executequery("select * from online_registration where reg_id='$reg_id'");
    foreach($res as $rowget)
    {

    //$company_id = $_SESSION['company_id'];
    
    $reg_id= $rowget['reg_id'];
    $fname= $rowget['fname'];
    $addmis_date= $rowget['addmis_date'];
    $session= $rowget['session'];
    $addmis_for= $rowget['addmis_for'];
    $class_name = $obj->getvalfield("m_class","class_name","class_id=$addmis_for");
    $gender= $rowget['gender'];
    $dob= $rowget['dob'];
    $aadhar_no= $rowget['aadhar_no'];
    $category= $rowget['category'];
    $category = $obj->getvalfield("m_category","cat_name","category_id='$category'");
    $cast= $rowget['cast'];
     $image= $rowget['image'];
     $address= $rowget['address'];
     $dist= $rowget['dist'];
     $pin_code= $rowget['pin_code'];
     $contact_one= $rowget['contact_one'];
     $contact_two= $rowget['contact_two'];
     $father_name= $rowget['father_name'];
     $mother_name= $rowget['mother_name'];
     $p_aadhar_no= $rowget['p_aadhar_no'];
     $fam_incom= $rowget['fam_incom'];
     $p_contact= $rowget['p_contact'];
     $tenth_board= $rowget['tenth_board'];
     $tenth_pass_year= $rowget['tenth_pass_year'];
     $tenth_roll_no= $rowget['tenth_roll_no'];
     $tenth_subject= $rowget['tenth_subject'];
     $tenth_tot_marks= $rowget['tenth_tot_marks'];
     $tenth_obta_marks= $rowget['tenth_obta_marks'];
     $twel_board= $rowget['twel_board'];
     $twel_pass_year= $rowget['twel_pass_year'];
     $twel_roll_no= $rowget['twel_roll_no'];
     $twel_subject= $rowget['twel_subject'];
     $twel_tot_marks= $rowget['twel_tot_marks'];
     $twel_obta_marks= $rowget['twel_obta_marks'];
     $tenth_att= $rowget['tenth_att'];
     $twel_att= $rowget['twel_att'];
     $tc_att= $rowget['tc_att'];
     $cast_att= $rowget['cast_att'];
     $aadhar_att= $rowget['aadhar_att'];
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PDF ONLINE ADMISSION REGISTRATION FORM</title>
    
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
                        <tr >
                            <!-- <td style="border-bottom: #999 solid 1px;">
                                <div style="border:1px solid gray;padding:15px;padding-bottom:60px;margin-top: 10px;"></div>
                            </td> -->
                            <td class="title" style="border-bottom: #999 solid 1px;">

                            <span class="title" style="text-align: center;">
                                <div style="border:1px solid gray;padding:15px;padding-bottom:60px;margin-top: 10px; width: 25%;"></div>
                                <img style="width: 120px; height: 135px;margin-left: 49px;
    margin-top: 10px;" src="../images/image/<?php echo $image; ?>" style="width:100%; max-width:200px;">
                                 <div style="border:1px solid gray;padding:16px;padding-bottom:30px;margin-top: 9px; width: 25%;"></div>
                            </span>

                          
                            
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
                                        <td style="text-align:left;"><?php //echo $caddress; ?></td>

                                    </tr>
                                    <tr>
                                        <td>Mobile No.</td>
                                        <td style="text-align:left;"><?php //echo $mobilec; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email Id</td>
                                        <td style="text-align:left;"><?php //echo $emailc; ?></td>
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
                    Student Details
                </td>
                
               
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                   Admission Year :<?php echo $session; ?>
                </td>
               <td style="text-align: left;">
                  Biometric Code. :
                </td>
            </tr>
            
            <tr class="heading">
                <td style="text-align: left;">
                    Admission For : <?php echo $class_name; ?>
                </td>
                <td style="text-align: left;">
                    Admission No. : 
                </td>

            </tr>
    
            <tr class="heading">
                <td style="text-align: left;">
                   Student Name : <?php echo $fname; ?>
                </td>
                <td style="text-align: left;">
                    Gender : <?php echo $gender; ?>
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                    Father's Name : <?php echo $father_name; ?>
                </td>
                <td style="text-align: left;">
                    Mother's Name : <?php echo $mother_name; ?>
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                    DOB : <?php echo $dob; ?>
                </td>
                <td style="text-align: left;">
                    Remark : 
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                   Aadhar Card No. : <?php echo $aadhar_no; ?>
                </td>
                <td style="text-align: left;">
                    Category : <?php echo $category; ?>
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                    Cast : <?php echo $cast; ?>
                </td>
                 <td style="text-align: left;">
                    Annual Family Income : <?php echo $fam_incom; ?>
                </td>
            </tr>

            <tr class="heading">
                <td style="text-align: left;">
                   Parent Aadhar No. : <?php echo $p_aadhar_no; ?>
                </td>
               <td style="text-align: left;">
                    Correspondence Address : <?php echo $address; ?>
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                    District : <?php echo $dist; ?>
                </td>
               <td style="text-align: left;">
                    Pincode : <?php echo $pin_code; ?>
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                    Student Mobile No : <?php echo $contact_one; ?>
                </td>
               <td style="text-align: left;">
                    Parents Contact No : <?php echo $p_contact; ?>
                </td>
            </tr>
            
            <!-- <tr class="heading">
                <td style="text-align: left;">
                 Bank Name : <?php //echo $bank_name; ?>
                </td>
               <td style="text-align: left;">
                    IFSC Code : <?php //echo $ifsc; ?>
                </td>
            </tr> -->
            <!-- <tr class="heading">
                <td style="text-align: left;">
                   Bank Account : <?php //echo $account_no; ?>
                </td>
               <td style="text-align: left;">
                  
                </td>
            </tr> -->
            

      </table> 
      <br>
      
      <table id="bill-table">
            <tr class="heading">
                <td style="text-align: center;" colspan="2">
                    10th Details
                </td>
                
               
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                   Name Of Board : <?php echo $tenth_board; ?>
                </td>
               <td style="text-align: left;">
                  Passing Year : <?php echo $tenth_pass_year; ?>
                </td>
            </tr>
            
            <tr class="heading">
                <td style="text-align: left;">
                    Roll No. : <?php echo $tenth_roll_no; ?>
                </td>
                <td style="text-align: left;">
                    Subject : <?php echo $tenth_subject; ?>
                </td>

            </tr>
             <tr class="heading">
                <td style="text-align: left;">
                    Total Marks : <?php echo $tenth_tot_marks; ?>
                </td>
                <td style="text-align: left;">
                    Obtain Marks : <?php echo $tenth_obta_marks; ?>
                </td>

            </tr>

      </table>      
      <br>

      <table id="bill-table">
            <tr class="heading">
                <td style="text-align: center;" colspan="2">
                     12th Details
                </td>
                
               
            </tr>
            <tr class="heading">
                <td style="text-align: left;">
                   Name Of Board : <?php echo $twel_board; ?>
                </td>
               <td style="text-align: left;">
                  Passing Year : <?php echo $twel_pass_year; ?>
                </td>
            </tr>
            
            <tr class="heading">
                <td style="text-align: left;">
                    Roll No. : <?php echo $twel_roll_no; ?>
                </td>
                <td style="text-align: left;">
                    Subject : <?php echo $twel_subject; ?>
                </td>

            </tr>
             <tr class="heading">
                <td style="text-align: left;">
                    Total Marks : <?php echo $twel_tot_marks; ?>
                </td>
                <td style="text-align: left;">
                    Obtain Marks : <?php echo $twel_obta_marks; ?>
                </td>

            </tr>

      </table>      
      <br>
      <table>
    
    <tr >
       <td> <h3 style="text-align: left;">छात्र / छात्रा .........................</h3></td>
       <td> <h3 style="text-align: right;">प्रबंधन .........................</h3></td>
    </tr>
    <tr >
       <td> <h3 style="text-align: left;">अभिभावक .........................</h3></td>
       <!-- <td> <h3 style="text-align: right;">वार्डन .........................</h3></td> -->
    </tr>
</table>  
    </div>
</body>
</html>
