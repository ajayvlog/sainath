<?php include("../adminsession.php");
$pagename = "hostel_fee_setting.php";
$module = "Fee Setting";
$submodule = "FEE SETTING";
$keyvalue = 0;
$tblname = "hostel_fee_setting";
$tblpkey = "hostel_fee_set_id";

if(isset($_GET['hostel_fee_set_id']))
$keyvalue = $_GET['hostel_fee_set_id'];
else
$keyvalue = 0;

if(isset($_GET['transferid']))
{
  $transferid = $_GET['transferid'];
  $m_student_reg_id1 = $obj->getvalfield("class_transfer","m_student_reg_id","transferid=$transferid");
  $is_set = $obj->getvalfield("hostel_fee_setting","count(*)","transferid=$transferid and sessionid='$sessionid'");
}

else
{
  $m_student_reg_id1 = 0;
  $transferid = 0;
}
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$dup = "";

if($is_set > 0)
{
  $btn_name = "Update";
}
else
{
  $btn_name = "Save";
}
if(isset($_POST['submit']))
{
 // print_r($_POST);die;
 $transferid = $_POST['transferid'];
 $fee_head_id_arr = $_POST['fee_head_id'];
 $total_fee_arr = $_POST['total_fee'];
 $hostel_fee_set_id = $_POST['hostel_fee_set_id']; 
 
      $total = count($fee_head_id_arr);
      if($total > 0)
           {
            //delete record 
          $where = array('transferid'=>$transferid);
          $obj->delete_record($tblname,$where);
          for($i=0;$i<$total;$i++)

      {

      $fee_head_id = $fee_head_id_arr[$i];
      $total_fee = $total_fee_arr[$i];
      
     //insert record
      

      $form_data = array('fee_head_id'=>$fee_head_id,'total_fee'=>$total_fee,'transferid'=>$transferid,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sessionid'=>$sessionid);
      $obj->insert_record($tblname,$form_data);
    

      }//for loop close
          }//if close

      $action=1;
      $process = "insert";
      echo "<script>location='$pagename?transferid=$transferid'</script>";


}//if(isset)close

 //update record
 // if(isset($_GET[$tblpkey]))
 // { 

 //     $btn_name = "Update";

 // }


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
                       <div id="wizard2" class="wizard tabbedwizard">
                        <?php include("inc/tabmenu.php");?>                       
                        <div>
                          <h4>Step 6: Fee Setting</h4>
                          <?php echo $dup; ?>
                       <div class="lg-12 md-12 sm-12">
                       <table class="table table-bordered"> 
                        <tr> 
                       <th>Student Name<span style="color:#F00;"></span>
                       </th>
                      </tr>
                       <tr> 
                          <td>
                        <select name="transferid" id="transferid" style="width:280px;" class="chzn-select" onChange="getid(this.value);">
                        <option value="">--Select--</option>
                        <?php
                        
                        $res = $obj->executequery("select * from class_transfer where sessionid=$sessionid");
                        foreach($res as $row)
                        {
                          $m_student_reg_id = $row['m_student_reg_id'];
                          $a_transferid = $row['transferid'];
                          $sem_id = $row['sem_id'];
                          $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id=$m_student_reg_id");
                          $class_id = $obj->getvalfield("m_student_reg","class_id","m_student_reg_id=$m_student_reg_id");
                          $class_name = $obj->getvalfield("m_class","class_name","class_id=$class_id");
                         $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id=$sem_id");
                        ?>
                        <option value="<?php echo $a_transferid; ?>"><?php echo $stu_name." / ".$class_name." / ".$sem_name; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('transferid').value='<?php echo $transferid ; ?>'; </script>    
                        </td>  
                        
                       </table>
                       </div> 
                       </div>
                       </div>  

                       
                       
                      
                            <?php
                           
                            if($transferid > 0)
                            { ?>
                              <?php 
                       if($is_set > 0)
                       { ?>
                        <h6><span style="color: green;">This Student Fee Setting alredy generated</span></h6>
                        <?php }
                        else
                        { ?>
                          <h6><span style="color: red;">This Student Fee Setting Not generated</span></h6>
                         <?php } ?>
                        <p>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Slno</td>
                                        <td>Course Name</td>
                                        <td>Total Fee</td>
                                    </tr> 
                                    <tr>
                                        <?php
                                        $res = $obj->executequery("select * from m_fee_head");
                                        $slno = 1;
                                        foreach($res as $row_get)
                                        {  


                                            $fee_head_id = $row_get['fee_head_id'];
                                            $class_id = $obj->getvalfield("m_student_reg","class_id","m_student_reg_id='$m_student_reg_id1'");

                                             $total_fee = $obj->getvalfield("hostel_fee_setting","total_fee","fee_head_id='$fee_head_id' and sessionid='$sessionid' and transferid=$transferid");
                                              
                                              if($total_fee == '')
                                              {
                                                $total_fee = $obj->getvalfield("course_fee_setting","total_fee","fee_head_id='$fee_head_id' and class_id='$class_id' and sessionid='$sessionid'");
                                              }

                                            
                                        ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                                <td><?php echo $row_get['fee_head_name']; ?>
                                                    <input type="hidden" name="fee_head_id[]" value="<?php echo $fee_head_id; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="total_fee[]" value="<?php
                                                    echo $total_fee; ?>">
                                                </td>
                                                
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </p>

                            <center> <p class="stdformbutton">
                            <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('');" />
                            <?php echo $btn_name; ?></button>
                            <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                            <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $class_id; ?>">
                            </p> </center>
                            <?php } ?>
                               
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
        url: 'ajax/delete_master_reg.php',
        data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
        dataType: 'html',
        success: function(data){
         //alert(data);
           location='<?php echo $pagename."?action=3" ; ?>';
        }
        
        });//ajax close
    }//confirm close
  } //fun close


jQuery('#admission_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#dob').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#admission_date').focus();

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

  function getid(transferid)
  { 
    
    var $url = 'hostel_fee_setting.php?transferid='+transferid;
   
    location = $url
    
  }
  </script>
</body>
</html>
