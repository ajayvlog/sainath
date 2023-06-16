<?php include("../adminsession.php");
//print_r($_SESSION);die;
 $pagename = "time_table_report.php";
 $module = "TIME TABLE REPORT";
 $submodule = "Time Table Report";
 $btn_name = "Search";
 
 $sessionid = $_SESSION['sessionid'];
 
$crit = "";
  if(isset($_GET['class_id']))
  {
    $class_id = $_GET['class_id'];
    if($class_id!="")
    {
        $crit .= "  A.class_id = '$class_id'";
    }
  }
  else
  {
    $class_id = '';
  }
  if(isset($_GET['sem_id']))
  {
    $sem_id = $_GET['sem_id'];
    if($sem_id!="")
    {
        $crit .= " and sem_id = '$sem_id'";
    }
  }
  else
  {
    $sem_id = '';
  }

  if(isset($_GET['week_id']))
  {
    $week_id = $_GET['week_id'];
    if($week_id!="")
    {
        $crit .= " and week_id = '$week_id'";
    }
  }
  else
  {
    $week_id = '';
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
          
          <form method="get" action="">
             
            <table class="table table-bordered table-condensed">
              <tr>
                <th>Course Name<span style="color:#F00;">*</span></th>
                <th>Sem/Year<span style="color:#F00;">*</span></th>
                <th>Day<span style="color:#F00;">*</span></th>
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
                </script></td>
                 <td>
                  <select name="week_id" id="week_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select Day---</option>

                    <?php
                    $res = $obj->executequery("select * from weeks_name order by week_id asc");
                    foreach($res as $row_get)
                    {
                      ?> 
                      <option value="<?php echo $row_get['week_id']; ?>"> <?php echo $row_get['days_name']; ?></option>                                                     
                    <?php } ?>
                  </select>
                  <script>document.getElementById('week_id').value = '<?php echo $week_id ; ?>';
                </script>
                  <!-- <select name="day_name" id="day_name" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select Day---</option>
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday </option>
                    <option value="wednesday">Wednesday </option>
                    <option value="thursday ">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
                    <option value="sunday">Sunday</option>
                </select>
                  <script>document.getElementById('day_name').value = '<?php echo $day_name ; ?>';
                </script> --></td>
                    
                    <td colspan="4"><input type="submit" name="submit" class="btn btn-success" value="<?php echo $btn_name; ?>" onClick="return checkinputmaster('class_id'); ">
                      <a href="time_table_report.php" class="btn btn-success">Reset</a>
                    </td>
                  </table>
                  <div>
                  </form>
                  <br>
         <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="simple-html-invoice/simple-html-invoice-template-master/pdf_all_student_reg_report.php?class_id=<?php //echo $class_id; ?>&s_sessionid=<?php //echo $s_sessionid; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>
          
          
          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
        </p> -->

         <p align="right" style="margin-top:7px; margin-right:10px;">
          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
        </p> 

        <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
        <table class="table table-bordered" id="tblData">
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
              <th width="18%" class="head0">Subject / Semester</th>
              <?php 
              $sql = "select * from weeks_name order by week_id asc";
              $res = $obj->executequery($sql);
              foreach($res as $row_get2)
              { 
              $week_id = $row_get2['week_id'];
              ?>
              <th><?php echo $row_get2['days_name']; ?></th>
              <?php } ?>  
            </tr>
          </thead>
       
         <tbody id="record">
                           
    <?php
    $sql = "select * from m_subject where class_id='$class_id'";
    $res = $obj->executequery($sql);
    foreach($res as $row_get1)
    {
      $subject_id = $row_get1['subject_id'];
      $sem_id=$obj->getvalfield("m_subject","sem_id","subject_id='$subject_id'");
      $sem_name=$obj->getvalfield("m_semester","sem_name","sem_id='$sem_id'");
     
         ?> 
    <tr>
      <td style="padding: 6px;"><?php echo $row_get1['subject'].' / '.$sem_name; ?></td>

    <?php 
    $sql = "select * from weeks_name order by week_id asc";
    $res = $obj->executequery($sql);
    foreach($res as $row_get)
    {
       
      $week_id = $row_get['week_id'];
      $subject_id = $row_get1['subject_id'];

      $start_time=$obj->getvalfield("time_table_setting as A left join m_subject as B on A.class_id = B.class_id","start_time","$crit and A.subject_id='$subject_id' and week_id='$week_id'");
      $end_time=$obj->getvalfield("time_table_setting as A left join m_subject as B on A.class_id = B.class_id","end_time","$crit and A.subject_id='$subject_id' and week_id='$week_id'");
         
    ?>
    
         <td style="padding: 0px;line-height:30px;">
           <div class="row-fluid">
              <div class="span6" style="text-align: center;border-right:1px solid #ddd;"><?php echo $start_time; ?></div>
              <div class="span6" style="text-align: center;"><?php echo $end_time; ?></div>
           </div>
         </td>
        <?php
        } //outer looop close
        ?>
  </tr>
        <?php
        }//inner looop close
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

    
 
</script>
</body>
</html>
