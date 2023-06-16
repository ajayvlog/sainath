<?php include("../adminsession.php");
//print_r($_SESSION); die;
$transferid = trim(addslashes($_REQUEST['transferid']));
$m_student_reg_id = $obj->getvalfield("class_transfer", "m_student_reg_id", "transferid='$transferid'");

$sessionid = $obj->getvalfield("class_transfer", "sessionid", "transferid='$transferid'");

//$class_id = $obj->getvalfield("m_student_reg","class_id","m_student_reg_id ='$m_student_reg_id'");
$total_paid = $obj->getvalfield("fee_payment
", "sum(paid_amt)", "sessionid ='$sessionid' and transferid = '$m_student_reg_id'");


?>
<style>
    .table-bg {
  background: #3b6998 !important;
  color: white;
}
</style>


<div class="col-lg-6">

    <div class="panel panel-default toggle panelMove panelClose panelRefresh">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title" style="margin: 7px;">&nbsp;<b> Previouse Paid List (Session : <?php echo $obj->getvalfield("m_session", "session_name", "sessionid='$sessionid'"); ?>)</b></h4>

        </div>
        <div class="panel-body" style="height:400px; overflow-y:scroll">

            <table class="table table-hover table-condesed table-bordered" style="background-color: white;">
                 <thead>

                    <th class="per5 table-bg" colspan="2"></th>
                    <th class="per15 table-bg" style="text-align: right;">Total</th>
                    <th class="per15 table-bg" style="text-align: right;">Paid</th>
                    <th class="per15 table-bg" style="text-align: right;">Balance</th>

                </thead>
                <?php

                $res = $obj->executequery("select * from class_transfer where m_student_reg_id = '$m_student_reg_id'");
                foreach ($res as $row_get) {
                    $sessionid1 = $row_get['sessionid'];

                    $sem_name = $obj->getvalfield("m_semester", "sem_name", "sem_id='$row_get[sem_id]'");
                    $total_payment_all = $obj->getvalfield("hostel_fee_setting left join class_transfer on hostel_fee_setting.transferid = class_transfer.transferid", "sum(total_fee)", "sem_id='$row_get[sem_id]' and m_student_reg_id = '$m_student_reg_id' and class_transfer.sessionid='$sessionid1'");

                    $total_paid_all = $obj->getvalfield("fee_payment left join class_transfer on fee_payment.transferid = class_transfer.transferid", "sum(paid_amt)", "sem_id='$row_get[sem_id]' and class_transfer.m_student_reg_id = '$m_student_reg_id' and class_transfer.sessionid='$sessionid1'");

                ?>
                    <tr>
                        <td colspan="2"><strong> Total Fees <?php echo $sem_name; ?></strong></td>
                        <td style="text-align:right;"><strong><?php echo number_format($total_payment_all, 2); ?></strong>&nbsp;</td>
                        <td style="text-align:right;"><strong><?php echo number_format($total_paid_all, 2); ?></strong>&nbsp;</td>
                        <td style="text-align:right;"><strong><?php echo number_format($total_payment_all - $total_paid_all, 2); ?></strong>&nbsp;
                        </td>
                    </tr>
                <?php } ?>

            </table>
            <br>
            <table class="table table-hover table-condesed">
                <thead>

                    <th class="per5 table-bg">Sno.</th>
                    <th class="per40 table-bg">Fee Name</th>
                    <th class="per15 table-bg" style="text-align: right;">Total</th>
                    <th class="per15 table-bg" style="text-align: right;">Paid</th>
                    <th class="per15 table-bg" style="text-align: right;">Balance</th>

                </thead>
                <tbody>
                    <?php
                    $sn = 1;
                    $total_payment = 0;
                    $total_paid = 0;
                    $sql = $obj->executequery("select * from hostel_fee_setting where sessionid='$sessionid' && transferid='$transferid' and total_fee!='0'");
                    foreach ($sql as $row) {
                        $fee_head_id = $row['fee_head_id'];
                        $transferid = $row['transferid'];

                        $fee_head_name = $obj->getvalfield("m_fee_head", "fee_head_name", "fee_head_id=$fee_head_id");
                        $total_fee = $row['total_fee'];

                        $class_id = $obj->getvalfield("m_student_reg", "class_id", "m_student_reg_id='$m_student_reg_id'");

                        $total_pay = $obj->getvalfield("fee_payment", "sum(paid_amt)", "transferid='$transferid' and fee_head_id='$fee_head_id' and sessionid='$sessionid'");
                        $head_bal_fee = $total_fee - $total_pay;
                    ?>
                        <tr>
                            <td>
                                <?php echo $sn++; ?>
                            </td>
                            <td><?php echo $fee_head_name; ?></td>
                            <td style="text-align:right;"><?php echo number_format($total_fee, 2); ?></td>
                            <td style="text-align:right;"><?php echo number_format($total_pay, 2); ?></td>
                            <td style="text-align:right;"><?php echo number_format($head_bal_fee, 2); ?></td>
                        </tr>
                    <?php
                        $total_payment += $total_fee;
                        $total_paid += $total_pay;
                    }
                    ?>
                    <tr style="background-color: white;">
                        <td colspan="2"><strong> Total Fees</strong></td>
                        <td style="color:#00C;text-align:right;"><strong><?php echo number_format($total_payment, 2); ?></strong>&nbsp;</td>
                        <td style="color:#00C;text-align:right;"><strong><?php echo number_format($total_paid, 2); ?></strong>&nbsp;</td>
                        <td style="color:#00C;text-align:right;"><strong><?php echo number_format($total_payment - $total_paid, 2); ?></strong>&nbsp;</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>