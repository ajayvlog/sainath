<?php include("../adminsession.php");
$pagename = "employee_transaction.php";
$module = "Employee Transaction";
$submodule = "EMPLOYEE TRANSACTION";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "emp_trancaction";
$tblpkey = "emp_tran_id";

if (isset($_GET['employee_id'])) {
  $employee_id1 = $_GET['employee_id'];
} else {
  $employee_id1 = 0;
}
$tot_salary_amt = $obj->getvalfield("emp_salary", "sum(netsalary)", "employee_id='$employee_id1'");
$tot_advance_amt = $obj->getvalfield("emp_advance", "sum(amount)", "employee_id='$employee_id1'");
$tot_debit_amt = $obj->getvalfield("emp_trancaction", "sum(paid_amt)", "employee_id='$employee_id1' and payment_type='Debit'");
$bal_amt = $tot_salary_amt - $tot_advance_amt - $tot_debit_amt;

if (isset($_GET['emp_tran_id'])) {
  $keyvalue = $_GET['emp_tran_id'];
} else {
  $keyvalue = 0;
}

if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$paid_amt = "";
$mode = "";
$employee_id = "";
$payment_type = "";
$remark = "";


if (isset($_POST['submit'])) {
  //print_r($_POST);die;
  $employee_id = $_POST['employee_id'];
  $pay_date = $obj->dateformatusa($_POST['pay_date']);
  $paid_amt  = $_POST['paid_amt'];
  $mode = $_POST['mode'];
  $payment_type = $_POST['payment_type'];
  $remark = $_POST['remark'];


  if ($keyvalue == 0) {
    $form_data = array('employee_id' => $employee_id, 'pay_date' => $pay_date, 'paid_amt' => $paid_amt, 'mode' => $mode, 'payment_type' => $payment_type, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate, 'sessionid' => $sessionid, 'remark' => $remark);
    $obj->insert_record($tblname, $form_data);
    $action = 1;
    $process = "insert";
  } else {
    //update
    $form_data = array('employee_id' => $employee_id, 'pay_date' => $pay_date, 'paid_amt' => $paid_amt, 'mode' => $mode, 'payment_type' => $payment_type, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate, 'remark' => $remark);
    $where = array($tblpkey => $keyvalue);
    $obj->update_record($tblname, $where, $form_data);
    $action = 2;
    $process = "updated";
  }
  echo "<script>location='$pagename?action=$action&employee_id=$employee_id'</script>";
}

