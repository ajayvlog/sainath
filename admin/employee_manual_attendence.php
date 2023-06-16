<?php include("../adminsession.php");
$pagename = "employee_manual_attendence.php";
$module = "Employee Manual Attendance";
$submodule = "Employee Attendance Report";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "emp_attendance_entry";
$tblpkey = "emp_attendance_id";
if(isset($_GET['emp_attendance_id']))
$keyvalue = $_GET['emp_attendance_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$crit = " where 1 = 1";

if(isset($_GET['emp_attendance_date']))
{
    $emp_attendance_date = $obj->dateformatusa(trim(addslashes($_GET['emp_attendance_date'])));
    $crit .= " and emp_attendance_date='$emp_attendance_date' ";      
}
else
{
    $emp_attendance_date= date('Y-m-d');
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
                        <th width="22%">Date <span style="color:#F00;"> * </span> </th>
                        <th width="31%">Action </th>
                        </tr>
                        <tr> 
                        <td><input type="text" name="emp_attendance_date" id="emp_attendance_date" class="input-xxlarge" style="width:80%" value="<?php echo $obj->dateformatindia($emp_attendance_date);?>"   autocomplete="off" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/> </td>

                        <td>
                        <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('emp_attendance_date'); ">
                        <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>

                        </td>

                        </tr>
                        </table>   
                    </form>
                     </div>  
                       
                    </div>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_emp_attendance_report.php?emp_attendance_date=<?php echo $obj->dateformatindia($emp_attendance_date); ?>" class="btn btn-info" target="_blank">
                    <span style="#000; color:#FFF">Print PDF</span></a></p>
                 <!--  <?php
                  if($attendance_date !='--')
                  {
                    
                  ?> -->
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
                    
                    <th width="10%" class="head0 nosort">S.No.</th>
                    <th width="21%" class="head0">Employee Name</th>  
                    <th width="22%" class="head0">Post</th>                            
                    <th width="22%" class="head0">Mobile</th>
                    <th width="22%" class="head0">Date/Time</th>
                    <th width="22%" class="head0">In Time</th>
                    <th width="22%" class="head0">Out Time</th>
                    <th width="22%" class="head0">Att_By</th>
                    <th width="25%" class="head0">Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    </span>
                    <?php
                    $slno=1;

                    //"select A.* from m_student_reg as A left join class_transfer as B on A.m_student_reg_id=B.m_student_reg_id left join attendance_entry as C on B.m_student_reg_id = C.m_student_reg_id $crit group by A.m_student_reg_id"

                     //echo "select A.* from emp_attendance_entry as A left join m_employee as B on A.employee_id=B.employee_id";die;
                     
                    $res = $obj->executequery("select * from m_employee where status='0'");
                    foreach($res as $rowget)
                    {
                        $employee_id = $rowget['employee_id'];
                       
                        $count = $obj->getvalfield("emp_attendance_entry","count(*)","emp_attendance_date='$emp_attendance_date' && employee_id='$employee_id'"); 

                        $in_entry = $obj->getvalfield("emp_attendance_entry","attendance_time","employee_id='$employee_id' and emp_attendance_date='$emp_attendance_date' order by emp_attendance_id asc limit 0,1");

                        if($count > 1)
                        {
                          $out_entry = $obj->getvalfield("emp_attendance_entry","attendance_time","employee_id='$employee_id' and emp_attendance_date='$emp_attendance_date' order by emp_attendance_id desc limit 0,1");
                        }
                        else
                        $out_entry = "";

                        $attendanceby = $obj->getvalfield("emp_attendance_entry","attendanceby","emp_attendance_date='$emp_attendance_date' && employee_id='$employee_id'");

                           

                       if($count > 0)
                        {
                            $emp_attendance_date=$obj->getvalfield("emp_attendance_entry","emp_attendance_date","emp_attendance_date='$emp_attendance_date' && employee_id='$employee_id'");

                            $attendance_time= $obj->getvalfield("emp_attendance_entry","attendance_time","emp_attendance_date='$emp_attendance_date' && employee_id='$employee_id'");

                            $msg='Present';
                            $class="btn btn-success";

                             $show_date_time = $emp_attendance_date.' / '.$attendance_time;
                        }
                        else
                        {
                            $msg='Absent';
                            $class="btn btn-warning";
                            $show_date_time = "";
                           
                        }
                        
                        
                         if($attendanceby == 0){
                          $attype = "Manual";
                         }else
                         $attype = "Machine";
                        
                    ?>
                 <tr>
                      <td><?php echo $slno++; ?></td> 
                      <td><?php echo $rowget['emp_name']; ?></td> 
                      <td><?php echo $rowget['post']; ?></td> 
                      <td><?php echo $rowget['mobile']; ?></td>
                      <td id="atte_date<?php echo $employee_id; ?>"><?php echo $show_date_time; ?></td> 
                      <td><?php echo $in_entry; ?></td>
                      <td><?php echo $out_entry; ?></td>
                      <td><?php echo $attype; ?></td>
                      <td>
                        <?php
                        if($attendanceby == 0){ ?>
                      <button id="attendance<?php echo $employee_id; ?>" class="<?php echo $class; ?>" onClick="makeattendance('<?php echo $employee_id; ?>');" > <?php echo $msg; ?> </button>
                    <?php } ?>
                      </td>
                     
                    
                 </tr>
                    <?php   
                    }
                    ?>                 
                    
                    </tbody>
                    </table>
                    
                 <!--  <?php
                  }
                  ?> -->
                
               
            </div><!--contentinner-->
        </div><!--maincontent-->
        
   
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
</div><!--mainwrapper-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_party1">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">For Half Day Or Leave</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <input type="text" name="employee_id" id="employee_id1" value="<?php echo $employee_id; ?>">
             <table class="table table-condensed table-bordered">
             
              
              <tr> 
                <th style="width: 50%;">For Half Day Or Leave<span style="color:#F00;"> * </span> </th>
                
              </tr>
              <tr>
                  <td>
                   <select class="chzn-select" id="halfday" name="halfday">
                     <option value="">--Select--</option>
                     <option value="half_day">Half Day</option>
                     <option value="leave">Leave</option>
                   </select>
                  </td>
                  </tr>
                  
                              
              
            
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_attandance();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
</div>

<script>

    function makeattendance(employee_id)
    { 

        var emp_attendance_date=document.getElementById('emp_attendance_date').value;
//alert(emp_attendance_date);

        if(employee_id !='')
        {
          
            jQuery.ajax({
              type: 'POST',
              url: 'empattendance.php',
              data: 'employee_id='+employee_id+'&emp_attendance_date='+emp_attendance_date,
              dataType: 'html',
              success: function(data){

                var obj = JSON.parse(data);
                //alert(data);
              //  namestr = 'atte_date' + employee_id + 'atte_time' + employee_id;
              // alert(namestr);
                if(obj.status=="Present")
                {
                    
                    document.getElementById('attendance'+employee_id).className='btn btn-success';
                    document.getElementById('attendance'+employee_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+employee_id).innerHTML = obj.date+ ' ' +obj.time;
                   
                }
                else
                {
                     
                    document.getElementById('attendance'+employee_id).className='btn btn-warning';
                    document.getElementById('attendance'+employee_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+employee_id).innerHTML = '';
                  
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
                  var obj = JSON.parse(data);
                //alert(data);
              //  namestr = 'atte_date' + employee_id + 'atte_time' + employee_id;
              // alert(namestr);
                if(obj.status=="Present")
                {
                    
                    document.getElementById('attendance'+employee_id).className='btn btn-success';
                    document.getElementById('attendance'+employee_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+employee_id).innerHTML = obj.date+ ' ' +obj.time;
                   
                }
                else
                {
                     
                    document.getElementById('attendance'+employee_id).className='btn btn-warning';
                    document.getElementById('attendance'+employee_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+employee_id).innerHTML = '';
                  
                }
                   location='<?php echo $pagename."?action=3" ; ?>';
                }
                
              });//ajax close
        }//confirm close
    } //fun close
    
jQuery('#emp_attendance_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#emp_attendance_date').focus();

function halfday(employee_id)
{
   jQuery('#myModal_party1').modal('show');
    
    jQuery("#employee_id1").val(employee_id);
    // jQuery("#msg").val(msg);
    // jQuery("#customer_name").html(customer_name);

}

function save_attandance(employee_id)
{
  // alert('hiie');
  var halfday = document.getElementById('halfday').value;

  var employee_id = document.getElementById('employee_id1').value;
  var emp_attendance_date=document.getElementById('emp_attendance_date').value;
  //alert(employee_id);

   jQuery.ajax({
        type: 'POST',
        url: 'save_attandance.php',
        data: 'halfday='+halfday+'&employee_id='+employee_id+'&emp_attendance_date='+emp_attendance_date,
        dataType: 'html',
        success: function(data){          
          //alert(data);
          jQuery("#myModal_party1").modal('hide');

                       }
        });//ajax close
        location = 'employee_manual_attendence.php';
    }

  </script>
</body>
</html>
