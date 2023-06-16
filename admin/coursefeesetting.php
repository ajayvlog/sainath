<?php include("../adminsession.php");
$pagename = "coursefeesetting.php";
$module = "Course Fee Setting";
$submodule = "COURSE FEE SETTING";
$btn_name = "Update";
$keyvalue = 0;
$tblname = "course_fee_setting";
$tblpkey = "course_fee_set_id";



if(isset($_GET['class_id']))
$class_id = $_GET['class_id'];
else
$class_id = 0;

if(isset($_GET['sem_id']))
$sem_id = $_GET['sem_id'];
else
$sem_id = 0;


// if(isset($_GET['paper_set_id']))
// $keyvalue = $_GET['paper_set_id'];
// else
// $keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
// $choosed=0;






if(isset($_POST['submit']))
{
 $class_id = $_POST['h_class_id'];
 $sem_id = $_POST['h_sem_id'];
 $fee_head_id_arr = $_POST['fee_head_id'];
 $total_fee_arr = $_POST['total_fee'];
 
 
      $total = count($fee_head_id_arr);
      if($total > 0)
           {
            //delete record 
          $where = array('class_id'=>$class_id, 'sem_id'=>$sem_id, 'sessionid'=>$sessionid);
          $obj->delete_record($tblname,$where);
          for($i=0;$i<$total;$i++)

      {

      $fee_head_id = $fee_head_id_arr[$i];
      $total_fee = $total_fee_arr[$i];
//insert record
      $form_data = array('fee_head_id'=>$fee_head_id,'total_fee'=>$total_fee,'class_id'=>$class_id, 'sem_id'=>$sem_id,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sessionid'=>$sessionid);
      $obj->insert_record($tblname,$form_data);
      }//for loop close
          }//if close
      $action=1;
      $process = "insert";
      echo "<script>location='$pagename?action=$action&class_id=$class_id&sem_id=$sem_id'</script>";
              
                
}//if(isset)close

//update record
if(isset($_GET[$tblpkey]))
{ 

    $btn_name = "Update";
    $where = array($tblpkey=>$keyvalue);
    $sqledit = $obj->select_record($tblname,$where);
    $monthid =  $sqledit['monthid'];
    $year =  $sqledit['year'];
    
}

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
                     <h4 class="widgettitle">Year / Semester Wise Fee Setting</h4>
                            <table class="table table-bordered">
                              <tr>
                                <th>Course Name <span class="text-error">*</span></th>
                                <td>
                                  <select name="class_id" id="class_id" class="chzn-select" >
                                <option value=""> Select</option>
                                <?php
                                $slno=1;
                                $res = $obj->executequery("select * from m_class");
                                foreach($res as $row_get)
                                {   
                                ?>
                                <option value="<?php echo $row_get['class_id'];  ?>"><?php echo $row_get['class_name']; ?></option>
                                <?php } ?>
                                </select>
                                <script>  document.getElementById('class_id').value='<?php echo $class_id; ?>'; </script>
                                </td>
                                <th>Year / Semester<span class="text-error">*</span></th>
                                <td>
                                  <select name="sem_id" id="sem_id" class="chzn-select" >
                                <option value=""> Select</option>
                                <?php
                                $slno=1;
                                $res = $obj->executequery("select * from m_semester");
                                foreach($res as $row_get)
                                {   
                                ?>
                                <option value="<?php echo $row_get['sem_id'];  ?>"><?php echo $row_get['sem_name']; ?></option>
                                <?php } ?>
                                </select>
                                <script>  document.getElementById('sem_id').value='<?php echo $sem_id; ?>'; </script>
                                </td>
                                <td><input type="submit" name="search" value="Get Details" class="btn btn-primary" onclick="return checkinputmaster('class_id,sem_id');"></td>
                              </tr>
                            </table>
                        </form>
                            <hr>
                            <?php
                           
                            if($class_id > 0 && $sem_id > 0)
                            { ?>
                        <p>
                                <form class="stdform stdform2" method="post" action="">
                                <table class="table table-bordered" >
                                    <tr >
                                        <th>Slno</th>
                                        <th>Course Name</th>
                                        <th>Total Fee</th>
                                    </tr> 
                                    <tr>
                                        <?php
                                        $res = $obj->executequery("select * from m_fee_head");
                                        $slno = 1;
                                        foreach($res as $row_get)
                                        {   
                                            $fee_head_id = $row_get['fee_head_id'];
                                            $total_fee = $obj->getvalfield("course_fee_setting","total_fee","fee_head_id='$fee_head_id' and class_id='$class_id' and sem_id='$sem_id' and sessionid='$sessionid'");
                                             // $count = $obj->getvalfield("course_fee_setting","count(*)","class_id='$class_id' and 1=1");

                                        ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                                <td><?php echo strtoupper($row_get['fee_head_name']); ?>
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
                            <input type="hidden" name="h_class_id" id="h_class_id" value="<?php echo $class_id; ?>">
                            <input type="hidden" name="h_sem_id" id="h_sem_id" value="<?php echo $sem_id; ?>">
                            </p> </center>

                            <?php } ?>
                        </form>
                    </div>
                     <!--  <?php if($class_id > 0 ) { ?> -->
                   
                 
               <!--  <h4 class="widgettitle"><?php echo $submodule; ?> List</h4> -->
               <!--  <form method="post" action="">
                <table class="table table-bordered">
                    <colgroup>
                        <col class="con0" style="align: center; width: 4%" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr> -->
                            
                            <!-- <th width="11%" class="head0 nosort">Sno.</th>
                            <th width="18%" class="head0">Fee Head</th>
                            <th width="18%" class="head0">Amount</th>
                            
                         </tr>
                    </thead>
                    <tbody>
                           </span> -->
                <!-- <?php
                        $slno=1;
                        //$res = $obj->fetch_record("m_area");
            $res = $obj->executequery("select * from newspaper_master order by newspaper_id desc");
                        foreach($res as $row_get)
                {
                  $newspaper_id = $row_get['newspaper_id'];
                  $rate = $obj->getvalfield("paper_setting_rate","rate","newspaper_id=$newspaper_id and monthid=$monthid and year=$year");
                ?>    -->
                   <!-- <tr>
                        <td><?php echo $slno++; ?></td>
                        <td><?php echo $row_get['newspaper_name']; ?></td>
                        <td><?php echo $row_get['newspaper_name1']; ?></td>
                        
                        <td style="text-align:right;">
                        <input style="text-align:right; width:90%" type="text" id="rate<?php echo $row_get['newspaper_id']; ?>" name="rate[]" value="<?php echo $rate; ?>">
                         <input type="hidden" id="newspaper_id<?php echo $row_get['newspaper_id']; ?>" name="newspaper_id[]" value="<?php echo $row_get['newspaper_id']; ?>"> 

                        </td>
                        
                </tr>
                
                <?php
                }
                ?>      -->
                     </tbody>
                </table>
<br>
                <!-- <center><input  type="submit" name="submit" class="btn btn-primary" value="Update Record"></center> -->
                              
</form>
                <?php } ?>
            </div><!-- contentinner -->
       </div> <!--maincontent-->
        
   
        
    <!-- </div> -->
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    <!--footer-->
      
    
</div><!--mainwrapper-->

  <!--   footer -->
    <div class="clearfix"></div>
    <?php include("inc/footer.php"); ?>


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
function getid(class_id)
 {
    //var customer_id = document.getElementById('customer_id').value;
    location = 'coursefeesetting.php?class_id='+class_id;
 }
  </script>
</body>
</html>
