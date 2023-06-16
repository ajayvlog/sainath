<?php
include 'action.php';
$ipaddress = $obj->get_client_ip();
$createdate = date('Y-m-d H:i:s');  
$pagename = "online_student_reg.php";
$module = "Student Registration";
$submodule = "Student Registration";
$btn_name = "Save";
$keyvalue = 0 ;
$tblname = "online_registration";
$tblpkey = "reg_id";
$lastupdated = 
$imgpath = "images/image/";
$fname = "";
$addmis_date = date('Y-m-d');
$addmis_for = "";
$gender = "";
$dob = "";
$aadhar_no = "";
$category = "";
$cast = "";
$address = "";
$dist = "";
$msg = "";
$pin_code = "";
$contact_one = "";
$contact_two = "";
$father_name = "";
$mother_name = "";
$p_aadhar_no = "";
$fam_incom = "";
$p_contact = "";
$tenth_board = "";
$tenth_pass_year = "";
$tenth_roll_no = "";
$tenth_subject = "";
$tenth_tot_marks = "";
$tenth_obta_marks = "";
$twel_board = "";
$twel_pass_year = "";
$twel_roll_no = "";
$twel_subject = "";
$twel_tot_marks = "";
$twel_obta_marks = "";
$image = "";
$dup = "";

If(isset($_GET['action']))
{
  $action = $obj->test_input($_GET['action']);
}
else
{
  $action = "";
}


//$pro_pic = "";


