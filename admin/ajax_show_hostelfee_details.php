<?php 
include("../adminsession.php");
$transferid = $_REQUEST['transferid'];

    $sno = 1;
    $tot_paid = 0;
  // echo "select *,A.fee_head_id, A.transferid from fee_payment as A left join m_fee_head as B on A.fee_head_id = B.fee_head_id where A.transferid='$transferid'"
    $sql = $obj->executequery("select * from fee_payment where transferid='$transferid' and fee_head_id='9'");
    foreach ($sql as $key) 
    {
      $pay_date = $obj->dateformatindia($key['pay_date']);
      $paid_amt = $key['paid_amt'];
      
     ?>
    <tr>
        <td><?php echo $sno++; ?></td>
        <td><?php echo $pay_date; ?></td>
        <td style="text-align: right;"><?php echo number_format($paid_amt,2); ?></td>
    </tr>
  <?php 
    $tot_paid += $paid_amt;
   }
   ?>
   <tr>
    <td colspan="2"><b>Total Fee Amount:</b></td>
     <td style="text-align: right;"><b><?php echo number_format($tot_paid,2); ?></b></td>
   </tr>

