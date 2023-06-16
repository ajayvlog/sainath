<?php include("../adminsession.php");
$pagename = "employee_master.php";
$module = "Employee Master";
$submodule = "EMPLOYEE MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_employee";
$tblpkey = "employee_id";
$imgpath = "images/emp_pic/";
$imgname = "";

if(isset($_GET['employee_id']))
$keyvalue = $_GET['employee_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "0";
$dup = "";
$emp_name = "";
$post = "";
$mobile = "";
$dob = "";
$password = "";
$basic_salary = "";
$bank_details = "";
$address = "";
$acc_no = "";
$ifsc = "";
$biometric_id = "";

if(isset($_POST['submit']))
{	
  //print_r($_POST); die;
	
	 $emp_name = $_POST['emp_name'];
   $post = $_POST['post'];
   $mobile = $_POST['mobile'];
   $dob = $obj->dateformatusa($_POST['dob']);
   $join_date = $obj->dateformatusa($_POST['join_date']);
   $basic_salary = $_POST['basic_salary'];
   $bank_details = $_POST['bank_details'];
   $address = $_POST['address'];
   $acc_no = $_POST['acc_no'];
   $ifsc = $_POST['ifsc'];
   $biometric_id = $_POST['biometric_id'];
   $password = $_POST['password'];
   $status = $_POST['status'];
   $imgname = $_FILES['imgname'];
   

    //check Duplicate
	$cwhere = array("emp_name"=>$_POST['emp_name'],"mobile"=>$_POST['mobile']);
	$count = $obj->count_method("m_employee",$cwhere);
    	if($count > 0 && $keyvalue == 0 )
			{
			/*$dup = " Error : Duplicate Record";*/
			$dup="<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
			} 
			
		else{
			//insert
				if($keyvalue == 0)
			  {    
				$form_data = array('biometric_id'=>$biometric_id,'acc_no'=>$acc_no,'ifsc'=>$ifsc,'emp_name'=>$emp_name,'post'=>$post,'mobile'=>$mobile,'dob'=>$dob,'join_date'=>$join_date,'basic_salary'=>$basic_salary,'bank_details'=>$bank_details,'address'=>$address,'status'=>$status,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'password'=>$password);
        $lastid = $obj->insert_record_lastid($tblname,$form_data);

          $uploaded_filename = $obj->uploadImage($imgpath,$imgname);
          $form_data1 = array('imgname'=>$uploaded_filename);
          $where = array('employee_id'=>$lastid);
          $obj->update_record($tblname,$where,$form_data1);
          $action=1;
          $process = "insert";
          echo "<script>location='$pagename?action=$action'</script>";
			  }
        else{
				//update
				$form_data = array('biometric_id'=>$biometric_id,'acc_no'=>$acc_no,'ifsc'=>$ifsc,'emp_name'=>$emp_name,'post'=>$post,'mobile'=>$mobile,'dob'=>$dob,'join_date'=>$join_date,'basic_salary'=>$basic_salary,'bank_details'=>$bank_details,'address'=>$address,'status'=>$status,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'password'=>$password);
          $where = array($tblpkey=>$keyvalue);
          $obj->update_record($tblname,$where,$form_data);

        if($_FILES['imgname']['tmp_name']!="")
        {
          // delete old file
          $oldimg = $obj->getvalfield($tblname,"imgname","employee_id='$keyvalue'");
          //print_r($oldimg);die;
          if($oldimg != "")
               @unlink("images/emp_pic/".$oldimg);

          $uploaded_filename = $obj->uploadImage($imgpath,$imgname);
        //print_r($uploaded_filename);die;
        $form_data = array('imgname'=>$uploaded_filename);
        $where = array('employee_id'=>$keyvalue);
        $update_image = $obj->update_record($tblname,$where,$form_data);
      }
      //$lastid = $keyvalue;
      $action=2;
      $process = "update";
    }
    echo "<script>location='$pagename?action=$action'</script>";
	}
}
if(isset($_GET[$tblpkey]))
{ 

	$btn_name = "Update";
	$where = array($tblpkey=>$keyvalue);
	$sqledit = $obj->select_record($tblname,$where);
	$emp_name =  $sqledit['emp_name'];
	$post =  $sqledit['post'];
  $mobile =  $sqledit['mobile'];
  $dob =  $obj->dateformatindia($sqledit['dob']);
  $join_date =  $obj->dateformatindia($sqledit['join_date']);
  $basic_salary =  $sqledit['basic_salary'];
  $bank_details =  $sqledit['bank_details'];
  $address =  $sqledit['address'];
  $acc_no =  $sqledit['acc_no'];
  $ifsc =  $sqledit['ifsc'];
  $biometric_id =  $sqledit['biometric_id'];
  $password =  $sqledit['password'];
  $status =  $sqledit['status'];
  $imgname =  $sqledit['imgname'];

}
else
{
    $join_date = date('d-m-Y');
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
                    <form class="stdform stdform2" method="post" action="" enctype="multipart/form-data">
                    <?php echo  $dup;  ?>
                       <div class="lg-12 md-12 sm-12">
                       <table class="table table-bordered"> 
                       <tr> 
                       <th>Employee Name<span style="color:#F00;">*</span></th>
                        <th>Post<span style="color:#F00;"></span></th>
                        <th>Mobile No.<span style="color:#F00;"></span></th>
                        
                       </tr>
                       <tr> 
                        <td> <input type="text" name="emp_name" id="emp_name" class="input-xlarge"  value="<?php echo $emp_name;?>" autofocus autocomplete="off"  placeholder="Enter Employee Name"/></td>
                       
                       <td> <input type="text" name="post" id="post" class="input-xlarge"  value="<?php echo $post;?>" autofocus autocomplete="off"  placeholder="Enter Post Name"/></td>

                        <td> <input type="text" name="mobile" id="mobile" class="input-xlarge" maxlength="10"  value="<?php echo $mobile;?>" autofocus autocomplete="off" placeholder="Enter Mobile No Name"/></td>
                        
                        </tr>
                        <tr> 
                        <th>DOB<span style="color:#F00;"></span></th>
                        <th>Date of Joining<span style="color:#F00;"></span></th>
                        <th>Basic Salary<span style="color:#F00;"></span></th>
                        
                       </tr>
                       <tr> 
                        <td> <input type="text" name="dob" id="dob" class="input-xlarge"  value="<?php echo $dob;?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/></td>
                       
                       <td> <input type="text" name="join_date" id="join_date" class="input-xlarge"  value="<?php echo $join_date;?>" autofocus autocomplete="off"  placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/></td>

                        <td> <input type="text" name="basic_salary" id="basic_salary" class="input-xlarge"  value="<?php echo $basic_salary;?>" autofocus autocomplete="off"  placeholder="Enter Basic Salary"/></td>
                        
                        </tr>
                        <tr> 
                       <th >Bank Details<span style="color:#F00;"></span></th>
                       <th >Account Number<span style="color:#F00;"></span></th>
                       <th >IFSC Code<span style="color:#F00;"></span></th>
                        
                        
                       </tr>
                       <tr> 
                        <td> <input type="text" name="bank_details" id="bank_details" class="input-xlarge"  value="<?php echo $bank_details;?>" autofocus autocomplete="off"  placeholder="Enter Bank Details"/></td>

                        <td ><input type="text" name="acc_no" id="acc_no" class="input-xlarge" placeholder="Enter Account Code" value="<?php echo $acc_no; ?>"></td>
                       
                       <td ><input type="text" name="ifsc" id="ifsc" class="input-xlarge" placeholder="Enter IFSC Code" value="<?php echo $ifsc; ?>"></td>
                        
                        </tr>
                        <tr> 
                            <th>Biometric ID<span style="color:#F00;"></span></th>
                            <th>Password<span style="color:#F00;">*</span></th>
                            <th>Address<span style="color:#F00;"></span></th>
                        
                       </tr>
                       <tr> 
                       
                       <td><input type="text" name="biometric_id" id="biometric_id" class="input-xlarge" placeholder="Enter Biometric ID" value="<?php echo $biometric_id; ?>"></td>
                       <td><input type="password" name="password" id="password" class="input-xlarge" placeholder="Enter Password" value="<?php echo $password; ?>"></td>
                       <td colspan="2"><textarea name="address" id="address" class="input-xlarge" placeholder="Enter Address" style="width: 95%;"><?php echo $address; ?></textarea></td>
                        </tr>
                        <tr>
                          <th>Status</th>
                          <th>Photo</th>
                          <th></th>
                        </tr>
                        <tr>
                          <td> <select id="status" name="status">
                            <option>--select status--</option>
                            <option value="0">Enable</option>
                            <option value="1">Disable</option>
                            </select>
                            <script type="text/javascript">document.getElementById('status').value = "<?php echo $status;?>"</script>
                          </td>
                          <td><input type="file" name="imgname" id="imgname" class="input-xlarge">
                          <?php if($imgname!="")
                                        {
                                          ?>
                                      <img src="images/emp_pic/<?php echo $imgname; ?>" style="width: 100px;">
                                        <?php
                                        }

                                        ?></td>
                          <td></td>
                        </tr>
                        <tr>
                       <td colspan="3"><button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('emp_name,password'); ">
								              <?php echo $btn_name; ?></button>
                                <a href="employee_master.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>"></td>
                       </tr>
                       
                       </table>
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
                        	
                            <th width="11%" class="head0 nosort">Sno.</th>
                            <th width="18%" class="head0">Employee Name</th>
                            <th width="18%" class="head0">Post</th>
                            <th width="15%" class="head0">Mobile</th>
                            <th width="15%" class="head0">DOB</th>
                            <th width="15%" class="head0">Join_Date</th>
                            <th width="15%" class="head0">Basic_Salary</th>
                            <th width="15%" class="head0">status</th>
                            <th width="15%" class="head0">Photo</th>
                            <?php  $chkedit = $obj->check_editBtn("employee_master.php",$loginid);              

                            if($chkedit == 1 || $loginid == 1){  ?>
                            <th width="9%" class="head0">Edit</th>
                            <?php  } $chkdel = $obj->check_delBtn("employee_master.php",$loginid);             

                            if($chkdel == 1 || $loginid == 1){  ?>
                            <th width="10%" class="head0">Delete</th> 
                            <?php } ?>
                         </tr>
                    </thead>
                    <tbody>
                           </span>
				<?php
						$slno=1;
						
            $res = $obj->executequery("select * from m_employee order by employee_id desc");
						foreach($res as $row_get)
                {
                  $status = $row_get['status'];
                  if($status == 0)
                  {
                    $status = "enable";
                  }
                  else
                  {
                   $status = "disable";
                  }
                  $imgname = $row_get['imgname'];

                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $row_get['emp_name']; ?></td>
                        <td><?php echo $row_get['post']; ?></td>
                        <td><?php echo $row_get['mobile']; ?></td>
                        <td><?php echo $obj->dateformatindia($row_get['dob']); ?></td>
                        <td><?php echo $obj->dateformatindia($row_get['join_date']); ?></td>
                        <td><?php echo $row_get['basic_salary']; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><img style="width: 50px; height: 50px;" <?php if($imgname!=""){?> src="images/emp_pic/<?php echo $imgname; ?>" <?php } else { }?>></td>
                        <?php                

                            if($chkedit == 1 || $loginid == 1){  ?>
                       <td><a class='icon-edit' title="Edit" href='employee_master.php?employee_id=<?php echo $row_get['employee_id'] ; ?>'></a></td>
                       <?php  } if($chkdel == 1 || $loginid == 1){  ?>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['employee_id']; ?>);' style='cursor:pointer'></a>
                        </td>
                        <?php } ?>
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
  { 
    //alert(id);   
    var tblname = '<?php echo $tblname; ?>';
    var tblpkey = '<?php echo $tblpkey; ?>';
    var pagename = '<?php echo $pagename; ?>';
    var submodule = '<?php echo $submodule; ?>';
    var imgpath = '<?php echo $imgpath; ?>';
   module = '<?php echo $module; ?>';
     //alert(module); 
     if(confirm("Are you sure! You want to delete this record."))
     {
      //ajax/delete_image_student_master.php
      jQuery.ajax({
       type: 'POST',
       url: 'ajax/delete_image_master.php',
       data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&imgpath='+'&module='+module,
       dataType: 'html',
       success: function(data){
           //alert(data);
           location='<?php echo $pagename."?action=3" ; ?>';
         }

        });//ajax close
    }//confirm close
  } //fun close


jQuery('#dob').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#join_date ').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#dob').focus();
  </script>
</body>
</html>
