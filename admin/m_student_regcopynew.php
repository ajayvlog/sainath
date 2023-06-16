<?php include("../adminsession.php");
$pagename = "m_student_reg.php";
$module = "Student Registration";
$submodule = "STUDENT REGISTRATION";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_student_reg";
$tblpkey = "m_student_reg_id";
$imgpath = "uploaded/studentimg/";
if(isset($_GET['m_student_reg_id']))
{
 $keyvalue = $_GET['m_student_reg_id'];
}
else
{
  $keyvalue = 0;
}

$sessionid = $obj->getvalfield("m_session","sessionid","status=1");
$session_name = $obj->getvalfield("m_session","session_name","sessionid=$sessionid");
if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$other_board_name = "";
$other_pass_year = "";
$other_roll = "";
$other_subject = "";
$other_tot_mark = "";
$other_obtain_mark = "";
$status = "";
$dup = "";
$remark = "";
$admission_year = $class_id = $rollno = $stu_name = $dob = $enrollment  = $gender = $aadhar_no = $cast= $atten_type= $address  = $pincode= $mobile= $bank_name= $ifsc = $account_no = $biometric_code = $sem_id = $admission_date = $con_id = $college_name = "";
$dis_id = "";
$stu_mobile = "";
$imgname = "";
$board_name_10 = "";
$pass_year_10 = "";
$roll_10 = "";
$subject_10 = "";
$tot_mark_10 = "";
$obtain_mark_10 = "";
$board_name_12 = "";
$pass_year_12 = "";
$roll_12 = "";
$subject_12 = "";
$tot_mark_12 = "";
$obtain_mark_12 = "";

$blood_group ="";


