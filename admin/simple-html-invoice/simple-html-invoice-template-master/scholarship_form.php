<?php 
include("../../../adminsession.php");
//echo $admission_id = $_GET['admission_id'];die;
// $company_name = $obj->getvalfield("company_setting","company_name","1=1");
// $caddress = $obj->getvalfield("company_setting","address","1=1");
// $emailc = $obj->getvalfield("company_setting","email","1=1");
// $mobilec = $obj->getvalfield("company_setting","mobile","1=1");
$m_student_reg_id= "";
$imgname= "";
$class_id= "";
$class_name = "";
$admission_year= "";
$stu_name= "";
$dob="";
$admission_date ="";
$gender="";
$father_name="";
$mother_name="";
$aadhar_no="";
$parent_aadhar_no="";
$category_id="";
$cat_name ="";
$cast="";
$f_income="";
$address="";
$district="";
$dis_name ="";
$pincode="";
$mobile="";
$parent_mobile="";
$bank_name="";
$ifsc="";
$account_no="";
$enrollment="";
$rollno ="";
$email ="";
$samgra_id ="";
$remark ="";
$biometric_code ="";
$board_name_10 ="";
$pass_year_10 ="";
$roll_10 ="";
$subject_10 ="";
$tot_mark_10 ="";
$obtain_mark_10 ="";
$board_name_12 ="";
$pass_year_12 ="";
$roll_12 ="";
$subject_12 ="";
$tot_mark_12 ="";
$obtain_mark_12 ="";
$other_course_name ="";
$other_board_name ="";
$other_roll  ="";
$other_pass_year ="";
$other_subject ="";
$other_tot_mark ="";
$other_obtain_mark ="";
if(isset($_GET['m_student_reg_id']))
{
    $m_student_reg_id = $_GET['m_student_reg_id'];
}
else
{
    $m_student_reg_id = "";
    header("location:../../m_student_reg.php");
}

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
    <title>PDF ADMISSION FORM</title>
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
        .table td,h5 {
            padding:7px;
            line-height: 12px;
            font-size: 12px;
            vertical-align: inherit;
        }
    </style>
</head>

<body >
    <br>
    <div class="container">
        <div class="row">
            <div class="span12">
                <div  style="border: 1px solid rgb(212, 212, 212);padding:5px;">
                   
                        <?php 
                            $qry = $obj->executequery("select * from college_setting");
                            foreach($qry as $key)
                            { ?>
                                <center>
                                <h3 style="font-weight:800;"><?php echo strtoupper($key['college_name']); ?></h3>
                                <h5 style="font-weight:800;"><?php echo strtoupper($key['city']); ?></h5>
                                <h5><u>FOR SCHOLARSHIP FORM </u></h5>
                                <h5>NEW / RENEWAL</h5> 
                            </center>
                         <?php } ?>
                        
                    <table class="table table-bordered" style="margin-bottom: 5px;">
                       <tr>
                           <td >Course:</td>
                           <td></td>
                           <td >Session:</td>
                           <td></td>
                        </tr>
                        <tr>
                          <td >Scholarship ID:</td>
                           <td></td>
                           <td >Password:</td>
                           <td></td>
                        </tr>
                   </table>
                   <h5>Cast Certificate</h5>
                   <table class="table table-bordered" style="margin-bottom:5px;">
                                <tr>
                                    <td>District:</td>
                                    <td></td>
                                    <td>Issue Date:</td>
                                    <td></td>
                                </tr>
                               <tr>
                                   <td>Case No.:</td>
                                    <td></td>
                                    <td>Issue Date:</td>
                                    <td></td>
                               </tr>
                               <tr>
                                   <td>Address:</td>
                                    <td></td>
                                    <td>Cast S. No.:</td>
                                    <td></td>
                               </tr>
                               <tr>
                                   <td width="200px">Cast</td>
                                   <td colspan="4"></td>
                               </tr>
                      </table>
                      <table class="table table-bordered" style="margin-bottom:5px;">
                               <h5>Digital Cost </h5>
                               <tr>
                                    <td>Registration No.:</td>
                                    <td></td>
                                    <td>Disposed Date:</td>
                                    <td></td>
                                </tr>
                      </table>
                      <table class="table table-bordered" style="margin-bottom:5px;">
                        <h5>10th Details </h5>
                               <tr>
                                   <td>Name of Board</td>
                                   <td></td>
                                   <td>Passing Year</td>
                                   <td></td>
                               </tr>
                              <tr>
                                   <td>Roll No. </td>
                                   <td></td>
                                   <td>School Name</td>
                                   <td></td>
                               </tr>
                      </table>
                      <table class="table table-bordered" style="margin-bottom:5px;">
                        <h5>Bank Details </h5>
                              <tr>
                                   <td>Name of Bank</td>
                                   <td></td>
                                   <td>IFSC</td>
                                   <td></td>
                            </tr>
                            <tr>
                                   <td width="200px">A/C No.</td>
                                  <td colspan="4"></td>
                            </tr>
                      </table>         
                       <table class="table table-bordered" style="margin-bottom:5px;">
                        <h5>Scholarship Details </h5>
                              <tr>
                                   <td>Institute Code</td>
                                   <td></td>
                                   <td>Course Code</td>
                                   <td></td>
                            </tr>
                            <tr>
                                   <td>Admission Date</td>
                                   <td></td>
                                   <td>DOB</td>
                                   <td></td>
                            </tr>
                            <tr>
                                   <td>Enrollment No.</td>
                                   <td></td>
                                   <td>Last Passed Exam Date</td>
                                   <td></td>
                            </tr>
                            <tr>
                                   <td>School Name</td>
                                   <td></td>
                                   <td>Last Passing %</td>
                                   <td></td>
                            </tr>
                            <tr>
                                   <td>Result</td>
                                   <td></td>
                                   <td>Student Aadhar No.</td>
                                   <td></td>
                            </tr>
                            <tr>
                                   <td width="200px">Father's Aadhar No.</td>
                                  <td colspan="4"></td>
                            </tr>
                    </table>
                    <table class="table table-bordered" style="margin-bottom:5px;">
                        <h5>Income Certificate </h5>
                              <tr>
                                   <td>Father's Occupation</td>
                                   <td></td>
                                   <td>Total Income</td>
                                   <td></td>
                            </tr>
                            <tr>
                                   <td>Income Issue Date</td>
                                   <td></td>
                                   <td>Income Certificate Issued By</td>
                                   <td></td>
                            </tr>
                    </table>
                    <table class="table table-bordered" style="margin-bottom:5px;">
                        <h5>Course Code Details</h5>
                        <tr>
                                   <td>DMLT</td>
                                   <td>12203</td>
                                   <td>BMLT</td>
                                   <td>7801</td>
                                   <td>OT</td>
                                   <td>12012</td>
                            </tr>
                     </table>
                     <br><br>
                       <h5 style="float: right;"><b>Student Signature</b></h5>
                        <br>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.min.js"></script>
    <script src="jquery.min.js"></script>
</body>
</html>
