<?php include("../adminsession.php");
//print_r($_SESSION);die;
 $pagename = "enquiry_master.php";
 $module = "ENQUIRY MASTER";
 $submodule = "Enquiry Master";
 $btn_name = "Save";
 $keyvalue =0 ;
 $tblname = "enquiry_master";
 $tblpkey = "enq_id";
 $dup ="";

$sessionid = $_SESSION['sessionid'];
 if(isset($_GET['enq_id']))
  $keyvalue = $_GET['enq_id'];
else
  $keyvalue = 0;

if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

$enq_name = $mobile = $address = $remark =  $prv_schl = "";

if(isset($_POST['submit']))
{ 

     $dis_id = $obj->test_input($_POST['dis_id']);
     $enq_name = $obj->test_input($_POST['enq_name']);
     $class_id = $obj->test_input($_POST['class_id']);
     $category_id = $obj->test_input($_POST['category_id']);
     $mobile = $obj->test_input($_POST['mobile']);
     $address = $obj->test_input($_POST['address']);
     $prv_schl = $obj->test_input($_POST['prv_schl']);
     $remark = $obj->test_input($_POST['remark']);
     $con_id = $obj->test_input($_POST['con_id']);
     $cwhere = array("enq_name"=>$_POST['enq_name']);
     $count = $obj->count_method("enquiry_master",$cwhere);
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
      $form_data = array('dis_id'=>$dis_id,'enq_name'=>$enq_name,'class_id'=>$class_id,'category_id'=>$category_id,'mobile'=>$mobile,'address'=>$address,'prv_schl'=>$prv_schl,'remark'=>$remark,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sessionid'=>$sessionid,'con_id'=>$con_id);
      $obj->insert_record($tblname,$form_data); 
           //print_r($form_data); die;
      $action = 1;
      $process = "insert";
      echo "<script>location='$pagename?action=$action'</script>";
    }
    else{
          //update
      $form_data = array('dis_id'=>$dis_id,'enq_name'=>$enq_name,'class_id'=>$class_id,'category_id'=>$category_id,'mobile'=>$mobile,'address'=>$address,'prv_schl'=>$prv_schl,'remark'=>$remark,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'sessionid'=>$sessionid,'con_id'=>$con_id);
      $where = array($tblpkey=>$keyvalue);
      $keyvalue = $obj->update_record($tblname,$where,$form_data);
      $action = 2;
      $process = "updated";
      echo "<script>location='$pagename?action=$action'</script>";
    }

}

}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $dis_id =  $sqledit['dis_id'];
  $enq_name =  $sqledit['enq_name'];
  $class_id =  $sqledit['class_id'];
  $category_id =  $sqledit['category_id'];
  $mobile =  $sqledit['mobile'];
  $address =  $sqledit['address'];
  $prv_schl =  $sqledit['prv_schl'];
  $remark =  $sqledit['remark'];
  $con_id = $sqledit['con_id'];
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
          <form class="" method="POST" action="">
            <?php echo  $dup;  ?>
            <table class="table table-bordered table-condensed">
              <tr>
                <th>Name<span style="color:#F00;">*</th>
                <th>Mobile<span style="color:#F00;">*</th>
                <th>District Name<span style="color:#F00;">*</th>
                <th>Address<span style="color:#F00;">*</th>
              </tr>
              <tr>
                <td>
                  <input type="text" name="enq_name" id="enq_name" value="<?php echo $enq_name; ?>" class="input-xxlarge" placeholder="Enter Name" autofocus autocomplete="off" style="width:200px;">
                </td>
                <td>
                  <input type="text" name="mobile" id="mobile" value="<?php echo $mobile; ?>" class="input-xxlarge" placeholder="Enter Mobile No." autofocus autocomplete="off" maxlength="10" style="width:200px;">
                </td>
                <td>
                  <select name="dis_id" id="dis_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("m_district");
                    foreach($res as $row_get)
                    {
                      ?> 
                      <option value="<?php echo $row_get['dis_id']; ?>"> <?php echo $row_get['dis_name']; ?></option>                                                     
                    <?php } ?>
                  </select>
                  <script>document.getElementById('dis_id').value = '<?php echo $dis_id ; ?>';
                </script>
                 <td>
                      <input type="text" name="address" id="address" value="<?php echo $address; ?>" class="input-xxlarge" placeholder="Enter Address" autofocus autocomplete="off" style="width:200px;">
                    </td>
                  <tr>
                    <th>Previous School/College<span style="color:#F00;">*</th>
                    <th>Course<span style="color:#F00;">*</th>
                    <th>Category<span style="color:#F00;">*</th>
                    <th>Counselor Name<span style="color:#F00;">*</th>
                    
                  </tr>
                  <tr>
                  <td>
                      <input type="text" name="prv_schl" id="prv_schl" value="<?php echo $prv_schl; ?>" class="input-xxlarge" placeholder="Prevoius School or College" autofocus autocomplete="off" style="width:200px;">
                    </td>
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
                    </td> <td>
                      <select name="category_id" id="category_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("m_category");
                    foreach($res as $row_get)
                    {
                      ?> 
                      <option value="<?php echo $row_get['category_id']; ?>"> <?php echo $row_get['cat_name']; ?></option>                                                     
                    <?php } ?>
                    </select>
                    <script>document.getElementById('category_id').value = '<?php echo $category_id ; ?>';
                  </script>
                    </td> 
                    <td>
                      <select name="con_id" id="con_id" style="width:200px;" class="chzn-select">
                    <option value="" disabled selected>---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("counselor_master");
                    foreach($res as $row_get)
                    {
                      ?> 
                      <option value="<?php echo $row_get['con_id']; ?>"> <?php echo $row_get['counselor_name']; ?></option>                                                     
                    <?php } ?>
                  </select>
                  <script>document.getElementById('con_id').value = '<?php echo $con_id ; ?>';
                </script>
                    </td>
                    
                  </tr>
                  <tr>
                  <th colspan="4">Remark</th>
                  </tr>
                  <tr>
                  <td colspan="4">
                      <textarea name="remark" id="remark" placeholder="Enter Remark" style="width:96%;" autofocus autocomplete="off"><?php echo $remark; ?></textarea>
                    </td>
                  </tr>
                    <tr>
                    <td colspan="4"><input type="submit" name="submit" class="btn btn-primary" value="<?php echo $btn_name; ?>" onClick="return checkinputmaster('enq_name,mobile,dis_id,address,prv_schl,class_id,category_id,con_id'); ">
                      <a href="enquiry_master.php" class="btn btn-success">Reset</a></td>
                    </tr>
                  </table>
                  <div>
                  </form>
                  <br>
          <p align="right" style="margin-top:7px; margin-right:10px;">
          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
        </p> 

        <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
        <table class="table table-bordered" id="tblData">
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

              <th width="11%" class="head0 nosort">Sno.</th>
              <th width="18%" class="head0">Name</th>
              <th width="18%" class="head0">Mobile</th>
              <th width="18%" class="head0">District Name</th>
              <th width="18%" class="head0">Address</th>
              <th width="18%" class="head0">Previous School/College</th>
              <th width="18%" class="head0">Course</th>
              <th width="18%" class="head0">Category</th>
              <th width="18%" class="head0">Counselor Name</th>
              <th width="18%" class="head0">Remark</th>
              <?php  $chkedit = $obj->check_editBtn("enquiry_master.php",$loginid);              

              if($chkedit == 1 || $loginid == 1){  ?>
              <th width="9%" class="head0">Edit</th>
              <?php  } $chkdel = $obj->check_delBtn("enquiry_master.php",$loginid);             

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
          $res = $obj->executequery("select * from  enquiry_master order by enq_id desc");
          foreach($res as $row_get)
          {
            $course_name = $obj->getvalfield("m_class","class_name","class_id = '$row_get[class_id]'");
            $category_name = $obj->getvalfield("m_category","cat_name","category_id='$row_get[category_id]'");
            $disname=$obj->getvalfield("m_district","dis_name","dis_id='$row_get[dis_id];'");

            $counselor_name=$obj->getvalfield("counselor_master","counselor_name","con_id='$row_get[con_id];'");
            ?>   
            <tr>
              <td><?php echo $slno++; ?></td> 
              <td><?php echo $row_get['enq_name']; ?></td>
              <td><?php echo $row_get['mobile']; ?></td>
              <td><?php echo $disname; ?></td>
              <td><?php echo $row_get['address']; ?></td>
              <td><?php echo $row_get['prv_schl']; ?></td>
              <td><?php echo $course_name; ?></td>
              <td><?php echo $category_name; ?></td>
              <td><?php echo $counselor_name; ?></td>
              <td><?php echo $row_get['remark']; ?></td>
              <?php                

                            if($chkedit == 1 || $loginid == 1){  ?>
              <td><a class='icon-edit' title="Edit" href='enquiry_master.php?enq_id=<?php echo $row_get['enq_id'] ; ?>'></a></td>
              <td>
                <?php  } if($chkdel == 1 || $loginid == 1){  ?>
                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['enq_id']; ?>);' style='cursor:pointer'></a>
              </td>
              <?php } ?>
            </tr>

            <?php
          }
          ?>     
        </tbody>
      </table>


      <!--  <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php echo number_format($totalqty,2); ?></h3></div>  --> 
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
