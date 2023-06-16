<?php include("../adminsession.php");
$sessionid = $_SESSION['sessionid'];
//include("../lib/smsinfo.php");

$pagename = "fee_payment.php";

$module = "Fee Payment";

$submodule = "FEE PAYMENT";

$btn_name = "Save";

$keyvalue = 0;

$tblname = "fee_payment";

$tblpkey = "fee_payid";



if (isset($_GET['transferid'])) {

  $transferid = $_GET['transferid'];

  $m_student_reg_id = $obj->getvalfield("class_transfer", "m_student_reg_id", "transferid='$transferid'");
  $sessionid = $obj->getvalfield("class_transfer", "sessionid", "transferid='$transferid'");
} else {

  $transferid = 0;

  $m_student_reg_id = 0;
}


$bank_name='';
$check_no='';


if (isset($_GET['fee_payid'])) {

  $keyvalue = $_GET['fee_payid'];
} else {

  $keyvalue = 0;

  //echo $sessionid;die; 

  $reciept_no = $obj->getcode($tblname, "reciept_no", "sessionid='$sessionid'");
}


if (isset($_GET['action']))

  $action = addslashes(trim($_GET['action']));

else

  $action = "";



if (isset($_GET['is_security']))

  $is_security = addslashes(trim($_GET['is_security']));

else

  $is_security = 0;



if (isset($_GET['class_id'])) {

  $class_id = $_GET['class_id'];
} else {

  $class_id = "";
}


if (isset($_POST['submit'])) {

  //print_r($_POST);die;

  $transferid = $_POST['transferid'];

  $pay_date = $obj->dateformatusa($_POST['pay_date']);

  $paid_amt  = $_POST['paid_amt'];

  $reciept_no = $_POST['reciept_no'];

  $payment_type = $_POST['payment_type'];

  $remark = $_POST['remark'];

  $fee_head_id = $_POST['fee_head_id'];
  $bank_name = $_POST['bank_name'];
  $check_no = $_POST['check_no'];

  $is_security  = isset($_POST['is_security']);



  if ($keyvalue == 0) {

    $form_data = array('transferid' => $transferid, 'pay_date' => $pay_date, 'paid_amt' => $paid_amt, 'reciept_no' => $reciept_no, 'payment_type' => $payment_type, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate, 'sessionid' => $sessionid, 'remark' => $remark, 'fee_head_id' => $fee_head_id, 'is_security' => $is_security,'bank_name'=>$bank_name,'check_no'=>$check_no);

    $obj->insert_record($tblname, $form_data);

    $action = 1;

    $process = "insert";

    if ($is_security > 0) {

      $mobile = $obj->getvalfield("m_student_reg", "mobile", "m_student_reg_id='$m_student_reg_id'");

      //$mobile = "8962796755";

      if (strlen($mobile) == 10) {

        // echo "hii"; die;

        $pay_date = $obj->dateformatindia($pay_date);

        $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");

        $fee_head_name = $obj->getvalfield("m_fee_head", "fee_head_name", "fee_head_id='$fee_head_id'");



        $msg = "Dear $stu_name\nYour Payment Received:-\nReceipt No. $reciept_no\nPayment Date: $pay_date\nFee Head: $fee_head_name\nPayment Amount: $paid_amt\nFrom SAINATH PARAMEDICAL COLLEGE";

        //$ok = 1;

        // $ok = $obj->sendsmsGET($username,$pass,$senderid,$msg,$serverUrl,$mobile);

        //$obj->sendsmsGET($username,$pass,$senderid,$msg,$serverUrl,"9301824171");// 8962796755

        //$ok = $obj->send_sms_indor($mobile,$msg);

        // $obj->send_sms_indor("9301824171",$msg);

        if ($ok) {

          echo "<script>alert('Message sent successfully!');</script>";
        } else {

          //echo $otp .'  ' . $newparichay_id;die;

          echo "<script>alert('Message could not be sent. Sorry!');</script>";
        }

        echo "<script>location='$pagename?action=$action&transferid=$transferid'</script>";
      }
    }
  } else {

    //update

    $form_data = array('transferid' => $transferid, 'pay_date' => $pay_date, 'paid_amt' => $paid_amt, 'reciept_no' => $reciept_no, 'payment_type' => $payment_type, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate, 'remark' => $remark, 'fee_head_id' => $fee_head_id, 'is_security' => $is_security,'bank_name'=>$bank_name,'check_no'=>$check_no);

    $where = array($tblpkey => $keyvalue);

    $obj->update_record($tblname, $where, $form_data);

    $action = 2;

    $process = "updated";
  }

  echo "<script>location='$pagename?action=$action&transferid=$transferid'</script>";
}



