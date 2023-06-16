<?php include("../adminsession.php");
$pagename = "view_birthdaylist.php";
$module = "Report";
$submodule = "Birthday List";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "m_student_reg";
$tblpkey = "m_student_reg_id";
$today = date('Y-m-d');
$college_name = $obj->getvalfield("college_setting","college_name","1=1");
$bithday = date('m-d');

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
            <div class="widgetcontent  shadowed nopadding">
                  <?php
				//  if($fromdate !='--' && $todate !='--' && $regid !='')
				//  {
				  ?>
                    
                  <!--   <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_birthdaylist.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>   --> 

                   <!--  student birthday  -->         
                    <h4 class="widgettitle"><?php echo "Student Birthday"; ?> List</h4>
                    
                    <table width="98%" class="table table-bordered">
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
                            <th class="head0 nosort">S.No.</th>
                            <th class="head0">Name</th>
                            <th class="head0">Father Name</th>
                            <th class="head0">Gender</th>
                            <th class="head0">DOB</th>
                            <th class="head0">Mobile </th>
                            <th class="head0">Address</th>
                            <th style="text-align: center;" class="head0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                           
                               <?php
									$slno=1;
                  $res = $obj->executequery("select * from m_student_reg where DATE_FORMAT(dob,'%m-%d') = '$bithday'");
                  foreach($res as $row_get)
                   {
                    $stu_name = $row_get['stu_name'];
										$message = " Dear $stu_name , May your Birthday be the start of a year filled with good luck, good health and much happiness. From $college_name " ;
									   ?>       
                      <tr>
                                    
                            <td><?php echo $slno++; ?></td>
                            <td><?php echo $row_get['stu_name']; ?></td>
                            <td><?php echo $row_get['father_name']; ?></td>
                            <td><?php echo $row_get['gender']; ?></td> 
                            <td><?php echo $obj->dateformatindia($row_get['dob']); ?></td>  
                            <td><?php echo $row_get['mobile']; ?></td>
                            <td><?php echo $row_get['address']; ?></td>
                            <td class="center"><button type="button"  class="btn btn-primary" onClick="sendsmsfun('<?php echo $row_get['stu_name']; ?>','<?php echo $row_get['mobile']; ?>','<?php echo $message; ?>');" >SendSMS</button></td>
                            
               				 </tr>
                        <?php
						}
						?>
                     </tbody>
                </table>
              </div>
                <br>
                <!-- employee birthday -->
                
                 <div class="widgetcontent  shadowed nopadding">
                     <h4 class="widgettitle"><?php echo "Employee Birthday"; ?> List</h4>
                     
                    <table width="98%" class="table table-bordered">

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
                            <th class="head0 nosort">S.No.</th>
                            <th class="head0">Employee Name</th>
                            <th class="head0">Post</th>
                            <th class="head0">DOB</th>
                            <th class="head0">Mobile </th>
                            <th class="head0">Address</th>
                            <th style="text-align: center;" class="head0">Action</th>
                        </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="odd"></tr>
                           
                  <?php
                  $slno=1;
                  $res = $obj->executequery("select * from m_employee where DATE_FORMAT(dob,'%m-%d') = '$bithday'");
                  foreach($res as $row_get)
                   {
                    $emp_name = $row_get['emp_name'];
                    $message_emp = " Dear $emp_name , May your Birthday be the start of a year filled with good luck, good health and much happiness. From $college_name " ;
                     ?>       
                      <tr>
                                    
                            <td><?php echo $slno++; ?></td>
                            <td><?php echo $row_get['emp_name']; ?></td>
                            <td><?php echo $row_get['post']; ?></td>
                          <!--   <td><?php echo $row_get['gender']; ?></td>  -->
                            <td><?php echo $obj->dateformatindia($row_get['dob']); ?></td>  
                            <td><?php echo $row_get['mobile']; ?></td>
                            <td><?php echo $row_get['address']; ?></td>
                            <td class="center"><button type="button"  class="btn btn-primary" onClick="sendsmsfunemp('<?php echo $row_get['emp_name']; ?>','<?php echo $row_get['mobile']; ?>','<?php echo $message_emp; ?>');" >SendSMS</button></td>
                            
                       </tr>
                        <?php
            }
            ?>
                     </tbody>
                </table>
              
              <!-- </div> -->
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
<div class="modal fade" id="myModal1" role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>Send Birthday Wishes</h4>
                    </div>
                        <div class="modal-body">
					<table class="table table-bordered table-condensed alert-info">
                     <tr style="font-weight:bold;">
                     	<td>
                        Student Name &nbsp;&nbsp;<span class='validation' style='color:red;margin-bottom: 20px;' id="dup"></span><br>
                        <input type="text" name="stu_name" id="stud_name" style="width:95%" readonly> </td>  
                    </tr>
                    <tr>
                    	<td>Mobile No. &nbsp;&nbsp;<span class='validation' style='color:red;margin-bottom: 20px;' id="dup"></span><br>
                        <input type="text" name="mobile" id="stud_mobile"  style="width:95%"> 
                        </td>
                   </tr>
                   <tr>
                   		<td>
                   		Message &nbsp;&nbsp;<span class='validation' style='color:red;margin-bottom: 20px;' id="dup"></span><br>
                   		<textarea rows="05" id="message" style="width:95%" ></textarea> </td>
                  </tr>
                  <tr>
                   	<td >
                   <!--  <img src="images/loadingimage.gif" alt="" id="smsloader"> -->
                   	<input type="submit" class="btn btn-success" id="sendsms" value="SEND SMS" onClick="send_sms_ajax_fun();">
                    <button data-dismiss="modal" class="btn btn-danger" id="smscancel" class="btn">Close</button>
                    </td> 
                  </tr>
                </table>
                    <br>
                   </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
