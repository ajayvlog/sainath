<?php include("../adminsession.php");
//print_r($_SESSION); die;
$employee_id = $obj->test_input($_REQUEST['employee_id']);
?>

<div class="col-lg-6"> 
<div class="panel panel-default toggle panelMove panelClose panelRefresh">
<!-- Start .panel -->
<div class="panel-heading">
<h4 class="panel-title">&nbsp;Salary Details</h4>

</div>
<div class="panel-body" style="height:200px; overflow-y:scroll">
<table class="table table-hover table-condesed alert-success">
  <thead>
  <tr>
  <th style="font-size: 11px;" class="per5">Sno.</th>
  <th style="font-size: 11px;" class="per40">Month</th>
  <th style="font-size: 11px;" class="per40">Year</th>
  <th style="font-size: 11px;" class="per15" style="text-align: right;">Basic_Amt</th>
  <th style="font-size: 11px;" class="per15" style="text-align: right;">Gross_Amt</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $sn=1;
  $total_net = 0;
  $total_paid = 0;
  $sql = $obj->executequery("select * from emp_salary where employee_id='$employee_id'");
  foreach($sql as $row)
    {
    $month = $row['month'];
    $year = $row['year'];
    $basic_salary = $row['basic_salary'];
    $netsalary = $row['netsalary'];
    if($month=='1'){$month1 = 'JAN';}
    if($month=='2'){$month1 = 'FEB';}
    if($month=='3'){$month1 = 'MARCH';}
    if($month=='4'){$month1 = 'APRIL';}
    if($month=='5'){$month1 = 'MAY';}
    if($month=='6'){$month1 = 'JUNE';}
    if($month=='7'){$month1 = 'JULY';}
    if($month=='8'){$month1 = 'AUG';}
    if($month=='9'){$month1 = 'SEP';}
    if($month=='10'){$month1 = 'OCT';}
    if($month=='11'){$month1 = 'NOV';}
    if($month=='12'){$month1 = 'DEC';}

    ?>
    <tr>
        <td style="font-size: 11px;"><?php echo $sn++; ?></td>
        <td style="font-size: 11px;"><?php echo $month1; ?></td>
        <td style="font-size: 11px;"><?php echo $year; ?></td>
        <td style="text-align:right; font-size: 11px;"><?php echo number_format($basic_salary,2); ?></td>
        <td style="text-align:right; font-size: 11px;"><?php echo number_format($netsalary,2); ?></td>

    </tr>
      <?php  
      $total_net += $netsalary;

      }
      ?>  
  <tr>
      <td colspan="4" style="font-size: 11px;"><strong> Total Amount</strong></td>
      <td style="text-align: right; font-size: 11px;"><strong><?php echo $total_net;?></strong></td>

  </tr>
</tbody>
</table>
</div>
</div>
</div>

<div class="col-lg-6"> 
<div class="panel panel-default toggle panelMove panelClose panelRefresh">
<!-- Start .panel -->
<div class="panel-heading">
<h4 class="panel-title">&nbsp;Advance Details</h4>

</div>
<div class="panel-body" style="height:200px; overflow-y:scroll">
<table class="table table-hover table-condesed alert-success">
  <thead>
  <tr>
  <th style="font-size: 11px;" class="per5">Sno.</th>
  <th style="font-size: 11px;" class="per40">Date</th>
  <th style="font-size: 11px;" class="per40">Paymode</th>
  <th style="font-size: 11px;" class="per15" style="text-align: right;">Transaction ID:</th>
  <th style="font-size: 11px;" class="per15" style="text-align: right;">Advance_Amt</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $sn=1;
  $total_advance = 0;
  $sql = $obj->executequery("select * from emp_advance where employee_id='$employee_id'");
  foreach($sql as $row)
    {
    $paydate = $obj->dateformatindia($row['paydate']);
    $paymode = $row['paymode'];
    $amount = $row['amount'];
    $ref_no = $row['ref_no'];
    ?>
    <tr>
        
        <td style="font-size: 11px;"><?php echo $sn++; ?></td>
        <td style="font-size: 11px;"><?php echo $paydate; ?></td>
        <td style="font-size: 11px;"><?php echo $paymode; ?></td>
        <td style="font-size: 11px;"><?php echo $ref_no; ?></td>
        <td style="text-align:right; font-size: 11px;"><?php echo number_format($amount,2); ?></td>

    </tr>
      <?php  
      $total_advance += $amount;
      }
      ?>  
  <tr>
      <td colspan="4" style="font-size: 11px;"><strong> Total Advance Amount</strong></td>
      <td style="text-align: right;font-size: 11px;"><strong><?php echo number_format($total_advance,2);?></strong></td>

  </tr>