if (isset($_GET[$tblpkey])) {



  $btn_name = "Update";

  $where = array($tblpkey => $keyvalue);

  $sqledit = $obj->select_record($tblname, $where);

  $transferid =  $sqledit['transferid'];

  $pay_date =  $obj->dateformatindia($sqledit['pay_date']);

  $paid_amt =  $sqledit['paid_amt'];

  $reciept_no =  $sqledit['reciept_no'];

  $payment_type =  $sqledit['payment_type'];

  $remark = $sqledit['remark'];

  $fee_head_id = $sqledit['fee_head_id'];

  $is_security =  $sqledit['is_security'];
  $bank_name =  $sqledit['bank_name'];
  $check_no =  $sqledit['check_no'];
} else {

  $pay_date = date('d-m-Y');

  $status = "";

  $prev_bal = "";

  $paid_amt = "";

  $bal_amt = "";

  $payment_type = "";

  $remark = "";

  $fee_head_id = "";
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

            <h4 class="widgettitle nomargin shadowed">Widget Title</h4>

            <div style="width:50%;float:left">

              <form class="stdform stdform2" method="post" action="">

                <table class="table table-bordered">

                  <tr>

                    <th>Select Course<span style="color:#F00;">*</span></th>

                    <td> <select name="class_id" id="class_id" class="chzn-select" style="width:283px;" onChange="setpageurlcourse(this.value);">

                        <option value="">-select-</option>

                        <?php

                        $res = $obj->executequery("select * from m_class order by class_id desc");

                        foreach ($res as $row) {



                        ?>

                          <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>

                        <?php

                        }

                        ?>

                      </select>

                      <script>
                        document.getElementById('class_id').value = '<?php echo $class_id; ?>';
                      </script>
                    </td>

                  </tr>

                  <tr>

                    <th>Select Student<span style="color:#F00;">*</span></th>

                    <td> <select name="transferid" id="transferid" class="chzn-select" style="width:283px;" onChange="setpageurlstudent(this.value);">

                        <option value="">-select-</option>

                        <?php

                        $res = $obj->executequery("select * from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id where class_id='$class_id'");

                        foreach ($res as $row) {

                          $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$row[m_student_reg_id]'");

                          $father_name = $obj->getvalfield("m_student_reg", "father_name", "m_student_reg_id='$row[m_student_reg_id]'");

                          $class_id = $obj->getvalfield("m_student_reg", "class_id", "m_student_reg_id='$row[m_student_reg_id]'");

                          $class_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
                          $sem_name = $obj->getvalfield("m_semester", "sem_name", "sem_id='$row[sem_id]'");
                          $semester_name = "<span style='color:red;'>$sem_name</span>";

                        ?>

                          <option value="<?php echo $row['transferid']; ?>"><?php echo $stu_name . " ( " . $class_name . ") C/O: $father_name" . ' / ' ?><?php echo $semester_name; ?></option>

                        <?php

                        }

                        ?>

                      </select>

                      <script>
                        document.getElementById('transferid').value = '<?php echo $transferid; ?>';
                      </script>
                    </td>

                  </tr>



                  <tr>
                    <th>Payment Date<span style="color:#F00;"></span></th>

                    <td><input type="text" name="pay_date" id="pay_date" class="input-xlarge" value="<?php echo $pay_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                  </tr>



                  <tr>
                    <th>Reciept No.<span style="color:#F00;">*</span></th>

                    <td> <input type="text" class="input-xlarge" name="reciept_no" id="reciept_no" value="<?php echo $reciept_no; ?>" data-inputmask="'alias':" placeholder="Reciept Number" />

                    </td>
                  </tr>



                  <tr>

                    <th>Fee Head<span style="color:#F00;"></span></th>

                    <td>

                      <select name="fee_head_id" id="fee_head_id" class="chzn-select" style="width:283px;">

                        <option value="">-select-</option>

                        <?php
                        $res = $obj->executequery("select * from hostel_fee_setting where sessionid='$sessionid' and transferid='$transferid' and total_fee <> 0");

                        foreach ($res as $row) {

                          $fee_head_name = $obj->getvalfield("m_fee_head", "fee_head_name", "fee_head_id='$row[fee_head_id];'");

                          $total_fee = $row['total_fee'];

                        ?>

                          <option value="<?php echo $row['fee_head_id']; ?>">

                            <?php echo strtoupper("$fee_head_name (Rs. $total_fee)"); ?>

                          </option>

                        <?php

                        } ?>

                      </select>

                      <script>
                        document.getElementById('fee_head_id').value = '<?php echo $fee_head_id; ?>';
                      </script>

                    </td>

                  </tr>



                  <tr>

                    <th>Paid Amount<span style="color:#F00;"></span></th>

                    <td> <input type="text" name="paid_amt" id="paid_amt" value="<?php echo $paid_amt; ?>" class="input-xlarge" placeholder="Paid Amount" /></td>
                  </tr>



                  <tr>

                    <th>Remark<span style="color:#F00;"></span></th>

                    <td> <input type="text" name="remark" id="remark" value="<?php echo $remark; ?>" class="input-xlarge" placeholder="Remark" /></td>
                  </tr>



                  <tr>

                    <th>Payment Type<span style="color:#F00;">*</span></th>

                    <td>

                      <select class="chzn-select" style="width:283px;" name="payment_type" id="payment_type" onchange="getid(this.value);">

                        <option value="">-select-</option>

                        <option value="cash">Cash</option>

                        <option value="checque">Cheque</option>

                        <option value="upi">UPI</option>

                      </select>

                      <script>
                        document.getElementById('payment_type').value = '<?php echo $payment_type; ?>';
                      </script>

                    </td>

                  </tr>
                  
               
                  <tr class="b1">

                    <th>Bank Name<span style="color:#F00;"></span></th>

                    <td> <input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" class="input-xlarge" placeholder="Bank Name" /></td>
                  </tr>

                  <tr class="b2">

                    <th>Cheque / UPI No.<span style="color:#F00;"></span></th>

                    <td> <input type="text" name="check_no" id="check_no" value="<?php echo $check_no; ?>" class="input-xlarge" placeholder="Check / UPI No." /></td>
                  </tr>
                
                



                  <tr>

                    <th>Is Send Msg<span style="color:#F00;"></span></th>

                    <td>

                      <input type="checkbox" name="is_security" id="is_security" class="input-xxlarge" value="1" <?php if ($is_security == 1) { ?> checked <?php } ?> />

                    </td>

                  </tr>

                  <tr>

                    <td colspan="2">

                      <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('transferid,pay_date dt,reciept_no,fee_head_id,paid_amt nu,payment_type');">

                        <?php echo $btn_name; ?></button>



                      <a href="fee_payment.php" name="reset" id="reset" class="btn btn-success">Reset</a>
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

                    <th class="head0">Receipt No</th>

                    <th class="head0">Payment Date</th>

                    <th class="head0">Student Name</th>

                    <th class="head0">Course</th>

                    <th class="head0">Paid Amount</th>

                    <th class="head0">Fee Head</th>
                    <th class="head0">Payment Type</th>
                    <th class="head0">Bank Name</th>
                    <th class="head0">Check No.</th>

                    <th class="head0">Print</th>

                    <?php $chkdel = $obj->check_delBtn("fee_payment.php", $loginid);



                    if ($chkdel == 1 || $loginid == 1) {  ?>

                      <th width="5%" class="head0">Delete</th>

                    <?php } ?>

                  </tr>

                </thead>

                <tbody>

                  <?php

                  $slno = 1;
                  $res = $obj->executequery("select * from fee_payment where transferid = '$transferid' order by fee_payid desc");

                  foreach ($res as $row_get) {

                    $fee_payid = $row_get['fee_payid'];

                    $fee_head_id = $row_get['fee_head_id'];

                    $transferid = $row_get['transferid'];

                    $studentinfo = $obj->studentinfo1($transferid);

                  ?>

                    <tr>

                      <td><?php echo $slno++; ?></td>

                      <td><?php echo $row_get['reciept_no']; ?></td>

                      <td><?php echo $obj->dateformatindia($row_get['pay_date']); ?></td>

                      <td><?php echo $studentinfo['stu_name']; ?></td>

                      <td><?php echo $studentinfo['class_name']; ?></td>

                      <td><?php echo number_format($row_get['paid_amt'], 2); ?></td>

                      <?php $fee_head_name = $obj->getvalfield("m_fee_head", "fee_head_name", "fee_head_id='$fee_head_id'"); ?>

                      <td><?php echo $fee_head_name; ?></td>
                      <td><?php echo $row_get['payment_type']; ?></td>
                      <td><?php echo $row_get['bank_name']; ?></td>
                      <td><?php echo $row_get['check_no']; ?></td>

                      <td><a class="btn btn-danger" href="pdf_fee_slip.php?fee_payid=<?php echo $fee_payid; ?>" target="_blank">Print</a></td>

                      <?php if ($chkdel == 1 || $loginid == 1) {  ?>

                        <td>

                          <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $fee_payid; ?>);' style='cursor:pointer'></a>

                        </td>

                      <?php } ?>

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

   /* jQuery(document).ready(function() { 
     jQuery('tr.b1').hide();
      jQuery('tr.b2').hide();
}*/

function getid(payment_type)
{
  if(payment_type=='cash')
  {
      jQuery('tr.b1').hide();
      jQuery('tr.b2').hide();
  }
  else
  {
    jQuery('tr.b1').show();
      jQuery('tr.b2').show();
  }
}
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

            //alert(data);

            // location='<?php echo $pagename . "?action=3"; ?>';

            location = '<?php echo $pagename . "?transferid=$transferid"; ?>';

          }



        }); //ajax close

      } //confirm close

    } //fun close




    jQuery('#pay_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });

    jQuery('#pay_date').focus();



    function getdetails(transferid)

    {

      if (transferid != '' || !isNaN(transferid))

      {

        jQuery.ajax({

          type: 'POST',

          url: 'getpaymentdetail.php',

          data: 'transferid=' + transferid,

          dataType: 'html',

          success: function(data) {

            //alert(data);



            jQuery('#showrecord').html(data);

          }



        }); //ajax close

      }

    }







    function setpageurlcourse(class_id)

    {

      var url = 'fee_payment.php?class_id=' + class_id;

      location = url;

    }



    function setpageurlstudent(transferid)

    {

      var class_id = '<?php echo $class_id; ?>';

      var url = 'fee_payment.php?transferid=' + transferid + '&class_id=' + class_id;

      location = url;

    }



    <?php

    if (isset($_GET['transferid']) && $_GET['transferid'] > 0) { ?>

      getdetails(<?php echo $_GET['transferid']; ?>);

    <?php

    }

    ?>
  </script>

</body>



</html>