if(isset($_POST['submit']))
{
	//print_r($_POST);die;
	$admission_year  = $_POST['admission_year'];
	$class_id = $_POST['class_id'];
	//$con_id = $_POST['con_id'];
  $college_name = $_POST['college_name'];
  //print_r($con_id);die;
  $rollno = $_POST['rollno'];
  $dob = $obj->dateformatusa($_POST['dob']);
  $stu_name  = $_POST['stu_name'];
  $gender = $_POST['gender'];
  $enrollment = $_POST['enrollment'];
  $stu_mobile = $_POST['stu_mobile'];
  $aadhar_no = $_POST['aadhar_no'];

  $board_name_10  = $_POST['board_name_10'];
  $pass_year_10 = $_POST['pass_year_10'];
  $roll_10 = $_POST['roll_10'];
  $subject_10 = $_POST['subject_10'];
  $tot_mark_10 = $_POST['tot_mark_10'];
  $obtain_mark_10 = $_POST['obtain_mark_10'];
  $board_name_12 = $_POST['board_name_12'];
  $roll_12  = $_POST['roll_12'];
  $pass_year_12 = $_POST['pass_year_12'];
  $subject_12 = $_POST['subject_12'];
  $tot_mark_12 = $_POST['tot_mark_12'];
  $obtain_mark_12 = $_POST['obtain_mark_12'];
  $other_board_name = $_POST['other_board_name'];
  $other_roll  = $_POST['other_roll'];
  $other_pass_year = $_POST['other_pass_year'];
  $other_subject = $_POST['other_subject'];
  $other_tot_mark = $_POST['other_tot_mark'];
  $other_obtain_mark = $_POST['other_obtain_mark'];
  $blood_group = $_POST['blood_group'];


  if(isset($_POST['category_id']))
  {
   $category_id = $_POST['category_id'];
 }
 else
 {
  $category_id = "";
}
   if(isset($_POST['dis_id']))
  {
  $dis_id = $_POST['dis_id'];
  }
  else
  {
    $dis_id = "";
  }
   if(isset($_POST['con_id']))
  {
  $con_id = $_POST['con_id'];
  }
  else
  {
    $con_id = "";
  }
$status = $_POST['status'];
$address = $_POST['address'];
$atten_type = $_POST['atten_type'];
$cast = $_POST['cast'];
$dis_id = $_POST['dis_id'];
$pincode =  $_POST['pincode'];
$mobile =  $_POST['mobile'];
$bank_name = $_POST['bank_name'];
$ifsc = $_POST['ifsc'];
$account_no = $_POST['account_no'];
$biometric_code = $_POST['biometric_code'];
$sem_id  = $_POST['sem_id'];
$admission_date = $obj->dateformatusa($_POST['admission_date']);
$remark = $_POST['remark'];
$imgname= $_FILES['imgname'];



if($keyvalue == 0)
{    
  $form_data = array('admission_year'=>$admission_year,'class_id'=>$class_id,'blood_group'=>$blood_group,'rollno'=>$rollno,'dob'=>$dob,'stu_name'=>$stu_name,'college_name'=>$college_name,'gender'=>$gender,'con_id'=>$con_id,'enrollment'=>$enrollment,'aadhar_no'=>$aadhar_no,'category_id'=>$category_id,'address'=>$address,'atten_type'=>$atten_type,'cast'=>$cast,'district'=>$dis_id,'pincode'=>$pincode,'mobile'=>$mobile,'admission_date'=>$admission_date,'bank_name'=>$bank_name,'ifsc'=>$ifsc,'account_no'=>$account_no,'stu_mobile'=>$stu_mobile,'biometric_code'=>$biometric_code,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'remark'=>$remark,'status'=>$status,'board_name_10'=>$board_name_10,'pass_year_10'=>$pass_year_10,'roll_10'=>$roll_10,'subject_10'=>$subject_10,'tot_mark_10'=>$tot_mark_10,'obtain_mark_10'=>$obtain_mark_10,'board_name_12'=>$board_name_12,'roll_12'=>$roll_12,'pass_year_12'=>$pass_year_12,'subject_12'=>$subject_12,'tot_mark_12'=>$tot_mark_12,'obtain_mark_12'=>$obtain_mark_12,'other_board_name'=>$other_board_name,'other_roll'=>$other_roll,'other_pass_year'=>$other_pass_year,'other_subject'=>$other_subject,'other_tot_mark'=>$other_tot_mark,'other_obtain_mark'=>$other_obtain_mark);
       //$obj->insert_record($tblname,$form_data);
   $lastid = $obj->insert_record_lastid("m_student_reg",$form_data);
       //print_r($form_data);die;
  $uploaded_filename = $obj->uploadImage($imgpath,$imgname);
         //print_r($uploaded_filename);die;
  $form_data1 = array('imgname'=>$uploaded_filename);
  $where = array($tblpkey=>$lastid);
  $obj->update_record($tblname,$where,$form_data1);

  $form_data2 = array('sem_id'=>$sem_id,'sessionid'=>$sessionid,'m_student_reg_id'=>$lastid,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
  $obj->insert_record("class_transfer",$form_data2);
  $action=1;
  $process = "insert";
  echo "<script>location='parent_details.php?m_student_reg_id=$lastid'</script>";
}
else
{
					//update

 $form_data = array('admission_year'=>$admission_year,'class_id'=>$class_id,'blood_group'=>$blood_group,'rollno'=>$rollno,'dob'=>$dob,'stu_name'=>$stu_name,'college_name'=>$college_name,'con_id'=>$con_id,'gender'=>$gender,'enrollment'=>$enrollment,'aadhar_no'=>$aadhar_no,'category_id'=>$category_id,'address'=>$address,'atten_type'=>$atten_type,'cast'=>$cast,'district'=>$dis_id,'pincode'=>$pincode,'mobile'=>$mobile,'stu_mobile'=>$stu_mobile,'bank_name'=>$bank_name,'ifsc'=>$ifsc,'account_no'=>$account_no,'biometric_code'=>$biometric_code,'admission_date'=>$admission_date,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'remark'=>$remark,'status'=>$status,'board_name_10'=>$board_name_10,'pass_year_10'=>$pass_year_10,'roll_10'=>$roll_10,'subject_10'=>$subject_10,'tot_mark_10'=>$tot_mark_10,'obtain_mark_10'=>$obtain_mark_10,'board_name_12'=>$board_name_12,'roll_12'=>$roll_12,'pass_year_12'=>$pass_year_12,'subject_12'=>$subject_12,'tot_mark_12'=>$tot_mark_12,'obtain_mark_12'=>$obtain_mark_12,'other_board_name'=>$other_board_name,'other_roll'=>$other_roll,'other_pass_year'=>$other_pass_year,'other_subject'=>$other_subject,'other_tot_mark'=>$other_tot_mark,'other_obtain_mark'=>$other_obtain_mark);
 $where = array($tblpkey=>$keyvalue);
 $obj->update_record($tblname,$where,$form_data);
 if($_FILES['imgname']['tmp_name']!="")
 {

               //delete old file
  $oldimg = $obj->getvalfield("$tblname","imgname","$tblpkey='$keyvalue'");

  if($oldimg != "")
    unlink("uploaded/studentimg/$oldimg");

  $uploaded_filename = $obj->uploadImage($imgpath,$imgname);
             // print_r($uploaded_filename);die;
  $form_data = array('imgname'=>$uploaded_filename);
  $where = array($tblpkey=>$keyvalue);
  $obj->update_record($tblname,$where,$form_data);
}
$action=2;
$process = "updated";
}

echo "<script>location='$pagename?action=$action'</script>";

}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $admission_year =  $sqledit['admission_year'];
  $class_id =  $sqledit['class_id'];
  $dob =  $sqledit['dob'];
  $rollno =  $sqledit['rollno'];
  $con_id =  $sqledit['con_id'];
  $gender =  $sqledit['gender'];
  $stu_name =  $sqledit['stu_name'];
  $college_name =  $sqledit['college_name'];
  $enrollment =  $sqledit['enrollment'];
  $aadhar_no =  $sqledit['aadhar_no'];
  $category_id = $sqledit['category_id'];
  $address =  $sqledit['address'];
  $atten_type = $sqledit['atten_type'];
  $cast = $sqledit['cast'];
  $dis_id = $sqledit['district'];
  $pincode =  $sqledit['pincode'];
  $mobile = $sqledit['mobile'];
  $bank_name = $sqledit['bank_name'];
  $ifsc = $sqledit['ifsc'];
  $account_no = $sqledit['account_no'];
  $admission_date = $sqledit['admission_date'];
  $imgname = $sqledit['imgname'];
  $sem_id = $obj->getvalfield("class_transfer","sem_id","m_student_reg_id=$keyvalue");
  $remark = $sqledit['remark'];
  $biometric_code = $sqledit['biometric_code'];
  $stu_mobile = $sqledit['stu_mobile'];
  $status = $sqledit['status'];
  $blood_group = $sqledit['blood_group'];

  $board_name_10 =  $sqledit['board_name_10'];
  $roll_10 =  $sqledit['roll_10'];
  $pass_year_10 =  $sqledit['pass_year_10'];
  $subject_10 =  $sqledit['subject_10'];
  $tot_mark_10 =  $sqledit['tot_mark_10'];
  $obtain_mark_10 =  $sqledit['obtain_mark_10'];
  $board_name_12 =  $sqledit['board_name_12'];
  $roll_12 =  $sqledit['roll_12'];
  $pass_year_12 = $sqledit['pass_year_12'];
  $subject_12 =  $sqledit['subject_12'];
  $tot_mark_12 = $sqledit['tot_mark_12'];
  $obtain_mark_12 = $sqledit['obtain_mark_12'];
  $other_board_name =  $sqledit['other_board_name'];
   $other_roll =  $sqledit['other_roll'];
   $other_pass_year = $sqledit['other_pass_year'];
   $other_subject =  $sqledit['other_subject'];
   $other_tot_mark = $sqledit['other_tot_mark'];
   $other_obtain_mark = $sqledit['other_obtain_mark'];
}
else
{
  $admission_date = date('Y-m-d');
  
}
?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script>
    function Numberin(input)
    {
     var num = /[^0-9]/g;
     input.value=input.value.replace(num,"");
    }
  </script>
  <?php include("inc/top_files.php"); ?>
