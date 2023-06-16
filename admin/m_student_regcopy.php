<?php include("../adminsession.php");
$pagename = "m_student_reg.php";
$module = "Student Registration";
$submodule = "STUDENT REGISTRATION";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_student_reg";
$tblpkey = "m_student_reg_id";
if(isset($_GET['m_student_reg_id']))
$keyvalue = $_GET['m_student_reg_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$address = "";
$fname = "";
$lname = "";
$admission_date = "";
$dob = "";
$blood_group = "";
$gender ="";
$class_id ="";
$section_id="";
$enrollment="";
$stu_no="";
$rollno = "";
$fathername ="";
$f_mobile="";
$f_occupation="";
$mothername="";
$m_mobile = "";
$m_occupation = "";
$landline = "";
$aadhar_no = "";
$categary = "";
$religion = "";
$biometric_code = "";

if(isset($_POST['submit']))
{
	//print_r($_POST);die;
	$fname  = $_POST['fname'];
	$lname = $_POST['lname'];
	$admission_date = $obj->dateformatusa($_POST['admission_date']);
	$dob = $obj->dateformatusa($_POST['dob']);
	$blood_group  = $_POST['blood_group'];
	$gender = $_POST['gender'];
  $class_id = $_POST['class_id'];
  $section_id = $_POST['section_id'];
	$rollno = $_POST['rollno'];
  $address = $_POST['address'];
	$fathername = $_POST['fathername'];
	$f_mobile = $_POST['f_mobile'];
	$f_occupation = $_POST['f_occupation'];
	$mothername =  $_POST['mothername'];
	$m_mobile =  $_POST['m_mobile'];
	$m_occupation = $_POST['m_occupation'];
  $landline = $_POST['landline'];
  $aadhar_no = $_POST['aadhar_no'];
  $categary = $_POST['categary'];
  $religion = $_POST['religion'];
  $enable = $_POST['enable'];
  $biometric_code = $_POST['biometric_code'];
  $enrollment = $_POST['enrollment'];
  $stu_no = $_POST['stu_no'];
//   if(isset($_POST['class_id']))
//   $class_id = $_POST['class_id'];
// else
//   $class_id = "";
// if(isset($_POST['section_id']))
//   $section_id = $_POST['section_id'];
// else
//   $section_id = "";

	 //check Duplicate
		$cwhere = array("fname"=>$_POST['fname'],"lname"=>$_POST['lname'],"f_mobile"=>$_POST['f_mobile']);
       // print_r($cwhere);die;
		 $count = $obj->count_method("m_student_reg",$cwhere);
		if ($count > 0 && $keyvalue == 0) 
				{ 
			$dup="<div class='alert alert-danger'>
			<strong>Error!</strong> Duplicate Record.
			</div>";
			//echo $dup; die;
				} 
			else //insert
			 {	
				if($keyvalue == 0)
			  {    
				$form_data = array('fname'=>$fname,'lname'=>$lname,'admission_date'=>$admission_date,'dob'=>$dob,'blood_group'=>$blood_group,'gender'=>$gender,'address'=>$address,'fathername'=>$fathername,'f_mobile'=>$f_mobile,'f_occupation'=>$f_occupation,'mothername'=>$mothername,'m_mobile'=>$m_mobile,'m_occupation'=>$m_occupation,'landline'=>$landline,'aadhar_no'=>$aadhar_no,'categary'=>$categary,'religion'=>$religion,'enable'=>$enable,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'biometric_code'=>$biometric_code);
        //$obj->insert_record($tblname,$form_data);
         $lastid = $obj->insert_record_lastid($tblname,$form_data);
       // echo $lastid; die;

          $form_data1 = array('class_id'=>$class_id,'section_id'=>$section_id,'rollno'=>$rollno,'m_student_reg_id'=>$lastid,'transsessionid'=>$sessionid,'createdate'=>$createdate);
         //print_r($form_data1);die;
          $obj->insert_record("class_transfer",$form_data1);

				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
				else
				{
					//update
					$form_data = array('fname'=>$fname,'lname'=>$lname,'admission_date'=>$admission_date,'dob'=>$dob,'blood_group'=>$blood_group,'gender'=>$gender,'address'=>$address,'fathername'=>$fathername,'f_mobile'=>$f_mobile,'f_occupation'=>$f_occupation,'mothername'=>$mothername,'m_mobile'=>$m_mobile,'m_occupation'=>$m_occupation,'landline'=>$landline,'aadhar_no'=>$aadhar_no,'categary'=>$categary,'religion'=>$religion,'enable'=>$enable,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'biometric_code'=>$biometric_code);
					  $where = array($tblpkey=>$keyvalue);
					 $obj->update_record($tblname,$where,$form_data);


           //$form_data1 = array('class_id'=>$class_id,'section_id'=>$section_id,'rollno'=>$rollno,'m_student_reg_id'=>$keyvalue,'transsessionid'=>$sessionid);
          // print_r($form_data1);die;
         // $where = array($tblpkey=>$keyvalue);
          // $obj->update_record("class_transfer",$where,$form_data1);
					$action=2;
					$process = "updated";
				}
				echo "<script>location='$pagename?action=$action'</script>";
} 
}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $fname =  $sqledit['fname'];
  $lname =  $sqledit['lname'];
  $admission_date =  $obj->dateformatindia($sqledit['admission_date']);
  $dob =  $obj->dateformatindia($sqledit['dob']);
  $blood_group =  $sqledit['blood_group'];
  $gender =  $sqledit['gender'];
 // $class_id =  $sqledit['class_id'];
 // $section_id =  $sqledit['section_id'];
  $class_id = $obj->getvalfield("class_transfer","class_id","m_student_reg_id = '$keyvalue' and transsessionid='$sessionid'");
  $section_id = $obj->getvalfield("class_transfer","section_id","m_student_reg_id = '$keyvalue' and transsessionid='$sessionid'");
  $rollno =  $obj->getvalfield("class_transfer","rollno","m_student_reg_id = '$keyvalue' and transsessionid='$sessionid'");	
  $fathername =  $sqledit['fathername'];
  $f_mobile =  $sqledit['f_mobile'];
  $f_occupation =  $sqledit['f_occupation'];
  $mothername = $sqledit['mothername'];
	$m_mobile =  $sqledit['m_mobile'];
  $m_occupation = $sqledit['m_occupation'];
  $landline = $sqledit['landline'];
  $aadhar_no = $sqledit['aadhar_no'];
  $categary =  $sqledit['categary'];
  $religion = $sqledit['religion'];
  $enable = $sqledit['enable'];
  $address = $sqledit['address'];
  $biometric_code = $sqledit['biometric_code'];
}
else
{
		$admission_date = date('d-m-Y');
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                    <form class="stdform stdform2" method="post" action="">
                    <?php echo $dup; ?>
                       <div class="lg-12 md-12 sm-12">
                       <table class="table table-bordered"> 
                        <tr> 
                     
                       <th>Student No.<span style="color:#F00;">*</span></th>
                       <th>Enrollment No.<span style="color:#F00;">*</span></th>
                       <th>Roll No.<span style="color:#F00;"></span></th>
                      </tr>
                       <tr> 

                        <td> <input type="text" name="stu_no" id="stu_no" class="input-xlarge"  value="<?php echo $stu_no; ?>" autofocus autocomplete="off"  placeholder="Enter Student No"/></td>       
                                         
                        <td> <input type="text" name="enrollment" id="enrollment" class="input-xlarge"  value="<?php echo $enrollment; ?>" autofocus autocomplete="off"  placeholder="Enter Enrollment No"/></td>

                        <td> <input type="text" name="rollno" id="rollno" class="input-xlarge"  value="<?php echo $rollno; ?>" autofocus autocomplete="off"  placeholder="Enter Roll No" <?php if($keyvalue!=""){ echo "disabled='disabled'"; } ?>/></td>
                                 
                        <tr>
                       <tr> 
                     
 						           <th>First Name<span style="color:#F00;">*</span></th>
                       <th>Last Name<span style="color:#F00;">*</span></th>
                       <th>Admission Date<span style="color:#F00;"></span></th>
 						          </tr>
                       <tr> 

                        <td> <input type="text" name="fname" id="fname" class="input-xlarge"  value="<?php echo $fname; ?>" autofocus autocomplete="off"  placeholder="Enter First Name"/></td>       
                                         
                        <td> <input type="text" name="lname" id="lname" class="input-xlarge"  value="<?php echo $lname; ?>" autofocus autocomplete="off"  placeholder="Enter Last Name"/></td>

                        <td><input type="text" name="admission_date" id="admission_date" class="input-xlarge"  value="<?php echo $admission_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/></td>
                                 
                        <tr>
                        <th>D.O.B<span style="color:#F00;"></span></th>
                        <th>Blood Group<span style="color:#F00;"></span></th>
                        <th>Gender<span style="color:#F00;">*</span></th>
                        </tr>
                       <tr>
                       <td> <input type="text" name="dob" id="dob" class="input-xlarge"  value="<?php echo $dob; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask placeholder="dd-mm-yyyy"/></td>

                        <td><select name="blood_group" id="blood_group"  class="chzn-select" style="width:283px;" >
                          <option value="">-select-</option>
                          <option value="A+">A+</option>
                          <option value="B+">B+</option>
                          <option value="AB+">AB+</option>
                          <option value="O+">O+</option>
                          <option value="A-">A-</option>
                          <option value="B-">B-</option>
                          <option value="AB-">AB-</option>
                          <option value="O-">O-</option>
                        </select>
                      <script>document.getElementById('blood_group').value = '<?php echo $blood_group;?>' ;</script></td>
    
                      <td> <select name="gender" id="gender"  class="chzn-select" style="width:283px;" >
                      <option value="">-select-</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      </select>
                      <script>document.getElementById('gender').value = '<?php echo $gender;?>' ;</script>
                      </td>
                        </tr>
                        <tr>
                        <th>Course<span style="color:#F00;">*</span></th>
                        <th>Section<span style="color:#F00;"></span></th>
                        <th>Status<span style="color:#F00;"></span></th>
                        </tr>
                        <tr>
                        <td>
                        <select name="class_id" id="class_id"  class="chzn-select" style="width:283px;" <?php if($keyvalue!=""){ echo "disabled='disabled'"; } ?>>
                        <option value="">-select-</option>
                        <?php
                        
                        $res = $obj->fetch_record("m_class");
                        foreach($res as $row)
                        {
                        ?> 
                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script>document.getElementById('class_id').value = '<?php echo $class_id ; ?>' ;</script>
                        </td>  
                        <td>
                        <select name="section_id" id="section_id"  class="chzn-select" style="width:283px;" <?php if($keyvalue!=""){ echo "disabled='disabled'"; } ?>>
                        <option value="">-select-</option>
                        <?php
                        
                        $res = $obj->fetch_record("m_section");
                        foreach($res as $row)
                        {
                        ?> 
                        <option value="<?php echo $row['section_id']; ?>"><?php echo $row['section_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script>document.getElementById('section_id').value = '<?php echo $section_id ; ?>' ;</script>
                        </td>        
                                
                        <td>
                        <select  name="enable" id="enable" class="chzn-select" style="width:283px;">
                        <option value="">-select-</option>
                        <option value="enable">Enable</option>
                        <option value="disable">Disable</option>
                        </select>
                        <script>document.getElementById('enable').value = '<?php echo $enable;?>' ;</script></td>
                        </tr>
                        <tr> 
                        <th>Category<span style="color:#F00;"></span></th>
                        <th>Religion<span style="color:#F00;"></span></th>
                        <th>Aadhar No.<span style="color:#F00;"></span></th>
                        </tr>
                        <tr>
 									       <td><select name="categary" id="categary"  class="chzn-select" style="width:283px;" >
                                        <option value="">-select-</option>
                                        <option value="ST">ST</option>
                                        <option value="SC">SC</option>
                                        <option value="OBC">OBC</option>
                                        <option value="GENERAL">GENERAL</option>
                                        </select>
                               <script>document.getElementById('categary').value = '<?php echo $categary;?>' ;</script></td>

                         <td> <select name="religion" id="religion"  class="chzn-select" style="width:283px;" >
                                        <option value="">-select-</option>
                                        <option value="ST">HINDU</option>
                                        <option value="SC">MUSLIM</option>
                                        <option value="OBC">CHRISTIAN</option>
                                        <option value="SIKH">SIKH</option>
                                        <option value="BUDHA">BUDDHA</option>
                                        <option value="JAIN">JAIN</option>
                                        <option value="OTHER">OTHER</option>
                                        </select>
                               <script>document.getElementById('religion').value = '<?php echo $religion;?>' ;</script></td>

                         <td> <input type="text" name="aadhar_no" id="aadhar_no" class="input-xlarge" maxlength="12" value="<?php echo $aadhar_no; ?>" autofocus autocomplete="off"  placeholder="Enter Aadhar No"/></td>

                        <tr>
                        <th>Biometric Code</th>
                        <th></th>
                        <th></th>
                        </tr>
                        <tr>

                        <td> <input type="text" name="biometric_code" id="biometric_code" class="input-xlarge" value="<?php echo $biometric_code; ?>" autofocus autocomplete="off" placeholder="Enter Biometric Code"/></td>
                      <td></td>
                      <td></td>
                       </tr>
                       </table>
                       </div>   
                       <br>                      
                       <h3>Parent Details</h3>
                       <div class="lg-12 md-12 sm-12">
                       <table class="table table-bordered"> 
                       <tr> 
                     
                       <th>Father's Name<span style="color:#F00;">*</span></th>
                       <th>Father's Mobile<span style="color:#F00;">*</span></th>
                       <th>Father Ocupation<span style="color:#F00;"></span></th>
                       </tr>
                       <tr>   
                       <td> <input type="text" name="fathername" id="fathername" class="input-xlarge"  value="<?php echo $fathername; ?>" autofocus autocomplete="off"  placeholder="Enter Father's Name"/></td>       
                                         
                        <td> <input type="text" name="f_mobile" id="f_mobile" class="input-xlarge" maxlength="10"  value="<?php echo $f_mobile; ?>" autofocus autocomplete="off"  placeholder="Enter Father's Mobile"/></td>

                        <td><input type="text" name="f_occupation" id="f_occupation" class="input-xlarge"  value="<?php echo $f_occupation; ?>" autofocus autocomplete="off" placeholder="Enter Father Ocupation"/></td>
                                 
                        <tr>
                        <th>Landline<span style="color:#F00;"></span></th>
                        <th>Mother's Name<span style="color:#F00;"></span></th>
                        <th>Mother's Mobile<span style="color:#F00;"></span></th>
                        </tr>
                               <tr>
                               <td> <input type="text" name="landline" id="landline" class="input-xlarge" maxlength="10"  value="<?php echo $landline; ?>" autofocus autocomplete="off"  placeholder="Enter Landline"/></td>
 
                                <td> <input type="text" name="mothername" id="mothername" class="input-xlarge"  value="<?php echo $mothername; ?>" autofocus autocomplete="off"  placeholder="Enter Mother's Name"/></td>
            
                                 <td> <input type="text" name="m_mobile" id="m_mobile" class="input-xlarge" maxlength="10"  value="<?php echo $m_mobile; ?>" autofocus autocomplete="off"  placeholder="Enter Mother's Mobile"/></td>
                                </tr>
                               <tr>
                                <th>Mother Ocupation<span style="color:#F00;"></span></th>
                                    <th colspan="2">Address<span style="color:#F00;"></span></th>
                                    
                                </tr>
                                <tr>
                                <td><input type="text" name="m_occupation" id="m_occupation" class="input-xlarge"  value="<?php echo $m_occupation; ?>" autofocus autocomplete="off" placeholder="Enter Mother Ocupation"/></td>

                                 <td colspan="2"><textarea type="text" name="address" id="address" class="input-xlarge" style="width: 95%;"  value="" autofocus autocomplete="off" placeholder="Enter Address"><?php echo $address; ?></textarea></td> 
                              </tr>
                                <td colspan="3">
                                  <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster(''); ">
                                <?php echo $btn_name; ?></button>
                                <a href="m_student_reg.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">                    
                       </tr>
                       
                       </table>
                       </div>
                        </form>
                    </div>
                    <!--<p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_class_master.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>-->
                <!--widgetcontent-->
                 
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
							              <th class="head0">Father Name</th>
                            <th class="head0">Mother Name</th>
                            <th class="head0">Class</th>
                            <th  class="head0">Section</th>
                            <th class="head0">Mobile</th>
                            <th width="4%" class="head0">Edit</th>
                            <th width="5%" class="head0">Delete</th> 
                         </tr>
                    </thead>
                    <tbody>
                           </span>
				<?php
						$slno=1;
						//$res = $obj->fetch_record("m_product");
           
            $res = $obj->executequery("select * from class_transfer where transsessionid = '$sessionid' order by $tblpkey desc");
						foreach($res as $row_get)
                {

                         $class_id = $row_get['class_id'] ; 
                         $class_name =  $obj->getvalfield("m_class","class_name","class_id = '$class_id'");
                         $section_id = $row_get['section_id'];
                         $section_name =  $obj->getvalfield("m_section","section_name","section_id = '$section_id'");
                         $m_student_reg_id = $row_get['m_student_reg_id']; 
                         $fullname =  $obj->getvalfield("m_student_reg","concat(fname,' ',lname)","m_student_reg_id = '$m_student_reg_id'");
                         $f_mobile =  $obj->getvalfield("m_student_reg","f_mobile","m_student_reg_id = '$m_student_reg_id'") ;
                         $fathername =  $obj->getvalfield("m_student_reg","fathername","m_student_reg_id = '$m_student_reg_id'") ;
                         $mothername =  $obj->getvalfield("m_student_reg","mothername","m_student_reg_id = '$m_student_reg_id'") ;
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td>
					            	<td><?php echo $fullname; ?></td>
                        <td><?php echo $fathername; ?></td>
                        <td><?php echo $mothername; ?></td>
                        <td><?php echo $class_name; ?></td>
                        <td><?php echo $section_name; ?></td>
                        <td><?php echo $f_mobile; ?></td>
                       <td><a class='icon-edit' title="Edit" href='m_student_reg.php?m_student_reg_id=<?php echo $m_student_reg_id ; ?>'></a></td>
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
		module = '<?php echo $module; ?>';
		 //alert(module); 
		if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master_reg.php',
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
  </script>
</body>
</html>
