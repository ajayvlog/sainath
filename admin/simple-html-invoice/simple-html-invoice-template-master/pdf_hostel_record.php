<?php 
include("../../../adminsession.php");

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PDF ADMISSION FORM</title>
    
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
        width: 20%;
    }
    .item td p{line-height: 5px;}
    </style>
</head>

<body>
    <div class="invoice-box">
       
        <table cellpadding="0" cellspacing="0">

           <!--  <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td style="border-bottom: #999 solid 1px;text-align:center;" class="title"><span class="title" style="text-align: center;"><img src="../../uploaded/studentimg/<?php echo $imgname ;?>" style="width:100%; max-width:200px;"></span>
                            
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>  -->
            
        </table>
        <table id="bill-table">
            
            <tr class="heading">
                <td style="text-align: center;font-size: 20px;" colspan="5">
                   <b> Hosteller Report</b>
                </td>
                
            </tr>

            <tr class="heading">
                <td style="text-align: left;font-size: 15px;" colspan="4">
                   <b>  Class Name :    <?php //echo $class_name; ?></b>
                </td>
                <td style="text-align: left;font-size: 15px;" colspan="4">
                   <b> Session Name :   <?php //echo $session_name; ?></b>
                </td>
            </tr>
          </table>

        <?php
        $sql = "select * from transfer_hostel where sessionid='$sessionid'";
    $res = $obj->executequery($sql);
    foreach($res as $row_get)
    {
    
    // $m_student_reg_id= $rowget['m_student_reg_id'];
    // $imgname= $rowget['imgname'];
    // $class_id= $rowget['class_id'];
    // $class_name = $obj->getvalfield("m_class","class_name","class_id=$class_id");
    // $admission_year= $rowget['admission_year'];
    // $stu_name= $rowget['stu_name'];
    // $dob= $obj->dateformatindia($rowget['dob']);
    // $gender= $rowget['gender'];
    //  $father_name= $rowget['father_name'];
    //  $mother_name= $rowget['mother_name'];
    //  $aadhar_no= $rowget['aadhar_no'];
    //  $parent_aadhar_no= $rowget['parent_aadhar_no'];
    //  $category_id= $rowget['category_id'];
    //  $cast= $rowget['cast'];
    //  $f_income= $rowget['f_income'];
    //  $address= $rowget['address'];
    //  $district= $rowget['district'];
    //  $pincode= $rowget['pincode'];
    //  $mobile= $rowget['mobile'];
    //  $parent_mobile= $rowget['parent_mobile'];
    //  $bank_name= $rowget['bank_name'];
    //  $ifsc= $rowget['ifsc'];
    //  $account_no= $rowget['account_no'];
    //  $enrollment= $rowget['enrollment'];
    //  $rollno = $rowget['rollno'];
    //  $email = $rowget['email'];
    //  $sem_id = $rowget['sem_id'];
    //  $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id=$sem_id");
           $transferid = $row_get['transferid'];
           $studentinfo = $obj->studentinfo($transferid);
           $stu_name  = $studentinfo['stu_name'];
           $father_name = $studentinfo['father_name'];

           $room_id = $row_get['room_id'];
           $room_no = $obj->getvalfield("m_room","room_no","room_id='$room_id'");

           $hostel_id = $obj->getvalfield("m_room","hostel_id","room_id='$room_id'");
           $floor_id = $obj->getvalfield("m_room","floor_id","room_id='$room_id'");

           $hostel_name=$obj->getvalfield("m_hostel","hostel_name","hostel_id='$hostel_id'");
           $floor_name=$obj->getvalfield("m_floor","floor_name","floor_id='$floor_id'");

           $mobile = $studentinfo['mobile'];
           $admission_year = $studentinfo['admission_year'];
           $class_name = $studentinfo['class_name'];
           $dob = $studentinfo['dob'];
           $mother_name = $studentinfo['mother_name'];
           $parent_mobile = $studentinfo['parent_mobile'];

     
        ?>
   <br>
        <table id="bill-table">
            
            <tr class="heading">
                <td style="text-align: left; font-size: 15px;" colspan="4">
                    
                    <b>Student Name :   <?php echo $stu_name; ?></b>
                </td>
            </tr>
          <!-- </table>
          <br>
            <table id="bill-table"> -->
             <!-- <tr class="heading">
                <td style="text-align: left;">
                   <b>Student Info</b>
                </td>
               <td style="text-align: left;">
                  <b>Course Details</b>.
                </td>
                 <td style="text-align: left;">
                 <b> Parents Details</b>
                </td>
                 <td style="text-align: left;">
                 <b>Bank Details</b>
                </td>
            </tr> -->

             <tr class="heading">
                <td style="text-align: left;">
                   student name :<?php echo $gender; ?>
                </td>
               <td style="text-align: left;">
                  Course Name : <?php echo $class_name; ?>
                </td>
                 <td style="text-align: left;">
                  Father's Name :<?php echo $father_name; ?>
                </td>
                 <td style="text-align: left;">
                  Bank Name : <?php echo $bank_name; ?>
                </td>
            </tr>
           
           
      </table>     
      <?php } ?> 
      <!-- <table>
    
    <tr >
       <td> <h3 style="text-align: left;">छात्र / छात्रा .........................</h3></td>
       <td> <h3 style="text-align: right;">प्रबंधन .........................</h3></td>
    </tr>
    <tr >
       <td> <h3 style="text-align: left;">अभिभावक .........................</h3></td>
       <td> <h3 style="text-align: right;">वार्डन .........................</h3></td>
    </tr>
</table>   -->
    </div>
</body>
</html>
