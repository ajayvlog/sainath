<?php include("../adminsession.php");
$pagename = "manual_attendance.php";
$module = "Manual Attendance";
$submodule = "Attendance Report";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "attendance_entry";
$tblpkey = "attendance_id";

if(isset($_GET['attendance_id']))
$keyvalue = $_GET['attendance_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = $obj->test_input($_GET['action']);
else
$action = "";
$class_id = "";
$crit = " where 1 = 1";
$createdate1 = "";
$sem_id = "";

if(isset($_GET['createdate']))
{
    $createdate1 = $obj->dateformatusa($obj->test_input($_GET['createdate']));
  //$crit .= " and A.createdate='$createdate1' ";      
}
else
{
    $createdate1= date('Y-m-d');
}

if(isset($_GET['class_id']))
{
    $class_id = $obj->test_input($_GET['class_id']);    
}

if($class_id !='')
{
    $class_id=$obj->test_input($_GET['class_id']);
    $crit .= " and B.class_id='$class_id' ";    
}

if(isset($_GET['sem_id']))
{
    $sem_id = $obj->test_input($_GET['sem_id']);    
}

if($sem_id !='')
{
    $sem_id=$obj->test_input($_GET['sem_id']);
    $crit .= " and A.sem_id='$sem_id' ";    
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
              <?php include("../include/alerts.php"); ?>
                <!--widgetcontent-->        
                <div class="widgetcontent  shadowed nopadding">
                    <form class="stdform stdform2" method="get" action="">
                   
                       <div class="lg-12 md-12 sm-12">
                                <table class="table table-bordered" > 
                                <tr>
                                 <th width="22%"> Date <span style="color:#F00;"> * </span> </th>
                                 <th width="22%">Course Name </th>
                                 <th width="22%">Sem/Year</th>
                                 <th width="31%">Action </th>
                               </tr>
                                <tr> 
                                <td><input type="text" name="createdate" id="createdate" class="input-xxlarge" style="width:80%" value="<?php echo $obj->dateformatindia($createdate1);?>"   autocomplete="off" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/> </td>
                                <td>

                                <select name="class_id" id="class_id"  class="chzn-select" style="width:283px;">
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
                                <select name="sem_id" id="sem_id"  class="chzn-select" style="width:283px;">
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
                        <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster(''); ">
                        <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                     
                                </td>
                                
                                </tr>
                                </table>   
                        </form>

                        
                     </div>  
                       
                    </div>
                    <?php if($class_id > 0 and $sem_id > 0)
                    {
                      ?>
                      <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_student_attendance_report.php?createdate=<?php echo $obj->dateformatindia($createdate1); ?>&class_id=<?php echo $class_id; ?>&sem_id=<?php echo $sem_id; ?>" class="btn btn-info" target="_blank">
                    
                    <span style="#000; color:#FFF">Print PDF</span></a></p>
                 
              <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    
                    <div>
                    <form class="navbar-search pull-right">
                    <!-- <input class="search-query" placeholder="Search by member name..." id="myInput1" onKeyUp="myFunction1();" type="text"> -->
                    </form>
                    </div>
                
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
                    
                    <th class="head0 nosort">S.No.</th>
                    <th class="head0">Member Name</th>  
                    <th class="head0">Father's Name</th>                            
                    <th class="head0">Mobile</th>
                    <th class="head0">Date/Time</th>
                    <th class="head0">In Time</th>
                    <th class="head0">Out Time</th>
                    <th class="head0">By Machine</th>
                    <th class="head0">Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    </span>
                    <?php
                      $slno=1;

                    
               $curdate = date('Y-m-d');
            $res = $obj->executequery("select A.*,B.* from class_transfer as A left join m_student_reg as B on A.m_student_reg_id=B.m_student_reg_id $crit and A.sessionid = '$sessionid' group by A.m_student_reg_id");
            foreach($res as $rowget)
                
                    {
                        $transferid=$rowget['transferid'];
                        $m_student_reg_id=$rowget['m_student_reg_id'];
                        $stu_name=$rowget['stu_name'];
                        $father_name=$rowget['father_name'];
                        $mobile=$rowget['mobile'];
                        
                         $count=$obj->getvalfield("attendance_entry","count(*)","attendance_date='$createdate1' && transferid='$transferid'");   

                        $in_entry = $obj->getvalfield("attendance_entry","attendance_time","transferid='$transferid' and attendance_date='$createdate1' order by attendance_id asc limit 0,1");

                         if($count > 1)
                        {
                         $out_entry = $obj->getvalfield("attendance_entry","attendance_time","transferid='$transferid' and attendance_date='$createdate1' order by attendance_id desc limit 0,1");
                        }
                        else
                        $out_entry = "";

                                           
                        if($count > 0)
                        {
                             $attendance_date=$obj->getvalfield("attendance_entry","attendance_date","transferid=$transferid and attendance_date='$createdate1'");

                             $attendance_time=$obj->getvalfield("attendance_entry","attendance_time","transferid=$transferid and attendance_date='$createdate1'");

                             $verifyiedby=$obj->getvalfield("attendance_entry","verifyiedby","transferid='$transferid' and attendance_date='$createdate1'");

                             $machinest = "";
                             if($verifyiedby == 1 || $verifyiedby == 2)
                             $machinest = "By Machine";
                              

                            $msg='Present';
                            $class="btn btn-success";
                        }
                        else
                        {
                            $msg='Absent';
                            $class="btn btn-warning";
                            $attendance_date = "";
                            $attendance_time = "";
                            $machinest = "";
                        }
                        
                    ?>
                 <tr>
                      <td><?php echo $slno++; ?></td> 
                      <td><?php echo $stu_name; ?></td> 
                      <td><?php echo $father_name; ?></td> 
                      <td><?php echo $mobile; ?></td>
                      <td id="atte_date<?php echo $transferid; ?>"><?php echo $obj->dateformatindia($attendance_date)." ".$attendance_time; ?></td> 
                      <td><?php echo $in_entry; ?></td>
                      <td><?php echo $out_entry; ?></td>
                      <td><?php echo $machinest; ?></td>
                      <td>
                      <button id="attendance<?php echo $transferid; ?>" class="<?php echo $class; ?>" onClick="makeattendance('<?php echo $transferid; ?>');" > <?php echo $msg; ?> </button>
                      </td>
                    
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

   function makeattendance(transferid)
    { 
        var attendance_date=document.getElementById('createdate').value;

        if(transferid !='')
        {
          //document
            jQuery.ajax({
              type: 'POST',
              url: 'makeattendance.php',
              data: 'transferid='+transferid+'&attendance_date='+attendance_date,
              dataType: 'html',
              success: function(data){
                var obj = JSON.parse(data);
                //alert(data);
                //namestr = 'atte_date' + transferid + 'atte_time' + transferid;
               //alert(namestr);
                if(obj.status=="Present")
                {
                    //alert(obj.status);
                    //alert(obj.date);
                   // alert(obj.time);
                    document.getElementById('attendance'+transferid).className='btn btn-success';
                    document.getElementById('attendance'+transferid).innerHTML = obj.status;
                    document.getElementById('atte_date'+transferid).innerHTML = obj.date+' ' +obj.time;
                  
                }
                else
                {
                    // alert(obj.status);
                    // alert(obj.date);
                    // alert(obj.time);
                    document.getElementById('attendance'+transferid).className='btn btn-warning';
                    document.getElementById('attendance'+transferid).innerHTML = obj.status;
                    document.getElementById('atte_date'+transferid).innerHTML = '';
                  
                }
                 }
              });//ajax close
        }
    }
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
    
    
 //    jQuery(function() {
 //                //Datemask dd/mm/yyyy
 //                jQuery("#attendance_date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
                                            
 //                //Money Euro
 //                jQuery("[data-mask]").inputmask();
 // });
    
jQuery('#createdate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#createdate').focus();
  </script>
</body>

</html>
