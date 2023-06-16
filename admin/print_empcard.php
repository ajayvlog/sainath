<?php include("../adminsession.php");
$pagename = "print_empcard.php";
$module = "Print Employee Card";
$submodule = "PRINT EMPLOYEE CARD";
$btn_name = "Save";
$keyvalue = 0;
//$tblname = "m_class";
//$tblpkey = "class_id";
// if(isset($_GET['class_id']))
// $keyvalue = $_GET['class_id'];
// else
// $keyvalue = 0;
if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

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
              <tr>

                <th width="11%" class="head0 nosort">Sno.</th>
                <th width="18%" class="head0">Employee Name</th>
                <th width="18%" class="head0">Post</th>
                <th width="15%" class="head0">Mobile</th>
                <th width="15%" class="head0">DOB</th>
                <th width="15%" class="head0">Join_Date</th>
                <th width="15%" class="head0">Basic_Salary</th>
                <th width="15%" class="head0">status</th>
                <th class="head0">Action</th>
                <!--  <th width="9%" class="head0">Edit</th>
                            <th width="10%" class="head0">Delete</th>  -->
              </tr>
            </thead>
            <tbody>
              </span>
              <?php
              $slno = 1;
              //$res = $obj->fetch_record("m_city");
              $res = $obj->executequery("select * from m_employee where status='0' order by employee_id desc");
              foreach ($res as $row_get) {
                $employee_id = $row_get['employee_id'];
                $status = $row_get['status'];
                if ($status == 0) {
                  $status = "enable";
                } else {
                  $status = "disable";
                }
              ?>
                <tr>
                  <td><?php echo $slno++; ?></td>
                  <td><?php echo $row_get['emp_name']; ?></td>
                  <td><?php echo $row_get['post']; ?></td>
                  <td><?php echo $row_get['mobile']; ?></td>
                  <td><?php echo $obj->dateformatindia($row_get['dob']); ?></td>
                  <td><?php echo $obj->dateformatindia($row_get['join_date']); ?></td>
                  <td><?php echo $row_get['basic_salary']; ?></td>
                  <td><?php echo $status; ?></td>
                  <td><a class="btn btn-danger" href="pdf_empcard.php?employee_id=<?php echo  $employee_id; ?>" target="_blank">Print Card</a></td>
                  <!-- <td><a class='icon-edit' title="Edit" href='m_class.php?class_id=<?php //echo $row_get['class_id'] ; 
                                                                                        ?>'></a></td>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php //echo $row_get['class_id']; 
                                                                              ?>);' style='cursor:pointer'></a>
                        </td> -->
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
    function funDel(id) { //alert(id);   
      tblname = '<?php echo $tblname; ?>';
      tblpkey = '<?php echo $tblpkey; ?>';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';
      //alert(module); 
      if (confirm("Are you sure! You want to delete this record.")) {
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