<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "assign_subjects.php";
$module = "Assign Subject";
$submodule = "ASSIGN SUBJECT";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "assign_subject";
$tblpkey = "assign_id";
if(isset($_GET['assign_id']))
$keyvalue = $_GET['assign_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$stu_subject_id = "";
$employee_id = "";
$sessionid = $_SESSION['sessionid'];
if(isset($_POST['submit']))
{	//print_r($_POST); die;

	 $employee_id = $obj->test_input($_POST['employee_id']);
	 $stu_subject_id = $obj->test_input($_POST['stu_subject_id']);
   

    //check Duplicate
	$cwhere = array("employee_id"=>$_POST['employee_id'],"stu_subject_id"=>$_POST['stu_subject_id']);
	$count = $obj->count_method("assign_subject",$cwhere);
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
				$form_data = array('employee_id'=>$employee_id,'stu_subject_id'=>$stu_subject_id,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sessionid'=>$sessionid);
				$obj->insert_record($tblname,$form_data); 
	//print_r($form_data); die;
				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
	
			   else{
				//update
				$form_data = array('employee_id'=>$employee_id,'stu_subject_id'=>$stu_subject_id,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'sessionid'=>$sessionid);
				$where = array($tblpkey=>$keyvalue);
				$keyvalue = $obj->update_record($tblname,$where,$form_data);
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
	$employee_id =  $sqledit['employee_id'];
  $stu_subject_id =  $sqledit['stu_subject_id'];
	
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
                    <?php echo  $dup;  ?>
                       <div class="lg-12 md-12 sm-12">
                       <table class="table table-bordered"> 
                       <tr> 
                       <th>Employee Name<span style="color:#F00;">*</span></th>
                        <th>Subject Name<span style="color:#F00;">*</span></th>
                       </tr>
                       <tr> 
                       <td>
                        <select name="employee_id" id="employee_id" style="width:250px;" class="chzn-select">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from m_employee");
                        foreach($res as $row)
                        {
                        ?>
                        <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['emp_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('employee_id').value='<?php echo $employee_id; ?>'; </script>    
                        </td>

                       <td>
                        <select name="stu_subject_id" id="stu_subject_id" style="width:250px;" class="chzn-select">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from student_subject_master");
                        foreach($res as $row)
                        {
                          $class_id = $row['class_id'];
                          $sem_id = $row['sem_id'];
                          $class_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'");
                          $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id='$sem_id'");
                        ?>
                        <option value="<?php echo $row['stu_subject_id']; ?>"><?php echo $row['subject_name']." ( ".$class_name." / ".$sem_name." ) "; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('stu_subject_id').value='<?php echo $stu_subject_id; ?>'; </script>    
                        </td>

                       
                       <td><button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('employee_id,stu_subject_id'); ">
								       <?php echo $btn_name; ?></button>
                                <a href="assign_subjects.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
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
                            <th width="18%" class="head0">Subject Name</th>
                            <?php  $chkedit = $obj->check_editBtn("assign_subjects.php",$loginid);              

                            if($chkedit == 1 || $loginid == 1){  ?>
                            <th width="9%" class="head0">Edit</th>
                            <?php  } $chkdel = $obj->check_delBtn("assign_subjects.php",$loginid);
                            if($chkdel == 1 || $loginid == 1){  ?>
                            <th width="10%" class="head0">Delete</th> 
                          <?php } ?>
                         </tr>
                    </thead>
                    <tbody>
                           </span>
				<?php
						$slno=1;
						
            $res = $obj->executequery("select * from assign_subject order by assign_id desc");
						foreach($res as $row_get)
                {
                  $employee_id = $row_get['employee_id'];
                  $emp_name = $obj->getvalfield("m_employee","emp_name","employee_id='$employee_id'");
                  $stu_subject_id = $row_get['stu_subject_id'];
                  $subject_name = $obj->getvalfield("student_subject_master","subject_name","stu_subject_id='$stu_subject_id'");
                  $class_id = $obj->getvalfield("student_subject_master","class_id","stu_subject_id='$stu_subject_id'");
                  $sem_id = $obj->getvalfield("student_subject_master","sem_id","stu_subject_id='$stu_subject_id'");
                  $class_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'");
                  $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id='$sem_id'");
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $emp_name; ?></td>
                        <td><?php echo $subject_name." ( ".$class_name." / ".$sem_name." ) "; ?></td>
                        <?php                

                            if($chkedit == 1 || $loginid == 1){  ?>
                       <td><a class='icon-edit' title="Edit" href='assign_subjects.php?assign_id=<?php echo $row_get['assign_id'] ; ?>'></a></td>
                       <?php  } if($chkdel == 1 || $loginid == 1){  ?>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['assign_id']; ?>);' style='cursor:pointer'></a>
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
			  url: 'ajax/delete_master.php',
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close
jQuery('#holiday_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
  </script>
</body>
</html>