</div>
<!-- employee model -->
<div class="modal fade" id="myModal2" role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>Send Birthday Wishes</h4>
                    </div>
                        <div class="modal-body">
          <table class="table table-bordered table-condensed alert-info">
                     <tr style="font-weight:bold;">
                      <td>
                        Employee Name &nbsp;&nbsp;<span class='validation' style='color:red;margin-bottom: 20px;' id="dup"></span><br>
                        <input type="text" name="emp_name" id="emp_name" style="width:95%" readonly> </td>  
                    </tr>
                    <tr>
                      <td>Mobile No. &nbsp;&nbsp;<span class='validation' style='color:red;margin-bottom: 20px;' id="dup"></span><br>
                        <input type="text" name="mobile" id="mobile"  style="width:95%"> 
                        </td>
                   </tr>
                   <tr>
                      <td>
                      Message &nbsp;&nbsp;<span class='validation' style='color:red;margin-bottom: 20px;' id="dup"></span><br>
                      <textarea rows="05" id="message_emp" style="width:95%" ></textarea> </td>
                  </tr>
                  <tr>
                    <td >
                   <!--  <img src="images/loadingimage.gif" alt="" id="smsloader"> -->
                    <input type="submit" class="btn btn-success" id="sendsms" value="SEND SMS" onClick="send_sms_ajax_funemp();">
                    <button data-dismiss="modal" class="btn btn-danger" id="smscancel" class="btn">Close</button>
                    </td> 
                  </tr>
                </table>
                    <br>
                   </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
</div>
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
			  url: 'ajax/delete_student.php',
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close
	
	
	jQuery(function() {
                //Datemask dd/mm/yyyy
                jQuery("#fromdate").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
				  jQuery("#todate").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
                               
                //Money Euro
                jQuery("[data-mask]").inputmask();
 });

function sendsmsfun(stu_name,mobile,message)
{
	jQuery("#myModal1").modal('show');
	jQuery("#stud_name").val(stu_name);
	jQuery("#stud_mobile").val(mobile);
	jQuery("#message").val(message);
	jQuery("#smsloader").hide();
}

function sendsmsfunemp(emp_name,mobile,message_emp)
{
  jQuery("#myModal2").modal('show');
  jQuery("#emp_name").val(emp_name);
  jQuery("#mobile").val(mobile);
  jQuery("#message_emp").val(message_emp);
  jQuery("#smsloader").hide();
}

function send_sms_ajax_fun()
{
	//jQuery("#myModal1").modal('show');	
	stu_name = jQuery("#stud_name").val();
	mobile = jQuery("#stud_mobile").val();
	message = jQuery("#message").val();
	//jQuery("#myModal1").modal('hide');	
	jQuery("#sendsms").hide();
	jQuery("#smscancel").hide();
	jQuery("#smsloader").show();
	
	if(mobile!="" && stu_name!="" && message!="")
	{
		jQuery.ajax({
			  type: 'POST',
			  url: 'ajax_send_msg.php',
			  data: 'stu_name='+stu_name+'&mobile='+mobile+'&message='+message,
			  dataType: 'html',
			  success: function(data){
			  if(data == 1)
			  {
				alert("Msg Sent Successfully...");
				jQuery("#smsloader").hide();
				jQuery("#sendsms").show();
				jQuery("#smscancel").show();
			  }
				  
			}
				
	   });//ajax close
	}
	//jQuery("#reg_id").val(regid);
}  

function send_sms_ajax_funemp()
{
  //jQuery("#myModal1").modal('show');  
  emp_name = jQuery("#emp_name").val();
  mobile = jQuery("#mobile").val();
  message = jQuery("#message_emp").val();
  //jQuery("#myModal1").modal('hide');  
  jQuery("#sendsms").hide();
  jQuery("#smscancel").hide();
  jQuery("#smsloader").show();
  
  if(mobile!="" && emp_name!="" && message!="")
  {
    jQuery.ajax({
        type: 'POST',
        url: 'ajax_send_msgemp.php',
        data: 'emp_name='+emp_name+'&mobile='+mobile+'&message='+message,
        dataType: 'html',
        success: function(data){
        if(data == 1)
        {
        alert("Msg Sent Successfully...");
        jQuery("#smsloader").hide();
        jQuery("#sendsms").show();
        jQuery("#smscancel").show();
        }
          
      }
        
     });//ajax close
  }
  //jQuery("#reg_id").val(regid);
}  
</script>
</body>

</html>