if (isset($_GET[$tblpkey])) {

  $btn_name = "Update";
  $where = array($tblpkey => $keyvalue);
  $sqledit = $obj->select_record($tblname, $where);
  $employee_id =  $sqledit['employee_id'];
  $pay_date =  $obj->dateformatindia($sqledit['pay_date']);
  $paid_amt =  $sqledit['paid_amt'];
  $mode =  $sqledit['mode'];
  $payment_type =  $sqledit['payment_type'];
  $remark = $sqledit['remark'];
} else {
  $pay_date = date('d-m-Y');
}
?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
  <script type="text/javascript">
    function setpageurl(employee_id) {
      var url = 'employee_transaction.php?employee_id=' + employee_id;
      location = url;
    }


    function getdetails(employee_id) {

      if (employee_id != '' || !isNaN(employee_id)) {
        jQuery.ajax({
          type: 'POST',
          url: 'getemptrans_detail.php',
          data: 'employee_id=' + employee_id,
          dataType: 'html',
          success: function(data) {
            //alert(data);

            jQuery('#showrecord').html(data);
          }

        }); //ajax close
      }
    }

    <?php
    if (isset($_GET['employee_id']) && $_GET['employee_id'] > 0) { ?>
      getdetails(<?php echo $_GET['employee_id']; ?>);
    <?php
    }
    ?>
  </script>


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
            <h4 class="widgettitle nomargin shadowed">Widget Title</h4>
            <div style="width:50%;float:left">
              <form class="stdform stdform2" method="post" action="">
                <table class="table table-bordered">
                  <tr>
                    <th>Select Employee<span style="color:#F00;">*</span></th>
                    <td> <select name="employee_id" id="employee_id" class="chzn-select" style="width:283px;" onChange="setpageurl(this.value);">
                        <option value="">-select-</option>
                        <?php
                        $res = $obj->executequery("select * from m_employee where status='0'");
                        foreach ($res as $row) {

                        ?>
                          <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['emp_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <script>
                        document.getElementById('employee_id').value = '<?php echo $employee_id1; ?>';
                      </script>
                    </td>
                  </tr>

                  <tr>
                    <th>Balance Amount<span style="color:#F00;"></span></th>
                    <td><input type="text" name="bal_amt" id="bal_amt" class="input-xlarge" value="<?php echo $bal_amt; ?>" readonly="readonly" /></td>
                  </tr>
                  <tr>
                    <th>Current Paid Amt<span style="color:#F00;">*</span></th>
                    <td><input type="text" name="paid_amt" id="paid_amt" class="input-xlarge" autocomplete="off" value="<?php echo $paid_amt; ?>" placeholder="Current Paid Amt" /></td>
                  </tr>
                  <tr>
                    <th>Payment Date<span style="color:#F00;">*</span></th>
                    <td><input type="text" name="pay_date" id="pay_date" class="input-xlarge" value="<?php echo $pay_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                  </tr>

                  <tr>
                    <th>Mode<span style="color:#F00;">*</span></th>
                    <td>
                      <select class="chzn-select" style="width:283px;" name="mode" id="mode">
                        <option value="">-select-</option>
                        <option value="CASH">CASH</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="NEFT">NEFT</option>
                        <option value="GOOGLE">GOOGLE</option>
                      </select>
                      <script>
                        document.getElementById('mode').value = '<?php echo $mode; ?>';
                      </script>
                    </td>
                  </tr>

                  <tr>
                    <th>Payment Type<span style="color:#F00;">*</span></th>
                    <td>
                      <select class="chzn-select" style="width:283px;" name="payment_type" id="payment_type">
                        <option value="">-select-</option>
                        <option value="Debit">Debit(Pay To)</option>
                        <option value="Credit">Credit(Received From)</option>

                      </select>
                      <script>
                        document.getElementById('payment_type').value = '<?php echo $payment_type; ?>';
                      </script>
                    </td>
                  </tr>

                  <tr>
                    <th>Remark<span style="color:#F00;"></span></th>
                    <td> <input type="text" name="remark" id="remark" value="<?php echo $remark; ?>" class="input-xlarge" placeholder="Remark" autocomplete="off" /></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('employee_id,paid_amt nu,pay_date dt,mode,payment_type');">
                        <?php echo $btn_name; ?></button>

                      <a href="employee_transaction.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                    </td>
                  </tr>
                </table>
              </form>
            </div>

            <div style="width:46%;float:right;">
              <div id="showrecord">
                Data will loading after student selection...
              </div>
            </div>
            <div class="clearfix"></div>
            <hr>

            <div class="row-fluid">
              <table class="table table-bordered" id="dyntable">
                <thead>
                  <tr>
                    <th class="head0 nosort">Sno.</th>
                    <th class="head0">Employee_Name</th>
                    <th class="head0">Current_Amt</th>
                    <th class="head0">Payment_Date</th>
                    <th class="head0">Mode</th>
                    <th class="head0">Payment Type</th>
                    <th class="head0">Remark</th>
                    <th class="head0">Print</th>
                    <?php $chkdel = $obj->check_delBtn("employee_advance.php", $loginid);

                    if ($chkdel == 1 || $loginid == 1) {  ?>
                      <th width="5%" class="head0">Delete</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $slno = 1;

                  $res = $obj->executequery("select * from emp_trancaction where employee_id = '$employee_id1' order by emp_tran_id desc");
                  foreach ($res as $row_get) {

                    $employee_id = $row_get['employee_id'];
                    $emp_tran_id = $row_get['emp_tran_id'];
                    $emp_name = $obj->getvalfield("m_employee", "emp_name", "employee_id='$employee_id'");
                    $paid_amt = $row_get['paid_amt'];
                    $payment_type = $row_get['payment_type'];
                    if ($payment_type == "Credit") {
                      $payment_type1 = "Received From";
                    } else {
                      $payment_type1 = "Pay To";
                    }


                  ?>
                    <tr>
                      <td><?php echo $slno++; ?></td>
                      <td><?php echo $emp_name; ?></td>
                      <td><?php echo number_format($row_get['paid_amt'], 2); ?></td>
                      <td><?php echo $obj->dateformatindia($row_get['pay_date']); ?></td>
                      <td><?php echo $row_get['mode']; ?></td>
                      <td><?php echo $payment_type1; ?></td>
                      <td><?php echo $row_get['remark']; ?></td>
                      <td><a class="btn btn-danger" href="pdf_employee_payslip.php?emp_tran_id=<?php echo $emp_tran_id; ?>" target="_blank">Print</a></td>
                      <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['emp_tran_id']; ?>);' style='cursor:pointer'></a>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

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
    function funDel(id) {
      //alert(id);   
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
            //alert(data);
            // location='<?php echo $pagename . "?action=3"; ?>';
            location = '<?php echo $pagename . "?employee_id=$employee_id"; ?>';
          }

        }); //ajax close
      } //confirm close
    } //fun close


    jQuery('#pay_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#pay_date').focus();
  </script>
</body>

</html>