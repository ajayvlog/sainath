<?php include("../adminsession.php");
$pagename = "college_setting.php";
$module = "Add College";
$submodule = "College Setting";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "college_setting";
$tblpkey = "college_id";
$keyvalue= "1";
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
if(isset($_POST['submit']))
{
    //print_r($_POST);die;
	$college_name = $_POST['college_name'];
	$mobile = $_POST['mobile'];
	$address = $_POST['address'];	
	$city = $_POST['city'];
	$email = $_POST['email'];
	$term_cond  = $_POST['term_cond'];
	
	
	
		//update
            $form_data = array('college_name'=>$college_name,'mobile'=>$mobile,'address'=>$address,'city'=>$city,'email'=>$email,'term_cond'=>$term_cond,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
            $where = array($tblpkey=>$keyvalue);
            $obj->update_record($tblname,$where,$form_data);
				$action=2;
				$process = "updated";
		 echo "<script>location='$pagename?action=$action'</script>";
	  
	
}
    $btn_name = "Update";
    $where = array($tblpkey=>$keyvalue);
    $sqledit = $obj->select_record($tblname,$where);
    $college_name  =  $sqledit['college_name'];
    $mobile = $sqledit['mobile'];
    $address = $sqledit['address'];
    $city = $sqledit['city'];
    $email = $sqledit['email'];
    $term_cond = $sqledit['term_cond'];
	
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
                                <label>College Name <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="college_name" id="college_name" class="input-xxlarge" value="<?php echo $college_name;?>" autofocus/></span>
                            </p>
                            <p>
                                <label>Mobile No:</label>
                                <span class="field"><input type="text" name="mobile" id="mobile" class="input-xxlarge" value="<?php echo $mobile;?>" maxlength="10" autofocus/></span>
                            </p>
                            
                            <p>
                                <label>Address: </label>
                                <span class="field"><input type="text" name="address" id="address" class="input-xxlarge" value="<?php echo $address;?>" autofocus/></span>
                            </p>
                            
                             <p>
                                <label>City: </label>
                                <span class="field"><input type="text" name="city" id="city" class="input-xxlarge" value="<?php echo $city;?>" autofocus/></span>
                            </p>
                            
                            <p>
                                <label>Email ID: </label>
                                <span class="field"><input type="text" name="email" id="email" class="input-xxlarge" value="<?php echo $email;?>" autofocus/></span>
                            </p>
                            
                           <p>
                                <label>Terms & Conditions: </label>
                                <span class="field"><textarea id="term_cond" name="term_cond" class="input-xxlarge"> <?php echo $term_cond;?></textarea>
                               </span>
                            </p>
                            
                          <center> <p class="stdformbutton">
                                <button  type="submit" name="submit"class="btn btn-primary" onClick="return checkinputmaster('college_name'); ">
								<?php echo $btn_name; ?></button>
                                <a href="company_setting.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
                </div>
                   
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
 <script src="../js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
     
       <script type="text/javascript">

            $(function() {
                // Replace the <textarea id="editor2"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('term_cond');
				 
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script> 

</body>

</html>
