<?php include("../adminsession.php");
$pagename = "m_category.php";
$module = "Category Master";
$submodule = "CATEGORY MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_category";
$tblpkey = "category_id";
if(isset($_GET['category_id']))
$keyvalue = $_GET['category_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$cat_name = "";
if(isset($_POST['submit']))
{	//print_r($_POST); die;
	
	 $cat_name = $_POST['cat_name'];

    //check Duplicate
	$cwhere = array("cat_name"=>$_POST['cat_name']);
	$count = $obj->count_method("m_category",$cwhere);
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
				$form_data = array('cat_name'=>$cat_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
				$obj->insert_record($tblname,$form_data); 
	//print_r($form_data); die;
				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
	
			   else{
				//update
				$form_data = array('cat_name'=>$cat_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
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
	$cat_name =  $sqledit['cat_name'];
	//$status =  $sqledit['status'];
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
                       <th>Category Name<span style="color:#F00;">*</span></th>
                       </tr>
                       <tr> 
                       <td> <input type="text" name="cat_name" id="cat_name" class="input-xlarge"  value="<?php echo $cat_name;?>" autofocus autocomplete="off"  placeholder="Enter Course Name"/></td>
                             
                       
                       <td><button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('cat_name'); ">
								<?php echo $btn_name; ?></button>
                                <a href="m_category.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
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
                            <th width="18%" class="head0">Category Name</th>
                            <?php  $chkedit = $obj->check_editBtn("m_category.php",$loginid);              

                            if($chkedit == 1 || $loginid == 1){  ?>
                            <th width="9%" class="head0">Edit</th>
                            <?php  } $chkdel = $obj->check_delBtn("m_category.php",$loginid);  
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
            $res = $obj->executequery("select * from m_category order by category_id desc");
						foreach($res as $row_get)
                {
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $row_get['cat_name']; ?></td>
                        <?php                

                            if($chkedit == 1 || $loginid == 1){  ?>
                       <td><a class='icon-edit' title="Edit" href='m_category.php?category_id=<?php echo $row_get['category_id'] ; ?>'></a></td>
                       <?php  } if($chkdel == 1 || $loginid == 1){  ?>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['category_id']; ?>);' style='cursor:pointer'></a>
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
