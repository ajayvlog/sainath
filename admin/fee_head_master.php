<?php include("../adminsession.php");
$pagename = "fee_head_master.php";
$module = "Fee Head Master";
$submodule = "FEE HEAD MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_fee_head";
$tblpkey = "fee_head_id";
if(isset($_GET['fee_head_id']))
$keyvalue = $_GET['fee_head_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$fee_head_name = "";

if(isset($_POST['submit']))
{	//print_r($_POST); die;
	
	 
   $fee_head_name = $obj->test_input($_POST['fee_head_name']);
  

    //check Duplicate
	// $cwhere = array("class_id"=>$_POST['class_id'],"fee_head_name"=>$_POST['fee_head_name']);
	// $count = $obj->count_method("m_fee_head",$cwhere);
 //    	if($count > 0 && $keyvalue == 0 )
	// 		{
	// 		/*$dup = " Error : Duplicate Record";*/
	// 		$dup="<div class='alert alert-danger'>
	// 		<strong>Error!</strong> Error : Duplicate Record.
	// 		</div>";
	// 		} 
			
	// 	else{
			//insert
				if($keyvalue == 0)
			  {    
				$form_data = array('fee_head_name'=>$fee_head_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
				$obj->insert_record($tblname,$form_data); 
	      //print_r($form_data); die;
				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
	
			   else{
				//update
				$form_data = array('fee_head_name'=>$fee_head_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
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

	$fee_head_name =  $sqledit['fee_head_name'];
}
else
{
//$status = "enable";
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
                     <!--   <th>Course Name<span style="color:#F00;">*</span></th> -->
                        <th>Fee Head Name<span style="color:#F00;">*</span></th>
                        <!-- <th>Amount<span style="color:#F00;">*</span></th> -->
                       </tr>
                       <tr> 
                        <!-- <td>
                          <select name="class_id" id="class_id"  class="chzn-select" style="width:283px;">
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
                        </td> -->
                       
                       <td> <input type="text" name="fee_head_name" id="fee_head_name" class="input-xlarge"  value="<?php echo $fee_head_name;?>" autofocus autocomplete="off"  placeholder="Enter Fee Head Name"/></td>

                       <!-- <td> <input type="text" name="amt" id="amt" class="input-xlarge"  value="<?php echo $amt;?>" autofocus autocomplete="off"  placeholder="Enter Fee Head Name"/></td> -->
                        
                       <td><button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('class_id,fee_head_name'); ">
								<?php echo $btn_name; ?></button>
                                <a href="fee_head_master.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
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
                          <!--   <th width="18%" class="head0">Course Name</th> -->
                            <th width="18%" class="head0">Fee Head Name</th>
                             <!-- <th width="18%" class="head0">Amount</th> -->
                             <?php  $chkedit = $obj->check_editBtn("fee_head_master.php",$loginid);              

                            if($chkedit == 1 || $loginid == 1){  ?>
                            <th width="9%" class="head0">Edit</th>
                            <?php  } $chkdel = $obj->check_delBtn("fee_head_master.php",$loginid);             

                            if($chkdel == 1 || $loginid == 1){  ?>
                            <th width="10%" class="head0">Delete</th> 
                            <?php } ?>
                         </tr>
                    </thead>
                    <tbody>
                           </span>
				<?php
						$slno=1;
						
            $res = $obj->executequery("select * from m_fee_head order by fee_head_id desc");
						foreach($res as $row_get)
                {
                  $class_id = $row_get['class_id'];
                  $class_name = $obj->getvalfield("m_class","class_name","class_id=$class_id");
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td> 
                        <!-- <td><?php echo $class_name; ?></td> -->
                        <td><?php echo $row_get['fee_head_name']; ?></td>
                        <!--  <td><?php echo $row_get['amt']; ?></td> -->
                        <?php                

                            if($chkedit == 1 || $loginid == 1){  ?>
                       <td><a class='icon-edit' title="Edit" href='fee_head_master.php?fee_head_id=<?php echo $row_get['fee_head_id'] ; ?>'></a></td>
                       <?php  } if($chkdel == 1 || $loginid == 1){  ?>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['fee_head_id']; ?>);' style='cursor:pointer'></a>
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
