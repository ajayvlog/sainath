<?php include("../adminsession.php");

$pagename = "stu_document_upload.php";
$module = "Document Upload";
$submodule = "Document Upload";
$btn_name = "Save";
$customer_id =0 ;
$tblname = "document_upload";
$tblpkey = "doc_upload_id";
$imgpath = "/uploaded/document/";

if(isset($_GET['m_student_reg_id']))
$m_student_reg_id = $_GET['m_student_reg_id'];
else
$m_student_reg_id = 0;


if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{	
	//print_r($_FILES); die;
	$m_student_reg_id = $_POST['m_student_reg_id'];
    $document_id_arr = $_POST['document_id'];
	$imgname_arr   = $_FILES['imgname'];
    //$imgname= $_FILES['imgname'];
	
    //customer images update
    if($m_student_reg_id > 0)
    {
            $where = array('m_student_reg_id'=>$m_student_reg_id);
            $obj->delete_record($tblname,$where);
			$i = 0;
            foreach($document_id_arr as $document_id)
            {
                
                $imgname = $imgname_arr[$i];
                
                
                $form_data = array('m_student_reg_id'=>$m_student_reg_id,'document_id'=>$document_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
                //$obj->insert_record($tblname,$form_data); 
               $keyvalue = $obj->insert_record_lastid($tblname,$form_data);
            $uploaded_filename = $obj->uploadImage($imgpath,$imgname);

            $form_data = array('imgname'=>$uploaded_filename);
            $where = array($tblpkey=>$keyvalue);
            $keyvalue = $obj->update_record($tblname,$where,$form_data);
                $i++;
            }
			$action=1;
			$process = "insert";
    }
	echo "<script>location='$pagename?action=$action&m_student_reg_id=$m_student_reg_id'</script>";
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
                   
                           <p>
                            <label>Student Name <span class="text-error">*</span></label>
                            <span class="field"><select name="m_student_reg_id" id="m_student_reg_id" class="chzn-select" style="width:538px;" onChange="getid(this.value)" >
                            <option value=""> Select</option>
                            <?php
                            $slno=1;
                            $res = $obj->executequery("select * from m_student_reg");
                            foreach($res as $row_get)
                            {   
                            ?>
                            <option value="<?php echo $row_get['m_student_reg_id'];  ?>"> <?php echo $row_get['fname']." ".$row_get['lname']; ?></option>
                            <?php } ?>
                            </select>
                            <script>  document.getElementById('m_student_reg_id').value='<?php echo $m_student_reg_id; ?>'; </script></span>
                            </p>
                            <hr>
                            <?php
                            if($m_student_reg_id > 0)
                            { ?>
                    		<p>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Slno</td>
                                        <td>Document Name</td>
                                        <td>Upload Files</td>
                                    </tr> 
                                    <tr>
                                        <?php
                                        $res = $obj->executequery("select * from m_document");
                                        $slno = 1;
                                        foreach($res as $row_get)
                                        {   
                                            $document_id = $row_get['document_id'];
                                            $doc_imgname = $obj->getvalfield("document_upload","imgname","m_student_reg_id='$m_student_reg_id' and document_id='$document_id'");

                                        ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                               
                                                <td><?php echo $row_get['document_name']; ?>
                                                    <input type="hidden" name="document_id[]" value="<?php echo $document_id; ?>">
                                                </td>
                                                <td>
                                                    <input class="form-control" id="imgname" name="imgname[]" type="file" value="<?php echo $doc_imgname; ?>">
                                                    <!-- <input type="text" name="total_fee[]" value="<?php echo $total_fee; ?>"> -->
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
 
 function getid(m_student_reg_id)
 {
    //var customer_id = document.getElementById('customer_id').value;
    location = 'stu_document_upload.php?m_student_reg_id='+m_student_reg_id;
 }
  </script>
</body>
</html>
