<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "cash_book_report.php";
$module = "Cash Book Report";
$submodule = "Cash Book Report";
$btn_name = "Save";
$keyvalue = 0;

if (isset($_GET['action']))
    $action = $obj->test_input($_GET['action']);
else
    $action = "";
$duplicate = "";
//$crit = " where 1 = 1 ";


if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date  =  $_GET['to_date'];
} else {
    $to_date = date('Y-m-d');
    $from_date = date('Y-m-d');
}

$crit = " where 1 = 1 and exp_date between '$from_date' and '$to_date'";

if (isset($_GET['payment_type'])) {
    $payment_type = $obj->test_input($_GET['payment_type']);
    if ($payment_type != '')
        $crit .= " and mode = '$payment_type'";
} else {
    $payment_type = "";
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
                <div class="contentinner content-dashboard">

                    <form method="get" action="">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th>From Date:<span style="color: red;">*</span></th>
                                <th>To Date:<span style="color: red;">*</span></th>
                                <th>Payment Type:<span style="color: red;">*</span></th>
                            </tr>
                            <tr>
                                <td><input type="date" name="from_date" id="from_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $from_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                                <td><input type="date" name="to_date" id="to_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $to_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                                <td> <select class="chzn-select" style="width:283px;" name="payment_type" id="payment_type">

                                        <option value="">-select-</option>

                                        <option value="cash">Cash</option>

                                        <option value="checque">Cheque</option>

                                        <option value="upi">UPI</option>

                                    </select>

                                    <script>
                                        document.getElementById('payment_type').value = '<?php echo $payment_type; ?>';
                                    </script>
                                </td>
                                <td><input type="submit" name="search" class="btn btn-success" value="Search" onClick="return checkinputmaster('from_date,to_date,payment_type');">
                                    <a href="<?php echo $pagename; ?>" name="reset" id="reset" class="btn btn-success">Reset</a>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <div>
                    </form>
                    <p align="right" style="margin-top:7px; margin-right:10px;">
                        <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
                    </p>

                    <?php

                    $slno = 1;
                    $arrayName = array();
                    // show expanse record
                    $sql = $obj->executequery("select * from expanse $crit and type = 'expense'");


                    foreach ($sql as $row_get) {

                        $exp_date = $row_get['exp_date'];
                        $exp_name = $row_get['exp_name'];
                        $ex_group_id = $row_get['ex_group_id'];
                        $ex_groupname = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id='$ex_group_id' and type = 'expense'");
                        $exp_amount = $row_get['exp_amount'];
                        $voucher_no = $row_get['voucher_no'];

                        $particular = "By Expense ( $voucher_no )";

                        $arrayName[] = array('led_date' => $exp_date, 'particular' => $particular, 'total' => $exp_amount, 'led_type' => 'debit', 'ex_groupname' => $ex_groupname, 'exp_name' => $exp_name);
                    }


                    // show income record
                    $sql = $obj->executequery("select * from expanse $crit and type = 'income'");
                    foreach ($sql as $row_get) {
                        $exp_date = $row_get['exp_date'];
                        $exp_name = $row_get['exp_name'];
                        $exp_amount = $row_get['exp_amount'];
                        $voucher_no = $row_get['voucher_no'];
                        $ex_group_id = $row_get['ex_group_id'];
                        $ex_groupname = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id='$ex_group_id' and type = 'income'");

                        $particular = "By Income ( $voucher_no )";

                        $arrayName[] = array('led_date' => $exp_date, 'particular' => $particular, 'total' => $exp_amount, 'led_type' => 'credit', 'ex_groupname' => $ex_groupname, 'exp_name' => $exp_name);
                    }

                    // show fee_payment record
                    $sql = $obj->executequery("select * from fee_payment where pay_date between '$from_date' and '$to_date' and payment_type='$payment_type' ");


                    foreach ($sql as $row_get) {

                        $pay_date = $row_get['pay_date'];
                        $payment_type = $row_get['payment_type'];
                        $transferid = $row_get['transferid'];

                        $m_student_reg_id = $obj->getvalfield("class_transfer", "m_student_reg_id", "transferid='$transferid'");
                        $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");

                        $paid_amt = $row_get['paid_amt'];
                        $reciept_no = $row_get['reciept_no'];

                        $particular = "By Fee Payment ($reciept_no) <br>Mode : $payment_type";

                        $arrayName[] = array('led_date' => $pay_date, 'particular' => $particular, 'total' => $paid_amt, 'led_type' => 'credit', 'ex_groupname' => '', 'exp_name' => $stu_name);
                    }

                    $sql = $obj->executequery("select * from emp_trancaction where pay_date between '$from_date' and '$to_date' ");


                    foreach ($sql as $row_get) {

                        $pay_date = $row_get['pay_date'];
                        $payment_type = $row_get['payment_type'];
                        $employee_id = $row_get['employee_id'];

                        $emp_name = $obj->getvalfield("m_employee", "emp_name", "employee_id='$employee_id'");

                        $paid_amt = $row_get['paid_amt'];
                        $reciept_no = "";

                        $particular = "By Employee Transaction <br> Mode : $payment_type";

                        $arrayName[] = array('led_date' => $pay_date, 'particular' => $particular, 'total' => $paid_amt, 'led_type' => 'debit', 'ex_groupname' => 'Employee Transaction', 'exp_name' => $emp_name);
                    }


                    function date_compare($a, $b)
                    {
                        $t1 = strtotime($a['led_date']);
                        $t2 = strtotime($b['led_date']);
                        return $t1 - $t2;
                    }
                    usort($arrayName, 'date_compare');


                    ?>
                    <br>



                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>

                    <table class="table table-bordered" id="tblData">
                        <tr>
                            <td>Slno</td>
                            <td>Date</td>
                            <td>Name</td>
                            <td>Group Name</td>
                            <td>Particular</td>
                            <td>Debit</td>
                            <td>Credit</td>
                            <td>Balance</td>
                        </tr>

                        <?php
                        $balance = 0;
                        $total_debit = 0;
                        $total_credit = 0;
                        $total_balance = 0;
                        foreach ($arrayName as $key) {
                            if ($key['led_type'] == 'debit') {
                                $credit = 0;
                                $debit = $key['total'];
                                $total_debit +=  $debit;
                            } else {
                                $debit = 0;
                                $credit = $key['total'];
                                $total_credit += $credit;
                            }

                            $balance +=  $credit - $debit;
                        ?>
                            <tr>
                                <td><?php echo $slno++; ?></td>
                                <td><?php echo $obj->dateformatindia($key['led_date']); ?></td>
                                <td><?php echo $key['exp_name']; ?></td>
                                <td><?php echo $key['ex_groupname']; ?></td>
                                <td><?php echo $key['particular']; ?></td>

                                <td style="text-align: right;"><?php echo number_format($debit, 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($credit, 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($balance, 2); ?></td>
                            </tr>
                        <?php
                        } //close foreach loop
                        ?>
                        <tr>
                            <td colspan="5">Total : </td>
                            <td style="text-align: right;"><?php echo number_format($total_debit, 2); ?></td>
                            <td style="text-align: right;"><?php echo number_format($total_credit, 2); ?></td>
                            <td style="text-align: right;">Balance: <?php echo number_format(($total_credit - $total_debit), 2); ?></td>
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

        // jQuery('#from_date').mask('99-99-9999', {
        //     placeholder: "dd-mm-yyyy"
        // });
        // jQuery('#to_date').mask('99-99-9999', {
        //     placeholder: "dd-mm-yyyy"
        // });
        jQuery('#from_date').focus();
    </script>
</body>

</html>