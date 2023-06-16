 <?php include("../adminsession.php");
//print_r($_SESSION);die;
 $pagename = "student_subject_master.php";
 $module = "STUDENT SUBJECT MASTER";
 $submodule = "Student Subject Master";
 $btn_name = "Save";
 $keyvalue =0 ;
 $tblname = "student_subject_master";
 $tblpkey = "stu_subject_id";
 $dup = "";
 $sessionid = $_SESSION['sessionid'];
 if(isset($_GET['stu_subject_id']))
  $keyvalue = $_GET['stu_subject_id'];
else
  $keyvalue = 0;

if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

$sem_id = $class_id = $subject_name = "";

if(isset($_POST['submit']))
{ //print_r($_POST); die;

     $class_id = $obj->test_input($_POST['class_id']);
     $sem_id = $obj->test_input($_POST['sem_id']);
     $subject_name = $obj->test_input($_POST['subject_name']);
     

     $cwhere = array("class_id"=>$_POST['class_id'],"sem_id"=>$_POST['sem_id'],"subject_name"=>$_POST['subject_name']);
     $count = $obj->count_method("student_subject_master",$cwhere);
     if($count > 0 && $keyvalue == 0 )
     {
      /*$dup = " Error : Duplicate Record";*/
      $dup="<div class='alert alert-danger'>
      <strong>Error!</strong> Error : Duplicate Record.
      </div>";
    } 
    else{

       if($keyvalue == 0)
       {    
        $form_data = array('class_id'=>$class_id,'sem_id'=>$sem_id,'subject_name'=>$subject_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sessionid'=>$sessionid);
        $obj->insert_record($tblname,$form_data); 
             //print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action'</script>";
      }
      else{
              //update
        $form_data = array('class_id'=>$class_id,'sem_id'=>$sem_id,'subject_name'=>$subject_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'sessionid'=>$sessionid);
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
  $sem_id =  $sqledit['sem_id'];
  $class_id =  $sqledit['class_id'];
  $subject_name =  $sqledit['subject_name'];
 
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
        <div class="contentinner content-dashboard">
           <?php include("../include/alerts.php"); ?>
          <form method="POST" action="">
             <?php echo  $dup;  ?>
            <table class="table table-bordered table-condensed">
              <tr>
                <th>Course Name<span style="color:#F00;">*</span></th>
                <th>Sem/Year<span style="color:#F00;">*</span></th>
                <th>Subject Name<span style="color:#F00;">*</span></th>
                <!-- <th>Address</th> -->
              </tr>
              <tr>
                
                <td>
                 <select name="class_id" id="class_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("m_class");
                    foreach($res as $row_get)
                    {
                      ?> 
                      <option value="<?php echo $row_get['class_id']; ?>"> <?php echo $row_get['class_name']; ?></option>                                                     
                    <?php } ?>
                  </select>
                  <script>document.getElementById('class_id').value = '<?php echo $class_id ; ?>';
                </script>
                </td>
                <td>
                  <select name="sem_id" id="sem_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("m_semester");
                    foreach($res as $row_get)
                    {
                      ?> 
                      <option value="<?php echo $row_get['sem_id']; ?>"> <?php echo $row_get['sem_name']; ?></option>                                                     
                    <?php } ?>
                  </select>
                  <script>document.getElementById('sem_id').value = '<?php echo $sem_id ; ?>';
                </script>
                 <td>
                      <input type="text" name="subject_name" id="subject_name" value="<?php echo $subject_name; ?>" class="input-xxlarge" autofocus autocomplete="off" placeholder="Enter Subject Name" style="width:200px;">
                    </td>
                    
                    <td colspan="4"><input type="submit" name="submit" class="btn btn-success" value="<?php echo $btn_name; ?>" onClick="return checkinputmaster('class_id,sem_id,subject_name'); ">
                      <a href="student_subject_master.php" class="btn btn-success">Reset</a>
                    </td>
                  </table>
                  <div>
                  </form>
                  <br>
         <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="simple-html-invoice/simple-html-invoice-template-master/pdf_all_student_reg_report.php?class_id=<?php //echo $class_id; ?>&s_sessionid=<?php //echo $s_sessionid; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>
          
          
          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
        </p> -->

        <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
        <table class="table table-bordered" id="dyntable">
          <colgroup>
            <col class="con0" style="text-align: center; width: 4%" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
          </colgroup>
          <thead>
            <tr>

              <th width="11%" class="head0 nosort">Sno.</th>
              <th width="18%" class="head0">Course Name</th>
              <th width="18%" class="head0">Sem/Year</th>
              <th width="18%" class="head0">Subject Name</th>
              <?php  $chkedit = $obj->check_editBtn("student_subject_master.php",$loginid);              

              if($chkedit == 1 || $loginid == 1){  ?>
              <th width="9%" class="head0">Edit</th>
              <?php  } $chkdel = $obj->check_delBtn("student_subject_master.php",$loginid);             

              if($chkdel == 1 || $loginid == 1){  ?>
              <th width="10%" class="head0">Delete</th> 
              <?php } ?>
            </tr>
          </thead>
          <tbody>
          </span>
          <?php
          $slno=1;
            //$res = $obj->fetch_record("m_city");
          $res = $obj->executequery("select * from  m_subject $crit order by subject_id desc");
          foreach($res as $row_get)
          {
            $class_id = $row_get['class_id'];
            $coursename=$obj->getvalfield("m_class","class_name","class_id='$row_get[class_id];'");
            
            ?>   
            <tr>
              <td><?php echo $slno++; ?></td> 
              <td><?php echo $coursename; ?></td>
              <td><?php echo $semyear; ?></td>
              <td><?php echo $row_get['subject_name']; ?></td>
              <?php                

                            if($chkedit == 1 || $loginid == 1){  ?>
              <td><a class='icon-edit' title="Edit" href='student_subject_master.php?stu_subject_id=<?php echo $row_get['stu_subject_id'] ; ?>'></a></td>
              <?php  } if($chkdel == 1 || $loginid == 1){  ?>
              <td>
                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['stu_subject_id']; ?>);' style='cursor:pointer'></a>
              </td>
              <?php } ?>
            </tr>

            <?php
          }
          ?>     
        </tbody>
      </table>


      <!--  <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php //echo number_format($totalqty,2); ?></h3></div>  --> 
    </div>
  </div><!--contentinner-->
</div><!--maincontent-->
</div>
<!--mainright-->
<!-- END OF RIGHT PANEL -->
<!-- Modal -->
<div class="clearfix"></div>
<?php include("inc/footer.php"); ?>
<!--footer-->

</div><!--mainwrapper-->

<script type="text/javascript">

  function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
        type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
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
        url: 'ajax/delete_master_subject.php',
        data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
        dataType: 'html',
        success: function(data){
         // alert(data);
         location='<?php echo $pagename."?action=3" ; ?>';
       }

        });//ajax close
    }//confirm close
  } //fun close

  function settotal()
  {

    var basic_salary=parseFloat(jQuery('#basic_salary').val()); 
    var days=parseFloat(jQuery('#days').val()); 
    var presentdays=parseFloat(jQuery('#presentdays').val()); 

    if(!isNaN(basic_salary) && !isNaN(days) && !isNaN(presentdays))
    {
      totdays = basic_salary/days;
      netsalary = totdays*presentdays;
    } 
    jQuery('#netsalary').val(netsalary.toFixed(2));
  } 
</script>
</body>
</html>
