<?php include("../adminsession.php");
$pagename = "class_transfer.php";
$module = "Class Transfer";
$submodule = "CLASS TRANSFER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "class_transfer";
$tblpkey = "transferid";
if(isset($_GET['transferid']))
$keyvalue = $_GET['transferid'];
else
$keyvalue = 0;

if(isset($_GET['m_student_reg_id']))
$m_student_reg_id1 = $_GET['m_student_reg_id'];
else
$m_student_reg_id1 = 0;

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
                  <h4>Step 3: Class Transfer</h4>
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
                      <td>Semester Name </td>
                      <td>Session Name</td>
                      <td></td>
                     </tr>
                     <tr>
                        <td>
                        <select name="m_student_reg_id" id="m_student_reg_id" style="width:180px;" class="chzn-select" onchange="getid(this.value);">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from m_student_reg");
                        foreach($res as $row)
                        {
                          $m_student_reg_id = $row['m_student_reg_id'];
                           $stu_name = $row['stu_name'];
                           $class_id = $row['class_id'];
                           $class_name = $obj->getvalfield("m_class","class_name","class_id=$class_id");
                        ?>
                        <option value="<?php echo $m_student_reg_id; ?>"><?php echo $stu_name." / ".$class_name; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('m_student_reg_id').value='<?php echo $m_student_reg_id1; ?>'; </script>    
                        </td>
                        <td>
                        <select name="sem_id" id="sem_id" class="chzn-select" style="width:180px;">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from m_semester");
                        foreach($res as $row)
                        {
                        ?>
                        <option value="<?php echo $row['sem_id']; ?>"><?php echo $row['sem_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('sem_id').value='<?php echo $sem_id;?>'; </script>   
                        </td>  
                              
                        <td>
                        <select name="sessionid" id="sessionid" style="width:180px;" onChange="getcontact(this.value);">
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
                        <script> document.getElementById('sessionid').value='<?php echo $sessionid;?>'; </script>   
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
    
     <div class="clearfix">
      <!-- Modal for class -->
      <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_editdate">
        <div class="modal-header alert-info">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
          <h3 id="myModalLabel">Edit Date</h3>
        </div>
        <div class="modal-body">
          <span style="color:#F00;" id="suppler_model_error"></span>
          <table class="table table-condensed table-bordered">
            <tr>
              <th style="width: 50%;">Admission Date<span style="color:#F00;"> * </span> </th>

            </tr>
            <td>
              <input type="text" name="ad_date" id="ad_date" class="input-xxlarge" style="width:90%;" placeholder="dd-mm-yyyy" autocomplete="off" autofocus />
            </td>
            <input type="hidden" name="tid" id="tid">
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" name="save_course" id="save_course" onClick="editdate();">Save</button>
          <button data-dismiss="modal" class="btn btn-danger">Close</button>
        </div>
      </div>
      <!-- Modal Closing for class -->
    </div>
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
            location='<?php echo $pagename."?m_student_reg_id=$m_student_reg_id1" ; ?>';
        }
        
        });//ajax close
    }//confirm close
  } //fun close


jQuery('#admission_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#dob').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#admission_date').focus();

jQuery('#ad_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });

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
  var  m_student_reg_id= document.getElementById('m_student_reg_id').value;
  var  sem_id= document.getElementById('sem_id').value;
  var  sessionid= document.getElementById('sessionid').value;
  
  if(m_student_reg_id!="" && sem_id!="" && sessionid!="")
  {
    jQuery.ajax({
      type: 'POST',
      url: 'save_class_transfer.php',
      data: 'm_student_reg_id='+m_student_reg_id+'&sem_id='+sem_id+'&sessionid='+sessionid,
      dataType: 'html',
      success: function(data){  
      //alert(data);
      if(data == 0)
      {
        alert("Duplicate Entry!");
      }

      if(data == 1)
      {
        getrecord('<?php echo $keyvalue; ?>');
        jQuery('#m_student_reg_id').val('');  
        jQuery('#sem_id').val('');    
        jQuery('#sessionid').val('');
        jQuery("#m_student_reg_id").val('').trigger("liszt:updated");
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
 var m_student_reg_id = jQuery("#m_student_reg_id").val();
      jQuery.ajax({
      type: 'POST',
      url: 'show_class_transfer.php',
      data: "m_student_reg_id="+m_student_reg_id,
      dataType: 'html',
      success: function(data){          
      //alert(data);
        jQuery('#showrecord').html(data);         
        
        
      }
      });//ajax close
} 

function getid(m_student_reg_id)
  { 
    
    var $url = 'class_transfer.php?m_student_reg_id='+m_student_reg_id;
   
    location = $url
    
  }

   function editdate_modal(tid, ad_date) {
      document.getElementById("tid").value = tid;
      document.getElementById("ad_date").value = ad_date;
      jQuery('#myModal_editdate').modal('show');
    }

    function editdate() {
      var tid = jQuery("#tid").val();
      var admission_date = jQuery("#ad_date").val();
      jQuery.ajax({
        type: 'POST',
        url: 'update_admissiondate.php',
        data: "tid=" + tid + "&admission_date=" + admission_date,
        dataType: 'html',
        success: function(data) {
          console.log(data);
          getrecord(<?php echo $keyvalue; ?>);
          jQuery('#myModal_editdate').modal('hide');
        }
      }); //ajax close
    }
  </script>
</body>
</html>
