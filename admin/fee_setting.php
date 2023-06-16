<?php include("../adminsession.php");

$pagename = "fee_setting.php";
$module = "Fee Setting";
$submodule = "FEE SETTING";
$btn_name = "Save";
$customer_id =0 ;
$tblname = "fee_setting";
$tblpkey = "customer_id";

if(isset($_GET['sessionid']))
$sessionid = $_GET['sessionid'];
else
$sessionid = 0;


if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{	
	//print_r($_POST); die;
	$sessionid = $_POST['sessionid'];
    $class_id_arr = $_POST['class_id'];
	$total_fee_arr   = $_POST['total_fee'];
	
    //customer rate update
    if($sessionid > 0)
    {
            $where = array('sessionid'=>$sessionid);
            $obj->delete_record($tblname,$where);
			$i = 0;
            foreach($class_id_arr as $class_id)
            {
                
                $total_fee = $total_fee_arr[$i];
                
                
                $form_data = array('sessionid'=>$sessionid,'class_id'=>$class_id,'total_fee'=>$total_fee,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
                $obj->insert_record($tblname,$form_data); 
                $i++;
            }
			$action=1;
			$process = "insert";
    }
	echo "<script>location='$pagename?action=$action&sessionid=$sessionid'</script>";
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
                   
                           <p>
                            <label>Session Name <span class="text-error">*</span></label>
                            <span class="field"><select name="sessionid" id="sessionid" class="chzn-select" style="width:538px;" onChange="getid(this.value)" >
                            <option value=""> Select</option>
                            <?php
                            $slno=1;
                            $res = $obj->executequery("select * from m_session");
                            foreach($res as $row_get)
                            {   
                            ?>
                            <option value="<?php echo $row_get['sessionid'];  ?>"> <?php echo $row_get['session_name']; ?></option>
                            <?php } ?>
                            </select>
                            <script>  document.getElementById('sessionid').value='<?php echo $sessionid; ?>'; </script></span>
                            </p>
                            <hr>
                            <?php
                           
                            if($sessionid > 0)
                            { ?>
                    		<p>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Slno</td>
                                        <td>Course Name</td>
                                        <td>Total Fee</td>
                                    </tr> 
                                    <tr>
                                        <?php
                                        $res = $obj->executequery("select * from m_class");
                                        $slno = 1;
                                        foreach($res as $row_get)
                                        {   
                                            $class_id = $row_get['class_id'];
                                            $total_fee = $obj->getvalfield("fee_setting","total_fee","sessionid='$sessionid' and class_id='$class_id'");

                                        ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                               
                                                <td><?php echo $row_get['class_name']; ?>
                                                    <input type="hidden" name="class_id[]" value="<?php echo $class_id; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="total_fee[]" value="<?php echo $total_fee; ?>">
                                                </td>
                                                
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </p>

                         <center> <p class="stdformbutton">
<button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('total_fee');" />
								<?php echo $btn_name; ?></button>
                                <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $sessionid; ?>">
                            </p> </center>
                            <?php } ?>
                        </form>
                    </div>
                      
                   <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_class_master.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>-->
                <!--widgetcontent-->
                 
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
 
 function getid(sessionid)
 {
    //var customer_id = document.getElementById('customer_id').value;
    location = 'fee_setting.php?sessionid='+sessionid;
 }
  </script>
</body>
</html>