if(isset($_POST['submit']))
{
 //print_r($_POST);
// print_r($_FILES);die;
  $fname = $obj->test_input($_POST['fname']);
  $addmis_date =  $obj->test_input($_POST['addmis_date']);
  $session =  $obj->test_input($_POST['session']);
  $addmis_for =  $obj->test_input($_POST['addmis_for']);
  $gender =  $obj->test_input($_POST['gender']);
  $dob =  $obj->test_input($_POST['dob']);
  $aadhar_no =  $obj->test_input($_POST['aadhar_no']);
  $category =  $obj->test_input($_POST['category']);
  $cast =  $obj->test_input($_POST['cast']);
  $address =  $obj->test_input($_POST['address']);
  $dist =  $obj->test_input($_POST['dist']);
  $pin_code =  $obj->test_input($_POST['pin_code']); 
  $contact_one =  $obj->test_input($_POST['contact_one']); 
  $contact_two =  $obj->test_input($_POST['contact_two']); 
  $father_name =  $obj->test_input($_POST['father_name']); 
  $mother_name =  $obj->test_input($_POST['mother_name']); 
  $p_aadhar_no =  $obj->test_input($_POST['p_aadhar_no']); 
  $fam_incom =  $obj->test_input($_POST['fam_incom']); 
  $p_contact =  $obj->test_input($_POST['p_contact']); 
  $tenth_board =  $obj->test_input($_POST['tenth_board']); 
  $tenth_pass_year =  $obj->test_input($_POST['tenth_pass_year']); 
  $tenth_roll_no =  $obj->test_input($_POST['tenth_roll_no']); 
  $tenth_subject =  $obj->test_input($_POST['tenth_subject']); 
  $tenth_tot_marks =  $obj->test_input($_POST['tenth_tot_marks']); 
  $tenth_obta_marks =  $obj->test_input($_POST['tenth_obta_marks']); 
  $twel_board =  $obj->test_input($_POST['twel_board']); 
  $twel_pass_year =  $obj->test_input($_POST['twel_pass_year']); 
  $twel_roll_no =  $obj->test_input($_POST['twel_roll_no']); 
  $twel_subject =  $obj->test_input($_POST['twel_subject']); 
  $twel_tot_marks =  $obj->test_input($_POST['twel_tot_marks']); 
  $twel_obta_marks =  $obj->test_input($_POST['twel_obta_marks']); 
  // $tenth_att =  $_FILES['tenth_att'];
  // $twel_att =  $_FILES['twel_att'];
  // $tc_att =  $_FILES['tc_att'];
  // $cast_att =  $_FILES['cast_att'];
  // $aadhar_att =  $_FILES['aadhar_att'];
  $image =  $_FILES['image'];
  

  // check Duplicate
  $cwhere = array("contact_one"=>$_POST['contact_one']);
  $count = $obj->count_method("online_registration",$cwhere);
  
      if($count > 0 && $keyvalue == 0)
      {
      // $dup = " Error : Duplicate Record";
      $dup="<div class='text-danger'>
      <strong>Duplicate Record !</strong> This mobile number is already registered.
      </div>";
      
      } 
    else{
        if($keyvalue == 0)
        {
          //insert
          $form_data = array('fname'=>$fname,'addmis_date'=>$addmis_date,'session'=>$session,'addmis_for'=>$addmis_for,'gender'=>$gender,'dob'=>$dob,'aadhar_no'=>$aadhar_no,'category'=>$category,'cast'=>$cast,'address'=>$address,'dist'=>$dist,'pin_code'=>$pin_code,'contact_one'=>$contact_one,'contact_two'=>$contact_two,'father_name'=>$father_name,'mother_name'=>$mother_name,'p_aadhar_no'=>$p_aadhar_no,'fam_incom'=>$fam_incom,'p_contact'=>$p_contact,'tenth_board'=>$tenth_board,'tenth_pass_year'=>$tenth_pass_year,'tenth_roll_no'=>$tenth_roll_no,'tenth_subject'=>$tenth_subject,'tenth_tot_marks'=>$tenth_tot_marks,'tenth_obta_marks'=>$tenth_obta_marks,'twel_board'=>$twel_board,'twel_pass_year'=>$twel_pass_year,'twel_roll_no'=>$twel_roll_no,'twel_subject'=>$twel_subject,'twel_tot_marks'=>$twel_tot_marks,'twel_obta_marks'=>$twel_obta_marks,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'lastupdated'=>$lastupdated);
           // print_r($form_data);die;
          $lastid = $obj->insert_record_lastid("online_registration",$form_data);
          //echo $lastid; die;
          $uploaded_filename = $obj->uploadImage($imgpath,$image);
          
          //print_r($uploaded_filename);die;
          $form_data = array('image'=>$uploaded_filename);
          $where = array($tblpkey=>$lastid);
          $obj->update_record("online_registration",$where,$form_data);
          $action = 1;
          $process = "insert";

           $msg = "Dear Student - $fname\n Your registration successfully \n From SAINATH PARAMEDICAL COLLEGE \n Date: $addmis_date";
            $msg1 = "Dear Admin \n New student has been successfully registered \n Student name - $fname Mobile no - $contact_one From SAINATH PARAMEDICAL COLLEGE \n Date: $addmis_date";
            
           if(strlen($contact_one)==10)
          { 
            $ok = $obj->send_sms_indor($contact_one,$msg);
            $ok = $obj->send_sms_indor("9301824171",$msg1);
            if($ok > 0) 
            { 
              echo "<script>alert('Message sent successfully!');</script>";
            }
            else 
            {
             
              echo "<script>alert('Message could not be sent. Sorry!');</script>";
            }
          }
          
         // echo "<script>location='$pagename?action=$action'</script>";
         echo "<script>location='bank_details.php?action=$action'</script>";
        }
        
       }
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:title" content="Registration Form Session - 2020-21" />
  <meta property="og:description" content="For Registration click on below link" />
  <meta property="og:url" content="https://akshatinfotech.com/myprojects/cipssoft/online_student_reg.php" />
  <meta property="og:image" content="https://akshatinfotech.com/myprojects/cipssoft/images/cips_logo_08.jpg" />
  <link rel="stylesheet" href="library/css/bootstrap.min.css">
  <script src="library/js/jquery.min.js"></script>
  <script src="library/js/popper.min.js"></script>
  <script src="library/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="library/wizard.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style type="text/css">
    body{
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
  li a:hover {
  background-color:#178ea0f7;
  border-radius:5px;
  color:white !important;
  } 
    div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 180px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}

.sansserif {
  font-family: Arial, Helvetica, sans-serif;
}

  </style>
</head>
<body>
<!--   menu -->

<!--   menu -->
  <center>
    <div class="container">
      <img src="images/cips_logo_08.jpg" width="800" height="150" class="img-fluid p-2" alt="Responsive image">
      <h3>Registration Form</h3><h4>Session: 2020-21</h4>
      <h6><?php echo $dup; ?></h6>
    </div>
  </center>
  <section class="signup-step-container">
        <!-- <div class="text-center">
              <img src="images/cips_logo_08.jpg" width="800" height="150" class="img-fluid" alt="Responsive image">
              <h2>Registration Form<h3>Session-2020-21</h3></h2>
              <span><?php //echo $dup; ?> </span>
        </div> -->
         <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="wizard">
                        <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" style="cursor:not-allowed;pointer-events: none;"><span class="round-tab">1 </span> <i>Step 1</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false" style="cursor:not-allowed;pointer-events: none;"><span class="round-tab">2</span> <i>Step 2</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" style="cursor:not-allowed;pointer-events: none;"><span class="round-tab">3</span> <i>Step 3</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab" style="cursor:not-allowed;pointer-events: none;">4</span> <i>Step 4</i></a>
                                </li>
                               </ul>
                        </div>
                      <form  action="" method="post" class="login-box" enctype="multipart/form-data">
                            <div class="tab-content" id="main_form">
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <h4 class="text-center sansserif mb-4">Personal Information</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Full Name <span style="color:red;">*</span></label> 
                                                <input class="form-control" autocomplete="off" type="text" name="fname" id="fname" placeholder="Enter Full Name" autofocus="off" value="<?php //echo ""; ?>"> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admission Date</label> 
                                                <input class="form-control" autocomplete="off" type="text" name="addmis_date" id="addmis_date" placeholder="Enter Job Discription" readonly="" value="<?php echo $obj->dateformatindia($addmis_date); ?>"> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admission Session <span style="color:red;"></span></label> 
                                                <input class="form-control" autocomplete="off" type="text" name="session" id="session" placeholder="Enter Job Discription" value="2020-21" readonly=""> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admission For </label> 
                                                <select class="form-control" name="addmis_for" id="addmis_for">
                                                  <option value="">--Select Course--</option>
                                                  <?php
                                                  $qry = $obj->executequery("select * from m_class");
                                                  foreach ($qry as $key) {
                                                  ?>
                                                  <option value="<?php echo $key['class_id']; ?>"><?php echo $key['class_name']; ?></option>
                                                <?php }?>
                                                  
                                                </select>
                                                <!-- <input class="form-control" autocomplete="off" type="text" name="addmis_for" id="addmis_for" placeholder="Enter Job Discription" value="<?php //echo ""; ?>"> --> 
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label> 
                                                <select class="form-control" name="gender" id="gender" >
                                                  <option value="">--Select Gender--</option>
                                                  <option value="male">Male</option>
                                                  <option value="female">Female</option>
                                                  <option value="other">Other</option>
                                                 </select>
                                               </div>
                                             </div>

                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label> 
                                                <input class="form-control" autocomplete="off" type="date" name="dob" id="dob" placeholder="Enter date of birth" value="<?php //echo ""; ?>"> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Aadhar No.</label> 
                                                <input class="form-control" autocomplete="off" type="text" name="aadhar_no" id="aadhar_no" maxlength="12" minlength="12" placeholder="Enter Aadhar number" value="<?php //echo ""; ?>"> 
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Category</label> 
                                                <select class="form-control" name="category" id="category" >
                                                  <option value="">--Select Category--</option>
                                                  <?php
                                                  $qry = $obj->executequery("select * from m_category");
                                                  foreach ($qry as $key) {
                                                  ?>
                                                  <option value="<?php echo $key['category_id']; ?>"><?php echo $key['cat_name']; ?></option>
                                                <?php }?>
                                                 </select>
                                               </div>
                                             </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label>Cast</label> 
                                                <input class="form-control" autocomplete="off" type="text" name="cast" id="cast" placeholder="Enter Your Cast" value="<?php //echo ""; ?>"> 
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address</label> 
                                            <textarea name="address" placeholder="Address" autocomplete="off" id="address" class="form-control" rows="4" cols="50"></textarea>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                              <div class="form-group">
                                                <label>District </label> 
                                                <input class="form-control" autocomplete="off" type="text" name="dist" id="dist" placeholder="Enter Your District" value="<?php //echo ""; ?>"> 
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                <label>Pin Code</label> 
                                                <input class="form-control" autocomplete="off" type="text" name="pin_code" id="pin_code" placeholder="Enter Pincode" maxlength="6" value="<?php //echo ""; ?>"> 
                                            </div>
                                          </div>
                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mobile Number<span style="color:red;">*</span></label> 
                                                <input type="text" class="form-control" name="contact_one" id="contact_one" placeholder="Mobile No." maxlength="10">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alternet Mobile Number</label>
                                                <input type="text" class="form-control" name="contact_two" id="contact_two" placeholder="Mobile No." maxlength="10">
                                            </div>
                                        </div>
                                      </div>

                                    <ul class="list-inline pull-right">
                                        <li><button type="button" id="next" class="btn btn-success text-white next-step">Continue to next step</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step2">
                                    <h4 class="text-center mb-4 sansserif">Parents Details</h4>
                                    <div class="row">
                                    <div class="col-md-6">
                                              <div class="form-group">
                                                <label>Father Name</label> 
                                                <input class="form-control" autocomplete="off" type="text" name="father_name" id="father_name" placeholder="Enter Fathers Name" value="<?php //echo ""; ?>"> 
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                <label>Mother Name</label> 
                                                <input class="form-control" autocomplete="off" type="text" name="mother_name" id="mother_name" placeholder="Enter Mothers Name" value="<?php //echo ""; ?>"> 
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Parents Aadhar No.</label> 
                                                <input class="form-control" autocomplete="off" type="text" name="p_aadhar_no" id="p_aadhar_no" placeholder="Enter Aadhar number" maxlength="12" value="<?php //echo ""; ?>"> 
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Annual Family Income</label> 
                                                <input class="form-control" autocomplete="off" type="text" name="fam_incom" id="fam_incom" placeholder="Enter Family income" value="<?php //echo ""; ?>"> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Parents Contact Number</label> 
                                                <input type="text" class="form-control" name="p_contact" id="p_contact" placeholder="Enter contact number" maxlength="10">
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step">Back</button></li>
                                       <!--  <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li> -->
                                        <li><button type="button" class="btn btn-success next-step2 text-white" style="font-size:13px;">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <h4 class="text-center mb-4 sansserif">Education Information</h4>
                                    <label><h5>10th Class Details</h5></label> 
                                     <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name of Board</label> 
                                            <input class="form-control" type="text" name="tenth_board" id="tenth_board" placeholder="Enter Board" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Passing Year</label> 
                                            <input class="form-control" type="text" name="tenth_pass_year" id="tenth_pass_year" maxlength="4" minlength="4" placeholder="Enter Passing Year" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Roll Number</label> 
                                            <input class="form-control" type="text" name="tenth_roll_no" id="tenth_roll_no" placeholder="Enter Roll number" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Subject</label> 
                                            <input class="form-control" type="text" name="tenth_subject" id="tenth_subject" placeholder="Enter Subject" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total Marks</label> 
                                            <input class="form-control" type="text" name="tenth_tot_marks" id="tenth_tot_marks" maxlength="4" placeholder="Enter Total Marks" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Obtain Marks</label> 
                                            <input class="form-control" type="text" name="tenth_obta_marks" id="tenth_obta_marks" maxlength="4" placeholder="Enter Obtain Marks" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    </div>
                                    <hr>
                                     <label><h5>12th Class Details</h5></label> 
                                     <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name of Board</label> 
                                            <input class="form-control" type="text" name="twel_board" id="twel_board" placeholder="Enter Board" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Passing Year</label> 
                                            <input class="form-control" type="text" name="twel_pass_year" id="twel_pass_year" maxlength="4" minlength="4" placeholder="Enter Passing Year" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Roll Number</label> 
                                            <input class="form-control" type="text" name="twel_roll_no" id="twel_roll_no" placeholder="Enter Roll number" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Subject</label> 
                                            <input class="form-control" type="text" name="twel_subject" id="twel_subject" placeholder="Enter Subject" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total Marks</label> 
                                            <input class="form-control" type="text" name="twel_tot_marks" id="twel_tot_marks" maxlength="4" placeholder="Enter Total Marks" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Obtain Marks</label> 
                                            <input class="form-control" type="text" name="twel_obta_marks" id="twel_obta_marks" maxlength="4" placeholder="Enter Obtain Marks" value="<?php //echo ""; ?>"> 
                                        </div>
                                    </div>
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step">Back</button></li>
                                        <!-- <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li> -->
                                        <li><button type="button" class="btn btn-success next-step3 text-white" style="font-size:13px;">Continue</button></li>
                                    </ul>
                                    
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step4">
                                    <h4 class="text-center mb-4 sansserif">Upload Documents</h4>
                                    <div class="all-info-container">
                                        <div class="row">
                                            <div class="col-md-12">
                                              <div class="form-group">
                                                    <label>Upload A Passportsize Photo <span style="color:red;">*</span></label> 
                                                    <div class="custom-file">
                                                      <input  type="file" class="form-control" name="image" id="image">
                                                      <!-- <label class="custom-file-label" for="customFile">Select file</label> -->
                                                    </div>
                                                </div>
                                              </div>
                                              </div>
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step">Back</button></li>
                                        <li><button type="submit" name="submit" class="default-btn text-white next-step finish">Register</button>
                                        </li>
                                    </ul>
                                 </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- <div class="jumbotron text-center text-white bg-dark" style="padding:1rem 1rem;border-radius:0px;margin-bottom:0;">
        <p>@2020 copyright. All Rights Reserved</p>
</div> -->
<script src="library/js/sweetalert.min.js"></script>
<!--  ------------step-wizard------------- -->
<script src="library/js/formvalidation.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $("#contact_one").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      
      });
      $("#contact_two").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#p_contact").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#aadhar_no").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#p_aadhar_no").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#pin_code").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#tenth_pass_year").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#tenth_roll_no").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#tenth_tot_marks").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#tenth_obta_marks").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#twel_pass_year").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#twel_roll_no").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#twel_tot_marks").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#twel_obta_marks").keyup( function () {
          // alert("sdfsdaf");
         if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
      });
      $("#image").change( function () {
          // alert("sdfsdaf");
          var fileInput =  document.getElementById('image'); 
          var filePath = fileInput.value; 
          // Allowing file type 
          var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.png)$/i; 
            
          if (!allowedExtensions.exec(filePath)) { 
              swal("Warning",'Only jpeg/jpg/png/pdf image allow',"warning"); 
              fileInput.value = ''; 
              return false; 
          } 
        });
       $("#tenth_att").change( function () {
          // alert("sdfsdaf");
          var fileInput =  document.getElementById('tenth_att'); 
          var filePath = fileInput.value; 
          // Allowing file type 
          var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.png)$/i; 
            
          if (!allowedExtensions.exec(filePath)) { 
              swal("Warning",'Only jpeg/jpg/png/pdf image allow',"warning"); 
              fileInput.value = ''; 
              return false; 
          } 
        });
       $("#twel_att").change( function () {
          // alert("sdfsdaf");
          var fileInput =  document.getElementById('twel_att'); 
          var filePath = fileInput.value; 
          // Allowing file type 
          var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.png)$/i; 
            
          if (!allowedExtensions.exec(filePath)) { 
              swal("Warning",'Only jpeg/jpg/png/pdf image allow',"warning"); 
              fileInput.value = ''; 
              return false; 
          } 
        });
        $("#tc_att").change( function () {
          // alert("sdfsdaf");
          var fileInput =  document.getElementById('tc_att'); 
          var filePath = fileInput.value; 
          // Allowing file type 
          var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.png)$/i; 
            
          if (!allowedExtensions.exec(filePath)) { 
              swal("warning",'Only jpeg/jpg/png/pdf image allow',"warning"); 
              fileInput.value = ''; 
              return false; 
          } 
        });
         $("#cast_att").change( function () {
          // alert("sdfsdaf");
          var fileInput =  document.getElementById('cast_att'); 
          var filePath = fileInput.value; 
          // Allowing file type 
          var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.png)$/i; 
            
          if (!allowedExtensions.exec(filePath)) { 
              swal("warning",'Only jpeg/jpg/png/pdf image allow',"warning"); 
              fileInput.value = ''; 
              return false; 
          } 
        });
          $("#aadhar_att").change( function () {
          // alert("sdfsdaf");
          var fileInput =  document.getElementById('aadhar_att'); 
          var filePath = fileInput.value; 
          // Allowing file type 
          var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.pdf)$/i; 
            
          if (!allowedExtensions.exec(filePath)) { 
              swal("warning",'Only jpeg/jpg/png/pdf image allow',"warning"); 
              fileInput.value = ''; 
              return false; 
          } 
        });

    });     
</script>

<?php if($action == 1)
{ ?>
<script type="text/javascript">
 swal({
  title: "Registered Successfully",
  text: "",
  icon: "success",
  button: "Ok",
});
</script>
<?php }?>
</body>
</html>
