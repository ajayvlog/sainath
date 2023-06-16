<?php include("../adminsession.php");
$pagename = "cbwtf_registration.php";
$tblname = "cbwtf_register";
$tblpkey = "cbwtf_id";
$module = "AddCBMWTF";
$submodule = "CBMWTF";
$heading = "Add CBMWTF";
//$cbwtf_id="";
$btn_name = "Save";  
$imgpath = "uploaded/cbmwtfpic/";

if(isset($_GET['cbwtf_id']))
$keyvalue = $_GET['cbwtf_id'];
else
$keyvalue = 0;

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

//echo "$imgpath";  die;
if(isset($_POST['submit']))
{
  //print_r($_POST);die;
	$keyvalue = test_input($_POST['cbwtf_id']);
 	$cbwtf_name = test_input($_POST['cbwtf_name']);
	$cbwtf_address = test_input($_POST['cbwtf_address']);
	$cbwtf_contact = test_input($_POST['cbwtf_contact']);
	$cbwtf_mail = test_input($_POST['cbwtf_mail']);
	$latitude = test_input($_POST['latitude']);
	$longitude = test_input($_POST['longitude']);
	$c_owner = test_input($_POST['c_owner']);
	$c_address = test_input($_POST['c_address']);
	$c_contact = test_input($_POST['c_contact']);
	$coveredarea = test_input($_POST['coveredarea']);
	$c_remarks = test_input($_POST['c_remarks']);
    $villageid = test_input($_POST['villageid']);

  $c_khasrano = test_input($_POST['c_khasrano']);
  $c_halkano = test_input($_POST['c_halkano']);
  $c_pin = test_input($_POST['c_pin']);
  $c_covereddis = test_input($_POST['c_covereddis']);
	
	$filename = $_FILES['imgname']['name'];
	$filesize = $_FILES['imgname']['size'];
	$filetmpe = $_FILES['imgname']['tmp_name'];
	$filetype = $_FILES['imgname']['type'];
	
	if($keyvalue==0)
	{
 		if($_FILES['imgname']['tmp_name'] !='')
		{
	  		$file_ext=strtolower(end(explode('.',$_FILES['imgname']['name']))); //to separate extension from file
     		$expensions= array("jpeg","jpg","png","gif");
		
			if(in_array($file_ext,$expensions)=== false){
			$errors="extension not allowed, please choose a JPEG or PNG file.";
		}				
		else
		{	
				$filename =  "REG".time().".".$file_ext;
				move_uploaded_file($filetmpe,$imgpath.$filename);
		}
	}
	$cbwtf_code = $cmn->getcbwfreg("cbwtf_register","cbwtf_code","1=1");
	mysql_query("insert into cbwtf_register set cbwtf_code='$cbwtf_code',cbwtf_name='$cbwtf_name',cbwtf_address='$cbwtf_address',cbwtf_contact='$cbwtf_contact',cbwtf_mail='$cbwtf_mail',latitude='$latitude',longitude='$longitude',c_owner='$c_owner',c_address='$c_address',c_contact='$c_contact',c_remarks='$c_remarks',imgname='$filename',cbwtf_date='$cbwtf_date',coveredarea='$coveredarea',createdby='$loginuser_id',ipaddress='$ipaddress',createdate='$create_date',sessionid='$sessionid',villageid='$villageid',c_khasrano='$c_khasrano',c_halkano='$c_halkano',c_pin='$c_pin',c_covereddis='$c_covereddis'");	
		
	$action = 1;
	echo "<script>location='$pagename?action=$action'</script>";
	}
	else
	{
		mysql_query("update cbwtf_register set cbwtf_name='$cbwtf_name',cbwtf_address='$cbwtf_address',cbwtf_contact='$cbwtf_contact',cbwtf_mail='$cbwtf_mail',latitude='$latitude',longitude='$longitude',c_owner='$c_owner',c_address='$c_address',c_contact='$c_contact',c_remarks='$c_remarks',cbwtf_date='$cbwtf_date',coveredarea='$coveredarea',createdby='$loginuser_id',ipaddress='$ipaddress',createdate='$create_date',sessionid='$sessionid',villageid='$villageid',c_khasrano='$c_khasrano',c_halkano='$c_halkano',c_pin='$c_pin',c_covereddis='$c_covereddis' where cbwtf_id='$keyvalue'");
		
				
		if($_FILES['imgname']['tmp_name'] !='')
		{
			$file_ext=strtolower(end(explode('.',$_FILES['imgname']['name']))); //to separate extension from file			
			$expensions= array("jpeg","jpg","png","gif");
			
			if(in_array($file_ext,$expensions)=== false)
			{
			$errors="extension not allowed, please choose a JPEG or PNG file.";
			}			
			 else
			  {	
	  
	  		 $file_name =  "REG".time().".".$file_ext;
			move_uploaded_file($filetmpe,$imgpath.$file_name); 
		//	echo  "select imgname from cbwtf_register where cbwtf_id ='$keyvalue'";
			$sql = mysql_query("select imgname from cbwtf_register where cbwtf_id ='$keyvalue'");
			$row=mysql_fetch_assoc($sql);
			$oldimage=$row['imgname']; 

				  if(file_exists("uploaded/cbmwtfpic/".$oldimage))
		   unlink("uploaded/cbmwtfpic/".$oldimage); 
		   
	//	echo "update cbwtf_register set imgname='$file_name' where cbwtf_id='$keyvalue'";die;
		   mysql_query("update cbwtf_register set imgname='$file_name' where cbwtf_id='$keyvalue'");
	 
 			  }	
		}
		$action = 2;
	
echo "<script>location='$pagename?action=$action'</script>";
}
}
if($keyvalue != '0')
{
	 $btn_name = "Update";
	//echo "SELECT * from $tblname where $tblpkey = $keyvalue";die;
  $sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
  $rowedit = mysql_fetch_array(mysql_query($sqledit));
  $cbwtf_code =  "BMW".$rowedit['cbwtf_code'];
  $cbwtf_name_a =  $rowedit['cbwtf_name'];
  $cbwtf_address = $rowedit['cbwtf_address'];
  $cbwtf_contact = $rowedit['cbwtf_contact'];
  $cbwtf_mail = $rowedit['cbwtf_mail'];
  $latitude = $rowedit['latitude'];
  $longitude = $rowedit['longitude'];
  $imgname = $rowedit['imgname'];
  $c_owner = $rowedit['c_owner'];
  $c_address = $rowedit['c_address'];
  $c_contact = $rowedit['c_contact'];
  $coveredarea = $rowedit['coveredarea'];
  $c_remarks = $rowedit['c_remarks'];
  $villageid = $rowedit['villageid'];
  $tahsilid = $cmn->getvalfield("village_master","tahsilid","villageid='$villageid'");
  $distid = $cmn->getvalfield("tahsil_master","distid","tahsilid='$tahsilid'");

  $c_khasrano = $rowedit['c_khasrano'];
  $c_halkano = $rowedit['c_halkano'];
  $c_pin = $rowedit['c_pin'];
  $c_covereddis = $rowedit['c_covereddis'];
  }
  
  else
  {
	  $cbwtf_date=date('d-m-Y');
	 // $cbwtf_code = "BMW".$cmn->getcbwfreg("cbwtf_register","cbwtf_code","1=1");
  }

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php  include("inc/top_files.php"); ?>


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
                <div class="widgetcontent" >
                    <!-- START OF TABBED WIZARD -->
                    <form class="stdform" method="post" enctype="multipart/form-data">
                    <div id="wizard2" class="wizard tabbedwizard">
                        <?php include("inc/tabmenu.php");?>                       
                        <div>
                        	<h4>Step 1: CBMWTF Registration</h4>
                            
                         <table class="table table-bordered table-condensed">
                    <tr style="font-weight:bold;">
                     
                     <td width="25%">CBWTF Name <span style="color:red">&nbsp;*</span></td> 
                     	<td width="25%">CBWTF Address <span style="color:red">&nbsp;*</span></td>  
                        <td width="25%">CBWTF Contact No <span style="color:red">&nbsp;*</span></td>
                        <td width="23%">CBWTF Email ID</td>            
                      </tr>
                    
                   <tr>
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="cbwtf_name" id="cbwtf_name" style="width:90%;" value="<?php echo $cbwtf_name_a; ?>" placeholder='CBMWTF Name'></td>    
                        
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="cbwtf_address" id="cbwtf_address" style="width:90%;" value="<?php echo $cbwtf_address; ?>" placeholder='CBMWTF Address'>
                        </td>
                        
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="cbwtf_contact" id="cbwtf_contact" maxlength="10" style="width:90%;" value="<?php echo $cbwtf_contact; ?>" placeholder='CBMWTF Contact No.'>
                        </td>
                        
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="email" name="cbwtf_mail" id="cbwtf_mail" style="width:90%;" value="<?php echo $cbwtf_mail; ?>" placeholder='CBMWTF Mail'>
                        </td>  
                 </tr>
                           
                 <tr style="font-weight:bold;">
                       <td>Latitude </td> 
                        <td>Longitude</td> 
                        <td>Owner Name </td>  
                        <td>Owner Address</td>
                 </tr>
                     
                 <tr>
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="latitude" id="latitude" value="<?php echo $latitude; ?>" placeholder='Latitude' style="width:90%;" >
                        </td>
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="longitude" id="longitude" value="<?php echo $longitude; ?>" placeholder='Longitude' style="width:90%;" >
                        </td>
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="c_owner" id="c_owner" value="<?php echo $c_owner; ?>" placeholder='Owner Name' style="width:90%;" >
                        </td>
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="c_address" id="c_address" value="<?php echo $c_address; ?>" placeholder='Owner Address' style="width:90%;" >
                        </td>  
                  </tr>
                         
                         
                 <tr style="font-weight:bold;">
                        
                        <td>Owner Contact NO.</td>   
                        <td>Land Area (hectares)</td> 
                        <td>Remarks</td> 
                        <td>Building Photo </td>  
                        <td></td>
                </tr>
                      
                 <tr>
                         
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="c_contact" id="c_contact" maxlength="10" value="<?php echo $c_contact; ?>" placeholder='Owner Contact No.' style="width:90%;" >
                        </td>
                        
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="coveredarea" id="coveredarea" value="<?php echo $coveredarea; ?>" placeholder='Covered Area' style="width:90%;" >
                        </td> 
                        
                        <td>
                        <input class="form-control input-mini" autocomplete="off" type="text" name="c_remarks" id="c_remarks" value="<?php echo $c_remarks; ?>" placeholder='Remarks' style="width:90%;" >
                        </td>   
                        <td>
                        <input type="file" name="imgname" accept="image/*"><img id="blah" alt="" height='50px;' width="50px;" title='Text Image' src='<?php if($imgname!="" && file_exists("uploaded/cbmwtfpic/".$imgname))
                        {
                        echo "uploaded/cbmwtfpic/".$imgname; }?>'/>                        
                        </td>
                        <td></td>
                       </tr>

                       <tr>
                         <th>District<span style="color:red">&nbsp;*</span></th>
                         <th>Tehsil<span style="color:red">&nbsp;*</span></th>
                         <th>Village<span style="color:red">&nbsp;*</span></th>
                         <th>Khasra No<span style="color:red">&nbsp;*</span></th>
                       </tr>
                        
                       <tr>
                          <td>
                            <select name="distid" id="distid" style="width:180px;" class="chzn-select" onChange="get_combo(this.value,'tahsilid');">
                                <option value="">--Select--</option>
                                <?php
	                               $sql = mysql_query("select * from district_master");
	                               while($row = mysql_fetch_array($sql))
	                               {
	                               ?>
	                                            <option value="<?php echo $row['distid']; ?>"><?php echo $row['districtname']; ?></option>
	                                            <?php
	                               }
                               ?>
                            </select>
                            <script type="text/javascript">
                             	document.getElementById('distid').value = '<?php echo $distid; ?>';
                             </script>
                          </td> 

                          <td>
                          <select name="tahsilid" id="tahsilid" class="chzn-select" style="width:180px;" onChange="get_combo(this.value,'villageid');">
                          	<option value="">--Select--</option>
                               <?php 
                               if($tahsilid > 0)
                               { 
	                               $sql = mysql_query("select * from tahsil_master where tahsilid='$tahsilid'");
	                               while($row = mysql_fetch_array($sql))
	                               {
	                               ?>
	                                            <option value="<?php echo $row['tahsilid']; ?>"><?php echo $row['tahsilname']; ?></option>
	                                            <?php
	                               }
	                           }//if close
                               ?>
                             </select>
                             <script type="text/javascript">
                             	document.getElementById('tahsilid').value = '<?php echo $tahsilid; ?>';
                             </script>
                          </td> 

                          <td>
                           <select name="villageid" id="villageid" class="chzn-select" style="width:180px;">
                           	<option value="">--Select--</option>
                               <?php
                               if($villageid > 0)
                               { 
	                               $sql = mysql_query("select * from village_master where villageid='$villageid'");
	                               while($row = mysql_fetch_array($sql))
	                               {
	                               ?>
	                                            <option value="<?php echo $row['villageid']; ?>"><?php echo $row['villagename']; ?></option>
	                                            <?php
	                               }
	                           }//if close
                               ?>
                           </select>
                           
                             <script type="text/javascript">
                             	document.getElementById('villageid').value = '<?php echo $villageid; ?>';
                             </script>
                          </td> 

                          <td>
                          <input class="form-control input-mini" autocomplete="off" type="text" name="c_khasrano" id="c_khasrano" value="<?php echo $c_khasrano; ?>" placeholder='Khasra No' style="width:90%;" >
                          </td> 
                       </tr>

                       <tr>
                          
                          <th>Halka No<span style="color:red">&nbsp;*</span></th>
                          <th>PIN<span style="color:red">&nbsp;*</span></th>
                          <th>Covered District<span style="color:red">&nbsp;*</span></th>
                          <th></th>
                       </tr>
                       <tr>

                          <td>
                          <input class="form-control input-mini" autocomplete="off" type="text" name="c_halkano" id="c_halkano" value="<?php echo $c_halkano; ?>" placeholder='Halka No' style="width:90%;" >
                          </td> 

                          <td>
                          <input class="form-control input-mini" autocomplete="off" type="text" name="c_pin" id="c_pin" value="<?php echo $c_pin; ?>" placeholder='Pin' style="width:90%;" >
                          </td> 

                          <td>
                          <input class="form-control input-mini" autocomplete="off" type="text" name="c_covereddis" id="c_covereddis" value="<?php echo $c_covereddis; ?>" placeholder='Covered District' style="width:90%;" >
                          </td> 
                          <td></td>
                       </tr>


                        <tr>
                        <td colspan="4"><input type="submit" class="btn btn-primary" onClick="return checkinputmaster('cbwtf_name,cbwtf_address,cbwtf_contact nu,distid,tahsilid,villageid,c_khasrano,c_halkano,c_pin,c_covereddis');" name="submit" id="submit" value="Save" style="width:15%;">
                        <a href="cbwtf_registration.php"  name="reset" id="reset" class="btn btn-success" style="width:10%;">Reset</a></td>
                        </tr> <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                    </table>
                          
                           
                        </div><!--#wiz1step2_1-->
                    </div><!--#wizard-->
                     <div class="row-fluid">
                        <div class="span12">
                            <h4 class="widgettitle nomargin"> <span style="color:#00F;" >  Registration Details : 
                            </span></h4>
                        
                            <div class="row-fluid" id="showrecord">
                               <table width="96%" class="table table-bordered table-condensed">
            <thead>
                <tr>
                 <th width="4%" class="center">SNo</th> 
                 <th width="7%" class="center">CBWTFCode </th> 
                    <th width="6%" class="center">Name </th> 
                     	<th width="7%" class="center">Addr </th>  
                        <th width="7%" class="center">ContactNo</th>
                        <th width="8%" class="center"> Email</th> 
                         <th width="6%" class="center"> Lat.</th>   
                         <th width="8%" class="center"> Long .</th> 
                     	<th width="9%" class="center"> OwnerName </th>  
                        <th width="7%" class="center">OwnerAdd</th>
                        <!--<th width="7%" class="center">LandArea</th>-->
						<!-- <th width="7%" class="center">Remarks</th>-->
                        <th width="10%" class="center">BuildingPhoto</th>                                                             
                    <th width="14%" class="center">Action </th>
                </tr>
            </thead>
            <tbody>
            <?php
			$slno=1;
			$sql = mysql_query("select * from cbwtf_register");
			while($rowget=mysql_fetch_assoc($sql))
			{
				
														?>
                                            <tr>
                                            	<td><?php echo $slno++; ?></td>
                                             <td><a href="cbwtkeyperson.php?cbwtf_id=<?php echo $rowget['cbwtf_id'];?>"><?php echo "BMW".$rowget['cbwtf_code']; ?></a></td>
                                                <td><?php echo $rowget['cbwtf_name']; ?></td>
                                                 <td><?php echo $rowget['cbwtf_address']; ?></td>
                                                  <td><?php echo $rowget['cbwtf_contact']; ?></td>
                                                   <td><?php echo $rowget['cbwtf_mail']; ?></td>
                                                    <td><?php echo $rowget['latitude']; ?></td>
                                                      <td><?php echo $rowget['longitude']; ?></td>
                                                     <td><?php echo $rowget['c_owner']; ?></td>
                                                      <td><?php echo $rowget['c_address']; ?></td>
                                                      <!--<td><?php echo $rowget['coveredarea']; ?></td>-->
<!--  														<td><?php echo $rowget['c_remarks']; ?></td>
-->                                                       <td>
            <?php 
			if($rowget['imgname']!="")
			$image_name_path = "uploaded/cbmwtfpic/$rowget[imgname]"; 
			else
			$image_name_path = "uploaded/no-image-available.png"; 
			?>
				<img src="<?php echo $image_name_path; ?>"  height="50" width="50">
                </td>
                                              
                                                <td class="center">
                                                  <a class="icon-edit"  href='cbwtf_registration.php?cbwtf_id=<?php echo $rowget['cbwtf_id']; ?>'><span class="icon-edit"></span></a>&nbsp; 
                                                  <a class='icon-remove'  title="Delete" onclick='funDel(<?php echo  $rowget['cbwtf_id'] ; ?>);' style='cursor:pointer'>X</a></td>
                                            </tr>
                                            <?php }?>
                                       
                                        </tbody>
                                    </table> 
                            </div><!--widgetcontent-->
                     </div>
                 
                </div>
                    </form>
                                        
                    <!-- END OF TABBED WIZARD -->
                    
                </div><!--widgetcontent-->
                
        
            </div><!--contentinner-->
        </div><!--maincontent-->
        
    </div>
   
  
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
<div class="modal fade" id="myModal1" role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Product</h4>
                    </div>
                        <div class="modal-body">
                                <table class="table table-bordered table-condensed">
                                
                                <tr>
                                <th width="18%">CBMWTF Name &nbsp;<span style="color:#F00;">*</span></th>
                                <th width="18%">Key person Name &nbsp;<span style="color:#F00;">*</span><                                          
                                </tr>                                       
                                <tr>
                                <td>                                           
                                <input class="form-control" name="k_cbwt_name" id="k_cbwt_name" value="" autofocus="" type="text" readonly>
                                <input type="hidden" name="k_cbmwt_id" id="k_cbmwt_id" >                              
                                </td>
                                <td>                                           
                                <input class="form-control" name="k_kper_name" id="k_kper_name"  value="" autocomplete="off" autofocus="" type="text" >
                                </td>
                                </tr>
                                <tr>
                                <th width="18%">Designation &nbsp;<span style="color:#F00;">*</span></th>
                                <th width="18%">Contact No.&nbsp;<span style="color:#F00;">*</span></th>                                           
                                </tr>                                       
                                <tr>
                                <td>                                           
                                <input class="form-control" name="k_desig_name" id="k_desig_name" value="" autofocus="" type="text" autocomplete="off" readonly>
                                 <input type="hidden" name="k_desig_id" id="k_desig_id" >  
                                </td>
                                <td>                                           
                                <input class="form-control" name="kper_contactno" id="kper_contactno"  value="" autocomplete="off" autofocus="" type="text" >
                                </td>
                                </tr>
                                </table>
                        </div>
                        <div class="modal-footer clearfix">
                        <input type="hidden" id="k_keyper_id" value="0" >
                         <input type="submit" class="btn btn-primary" name="submit" value="Add" onClick="updatelist();" id="saveitem" >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
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
		imgpath = '<?php echo $imgpath; ?>';
		 //alert(module); 
		if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_image_master.php',
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module+'&imgpath='+imgpath,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close


