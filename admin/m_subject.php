<?php include("../adminsession.php");
$pagename = "m_subject.php";
$module = "Subject Master";
$submodule = "SUBJECT MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_subject";
$tblpkey = "subject_id";
if(isset($_GET['subject_id']))
$keyvalue = $_GET['subject_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = $obj->test_input($_GET['action']);
else
$action = "";
$status = "";
$dup = "";
$class_id = "";
$subject = "";
if(isset($_POST['submit']))
{	//print_r($_POST); die;
	
	 $class_id = $obj->test_input($_POST['class_id']);
	 $sem_id = $obj->test_input($_POST['sem_id']);
	 $subject = $obj->test_input($_POST['subject']);

    //check Duplicate
	// $cwhere = array("class_id"=>$_POST['class_id']);
	// $count = $obj->count_method("m_class",$cwhere);
    // 	if($count > 0 && $keyvalue == 0 )
	// 		{
	// 		/*$dup = " Error : Duplicate Record";*/
	// 		$dup="<div class='alert alert-danger'>
	// 		<strong>Error!</strong> Error : Duplicate Record.
	// 		</div>";
	// 		} 
			
		// else{
			//insert
				if($keyvalue == 0)
			  {    
				$form_data = array('class_id'=>$class_id,'sem_id'=>$sem_id,'subject'=>$subject,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
				$obj->insert_record($tblname,$form_data); 
				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
	
			   else{
				//update
				$form_data = array('class_id'=>$class_id,'sem_id'=>$sem_id,'subject'=>$subject,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
				$where = array($tblpkey=>$keyvalue);
				$keyvalue = $obj->update_record($tblname,$where,$form_data);
				$action=2;
				$process = "updated";
					
       				 }
		echo "<script>location='$pagename?action=$action'</script>";
	 
		//}
	}
if(isset($_GET[$tblpkey]))
{ 

	$btn_name = "Update";
	$where = array($tblpkey=>$keyvalue);
	$sqledit = $obj->select_record($tblname,$where);
	$class_id =  $sqledit['class_id'];
	$sem_id =  $sqledit['sem_id'];
	$subject =  $sqledit['subject'];
	//$status =  $sqledit['status'];
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
                       <th>Course Name<span style="color:#F00;">*</span></th>
                       <th>Sem/Year<span style="color:#F00;">*</span></th>
                       <th>Subject<span style="color:#F00;">*</span></th>
                       </tr>
                       <tr> 
                       <td> 
                          <select name="class_id" id="class_id" class="chzn-select input-xlarge" autofocus autocomplete="off">
                              <option value="">Select Class</option>
                              <?php
                              $sql = $obj->executequery("select * from m_class order by class_id desc");
                              foreach($sql as $row_get)
                              {
                               ?>
                               <option value="<?php echo $row_get['class_id']; ?>"><?php echo $row_get['class_name']; ?></option>
                               <?php } ?>
                          </select>  
                          <script>document.getElementById('class_id').value = '<?php echo $class_id; ?>'</script>
                    </td>
                    <td>
                  <select name="sem_id" id="sem_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("m_semester");
                    foreach($res as $row_get)
                    {
                      ?> 
                      <option value="<?php echo $row_get['sem_id']; ?>"> <?php echo $row_get['sem_name']; ?></option>                                                     
                    <?php } ?>
                  </select>
                  <script>document.getElementById('sem_id').value = '<?php echo $sem_id ; ?>';
                </script></td>
                    <td>
                    <input type="text" name="subject" id="subject" class="input-xlarge"  value="<?php echo $subject;?>" autofocus autocomplete="off"  placeholder="Enter Subject Name"/>
                    </td>
                             
                       
                       <td><button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('class_id,sem_id,subject'); ">
								<?php echo $btn_name; ?></button>
                                <a href="m_subject.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>"></td>
                       </tr>
                       
                       </table>
                       </div>
                        </form>
                    </div>
                      
                   
                 
 
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
            	<table class="table table-bordered" id="dyntable">
                    <colgroup>
                        <col class="con0" style="text-align: center; width: 4%" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr>
                        	
                            <th width="11%" class="head0 nosort">Sno.</th>
                            <th width="18%" class="head0">Course Name</th>
                            <th width="18%" class="head0">Sem/Year</th>
                            <th width="18%" class="head0">Subject Name</th>
                            <?php  $chkedit = $obj->check_editBtn("m_subject.php",$loginid);              

                            if($chkedit == 1 || $loginid == 1){  ?>
                            <th width="9%" class="head0">Edit</th>
                            <?php  } $chkdel = $obj->check_delBtn("m_subject.php",$loginid);             

                            if($chkdel == 1 || $loginid == 1){  ?>
                            <th width="10%" class="head0">Delete</th> 
                            <?php } ?>
                         </tr>
                    </thead>
                    <tbody>
                           </span>
				<?php
						$slno=1;
						//$res = $obj->fetch_record("m_city");
            $res = $obj->executequery("select * from m_subject order by subject_id desc");
						foreach($res as $row_get)
                {
                    $class_id = $row_get['class_id'];
                    $class_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'");
                    $sem_id = $row_get['sem_id'];
                    $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id='$sem_id'");
                    ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $class_name; ?></td>
                        <td><?php echo $sem_name; ?></td>
                        <td><?php echo $row_get['subject']; ?></td>
                        <?php                

                            if($chkedit == 1 || $loginid == 1){  ?>
                       <td><a class='icon-edit' title="Edit" href='m_subject.php?subject_id=<?php echo $row_get['subject_id'] ; ?>'></a></td>
                       <?php  } if($chkdel == 1 || $loginid == 1){  ?>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['subject_id']; ?>);' style='cursor:pointer'></a>
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

  </script>
</body>
</html>
