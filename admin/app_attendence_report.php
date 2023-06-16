<?php include("../adminsession.php");
$pagename = "app_attendence_report.php";
$module = "App Manual Attendance";
$submodule = "App Manual Student Attendance Report";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "app_subject_attendence";
$tblpkey = "app_attend_id";

$class_id = "";
$sem_id = "";
$stu_subject_id = "";
$crit = " where 1 = 1";


if(isset($_GET['attendate']))
{
    $attendate = $_GET['attendate'];
    //$crit1 .= " and attendate='$attendate' ";      
}
else
{
    $attendate= date('d-m-Y');
}

if(isset($_GET['class_id']) || $class_id !='')
{
    $class_id = $obj->test_input($_GET['class_id']);  
    $crit .= " and B.class_id='$class_id' ";      
}

if(isset($_GET['sem_id']) || $sem_id !='')
{
    $sem_id = $obj->test_input($_GET['sem_id']);
    $crit .= " and A.sem_id='$sem_id' ";      
}

if(isset($_GET['stu_subject_id']) || $stu_subject_id !='')
{
    $stu_subject_id = $obj->test_input($_GET['stu_subject_id']);
    //$crit1 .= " and stu_subject_id='$stu_subject_id' ";      
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
              
                <!--widgetcontent-->        
                <div class="widgetcontent  shadowed nopadding">
                    <form class="stdform stdform2" method="get" action="">
                   
                       <div class="lg-12 md-12 sm-12">
                                <table class="table table-bordered" > 
                                <tr>
                                     <th width="22%">Date<span style="color:#F00;">*</span></th>
                                     <th width="22%">Course Name<span style="color:#F00;">*</span></th>
                                     <th width="31%">Sem/Year <span style="color:#F00;">*</span></th>
                                     <th width="22%">Subject Name<span style="color:#F00;">*</span></th>
                                 
                               </tr>
                                <tr> 
                                    <td><input type="text" name="attendate" id="attendate" class="input-medium"  placeholder='dd-mm-yyyy'
                                    value="<?php echo $attendate; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                                
                                <td>
                                <select name="class_id" id="class_id"  class="chzn-select" style="width:200px;">
                                <option value="">-select-</option>
                                <?php

                                $res = $obj->fetch_record("m_class");
                                foreach($res as $row)
                                {
                                ?> 
                                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <script>document.getElementById("class_id").value="<?php echo $class_id; ?>" ;</script>
                                </td>

                                 <td>
                                <select name="sem_id" id="sem_id"  class="chzn-select" style="width:200px;">
                                <option value="">-select-</option>
                                <?php

                                $res = $obj->fetch_record("m_semester");
                                foreach($res as $row)
                                {
                                ?> 
                                <option value="<?php echo $row['sem_id']; ?>"><?php echo $row['sem_name']; ?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <script>document.getElementById("sem_id").value="<?php echo $sem_id; ?>" ;</script>

                                </td>  
                                  <td>
                                  <select name="stu_subject_id" id="stu_subject_id"  class="chzn-select" style="width:200px;">
                                  <option value="">-select-</option>
                                  <?php

                                  $res = $obj->fetch_record("student_subject_master");
                                  foreach($res as $row)
                                  {
                                  ?> 
                                  <option value="<?php echo $row['stu_subject_id']; ?>"><?php echo $row['subject_name']; ?></option>
                                  <?php
                                  }
                                  ?>
                                  </select>
                                  <script>document.getElementById("stu_subject_id").value="<?php echo $stu_subject_id; ?>" ;</script>

                                  </td>                  
                                 </tr>

                                 <tr>
                                <td colspan="4">
                        <center><button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('attendate,class_id,sem_id,stu_subject_id'); ">
                        <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a></center>
                     
                                </td>
                                </tr>
                                </table>   
                        </form>
                     </div>  
                       
                    </div>
                    <?php if($class_id > 0 and $sem_id > 0)
                    {
                      ?>
                      <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_app_stu_attend_report.php?attendate=<?php echo $attendate; ?>&class_id=<?php echo $class_id; ?>&sem_id=<?php echo $sem_id; ?>&stu_subject_id=<?php echo $stu_subject_id; ?>" class="btn btn-info" target="_blank">
                    
                    <span style="#000; color:#FFF">Print PDF</span></a></p>
                 
              <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    
                    <table class="table table-bordered" id="myTable1" >
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
                    
                    <th width="10%" class="head0 nosort">S.No.</th>
                    <th class="head0">Student Name</th>
                    <th class="head0">Biometric_code</th>  
                    <th class="head0">Father's Name</th>
                    <th class="head0">Mobile</th>
                    <th class="head0">Status</th>
                    <th class="head0">Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    </span>
                    <?php
                      $slno=1;
                      $res = $obj->executequery("select B.stu_name,B.biometric_code,B.father_name,B.mobile,A.transferid from class_transfer as A left join m_student_reg as B on A.m_student_reg_id=B.m_student_reg_id $crit and A.sessionid = '$sessionid'");
                      foreach($res as $rowget)
                      {
                        $transferid=$rowget['transferid'];
                        $stu_name=$rowget['stu_name'];
                        $father_name=$rowget['father_name'];
                        $mobile=$rowget['mobile'];
                        $biometric_code = $rowget['biometric_code'];
                        
                        $count = $obj->getvalfield("app_subject_attendence","count(*)","attendate = '$attendate' and stu_subject_id = '$stu_subject_id' and transferid = '$transferid'");
                         if($count > 0)
                          $status = "<span style='color:green'>Present</span>";
                        else
                          $status = "<span style='color:red'>Absent</span>";

                        $attendanc_time = $obj->getvalfield("app_subject_attendence","attendanc_time","attendate = '$attendate' and stu_subject_id = '$stu_subject_id' and transferid = '$transferid'");

                    ?>
                 <tr>
                      <td><?php echo $slno++; ?></td> 
                      <td><?php echo $stu_name; ?></td>
                      <td><?php echo $biometric_code; ?></td> 
                      <td><?php echo $father_name; ?></td> 
                      <td><?php echo $mobile; ?></td>
                      <td><?php echo $status; ?></td>
                      <td><?php echo $attendanc_time; ?></td>
                 </tr>
                    <?php  
                    }
                    ?>      
                    </tbody>
                    </table>  
                  <?php
                  }
                  ?> 
               
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
    
jQuery('#attendate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});


</script>
</body>
</html>
