<?php include("../adminsession.php");

$pagename = "counselor_master.php";
$module = "Counselor Master";
$submodule = "COUNSELOR MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "counselor_master";
$tblpkey = "con_id";
if(isset($_GET['con_id']))
$keyvalue = $_GET['con_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$counselor_name = "";
$counselor_contact = "";
$counselor_mobile = "";
$counselor_address = "";


//$company_id= $_SESSION['company_id'];

if(isset($_POST['submit']))
{	
	//print_r($_POST); die;
    $counselor_name = $obj->test_input($_POST['counselor_name']);
  	$counselor_contact = $obj->test_input($_POST['counselor_contact']);
    $counselor_mobile = $obj->test_input($_POST['counselor_mobile']);
    $counselor_address = $obj->test_input($_POST['counselor_address']);
   
    //check Duplicate
    $cwhere = array("counselor_name"=>$_POST['counselor_name']);
    $count = $obj->count_method("counselor_master",$cwhere);
    //print_r($count);
     if ($count > 0 && $keyvalue == 0) 
     { 
        $dup="<div class='alert alert-danger'>
        <strong>Error!</strong> Duplicate Record.
          </div>";
    //         //echo $dup; die;
     } 
           else //insert
            {  
                if($keyvalue == 0)
              {   
				$form_data = array('counselor_name'=>$counselor_name,'counselor_mobile'=>$counselor_mobile,'counselor_contact'=>$counselor_contact,'counselor_address'=>$counselor_address,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
				$obj->insert_record($tblname,$form_data); 
	   //print_r($form_data); die;
				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
			   else{
				//update
				$form_data = array('counselor_name'=>$counselor_name,'counselor_mobile'=>$counselor_mobile,'counselor_contact'=>$counselor_contact,'counselor_address'=>$counselor_address,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid);
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
  $counselor_name =  $sqledit['counselor_name'];
  $counselor_contact =  $sqledit['counselor_contact'];
  $counselor_mobile =  $sqledit['counselor_mobile'];
	$counselor_address =  $sqledit['counselor_address'];
    
}


?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
    function Numberin(input)
    {
     var num = /[^0-9]/g;
     input.value=input.value.replace(num,"");
    }
  </script>
<?php include("inc/top_files.php"); ?>
</head>
<body onLoad="getrecord('<?php echo $keyvalue; ?>');">
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
                <div class="stepContainer">
                  <div class="content">
                    <form class="stdform stdform2" method="post" action="">
                    <?php echo  $dup;  ?>
                            <p>
                                <label>Counselor Name <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="counselor_name" placeholder='Enter counselor name' value="<?php echo $counselor_name; ?>"  id="counselor_name" autocomplete="off" class="input-xxlarge" autofocus/></span>
                            </p>
                            <p>
                                <label>Counselor Mobile 1 <span class="text-error"></span></label>
                                <span class="field"><input type="text" name="counselor_contact" placeholder='Enter contact' value="<?php echo $counselor_contact; ?>" maxlength="10"  id="counselor_contact" onkeyup="Numberin(this);" autocomplete="off" class="input-xxlarge" autofocus/></span>
                            </p> 
                            <p>
                                <label>Counselor Mobile 2 <span class="text-error"></span></label>
                                <span class="field"><input type="text" name="counselor_mobile" placeholder='Enter contact' value="<?php echo $counselor_mobile; ?>" maxlength="10"  id="counselor_mobile" onkeyup="Numberin(this);" autocomplete="off" class="input-xxlarge" autofocus/></span>
                            </p>
                            
                            <p>
                                <label>Counselor Address <span class="text-error"></span></label>
                                <span class="field"><input type="text" name="counselor_address" placeholder='Enter Address' value="<?php echo $counselor_address; ?>"  id="counselor_address" autocomplete="off" class="input-xxlarge" autofocus/></span>
                            </p>
                            
                            <center> <p class="stdformbutton">
                            <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('counselor_name');" />
                            <?php echo $btn_name; ?></button>
                            <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                            <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>

                             
                        </form>
                    </div>
                </div>
          
                      
                   <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_class_master.php" class="btn btn-info" target="_blank">
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
                            <th class="head0 nosort">S.No.</th>
                            <th class="head0">Counselor Name</th>  
                            <th class="head0">Mobile No. 1</th>  
                            <th class="head0">Mobile No. 2</th>  
                            <th class="head0">Address</th>   
                            <th class="head0">Edit</th>
                            <th class="head0">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                        <?php
                        $slno=1;

                        $res = $obj->executequery("select * from counselor_master order by con_id desc");

                        foreach($res as $row_get)
                        {
                           
                        ?> 
                        <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $row_get['counselor_name']; ?></td>
                        <td><?php echo $row_get['counselor_contact']; ?></td> 
                        <td><?php echo $row_get['counselor_mobile']; ?></td> 
                        <td><?php echo $row_get['counselor_address']; ?></td>
                        <td><a class='icon-edit' title="Edit" href='counselor_master.php?con_id=<?php echo $row_get['con_id'] ; ?>'></a></td>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['con_id']; ?>);' style='cursor:pointer'></a>
                        </td>
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="settingModal" >
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">Paper Setting</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <!-- <form action="" method="post" id="settinginfo">
            
            </form> -->
            <table>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            </div>
            <div class="modal-footer">
               <!-- <input type="hidden" id="pcustomer_id"> -->
               <button class="btn btn-primary" name="s_save" id="s_save" >Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
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

    //for date mask
 jQuery('#appointment_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
 jQuery('#appointment_date').focus();

function papersetting(customer_name,customer_id)
{

   // alert(customer_id);
    jQuery.ajax({
    type: 'POST',
    url: 'show_papersetting.php',
    data: 'customer_name='+customer_name+'&customer_id='+customer_id,
    dataType: 'html',
    success: function(data){
    //alert(data);

    jQuery("#settinginfo").val(data);
    jQuery("#settingModal").modal('show');
    //location.reload();
     }

    });//ajax close

  jQuery('#settingModal').modal('show');
  jQuery('#pcustomer_name').val(customer_name);
  jQuery('#pcustomer_id').val(customer_id);
   
}

function save_papersetting_data()
{
    //alert('hii');
  //  var newspaper_id = document.getElementById('newspaper_id').value;
    var customer_id = document.getElementById('pcustomer_id').value;
    
  //  alert(newspaper_id);
    alert(customer_id);
     jQuery.ajax({
        type: 'POST',
        url: 'save_papersetting.php',
        data: 'newspaper_id='+newspaper_id+'&customer_id='+customer_id,
        dataType: 'html',
        success: function(data){
                  alert(data);

        jQuery("#newspaper_id").val('');
        jQuery("#pcustomer_id").val('');
        jQuery("#settingModal").modal('hide');
        //location.reload();
                 }

             });//ajax close

}

function abc(sn)   
{
        var newspaper_id = document.getElementById('newspaper_id'+sn).value;
        //alert(newspaper_id);

}
function changetab(pagename)
  {
    //alert('hi');
    location = pagename;
  }

  </script>
</body>
</html>