</tbody>
</table>
</div>
</div>
</div>

<div class="col-lg-6"> 
<div class="panel panel-default toggle panelMove panelClose panelRefresh">
<!-- Start .panel -->
<div class="panel-heading">
<h4 class="panel-title">&nbsp;Payment Details</h4>

</div>
<div class="panel-body" style="height:200px; overflow-y:scroll">
<table class="table table-hover table-condesed alert-success">
  <thead>
  <tr>
  <th style="font-size: 11px;" class="per5">Sno.</th>
  <th style="font-size: 11px;" class="per40">Payment Date</th>
  <th style="font-size: 11px;" class="per40">mode</th>
  <th style="font-size: 11px;" class="per15">Debit</th>
  <th style="font-size: 11px;" class="per15">Credit</th>
  <th style="font-size: 11px;" class="per15" style="text-align: right;">Balance_Amt</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $sn=1;
  $total_bal = 0;
  $bal_amt = 0;
  $total_debit = 0;
  $total_credit = 0;
  $sql = $obj->executequery("select * from emp_trancaction where employee_id='$employee_id'");
  foreach($sql as $row)
    {
    $pay_date = $obj->dateformatindia($row['pay_date']);
    $mode = $row['mode'];
    $paid_amt = $row['paid_amt'];
    $payment_type = $row['payment_type'];
    if($payment_type=='Debit')
    {
      
      $tot_cr = 0;
      $tot_dr = $row['paid_amt'];
      $total_debit +=  $tot_dr;
    }
    
    else
    {
      
      $tot_dr = 0;
      $tot_cr = $row['paid_amt'];
      $total_credit += $tot_cr;
    }
    
    $bal_amt += $tot_dr - $tot_cr;
    ?>


     <tr>
        
        <td style="font-size: 11px;"><?php echo $sn++; ?></td>
        <td style="font-size: 11px;"><?php echo $pay_date; ?></td>
        <td style="font-size: 11px;"><?php echo $mode; ?></td>
        <td style="text-align: right;font-size: 11px;"><?php echo number_format($tot_dr,2); ?></td>
        <td style="text-align: right;font-size: 11px;"><?php echo number_format($tot_cr,2); ?></td>
        <td style="text-align:right;font-size: 11px;"><?php echo number_format($bal_amt,2); ?></td>

    </tr> 
      <?php  
      //$total_bal += $bal_amt;

      }
      ?>  
  <tr>
      <td colspan="3"><strong> Total Amount</strong></td>
      <td style="text-align: right;font-size: 11px;"><strong><?php echo number_format($total_debit,2);?></strong></td>
      <td style="text-align: right;font-size: 11px;"><strong><?php echo number_format($total_credit,2);?></strong></td>
      <td style="text-align: right;font-size: 11px;"><strong><?php echo number_format(($total_debit - $total_credit),2);?></strong></td>

  </tr>
</tbody>
</table>

 <div class="well well-sm text"><h3 class="text-info text-right" style="font-size: 12px;">Total Salary: <?php echo number_format($total_net,2); ?></h3>
<h3 class="text-info text-right" style="font-size: 12px;">Total Advance: <?php echo number_format($total_advance,2); ?></h3>
<h3 class="text-info text-right" style="font-size: 12px;">Total Payment: <?php echo number_format($bal_amt,2); ?></h3>
<h3 class="text-info text-right" style="font-size: 12px;">Balance Amount: <?php echo number_format($total_net - $total_advance - $total_debit,2); ?></h3></div>
</div>
</div>
</div>