</head>
<body>
  <div class="mainwrapper">

    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
    
    <!-- START OF RIGHT PANEL -->
    
    <div class="rightpanel">
    	<?php include("inc/header.php"); ?>

      <div class="maincontent">
       <div class="contentinner">
        <?php include("../include/alerts.php"); ?>
        <!--widgetcontent-->        
        <div class="widgetcontent  shadowed nopadding">
          <form class="stdform stdform2" method="post" action="" enctype="multipart/form-data">
           <div id="wizard2" class="wizard tabbedwizard">
            <?php include("inc/tabmenu.php");?>                       
            <div>
              <h4>Step 1: Student Registration</h4>
              <?php echo $dup; ?>
              <div class="lg-12 md-12 sm-12">
               <table class="table table-bordered"> 
                <tr> 
                  <th>Admission Year<span style="color:#F00;">*</span></th>
                  <th>Admission For<span style="color:#F00;">*</span></th>
                  <th>Semester Name <span style="color:#F00;">*</span></th>

                </tr>
                <tr> 
                  <td> <input type="text" name="admission_year" id="admission_year" class="input-xlarge"  value="<?php echo $session_name; ?>" autofocus autocomplete="off"  placeholder="Enter Admission Year"/></td>

                  <td><select name="class_id" id="class_id" style="width:280px;" class="chzn-select">
                    <option value="">--Select--</option>
                    <?php
                    $res = $obj->executequery("select * from m_class");
                    foreach($res as $row)
                    {
                      ?>
                      <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <script> document.getElementById('class_id').value='<?php echo $class_id; ?>'; </script></td>

                  <td><select name="sem_id" id="sem_id" style="width:280px;" class="chzn-select">
                    <option value="">--Select--</option>
                    <?php
                    $res = $obj->executequery("select * from m_semester");
                    foreach($res as $row)
                    {
                      ?>
                      <option value="<?php echo $row['sem_id']; ?>"><?php echo $row['sem_name']; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <script> document.getElementById('sem_id').value='<?php echo $sem_id; ?>'; </script></td>

                </tr>
                <tr> 
                  <th>Student Name<span style="color:#F00;">*</span></th>
                  <th>Enrollment No.<span style="color:#F00;"></span></th>
                  <th>DOB.<span style="color:#F00;"></span></th>
                </tr>
                <tr> 
                  <td> <input type="text" name="stu_name" id="stu_name" class="input-xlarge"  value="<?php echo $stu_name; ?>" autofocus autocomplete="off"  placeholder="Enter Student Name"/></td>

                  <td> <input type="text" name="enrollment" id="enrollment" class="input-xlarge"  value="<?php echo $enrollment; ?>" autofocus autocomplete="off"  placeholder="Enter Enrollment No"/></td>

                  <td> <input type="text" name="dob" id="dob" class="input-xlarge"  value="<?php echo $obj->dateformatindia($dob); ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/></td>
                </tr>
                <tr> 
                  <th>Gender<span style="color:#F00;"></span></th>
                  <th>Blood Group<span style="color:#F00;"></span></th>
                  <th>Aadhar Card No.<span style="color:#F00;"></span></th>
                  
                </tr>
                <tr> 
                  <td><select name="gender" id="gender" class="chzn-select" style="width:283px;">
                    <option value="">--Select--</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                  <script>document.getElementById('gender').value = '<?php echo $gender;?>' ;</script>
                </td> 

                 <td> <input type="text" name="blood_group" id="blood_group" class="input-xlarge"  value="<?php echo $blood_group; ?>" autofocus autocomplete="off"  placeholder="Enter Blood Group"/></td>
      

                <td> <input type="text" name="aadhar_no" id="aadhar_no" class="input-xlarge"  value="<?php echo $aadhar_no; ?>" autofocus autocomplete="off"  placeholder="Enter Aadhar Card No"/></td>

                
                  </tr>
                  <tr>
                    <th>Category<span style="color:#F00;"></span></th>
                    <th>Cast<span style="color:#F00;"></span></th>
                    <th>Attendence Type<span style="color:#F00;"></span></th>
                    
                  </tr>
                  <tr>
                    <td><select name="category_id" id="category_id" style="width:280px;" class="chzn-select">
                      <option value="">--Select--</option>
                      <?php
                      $res = $obj->executequery("select * from m_category");
                      foreach($res as $row)
                      {
                        ?>
                        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['cat_name']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <script> document.getElementById('category_id').value='<?php echo $category_id; ?>'; </script></td>
                    <td> <input type="text" name="cast" id="cast" class="input-xlarge"  value="<?php echo $cast; ?>" placeholder="Enter Cast"/></td>

                    <td><select name="atten_type" id="atten_type" class="chzn-select" style="width:283px;">
                          <option value="">--Select--</option>
                          <option value="Regular">Regular</option>
                          <option value="Non_attending">Non Attending</option>
                        </select>
                        <script>document.getElementById('atten_type').value = '<?php echo $atten_type;?>' ;</script>
                    </td>

                    
                  </tr>
                  <tr>
                    <th>Correspondence Address<span style="color:#F00;"></span></th>
                    <th>District<span style="color:#F00;"></span></th>
                    <th>Pincode<span style="color:#F00;"></span></th>
                    
                  </tr>
                  <tr>
                    <td> <input type="text" name="address" id="address" class="input-xlarge"  value="<?php echo $address; ?>" placeholder="Enter Address"/>
                    </td>
                       <!-- <td> <input type="text" name="district" id="district" class="input-xlarge"  value="<?php //echo $district; ?>" placeholder="Enter District"/>
                       </td>  -->
                       <td> <select name="dis_id" id="dis_id" style="width:280px;" class="chzn-select">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from m_district");
                        foreach($res as $row)
                        {
                          ?>
                          <option value="<?php echo $row['dis_id']; ?>"><?php echo $row['dis_name']; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <script> document.getElementById('dis_id').value='<?php echo $dis_id; ?>'; </script>
                    </td> 
                    <td> <input type="text" name="pincode" id="pincode" class="input-xlarge" value="<?php echo $pincode; ?>" placeholder="Enter Pincode"/>
                    </td>   
                   
                  </tr>
                  <tr>
                    <th>Student Mobile No.1<span style="color:#F00;"></span></th>
                    <th>Student Mobile No.2<span style="color:#F00;"></span></th>
                    <th>Student Admission Date<span style="color:#F00;"></span></th>
                    
                  </tr>
                  <tr>
                    <td> <input type="text" name="mobile" id="mobile" class="input-xlarge" maxlength="10" value="<?php echo $mobile; ?>" onkeyup="Numberin(this);" placeholder="Enter Student Mobile No"/>
                    </td>
                   <td><input type="text" name="stu_mobile" id="stu_mobile" class="input-xlarge" maxlength="10" value="<?php echo $stu_mobile; ?>" onkeyup="Numberin(this);" placeholder="Enter Student Mobile No"/> 
                   </td> 
                   <td><input type="text" name="admission_date" id="admission_date" class="input-xlarge"  value="<?php echo $obj->dateformatindia($admission_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask placeholder='dd-mm-yyyy'/> 
                   </td>   
                   
                 </tr>
                 <tr> 
                  <th>Name of the Bank/Branch<span style="color:#F00;"></span></th>
                  <th>IFSC Code<span style="color:#F00;"></span></th>
                  <th>Bank Account Number<span style="color:#F00;"></span></th>
                  
                </tr>
                <tr>
                  <td><input type="text" name="bank_name" id="bank_name" class="input-xlarge"  value="<?php echo $bank_name; ?>" placeholder="Enter Name of the Bank/Branch"/> 
                   </td>
                  <td><input type="text" name="ifsc" id="ifsc" class="input-xlarge"  value="<?php echo $ifsc; ?>" placeholder="Enter IFSC Code"/> 
                  </td>
                  <td> <input type="text" name="account_no" id="account_no" class="input-xlarge"  value="<?php echo $account_no; ?>" placeholder="Enter Name of the Bank/Branch"/>
                  </td>
                  
                </tr>
                <tr>
                  <th>Biometric Code<span style="color:#F00;"></span></th>
                  <th>Roll No.</th>
                  <th>Passport size color photo (Max Size: 100 KB)</th>
                  
                </tr>
                <tr>

                  <td> <input type="text" name="biometric_code" id="biometric_code" class="input-xlarge"  value="<?php echo $biometric_code; ?>" placeholder="Enter IFSC Code"/>
                  </td>

                  <td>
                         <input type="text" name="rollno" id="rollno" class="input-xlarge"  value="<?php echo $rollno; ?>" placeholder="Enter Rollno."/>                  
                  </td>

                  <td><input type="file" name="imgname" id="imgname"><img id="blah" alt="" height='50px;' width="50px;" title='Text Image' src='<?php if($imgname!="" && file_exists("uploaded/studentimg/".$imgname))
                    {
                      echo "uploaded/studentimg/".$imgname; }?>'/> </td>
                </tr>
                <tr>
                  <th>Counselor Name</th>
                  <th>College Name</th>
                  <th>Remark</th>
                  
                </tr>
                <tr>
                  <td><select name="con_id" id="con_id" style="width:280px;" class="chzn-select">
                    <option value="">--Select--</option>
                    <?php
                    $res = $obj->executequery("select * from counselor_master");
                    foreach($res as $row)
                    {
                      ?>
                      <option value="<?php echo $row['con_id']; ?>"><?php echo $row['counselor_name']; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <script> document.getElementById('con_id').value='<?php echo $con_id; ?>'; </script> </td>

                  <td>
                     <input type="text" name="college_name" id="college_name" class="input-xlarge"  value="<?php echo $college_name; ?>" placeholder="Enter College Name"/>            
                  </td>

                  <td>
                    <textarea type="text" name="remark" id="remark" class="input-xlarge" placeholder="Enter Remark" style="width: 95%;"><?php echo $remark; ?></textarea>    
                  </td>
                 
                </tr> 
                <tr>
                  <th>Status</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr> 
                <tr>
                  <td> 
                    <select name="status" id="status" style="width:280px;" class="chzn-select">
                      <option value="">--Select--</option>
                      <option value="0">Enable</option>
                      <option value="1">Disable</option>
                    </select>
                    <script> document.getElementById('status').value='<?php echo $status; ?>'; </script>
                  </td>
                  <td></td>
                  <td></td>
                </tr>      
                  <!-- <tr>
                    <td colspan="3">
                      <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('admission_year,class_id,sem_id,stu_name'); ">
                        <?php //echo $btn_name; ?></button>
                        <a href="m_student_reg.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                        <input type="hidden" name="<?php //echo $tblpkey; ?>" id="<?php //echo $tblpkey; ?>" value="<?php //echo $keyvalue; ?>">
                    </td>                    
                  </tr> -->
              </table>
            </div>
          </div>
          <br>
            <div style="margin-top: 20px;">
              <h4>Step 2: 10th Details : </h4>
             
              <div class="lg-12 md-12 sm-12">
               <table class="table table-bordered"> 
                  <tr> 
                    <th>Name Of Board<span style="color:#F00;"></span></th>
                    <th>Passing Year<span style="color:#F00;"></span></th>
                    <th>Roll No. <span style="color:#F00;"></span></th>

                  </tr>
                  <tr> 
                    <td> <input type="text" name="board_name_10" id="board_name_10" class="input-xlarge"  value="<?php echo $board_name_10; ?>" autofocus autocomplete="off"  placeholder="Enter Name Of 10th Board"/></td>

                    <td><input type="text" name="pass_year_10" id="pass_year_10" class="input-xlarge"  value="<?php echo $pass_year_10; ?>" autofocus autocomplete="off"  placeholder="Enter Passing Year"/></td>

                    <td><input type="text" name="roll_10" id="roll_10" class="input-xlarge"  value="<?php echo $roll_10; ?>" autofocus autocomplete="off"  placeholder="Enter Roll No."/></td>

                  </tr>
                  <tr> 
                    <th>Subject<span style="color:#F00;"></span></th>
                    <th>Total Marks<span style="color:#F00;"></span></th>
                    <th>Obtain Mark<span style="color:#F00;"></span></th>
                  </tr>
                  <tr> 
                    <td> <input type="text" name="subject_10" id="subject_10" class="input-xlarge"  value="<?php echo $subject_10; ?>" autofocus autocomplete="off"  placeholder="Enter Subject"/></td>

                    <td> <input type="text" name="tot_mark_10" id="tot_mark_10" class="input-xlarge"  value="<?php echo $tot_mark_10; ?>" autofocus autocomplete="off"  placeholder="Enter Total Marks"/></td>

                    <td> <input type="text" name="obtain_mark_10" id="obtain_mark_10" class="input-xlarge"  value="<?php echo $obtain_mark_10; ?>" autofocus autocomplete="off"  placeholder="Enter Obtainboard_name_12 Marks"/></td>
                  </tr>
                  <!-- <tr>
                    <td colspan="3">
                      <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('admission_year,class_id,sem_id,stu_name'); ">
                        <?php //echo $btn_name; ?></button>
                        <a href="m_student_reg.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                        <input type="hidden" name="<?php //echo $tblpkey; ?>" id="<?php //echo $tblpkey; ?>" value="<?php //echo $keyvalue; ?>">
                    </td>                    
                  </tr> -->
                </table>
              </div>
            </div>

            <div style="margin-top: 20px;">
              <h4>Step 3: 12th Details : </h4>
              
              <div class="lg-12 md-12 sm-12">
               <table class="table table-bordered"> 
                  <tr> 
                    <th>Name Of Board<span style="color:#F00;"></span></th>
                    <th>Passing Year<span style="color:#F00;"></span></th>
                    <th>Roll No. <span style="color:#F00;"></span></th>

                  </tr>
                  <tr> 
                    <td> <input type="text" name="board_name_12" id="board_name_12" class="input-xlarge"  value="<?php echo $board_name_12; ?>" autofocus autocomplete="off"  placeholder="Enter Name Of 12th Board"/></td>

                    <td><input type="text" name="pass_year_12" id="pass_year_12" class="input-xlarge"  value="<?php echo $pass_year_12; ?>" autofocus autocomplete="off"  placeholder="Enter Passing Year"/></td>

                    <td><input type="text" name="roll_12" id="roll_12" class="input-xlarge"  value="<?php echo $roll_12; ?>" autofocus autocomplete="off"  placeholder="Enter Roll No."/></td>

                  </tr>
                  <tr> 
                    <th>Subject<span style="color:#F00;"></span></th>
                    <th>Total Marks<span style="color:#F00;"></span></th>
                    <th>Obtain Mark<span style="color:#F00;"></span></th>
                  </tr>
                  <tr> 
                   <td> <input type="text" name="subject_12" id="subject_12" class="input-xlarge"  value="<?php echo $subject_12; ?>" autofocus autocomplete="off"  placeholder="Enter Subject"/></td>

                    <td> <input type="text" name="tot_mark_12" id="tot_mark_12" class="input-xlarge"  value="<?php echo $tot_mark_12; ?>" autofocus autocomplete="off"  placeholder="Enter Total Marks"/></td>

                    <td> <input type="text" name="obtain_mark_12" id="obtain_mark_12" class="input-xlarge"  value="<?php echo $obtain_mark_12; ?>" autofocus autocomplete="off"  placeholder="Enter Obtainboard_name_12 Marks"/></td>
                  </tr>
                  <!-- <tr>
                    <td colspan="3">
                      <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('admission_year,class_id,sem_id,stu_name'); ">
                        <?php echo $btn_name; ?></button>
                        <a href="m_student_reg.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                        <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                    </td>                    
                  </tr> -->
                </table>
              </div>
            </div>
            <br>
             <div style="margin-top: 20px;">
              <h4>Step 4: Others Details : </h4>
              
              <div class="lg-12 md-12 sm-12">
               <table class="table table-bordered"> 
                  <tr> 
                    <th>Other Name Of Board<span style="color:#F00;"></span></th>
                    <th>Other Passing Year<span style="color:#F00;"></span></th>
                    <th>Other Roll No. <span style="color:#F00;"></span></th>

                  </tr>
                  <tr> 
                    <td> <input type="text" name="other_board_name" id="other_board_name" class="input-xlarge"  value="<?php echo $other_board_name; ?>" autofocus autocomplete="off"  placeholder="Enter Other Name Of Board"/></td>

                    <td><input type="text" name="other_pass_year" id="other_pass_year" class="input-xlarge"  value="<?php echo $other_pass_year; ?>" autofocus autocomplete="off"  placeholder="Enter Other Passing Year"/></td>

                    <td><input type="text" name="other_roll" id="other_roll" class="input-xlarge"  value="<?php echo $other_roll; ?>" autofocus autocomplete="off"  placeholder="Enter Other Roll No."/></td>

                  </tr>
                  <tr> 
                    <th>Other Subject<span style="color:#F00;"></span></th>
                    <th>Other Total Marks<span style="color:#F00;"></span></th>
                    <th>Other Obtain Mark<span style="color:#F00;"></span></th>
                  </tr>
                  <tr> 
                   <td> <input type="text" name="other_subject" id="other_subject" class="input-xlarge"  value="<?php echo $other_subject; ?>" autofocus autocomplete="off"  placeholder="Enter Other Subject"/></td>

                    <td> <input type="text" name="other_tot_mark" id="other_tot_mark" class="input-xlarge"  value="<?php echo $other_tot_mark; ?>" autofocus autocomplete="off"  placeholder="Enter Other Total Marks"/></td>

                    <td> <input type="text" name="other_obtain_mark" id="other_obtain_mark" class="input-xlarge"  value="<?php echo $other_obtain_mark; ?>" autofocus autocomplete="off"  placeholder="Enter Other Obtainboard_name Marks"/></td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('admission_year,class_id,sem_id,stu_name'); ">
                        <?php echo $btn_name; ?></button>
                        <a href="m_student_reg.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                        <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                    </td>                    
                  </tr>
                </table>
              </div>
            </div>


          </div>
        </form>
      </div>
      <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
      <table class="table table-bordered" id="dyntable">
        <colgroup>
          <col class="con0" style="align: center; width: 4%" />
          <col class="con1" />
          <col class="con0" />
          <col class="con1" />
          <col class="con0" />
          <col class="con1" />
        </colgroup>
        <thead>
          <tr>
            <th  class="head0 nosort">Sno.</th>
            <th  class="head0">Student Name</th>
             <th class="head0">College Name</th>
            <th class="head0">Biometric_Code</th>
            <th class="head0">Gender</th>
            <th class="head0">Mobile</th>
            <th class="head0">Action</th>
            <th width="4%" class="head0">Edit</th>
            <th width="5%" class="head0">Delete</th> 
          </tr>
        </thead>
        <tbody>
        </span>
        <?php
        $slno=1;
						//$res = $obj->fetch_record("m_product");

        $res = $obj->executequery("select * from class_transfer where sessionid=$sessionid order by m_student_reg_id desc");
        foreach($res as $row_get)
        {
          $transferid = $row_get['transferid'];
          $m_student_reg_id = $row_get['m_student_reg_id'];
          $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id=$m_student_reg_id");
          $college_name = $obj->getvalfield("m_student_reg","college_name","m_student_reg_id=$m_student_reg_id");
          $biometric_code = $obj->getvalfield("m_student_reg","biometric_code","m_student_reg_id=$m_student_reg_id");
          $gender = $obj->getvalfield("m_student_reg","gender","m_student_reg_id=$m_student_reg_id");
          $rollno = $obj->getvalfield("m_student_reg","rollno","m_student_reg_id=$m_student_reg_id");
          $mobile = $obj->getvalfield("m_student_reg","mobile","m_student_reg_id=$m_student_reg_id");
          ?>   
          <tr>
            <td><?php echo $slno++; ?></td>
            <td><?php echo $stu_name; ?></td>
            <td><?php echo $college_name; ?></td> 
            <td><?php echo $biometric_code; ?></td>
            <td><?php echo $gender; ?></td>
            
            <td><?php echo $mobile; ?></td>
            <td><a class="btn btn-danger" href="simple-html-invoice/simple-html-invoice-template-master/pdf_viewadmission1.php?m_student_reg_id=<?php echo $row_get['m_student_reg_id']; ?>" target="_blank">Print</a></td>
            <td><a class='icon-edit' title="Edit" href='m_student_reg.php?m_student_reg_id=<?php echo $row_get['m_student_reg_id'] ; ?>'></a></td>
            <td>
              <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $m_student_reg_id; ?>);' style='cursor:pointer'></a>
            </td>
          </tr>
          <?php
        }
        ?>     
      </tbody>
    </table>

  </div><!--contentinner-->
</div><!--maincontent-->
</div>
<!--mainright-->
<!-- END OF RIGHT PANEL -->

<div class="clearfix"></div>
<?php include("inc/footer.php"); ?>

<!--footer-->


</div><!--mainwrapper-->
<script>
	function funDel(id)
	{  //alert(id);   
		tblname = '<?php echo $tblname; ?>';
		tblpkey = '<?php echo $tblpkey; ?>';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
    //imgpath = '<?php echo $imgpath; ?>';
    module = '<?php echo $module; ?>';
		 //alert(module); 
     if(confirm("Are you sure! You want to delete this record."))
     {
      //ajax/delete_image_student_master.php
      jQuery.ajax({
       type: 'POST',
       url: 'ajax/delete_master.php',
       data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
       dataType: 'html',
       success: function(data){
				   //alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
         }

			  });//ajax close
		}//confirm close
	} //fun close


  jQuery('#admission_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
  jQuery('#dob').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
  jQuery('#admission_date').focus();

  jQuery(document).ready(function(){
    // Smart Wizard  
    jQuery('#wizard2').smartWizard({onFinish: onFinishCallback});

    function onFinishCallback(){
      alert('Finish Clicked');
    } 
    
    jQuery(".inline").colorbox({inline:true, width: '60%', height: '500px'});
    jQuery('select, input:checkbox').uniform();
  });

  function changetab(pagename)
  {
    //alert('hi');
    location = pagename;
  }
</script>
</body>
</html>
