<?php include("../adminsession.php");
$pagename = "expanse_group_entry.php";
$module = "Expense Master";
$submodule = "EXPENSE ENTRY MASTER";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "expanse";
$tblpkey = "expanse_id";

if (isset($_GET['expanse_id']))
  $keyvalue = $_GET['expanse_id'];
else
  $keyvalue = 0;
if (isset($_GET['action']))
  $action = $obj->test_input($_GET['action']);
else
  $action = "";
$status = "";
$dup = "";
$ex_group_id = "";
$exp_name = "";
$exp_date = date('d-m-Y');
$exp_amount = "";
$mode = "";
$voucher_no = "";
$remark = "";
$pay_type = "";
if (isset($_POST['submit'])) { //print_r($_POST); die;

  $ex_group_id = $obj->test_input($_POST['ex_group_id']);
  $exp_name = $obj->test_input($_POST['exp_name']);
  $exp_date = $obj->dateformatusa($_POST['exp_date']);
  $exp_amount = $obj->test_input($_POST['exp_amount']);
  $mode = $obj->test_input($_POST['mode']);
  $voucher_no = $obj->test_input($_POST['voucher_no']);
  $remark = $obj->test_input($_POST['remark']);
  $pay_type = $obj->test_input($_POST['pay_type']);
  $type = "expense";
  //check Duplicate
  $cwhere = array("ex_group_id" => $ex_group_id, "exp_name" => $exp_name, "exp_date" => $exp_date, "exp_amount" => $exp_amount, "mode" => $mode, "remark" => $remark, "type" => $type);
  $count = $obj->count_method("expanse", $cwhere);
  if ($count > 0 && $keyvalue == 0) {
    /*$dup = " Error : Duplicate Record";*/
    $dup = "<div class='alert alert-danger'>
      <strong>Error!</strong> Error : Duplicate Record.
      </div>";
  } else {
    //insert
    if ($keyvalue == 0) {
      $form_data = array('ex_group_id' => $ex_group_id, 'exp_name' => $exp_name, 'voucher_no' => $voucher_no, 'exp_date' => $exp_date, 'exp_amount' => $exp_amount, 'mode' => $mode, 'remark' => $remark, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate, 'pay_type' => $pay_type, 'type' => $type);
      $obj->insert_record($tblname, $form_data);
      //print_r($form_data); die;
      $action = 1;
      $process = "insert";
      echo "<script>location='$pagename?action=$action'</script>";
    } else {
      //update
      $form_data = array('ex_group_id' => $ex_group_id, 'exp_name' => $exp_name, 'voucher_no' => $voucher_no, 'exp_date' => $exp_date, 'exp_amount' => $exp_amount, 'mode' => $mode, 'remark' => $remark, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate, 'pay_type' => $pay_type);
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
  $ex_group_id =  $sqledit['ex_group_id'];
  $exp_name =  $sqledit['exp_name'];
  $exp_date =  $obj->dateformatindia($sqledit['exp_date']);
  $exp_amount =  $sqledit['exp_amount'];
  $mode =  $sqledit['mode'];
  $voucher_no =  $sqledit['voucher_no'];
  $remark =  $sqledit['remark'];
  $pay_type = $sqledit['pay_type'];
} else {
  $voucher_no = $obj->getvoucher($tblname,"voucher_no","1=1 and type='expense'");
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
                    <th>Expense Group Name:<span style="color:#F00;">*</span></th>
                    <th>Expense Name:<span style="color:#F00;">*</span></th>

                    <th>Date:<span style="color:#F00;">*</span></th>

                  </tr>
                  <tr>
                    <td><select name="ex_group_id" id="ex_group_id" style="width:285px;" class="chzn-select input-xlarge">
                        <option value="">---Select---</option>
                        <?php
                        $slno = 1;
                        $res = $obj->executequery("select * from m_expanse_group where type = 'expense'");
                        foreach ($res as $row_get) {
                        ?>
                          <option value="<?php echo $row_get['ex_group_id']; ?>"> <?php echo $row_get['group_name']; ?></option>
                        <?php } ?>
                      </select>
                      <script>
                        document.getElementById('ex_group_id').value = '<?php echo $ex_group_id; ?>';
                      </script>
                    </td>

                    <td> <input type="text" name="exp_name" id="exp_name" class="input-xlarge" value="<?php echo $exp_name; ?>" autofocus autocomplete="off" placeholder="Enter Name" /></td>

                    <td> <input type="text" name="exp_date" id="exp_date" class="input-xlarge" value="<?php echo $exp_date; ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>

                  </tr>
                  <tr>
                    <th>Amount<span style="color:#F00;">*</span></th>
                    <th>Mode<span style="color:#F00;">*</span></th>
                    <th>Pay Type<span style="color:#F00;">*</span></th>
                  </tr>
                  <tr>
                    <td> <input type="text" name="exp_amount" id="exp_amount" class="input-xlarge" value="<?php echo $exp_amount; ?>" autofocus autocomplete="off" placeholder="Enter Amount" /></td>

                    <td><select class="chzn-select input-xlarge" name="mode" id="mode" style="width:285px;" autocomplete="off" autofocus>
                        <option value="">--Select--</option>
                        <option value="cash">Cash</option>
                        <option value="checque">Checque</option>
                        <option value="upi">UPI</option>
                      </select>
                      <script type="text/javascript">
                        document.getElementById('mode').value = '<?php echo $mode; ?>';
                      </script>
                    </td>

                    <td> <select class="chzn-select input-xlarge" name="pay_type" id="pay_type" style="width:285px;" autocomplete="off" autofocus>
                        <option value="">--Select--</option>
                        <option value="Received">Received</option>
                        <option value="Payment">Payment</option>

                      </select>
                      <script type="text/javascript">
                        document.getElementById('pay_type').value = '<?php echo $pay_type; ?>';
                      </script>
                    </td>
                  </tr>

                  <tr>
                    <th>Voucher No.<span style="color:#F00;"></span></th>
                    <th>Remark<span style="color:#F00;"></span></th>
                    <th colspan="2"></th>
                  </tr>
                  <tr>
                    <td> <input type="text" name="voucher_no" id="voucher_no" readonly="" class="input-xlarge" value="<?php echo $voucher_no; ?>" autofocus autocomplete="off" placeholder="Enter Voucher number"/></td>
                    <td> <input type="text" name="remark" id="remark" class="input-xlarge" value="<?php echo $remark; ?>" autofocus autocomplete="off" placeholder="Enter Remark" /></td>
                    <td colspan="3"><button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('ex_group_id,exp_name,exp_date,exp_amount,mode,pay_type'); ">
                        <?php echo $btn_name; ?></button>
                      <a href="expanse_group_entry.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                    </td>
                  </tr>

                </table>
              </div>
            </form>
          </div>

          <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
          <table class="table table-bordered table-condensed" id="dyntable">
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

                <th class="head0 nosort">Sno.</th>
                <th class="head0">Expense Name</th>
                <th class="head0">Expense Group Name</th>
                <th class="head0">Date</th>
                <th class="head0">Mode</th>
                <th class="head0">Pay Type</th>
                <th class="head0">VoucherNo.</th>
                <th class="head0" style="text-align: right;">Amount</th>

                <th class="head0">Remark</th>
                <th class="head0">Print</th>
                <?php $chkedit = $obj->check_editBtn("expanse_group_entry.php", $loginid);

                if ($chkedit == 1 || $loginid == 1) {  ?>
                  <th class="head0">Edit</th>
                <?php  }
                $chkdel = $obj->check_delBtn("expanse_group_entry.php", $loginid);
                if ($chkdel == 1 || $loginid == 1) {  ?>
                  <th class="head0">Delete</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              </span>
              <?php
              $slno = 1;
              //$res = $obj->fetch_record("m_city");
              $res = $obj->executequery("select * from expanse where type='expense' order by expanse_id desc");
              foreach ($res as $row_get) {
                $ex_group_id = $row_get['ex_group_id'];
                $groupname = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id='$ex_group_id'");
              ?>
                <tr>
                  <td><?php echo $slno++; ?></td>
                  <td><?php echo $groupname; ?></td>
                  <td><?php echo $row_get['exp_name']; ?></td>
                  <td><?php echo $obj->dateformatindia($row_get['exp_date']); ?></td>
                  <td><?php echo $row_get['mode']; ?></td>
                  <td><?php echo $row_get['pay_type']; ?></td>
                  <td><?php echo $row_get['voucher_no']; ?></td>
                  <td style="text-align: right;"><?php echo number_format($row_get['exp_amount'], 2); ?></td>

                  <td><?php echo $row_get['remark']; ?></td>
                  <td><a class="btn btn-danger" href="pdf_expanse_voucher.php?expanse_id=<?php echo $row_get['expanse_id']; ?>&type=<?php echo $row_get['type']; ?>" target="_blank">Print</a></td>
                  <?php

                  if ($chkedit == 1 || $loginid == 1) {  ?>
                    <td><a class='icon-edit' title="Edit" href='expanse_group_entry.php?expanse_id=<?php echo $row_get['expanse_id']; ?>'></a></td>
                  <?php  }
                  if ($chkdel == 1 || $loginid == 1) {  ?>
                    <td>
                      <a class='icon-remove' title="Delete" onclick="funDel(<?php echo $row_get['expanse_id']; ?>);" style='cursor:pointer'></a>
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

    jQuery('#exp_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });

    jQuery('#exp_date').focus();
  </script>
</body>

</html>