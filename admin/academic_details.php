<?php include("../adminsession.php");
$pagename = "parent_details.php";
$module = "Parent Details";
$submodule = "PARENT DETAILS";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_student_reg";
$tblpkey = "m_student_reg_id";

if(isset($_GET['m_student_reg_id']))
 $keyvalue = $_GET['m_student_reg_id'];
else
$keyvalue = 0;

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$father_name = "";
$mother_name = "";
$parent_mobile = "";
$parent_aadhar_no = "";
$f_income = "";
$stu_name = "";
if(isset($_POST['submit']))
{
  //print_r($_POST);die;
  $father_name  = $_POST['father_name'];
  $mother_name = $_POST['mother_name'];
  $parent_mobile  = $_POST['parent_mobile'];
  $parent_aadhar_no = $_POST['parent_aadhar_no'];
  $f_income = $_POST['f_income'];

  //check Duplicate
    // $cwhere = array("m_student_reg_id"=>$_POST['m_student_reg_id'],"father_name"=>$_POST['father_name']);
    //    // print_r($cwhere);die;
    //  $count = $obj->count_method("m_student_reg",$cwhere);
    // if ($count > 0 && $keyvalue == 0) 
    //    { 
    //  $dup="<div class='alert alert-danger'>
    //  <strong>Error!</strong> Duplicate Record.
    //  </div>";
    //  //echo $dup; die;
    //    } 
    //  else 
    //   {  
  
       //update
            $form_data = array('father_name'=>$father_name,'mother_name'=>$mother_name,'parent_mobile'=>$parent_mobile,'parent_aadhar_no'=>$parent_aadhar_no,'f_income'=>$f_income);
            $where = array($tblpkey=>$keyvalue);
            $obj->update_record($tblname,$where,$form_data);
        $action=2;
        $process = "updated";
     echo "<script>location='class_transfer.php?m_student_reg_id=$keyvalue'</script>";

//}
}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $father_name =  $sqledit['father_name'];
  $mother_name =  $sqledit['mother_name'];
  $parent_mobile =  $sqledit['parent_mobile'];
  $parent_aadhar_no =  $sqledit['parent_aadhar_no'];
  $f_income = $sqledit['f_income'];
  
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
                       <div id="wizard2" class="wizard tabbedwizard">
                        <?php include("inc/tabmenu.php");?>                       
                        <div>
                          <?php echo $dup; ?>
                        <div style="padding:5px;">
                           <h3>10th Section</h3>
                        </div>
                       <div class="lg-12 md-12 sm-12">
                       <table class="table table-bordered">
                       <tr>
                         <th colspan="3">Student Name<span style="color:#F00;"></span></th>
                       </tr> 
                       <tr>
                         <td colspan="3">
                          <select name="m_student_reg_id" id="m_student_reg_id" style="width:280px;" class="chzn-select" onChange="getid(this.value);">
                        <option value="">--Select--</option>
                        <?php
                        

                        $res = $obj->executequery("select * from class_transfer LEFT JOIN m_student_reg ON class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where class_transfer.sessionid=$sessionid");
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
                        <script> document.getElementById('m_student_reg_id').value='<?php echo $keyvalue; ?>'; </script></td>
                       </tr>
                        <tr> 
                           <th>Name Of Board<span style="color:#F00;"></span></th>
                           <th>Passing Year<span style="color:#F00;">*</span></th>
                           <th>Roll No.<span style="color:#F00;">*</span></th>
                        </tr>
                       <tr> 
                         
                        <td> 
                          <input type="text" name="mother_name" id="mother_name" class="input-xlarge"  value="<?php //echo $mother_name; ?>" autofocus autocomplete="off"  placeholder="Enter Name of Board"/>
                        </td>
                        <td> 
                          <select style="width:280px;" class="chzn-select">
                            <option value="">--Select--</option>
                            
                            </select>
                            <!--  <script> document.getElementById('m_student_reg_id').value='<?php //echo $keyvalue; ?>'; </script>    --> 
                        </td> 
                          <td> <input type="text" name="parent_aadhar_no" id="parent_aadhar_no" class="input-xlarge"  value="<?php //echo $parent_aadhar_no; ?>" autofocus autocomplete="off"  placeholder="Enter Roll No."/></td> 
                        </tr>
                       <tr> 
                        
                        <th>Subject<span style="color:#F00;">*</span></th>
                        <th>Total Marks<span style="color:#F00;">*</span></th>
                        <th>Obtain Mark<span style="color:#F00;">*</span></th>
                       </tr>
                       <tr>             
                        <td> <input type="text" name="f_income" id="f_income" class="input-xlarge"  value="<?php //echo $f_income; ?>" autofocus autocomplete="off"  placeholder="Enter Subject"/></td>

                        <td> <input type="text" name="parent_mobile" id="parent_mobile" maxlength="10" class="input-xlarge"  value="<?php //echo $parent_mobile; ?>" autofocus autocomplete="off"  placeholder="Enter Total Mark"/></td>
                         <td colspan="3"><input type="text" name="parent_mobile" id="parent_mobile" maxlength="10" class="input-xlarge"  value="<?php //echo $parent_mobile; ?>" autofocus autocomplete="off"  placeholder="Enter Obtain Mark"/></td>
                      </tr>
              
                       </table>
                      </div> 
                       <!-- 12th section -->
                       <div style="padding:10px;">
                          <h3>12th Section</h3>
                       </div>
                       <div class="lg-12 md-12 sm-12">
                       <table class="table table-bordered"> 
                        <tr> 
                           <th>Name Of Board<span style="color:#F00;"></span></th>
                           <th>Passing Year<span style="color:#F00;">*</span></th>
                           <th>Roll No.<span style="color:#F00;">*</span></th>
                        </tr>
                       <tr> 
                         
                        <td> 
                          <input type="text" name="mother_name" id="mother_name" class="input-xlarge"  value="<?php //echo $mother_name; ?>" autofocus autocomplete="off"  placeholder="Enter Name of Board"/>
                        </td>
                        <td> 
                          <select style="width:280px;" class="chzn-select">
                            <option value="">--Select--</option>
                            
                            </select>
                            <!--  <script> document.getElementById('m_student_reg_id').value='<?php //echo $keyvalue; ?>'; </script>    --> 
                        </td> 
                          <td> <input type="text" name="parent_aadhar_no" id="parent_aadhar_no" class="input-xlarge"  value="<?php //echo $parent_aadhar_no; ?>" autofocus autocomplete="off"  placeholder="Enter Roll No."/></td> 
                        </tr>
                       <tr> 
                        
                        <th>Subject<span style="color:#F00;">*</span></th>
                        <th>Total Marks<span style="color:#F00;">*</span></th>
                        <th>Obtain Mark<span style="color:#F00;">*</span></th>
                       </tr>
                       <tr>             
                        <td> <input type="text" name="f_income" id="f_income" class="input-xlarge"  value="<?php //echo $f_income; ?>" autofocus autocomplete="off"  placeholder="Enter Subject"/></td>

                        <td> <input type="text" name="parent_mobile" id="parent_mobile" maxlength="10" class="input-xlarge"  value="<?php //echo $parent_mobile; ?>" autofocus autocomplete="off"  placeholder="Enter Total Mark"/></td>
                         <td colspan="3"><input type="text" name="parent_mobile" id="parent_mobile" maxlength="10" class="input-xlarge"  value="<?php //echo $parent_mobile; ?>" autofocus autocomplete="off"  placeholder="Enter Obtain Mark"/></td>
                      </tr>

                       <tr>
                          <td colspan="3">
                            <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster(''); ">
                          <?php echo $btn_name; ?></button>
                          <a href="academic_details.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                          <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">  
                          </td>                  
                      </tr>
                      </table>
                       </div>
                       </div>
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
                        
                            <th  class="head0 nosort">Sno.</th>
                            <th  class="head0">Student Name</th>
                            <th class="head0">Passing Year</th>
                            <th class="head0">Roll No.</th>
                            <th class="head0">Aadhar No</th>
                            <th  class="head0">Total Marks</th>
                            <th class="head0">Obtain Mark</th>
                            <?php  $chkedit = $obj->check_editBtn("academic_details.php",$loginid);              

                            if($chkedit == 1 || $loginid == 1){  ?>
                            <th width="4%" class="head0">Edit</th>
                          <?php } ?>
                            
                         
                    </thead>
                    <tbody>
                        
        <?php
            // $slno=1;
            //$res = $obj->fetch_record("m_product");
           
            // $res = $obj->executequery("select * from m_student_reg where m_student_reg_id = $keyvalue");
            // foreach($res as $row_get)
            //     {

                ?>   
                   <tr>
                        <td><?php //echo $slno++; ?></td>
                        <td><?php //echo $row_get['stu_name']; ?></td>
                        <td><?php //echo $row_get['father_name']; ?></td>
                        <td><?php //echo $row_get['mother_name']; ?></td>
                        <td><?php //echo $row_get['parent_aadhar_no']; ?></td>
                        <td><?php //echo $row_get['f_income']; ?></td>
                        <td><?php //echo $row_get['parent_mobile']; ?></td>
                       <td><a class='icon-edit' title="Edit" href=''></a></td>
                       <!--  <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php //echo $m_student_reg_id; ?>);' style='cursor:pointer'></a>
                        </td> -->
                </tr>
                
                <?php
                //}
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

  function getid(m_student_reg_id)
  { 
    
    var $url = 'academic_details.php?m_student_reg_id='+m_student_reg_id;
   
    location = $url;
    
  }
  </script>
</body>
</html>
