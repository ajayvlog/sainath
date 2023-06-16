<?php include("../adminsession.php");
$pagename = "floor_master.php";
$module = "Master";
$submodule = "FLOOR MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_floor";
$tblpkey = "floor_id";
if(isset($_GET['floor_id']))
$keyvalue = $_GET['floor_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$dup = "";
$hostel_id = $floor_name  ="";
// if(isset($_GET['st']))
// {
// 		$st = $_GET['st'];		
// 		$s = $_GET['status'];
// 		if($s!='')
// 		{
// 		$where = array('status'=>1);
// 		$myArray = array("status"=>0);
// 		$obj->update_record($tblname,$where,$myArray);

// 		$where = array($tblpkey=>$st);
// 		$myArray = array("status"=>1);
// 		$obj->update_record($tblname,$where,$myArray);
// 		}	
// 		/*else{								
// 					$where = array($tblpkey=>$st);
// 					$myArray = array("status"=>0);
// 					$obj->update_record($tblname,$where,$myArray);
// 			}*/	
// }
if(isset($_POST['submit']))
{
		// $keyvalue = $_POST['sessionid'];
		
		$floor_name  = $_POST['floor_name'];
		

        if($keyvalue == 0)
				{
					$form_data = array('floor_name'=>$floor_name,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'sessionid'=>$sessionid);			
					$obj->insert_record($tblname,$form_data);
					
					$action=1;
					$process = "insert";
				}
           
        else {
			//update
			$form_data = array('floor_name'=>$floor_name,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
            $where = array($tblpkey=>$keyvalue);
			$keyvalue=$obj->update_record($tblname,$where,$form_data);
			$action=2;
			$process = "updated";
				}
		echo "<script>location='$pagename?action=$action'</script>";
	 //}else close
}
if(isset($_GET[$tblpkey]))
  {
	 $btn_name = "Update";
     $where = array($tblpkey=>$keyvalue);
	 $sqledit = $obj->select_record($tblname,$where);
	 
	 $floor_name = $sqledit['floor_name'];
	 
  }
else
{
  $fromdate = date('Y-m-d');
  $todate = date('Y-m-d');
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
                        <table id="mytable01" align="center" class="table table-bordered table-condensed">
                       <tr> 
                       <th> <span style="color:#F00;"> * </span>Floor Name</th>
                       
                      
                       <th>&nbsp;</th>
                      </tr>
                      <tr> 
                      
                      <td><input type="text" name="floor_name" id="floor_name" class="input-medium"  placeholder='Enter Floor Name'
                     value="<?php echo $floor_name; ?>" /> </td>
                      
                      <td> <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('floor_name'); ">
								<?php echo $btn_name; ?></button>
                      <a href="floor_master.php"  name="reset" id="reset" class="btn btn-success">Reset</a> </td>
                      </tr>
                       </table>
                     </div>
                     	     <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                         
                        </form>
                    </div>
                   <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_master_unit.php" class="btn btn-info" target="_blank">
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
                        	
                          	<th width="6%" class="head0 nosort">S.No.</th>
                            
                            <th width="18%" class="head0">Floor Name</th>
                           <?php  $chkedit = $obj->check_editBtn("floor_master.php",$loginid);              

                            if($chkedit == 1 || $loginid == 1){  ?>
                            <th width="9%" class="head0">Edit</th>
                            <?php  } $chkdel = $obj->check_delBtn("floor_master.php",$loginid);
                            if($chkdel == 1 || $loginid == 1){  ?>
                            <th width="10%" class="head0">Delete</th>
                          <?php } ?>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                               <?php
										$slno=1;
										//$res = $obj->fetch_record("m_session");
                     $res = $obj->executequery("select * from m_floor order by floor_id desc");
										foreach($res as $row_get)
									   {
                      
									   ?> <tr>
                            <td><?php echo $slno++; ?></td> 
                            
                            <td><?php echo $row_get['floor_name']; ?></td>
                            
                            <!-- <td align="center">
                            <small class="badge pull-right bg-<?php if($row_get['status'] == 1) echo 'green'; else echo 'red'; ?>" style="cursor:pointer;" onClick="return change_status('<?php echo $row_get['sessionid'];?>','<?php echo $row_get['status'];?>');" >&nbsp;</small>
                            <?php if($row_get['status'] == 1) echo "<span style='color:green'> Active </span> "; else echo "<span style='color:Red'>In-Active </span> "; ?>
                            </td> -->
                           <?php                

                            if($chkedit == 1 || $loginid == 1){  ?>
                            <td width="12%" style="text-align:center;"><a class='icon-edit' title="Edit" href='floor_master.php?floor_id=<?php echo $row_get['floor_id'] ; ?>'></a></td>
                            <?php  } if($chkdel == 1 || $loginid == 1){  ?>
                            
                            <td width="8%" style="text-align:center;">
                            <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['floor_id']; ?>);' style='cursor:pointer'></a> </td>
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
				  //alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close

function change_status(st,status)
{
	if(st != "")
	{
		if(confirm("Are you sure! You want to active this session."))
		{
			location = '<?php echo $pagename; ?>?st='+st+'&status='+status;
		}
		
	}
}
jQuery('#fromdate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#todate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#fromdate').focus();
</script>
</body>
</html>