jQuery('#prevbal_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});

  </script>
  
<script type="text/javascript">
	jQuery(document).ready(function(){
		// Smart Wizard 	
  		jQuery('#wizard').smartWizard({onFinish: onFinishCallback});
      	jQuery('#wizard2').smartWizard({onFinish: onFinishCallback});
		jQuery('#wizard3').smartWizard({onFinish: onFinishCallback});
		jQuery('#wizard4').smartWizard({onFinish: onFinishCallback});
		function onFinishCallback(){
			alert('Finish Clicked');
		} 
		
		jQuery(".inline").colorbox({inline:true, width: '60%', height: '500px'});
		jQuery('select, input:checkbox').uniform();
	});
	
	
	function changetab(pagename)
	{
		//alert('hi');
		location = pagename;
	}
	
	
function getrecord(keyvalue,table_id){
      var suppartyid = jQuery("#suppartyid").val();
		  jQuery.ajax({
		  type: 'POST',
		  url: 'show_keyrecord.php',
		  data: "suppartyid="+suppartyid+'&saleid='+keyvalue+'&table_id='+table_id,
		  dataType: 'html',
		  success: function(data){				  
			//alert(data);
				jQuery('#showrecord').html(data);					
				setTotalrate();
				
			}
		  });//ajax close
}	


function get_combo(value,get_combo_for){
   // alert(get_combo_for);
      jQuery.ajax({
      type: 'POST',
      url: 'ajax_get_combo.php',
      data: "value="+value+'&get_combo_for='+get_combo_for,
      dataType: 'html',
      success: function(data){          
     // alert(data);
      get_combo_for = '#'+get_combo_for;
      jQuery(get_combo_for).html(data);
      jQuery(get_combo_for).trigger("liszt:updated"); 
         
      //jQuery("#customer_id").val('').trigger("liszt:updated");      
        //setTotalrate();
      }
      });//ajax close
} 



function getCbwwfId(cbwtf_id)
{
	location = 'cbwtf_registration.php?cbwtf_id='+cbwtf_id
}
</script>

<?php
if($keyvalue > 0)
{ 
?>
    <script type="text/javascript">
      //get_combo(<?php echo $distid; ?>,'tahsilid');
      //jQuery('distid').trigger("liszt:updated"); 
      //get_combo(<?php echo $tahsilid; ?>,'villageid');
      //jQuery('villageid').trigger("liszt:updated"); 

      //jQuery('#distid').val('<?php echo $distid; ?>').trigger('liszt:updated');
      //document.getElementById('distid').value = '<?php echo $distid; ?>';
      //document.getElementById('tahsilid').value = '<?php echo $tahsilid; ?>';
      //document.getElementById('villageid').value = '<?php echo $villageid; ?>';
    </script>
<?php 
}
?>

</body>

</html>
