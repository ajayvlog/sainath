<?php include("../adminsession.php");
$pagename = "transfer_hostel.php";
$module = "Hostel Transfer";
$submodule = "Hostel TRANSFER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "transfer_hostel";
$tblpkey = "transfer_hostelid";
if(isset($_GET['transfer_hostelid']))
$keyvalue = $_GET['transfer_hostelid'];
else
$keyvalue = 0;

if(isset($_GET['transferid']))
$transferid = $_GET['transferid'];
else
$transferid = 0;

// if(isset($_GET['room_id']))
// $room_id = $_GET['room_id'];
// else
// $room_id = 0;

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

$status = "";
$dup = "";

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                <form class="stdform" method="post">
                  <div id="wizard2" class="wizard tabbedwizard">

                  <?php include("inc/tabmenu.php");?>
                  <div class="stepContainer">
                  <h4>Step 4: Hostel Transfer</h4>
                  <div id="new2">
                  <div class="row-fluid">

                  </div>
                            <br>
                             <!--span8-->
                    <div >
                   <div class="alert alert-success">
                     <table class="table table-bordered table-condensed">
                     <tr style="font-weight:bold;">
                      <td>Student Name </td> 
                      <td>Hostel Report </td> 
                      <td>Session Name</td>
                      <td></td>
                     </tr>
                     <tr>
                        <td>
                        <select name="transferid" id="transferid" style="width:180px;" class="chzn-select" onchange="getid(this.value);">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from class_transfer where sessionid=$sessionid");
                        foreach($res as $row)
                        {
                          $m_student_reg_id = $row['m_student_reg_id'];
                          $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id=$m_student_reg_id");
                          $class_id = $obj->getvalfield("m_student_reg","class_id","m_student_reg_id=$m_student_reg_id");
                          $class_name = $obj->getvalfield("m_class","class_name","class_id=$class_id");
                        ?>
                        <option value="<?php echo $m_student_reg_id; ?>"><?php echo $stu_name." / ".$class_name; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('transferid').value='<?php echo $transferid; ?>'; </script>    
                        </td>
                        <!-- hostel info -->
                       <td>
                         <select name="room_id" id="room_id" class="chzn-select">
                           <option value="">--select--</option>
                           <?php
                           $res = $obj->executequery("select * from m_room where sessionid=$sessionid");
                           foreach ($res as $row)
                            {
                              $hostel_id=$row['hostel_id'];
                              $hostelname=$obj->getvalfield("m_hostel","hostel_name","hostel_id=$hostel_id");
                              $floor_id=$row['floor_id'];
                              $floor_name=$obj->getvalfield("m_floor","floor_name","floor_id=$floor_id");
                              $room_id = $row['room_id'];
                              $room_no=$obj->getvalfield("m_room","room_no","room_id=$room_id");
                            ?>
                            <option value="<?php echo $room_id; ?>"><?php echo $hostelname."/".$floor_name."/".$room_no; ?></option>
                          <?php
                           }
                           ?>
                         </select>
                         <script> document.getElementById('room_id').value='<?php echo $room_id; ?>';</script>
                       </td>

                        <td>
                        <select name="sessionid" id="sessionid" style="width:180px;" class="chzn-select">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from m_session");
                        foreach($res as $row)
                        {
                        ?>
                        <option value="<?php echo $row['sessionid']; ?>"><?php echo $row['session_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('sessionid').value='<?php echo $row['sessionid'];?>'; </script>   
                        </td>   
                            
                          <td>
                           <input type="button" name="add_data_list" id="add_data_list" class="btn btn-primary" onClick="addlist();" value="ADD" style="width:90%;">
                          </td>
                      </tr>
                    </table>
                      </div>
                    </div>
                  <!--span4-->
                  <br>
                     <div class="row-fluid">
                        <div class="span12">
                            <h4 class="widgettitle nomargin"> <span style="color:#00F;" > Key Person Details : 
                            </span></h4>
                        
                            <div class="row-fluid" id="showrecord">
                                
                            </div>
                     </div>
                 
                </div>  
               
                <!--row-fluid-->
                 
                
                </div>
                          
                            
                        </div><!--#wiz1step2_1-->
                        
                      
                    </div><!--#wizard-->
                    </form>
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
  function funDelete(id)
  { 
  // alert(id);   
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
        url: 'ajax/delete_master_reg.php',
        data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
        dataType: 'html',
        success: function(data){
         // alert(data);
            location='<?php echo $pagename."?m_student_reg_id=$m_student_reg_id" ; ?>';
        }
        
        });//ajax close
    }//confirm close
  } //fun close


// jQuery('#admission_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
// jQuery('#dob').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
// jQuery('#admission_date').focus();

jQuery(document).ready(function(){
    // Smart Wizard  
        jQuery('#wizard2').smartWizard({onFinish: onFinishCallback});
   
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

function addlist()
{ 
  //alert('hii');

  var  transferid= document.getElementById('transferid').value;
  var  sessionid= document.getElementById('sessionid').value;
  var  room_id = document.getElementById('room_id').value;


  if(transferid!="" && sessionid!="" && room_id!="")
  {
    jQuery.ajax({
      type: 'POST',
      url: 'save_hostel_transfer.php',
      data: 'transferid='+transferid+'&sessionid='+sessionid+'&room_id='+room_id,
      dataType: 'html',
      success: function(data){  
      alert(data);
      if(data == 0)
      {
        alert("Duplicate Entry!");
      }

      if(data == 1)
      {
        getrecord('<?php echo $keyvalue; ?>');
        jQuery('#transferid').val(''); 
        jQuery('#sessionid').val('');
        jQuery('#room_id').val('');
        jQuery("#transferid").val('').trigger("liszt:updated");
        //document.getElementById('m_student_reg_id').focus();
        jQuery(".chzn-single").focus();
      }

      if(data == 2)
      {
        alert("Something Error Occure!");
      }

      }
      });//ajax close
  }//if close //m_student_reg_id!=""
  else
    alert("Please Select All Fields!");      
}//function close

  function getrecord(keyvalue){
 var transferid = jQuery("#transferid").val();

      jQuery.ajax({
      type: 'POST',
      url: 'show_hostel_transfer.php',
      data: "transferid="+transferid,
      dataType: 'html',
      success: function(data){          
      //alert(data);
        jQuery('#showrecord').html(data);         
        
        
      }
      });//ajax close
} 

function getid(transferid)
  { 
    
    var $url = 'transfer_hostel.php?transferid='+transferid;
   
    location = $url
    
  }
  // function postid(room_id)
  // { 
    
  //   var $url = 'transfer_hostel.php?room_id='+room_id;
   
  //   location = $url
    
  // }
  </script>
</body>
</html>
