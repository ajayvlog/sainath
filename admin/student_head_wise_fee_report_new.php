<?php include("../adminsession.php");
$pagename = "student_head_wise_fee_report_new.php";
$module = "Student Head Wise Fee Report New";
$submodule = "STUDENT HEAD WISE FEE REPORT NEW";
$btn_name = "Update";
$keyvalue = 0;
$tblname = "course_fee_setting";
$tblpkey = "course_fee_set_id";



// if(isset($_GET['class_id']))
// $class_id = $_GET['class_id'];
// else
// $class_id = 0;

// if(isset($_GET['sem_id']))
// $sem_id = $_GET['sem_id'];
// else
// $sem_id = 0;


$crit = " where class_transfer.sessionid='$sessionid'";

if (isset($_GET['class_id']) && $_GET['class_id'] != "") {
    $class_id = trim(addslashes($_GET['class_id']));
    $crit .= " and m_student_reg.class_id='$class_id' ";
} else {
    $class_id = "";
}

if (isset($_GET['sem_id']) && $_GET['sem_id'] != "") {
    $sem_id = trim(addslashes($_GET['sem_id']));
    $crit .= " and class_transfer.sem_id='$sem_id' ";
}

if (isset($_GET['status']) && $_GET['status'] != "") {
    $status = trim(addslashes($_GET['status']));
    $crit .= " and m_student_reg.status='$status' ";
}

if (isset($_GET['action']))
    $action = addslashes(trim($_GET['action']));
else
    $action = "";
//$status = "";
$dup = "";
// $choosed=0;




?>
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
                        <form class="stdform stdform2" method="get" action="">
                            <h4 class="widgettitle">Year / Semester Wise Fee Setting</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Course Name <span class="text-error">*</span></th>
                                    <td>
                                        <select name="class_id" id="class_id" class="chzn-select">
                                            <option value=""> Select</option>
                                            <?php
                                            $slno = 1;
                                            $res = $obj->executequery("select * from m_class");
                                            foreach ($res as $row_get) {
                                            ?>
                                                <option value="<?php echo $row_get['class_id'];  ?>"><?php echo $row_get['class_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            document.getElementById('class_id').value = '<?php echo $class_id; ?>';
                                        </script>
                                    </td>
                                    <th>Year / Semester<span class="text-error">*</span></th>
                                    <td>
                                        <select name="sem_id" id="sem_id" class="chzn-select">
                                            <option value=""> Select</option>
                                            <?php
                                            $slno = 1;
                                            $res = $obj->executequery("select * from m_semester");
                                            foreach ($res as $row_get) {
                                            ?>
                                                <option value="<?php echo $row_get['sem_id'];  ?>"><?php echo $row_get['sem_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            document.getElementById('sem_id').value = '<?php echo $sem_id; ?>';
                                        </script>
                                    </td>
                                    <td><input type="submit" name="search" value="Get Details" class="btn btn-primary" onclick="return checkinputmaster('class_id,sem_id');"></td>
                                </tr>
                            </table>
                        </form>

                        <hr>
                        <?php

                        if ($class_id > 0 && $sem_id > 0) { ?>
                            <div class="navbar">
                                <div class="navbar-inner">
                                    <h5 style="float:left;margin-top:10px;">Student Head Wise Fees Report (Session : <?php echo $obj->getvalfield("m_session", "session_name", "sessionid='$sessionid'"); ?>)</h5>
                                    <div class="navbar-form pull-right">
                                        <button onclick="exportTableToExcel('tblData')" class="btn btn-info">Export Table Data To Excel File</button>
                                    </div>
                                </div>
                                <!--navbar-inner-->
                            </div>
                            <?php

                            $total_fee = 0;
                            $bal_amount = 0;

                            $sql = "select * from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit and sessionid=$sessionid";
                            $res = $obj->executequery($sql);
                            foreach ($res as $row_get1) {
                                //$m_student_reg_id = $row_get1['m_student_reg_id'];
                                $stu_name = $row_get1['stu_name'];
                                $transferid = $row_get1['transferid'];

                            ?>

                                <div id="tblData">
                                    <h4 class="widgettitle nomargin shadowed">Name : <?php echo strtoupper($stu_name); ?></h4>
                                    <!-- <div class="widgetcontent bordered shadowed"> -->

                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Fee Name</th>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $tot_paid_amt = 0;
                                            $tot_total_amt  = 0;
                                            $tot_bal_amt   = 0;
                                            $qry = $obj->executequery("select * from m_fee_head order by fee_head_id desc");
                                            foreach ($qry as $gethead) {
                                                $fee_head_id1 = $gethead['fee_head_id'];
                                                $total_fee = $obj->getvalfield("course_fee_setting", "total_fee", "fee_head_id='$fee_head_id1'");

                                                $paid_amt = $obj->getvalfield("fee_payment", "sum(paid_amt)", "fee_head_id='$fee_head_id1' and transferid='$transferid'");
                                                if ($paid_amt == '') {
                                                    $paid_amt = 0;
                                                }
                                                $bal_amount = $total_fee - $paid_amt;
                                            ?>
                                                <tr>
                                                    <td><?php echo $gethead['fee_head_name']; ?></td>
                                                    <td><?php echo number_format($total_fee, 2); ?></td>
                                                    <td><?php echo number_format($paid_amt, 2); ?></td>
                                                    <td><?php echo number_format($bal_amount, 2); ?></td>
                                                </tr>
                                            <?php

                                                $tot_total_amt += $total_fee;
                                                $tot_paid_amt += $paid_amt;
                                                $tot_bal_amt += $bal_amount;
                                            }
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <td><strong>Total</strong></td>
                                            <td><strong><?php echo number_format($tot_total_amt, 2); ?></strong></td>
                                            <td><strong><?php echo number_format($tot_paid_amt, 2); ?></strong></td>
                                            <td><strong><?php echo number_format($tot_bal_amt, 2); ?></strong></td>
                                        </tfoot>

                                    </table>
                                    <!--  </div> -->



                                <?php } ?>
                                </div>

                            <?php } ?>
                    </div><!-- contentinner -->

                </div>
                <!--maincontent-->


            </div>


            <!--rightpanel-->

            <!-- END OF RIGHT PANEL -->
            <!--footer-->

            <!--   footer -->
            <div class="clearfix"></div>
            <?php include("inc/footer.php"); ?>
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
            function getid(class_id) {
                //var customer_id = document.getElementById('customer_id').value;
                location = 'coursefeesetting.php?class_id=' + class_id;
            }

            jQuery(document).ready(function() {

                jQuery('#menues').click();

            });

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
</body>

</html>