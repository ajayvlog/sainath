<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "cash_book.php";
$module = "Cash Book";
$submodule = "Cash Book";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "expanse";
$tblpkey = "expanse_id";
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
   $from_date = $_GET['from_date'];
   $to_date  =  $_GET['to_date'];
} else {
   $to_date = date('Y-m-d');
   $from_date = date('Y-m-d');
}
$crit = " where 1 = 1 and exp_date between '$from_date' and '$to_date'";
?>
<!DOCTYPE html>

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <?php include("inc/top_files.php"); ?>
   <script type="text/javascript">
      function exportTableToExcel(tableID, filename = '') {
         var downloadLink;
         var dataType = 'application/vnd.ms-excel';
         var tableSelect = document.getElementById(tableID);
         var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
         // Specify file name
         filename = filename ? filename + '.xls' : 'excel_data.xls';
         // Create download link element
         downloadLink = document.createElement("a");
         document.body.appendChild(downloadLink);
         if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['\ufeff', tableHTML], {
               type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
         } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            // Setting the file name
            downloadLink.download = filename;
            //triggering the function
            downloadLink.click();
         }
      }
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
            <div class="contentinner content-dashboard">
               <form method="get" action="">
                  <table class="table table-bordered table-condensed">
                     <tr>
                        <th>From Date:<span style="color:#F00;">*</span></th>
                        <th>To Date:<span style="color:#F00;">*</span></th>
                        <th>&nbsp</th>
                     </tr>
                     <tr>
                        <td><input type="date" name="from_date" id="from_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $from_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                        <td><input type="date" name="to_date" id="to_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $to_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                        <td><input type="submit" name="search" class="btn btn-success" value="Search" onClick="return checkinputmaster('from_date,to_date');"></td>
                        <td><a href="cash_book.php" class="btn btn-success">Reset</a></td>
                     </tr>
                  </table>
                  <div>
               </form>
               <br>
               <p align="right" style="margin-top:7px; margin-right:10px;">
                  <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
               </p>
               <hr>
               <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
               <table class="table table-bordered" id="tblData">
                  <thead>
                     <tr>
                        <th>S.No.</th>
                        <th style="text-align: center;"> Name</th>
                        <th style="text-align: center;"> Group_Name</th>
                        <th style="text-align: center;"> Voucher No.</th>
                        <th style="text-align: center;">TransactionDate</th>
                        <th style="text-align: center;">Particular</th>
                        <th style="text-align: center;">Mode</th>
                        <th style="text-align: right;">Amount</th>
                     </tr>
                  </thead>
                  <tbody id="record">
                     <h4>Opening Balance : <?php echo $obj->opening_bal_exp_income($from_date); ?></h4>
                     <?php
                     $slno = 1;
                     $totalamt_expence = 0;
                     $totalamt_income = 0;
                     $arrayName = array();
                     $sql = "select * from expanse $crit";
                     $res = $obj->executequery($sql);
                     foreach ($res as $row_get) {
                        $expanse_id = $row_get['expanse_id'];
                        $voucher_no = $row_get['voucher_no'];
                        $ex_group_id = $row_get['ex_group_id'];
                        $exp_name = $row_get['exp_name'];
                        $group_name = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id=$ex_group_id");
                        $type = $row_get['type'];
                        $exp_date = $obj->dateformatindia($row_get['exp_date']);
                        $exp_amount = $row_get['exp_amount'];
                        $mode = $row_get['mode'];
                        if ($type == 'expense') {
                           $particular = "By Expense";
                        } else {
                           $particular = "By Income";
                        }

                        $arrayName[] = array('exp_name' => $exp_name, 'group_name' => $group_name, 'voucher_no' => $voucher_no, 'led_date' => $exp_date, 'particular' => $particular, 'mode' => $mode, 'led_type' => 'debit', 'total' => $exp_amount, 'type' => $type);
                     }

                     // $totalamt_paid_amt = 0;
                     $sql = $obj->executequery("select * from fee_payment where pay_date between '$from_date' and '$to_date'");
                     foreach ($sql as $row_get) {
                        $pay_date = $row_get['pay_date'];
                        $payment_type = $row_get['payment_type'];
                        $transferid = $row_get['transferid'];
                        $m_student_reg_id = $obj->getvalfield("class_transfer", "m_student_reg_id", "transferid='$transferid'");
                        $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
                        $paid_amt = $row_get['paid_amt'];
                        $voucher_no = $row_get['reciept_no'];
                        $exp_date = $obj->dateformatindia($row_get['pay_date']);
                        $particular = "By Fee Payment";
                        // $totalamt_paid_amt += $row_get['paid_amt'];

                        $arrayName[] = array('exp_name' => $stu_name, 'group_name' => "", 'voucher_no' => $voucher_no, 'led_date' => $exp_date, 'particular' => $particular, 'mode' => $payment_type, 'led_type' => 'debit', 'total' => $row_get['paid_amt'], 'type' => 'income');
                     }

                     $sql = $obj->executequery("select * from emp_trancaction where pay_date between '$from_date' and '$to_date'");

                     foreach ($sql as $row_get) {

                        $pay_date = $row_get['pay_date'];
                        $payment_type = $row_get['payment_type'];
                        $mode = $row_get['mode'];
                        $employee_id = $row_get['employee_id'];

                        $emp_name = $obj->getvalfield("m_employee", "emp_name", "employee_id='$employee_id'");

                        $paid_amt = $row_get['paid_amt'];
                        $reciept_no = "";

                        $particular = "By Employee Transaction";

                        $arrayName[] = array('exp_name' => $emp_name, 'group_name' => "Employee Transaction", 'voucher_no' => "", 'led_date' => $pay_date, 'particular' => $particular, 'mode' => $mode, 'led_type' => 'debit', 'total' => $paid_amt, 'type' => 'expense');
                     }

                     function date_compare($a, $b)
                     {
                        $t1 = strtotime($a['led_date']);
                        $t2 = strtotime($b['led_date']);
                        return $t1 - $t2;
                     }

                     usort($arrayName, 'date_compare');
                     foreach ($arrayName as $row_get) {
                        $type = $row_get['type'];
                        if ($type == 'expense') {
                           $color = 'red';
                        } else {
                           $color = 'green';
                        }
                        if ($type == 'expense') {
                           $totalamt_expence += $row_get['total'];
                        } else {
                           $totalamt_income += $row_get['total'];
                        }
                     ?>
                        <tr>
                           <td><?php echo $slno++; ?></td>
                           <td style="text-align: center;"><?php echo $row_get['exp_name']; ?></td>
                           <td style="text-align: center;"><?php echo $row_get['group_name'] ?></td>
                           <td style="text-align: center;"><?php echo $row_get['voucher_no']; ?></td>
                           <td style="text-align: center;"><?php echo $row_get['led_date']; ?></td>
                           <td style="text-align: center;"><?php echo $row_get['particular']; ?></td>
                           <td style="text-align: center;"><?php echo $row_get['mode']; ?></td>
                           <td style="text-align: right;color: <?php echo $color; ?>"><?php echo number_format($row_get['total'], 2); ?></td>
                        </tr>
                     <?php
                     } ?>
                  </tbody>
                  <tr>
                     <td style="text-align: right;" colspan="8">
                        <h3 class="text-info text-right">Total Expense : <?php echo number_format($totalamt_expence, 2); ?></h3>
                        <h3 class="text-info text-right">Total Income : <?php echo number_format($totalamt_income, 2); ?></h3>
                        <h3 class="text-info text-right">Total Balance : <?php echo number_format($totalamt_income - $totalamt_expence, 2); ?></h3>
                     </td>
                  </tr>
               </table>
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
      // jQuery('#from_date').mask('99-99-9999', {
      //    placeholder: "dd-mm-yyyy"
      // });
      // jQuery('#to_date').mask('99-99-9999', {
      //    placeholder: "dd-mm-yyyy"
      // });
      jQuery('#from_date').focus();
   </script>
</body>

</html>