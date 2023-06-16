<?php include("../adminsession.php");

$pagename = "income_head.php";

$module = "Income Master";

$submodule = "INCOME MASTER";

$btn_name = "Save";

$keyvalue = 0;

$tblname = "m_expanse_group";

$tblpkey = "ex_group_id";

$type = 'income';

if (isset($_GET['ex_group_id']))

   $keyvalue = $obj->test_input($_GET['ex_group_id']);

else

   $keyvalue = 0;

if (isset($_GET['action']))

   $action = $obj->test_input($_GET['action']);

else

   $action = "";


$dup = "";

$group_name = "";

$status = 1;

if (isset($_POST['submit'])) { //print_r($_POST); die;



   $group_name = $obj->test_input($_POST['group_name']);

   $status = $obj->test_input($_POST['status']);

   $type = "income";

   //check Duplicate

   $cwhere = array("group_name" => $group_name, "status" => $status, "type" => $type);

   $count = $obj->count_method("m_expanse_group", $cwhere);

   if ($count > 0 && $keyvalue == 0) {

      /*$dup = " Error : Duplicate Record";*/

      $dup = "<div class='alert alert-danger'>

      <strong>Error!</strong> Error : Duplicate Record.

      </div>";
   } else {

      //insert

      if ($keyvalue == 0) {

         $form_data = array('group_name' => $group_name, 'status' => $status, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate, 'type' => $type);

         $obj->insert_record($tblname, $form_data);

         //print_r($form_data); die;

         $action = 1;

         $process = "insert";

         echo "<script>location='$pagename?action=$action'</script>";
      } else {

         //update

         $form_data = array('group_name' => $group_name, 'status' => $status, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate);

         $where = array($tblpkey => $keyvalue);

         $keyvalue = $obj->update_record($tblname, $where, $form_data);

         $action = 2;

         $process = "updated";
      }

      echo "<script>location='$pagename?action=$action'</script>";
   }
}

if (isset($_GET[$tblpkey])) {



   $btn_name = "Update";

   $where = array($tblpkey => $keyvalue);

   $sqledit = $obj->select_record($tblname, $where);

   $group_name =  $sqledit['group_name'];

   $status =  $sqledit['status'];
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

                     <?php echo  $dup;  ?>

                     <div class="lg-12 md-12 sm-12">

                        <table class="table table-bordered">

                           <tr>

                              <th>Income Group Name<span style="color:#F00;">*</span></th>

                              <th>Status<span style="color:#F00;">*</span></th>

                           </tr>

                           <tr>

                              <td><input type="text" name="group_name" id="group_name" class="input-xlarge" value="<?php echo $group_name; ?>" autofocus autocomplete="off" placeholder="Enter Name" />

                              </td>



                              <td><select class="chzn-select input-xlarge" name="status" id="status" autocomplete="off" autofocus>

                                    <option value="" disabled selected>-----Select----</option>

                                    <option value="1">Enable</option>

                                    <option value="0">Disable</option>

                                 </select>

                                 <script type="text/javascript">
                                    document.getElementById('status').value = '<?php echo $status; ?>';
                                 </script>

                              </td>



                              <td><button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('group_name,status'); ">

                                    <?php echo $btn_name; ?></button>

                                 <a href="income_head.php" name="reset" id="reset" class="btn btn-success">Reset</a>

                                 <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                              </td>

                           </tr>



                        </table>

                     </div>

                  </form>

               </div>









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

                        <th width="18%" class="head0">Income Name</th>

                        <th width="18%" class="head0">Status</th>

                        <?php $chkedit = $obj->check_editBtn("income_head.php", $loginid);



                        if ($chkedit == 1 || $loginid == 1) {  ?>

                           <th width="9%" class="head0">Edit</th>

                        <?php  }
                        $chkdel = $obj->check_delBtn("income_head.php", $loginid);

                        if ($chkdel == 1 || $loginid == 1) {  ?>

                           <th width="10%" class="head0">Delete</th>

                        <?php } ?>

                     </tr>

                  </thead>

                  <tbody>



                     <?php

                     $slno = 1;



                     $res = $obj->executequery("select * from m_expanse_group where type = 'income' order by ex_group_id desc");

                     foreach ($res as $row_get) {

                     ?>

                        <tr>

                           <td><?php echo $slno++; ?></td>

                           <td><?php echo $row_get['group_name']; ?></td>

                           <td align="center">

                              <?php if ($row_get['status'] == 1) echo "<span style='color:green'> Enable </span> ";
                              else echo "<span style='color:Red'> Disable </span> "; ?>

                           </td>

                           <?php



                           if ($chkedit == 1 || $loginid == 1) {  ?>

                              <td><a class='icon-edit' title="Edit" href='income_head.php?ex_group_id=<?php echo $row_get['ex_group_id']; ?>'></a></td>

                           <?php  }
                           if ($chkdel == 1 || $loginid == 1) {  ?>

                              <td>

                                 <a class='icon-remove' title="Delete" onclick="funDel(<?php echo $row_get['ex_group_id']; ?>);" style='cursor:pointer'></a>

                              </td>

                           <?php } ?>

                        </tr>



                     <?php

                     }

                     ?>

                  </tbody>

               </table>





            </div>
            <!--contentinner-->

         </div>
         <!--maincontent-->







      </div>

      <!--mainright-->

      <!-- END OF RIGHT PANEL -->



      <div class="clearfix"></div>

      <?php include("inc/footer.php"); ?>

      <!--footer-->





   </div>
   <!--mainwrapper-->

   <script>
      function funDel(id)

      { //alert(id);   

         tblname = '<?php echo $tblname; ?>';

         tblpkey = '<?php echo $tblpkey; ?>';

         pagename = '<?php echo $pagename; ?>';

         submodule = '<?php echo $submodule; ?>';

         module = '<?php echo $module; ?>';

         //alert(module); 

         if (confirm("Are you sure! You want to delete this record."))

         {

            jQuery.ajax({

               type: 'POST',

               url: 'ajax/delete_master.php',

               data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,

               dataType: 'html',

               success: function(data) {

                  // alert(data);

                  location = '<?php echo $pagename . "?action=3"; ?>';

               }



            }); //ajax close

         } //confirm close

      } //fun close
   </script>

</body>

</html>