<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "academic_calendar.php";
$module = "Acadmic Calendar";
$submodule = "Acadmic Calendar";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "acadmic_calendar";
$tblpkey = "acadmic_cal_id";
$subject = "";


if (isset($_GET['acadmic_cal_id']))
    $keyvalue = $_GET['acadmic_cal_id'];
else
    $keyvalue = 0;
if (isset($_GET['action']))
    $action = $obj->test_input($_GET['action']);
else
    $action = "";
$from_date = date('Y-m-d');
$to_date = date('Y-m-d');
$dup = "";
if (isset($_POST['submit'])) {    //print_r($_POST); die;

    $from_date = $obj->dateformatusa($_POST['from_date']);
    $to_date = $obj->dateformatusa($_POST['to_date']);
    $subject = $_POST['subject'];

    //check Duplicate
    //insert
    if ($keyvalue == 0) {
        $form_data = array('from_date' => $from_date, 'to_date' => $to_date, 'subject' => $subject, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate);
        $obj->insert_record($tblname, $form_data);
        $action = 1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action'</script>";
    } else {
        //update
        $form_data = array('from_date' => $from_date, 'to_date' => $to_date, 'subject' => $subject, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate);
        $where = array($tblpkey => $keyvalue);
        $keyvalue = $obj->update_record($tblname, $where, $form_data);
        $action = 2;
        $process = "updated";
    }
    echo "<script>location='$pagename?action=$action'</script>";
}
if (isset($_GET[$tblpkey])) {

    $btn_name = "Update";
    $where = array($tblpkey => $keyvalue);
    $sqledit = $obj->select_record($tblname, $where);
    $from_date =  $sqledit['from_date'];
    $to_date =  $sqledit['to_date'];
    $subject =  $sqledit['subject'];
}

?>
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("inc/top_files.php"); ?>
</head>

<body >

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
                    <form method="post" action="">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th>From Date:</th>
                                <th>To Date:</th>
                                
                            </tr>
                            <tr>
                                <td><input type="text" name="from_date" id="from_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                                <td><input type="text" name="to_date" id="to_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                            </tr>
                            <tr>
                                <th>Subject</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><textarea name="subject" style="width:-webkit-fill-available" id="subject" rows="5" cols="50" placeholder="Subject"><?php echo $subject; ?></textarea></td>
                                <td><input type="submit" name="submit" class="btn btn-success" value="Save">
                                    <a href="academic_calendar.php" class="btn btn-info">Reset</a>
                                </td>
                            </tr>
                           
                                
                            


                            </tr>
                        </table>
                        <div>
                    </form>


                    <hr>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_academic_calendar.php" class="btn btn-info" target="_blank">
                            <span>Print PDF</span></a>

                    </p>


                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>

                    <table class="table table-bordered" id="dyntable">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th style="text-align: center;">From Date.</th>
                                <th style="text-align: center;">To Date</th>
                                <th style="text-align: center;">Subject</th>
                                <?php $chkedit = $obj->check_editBtn("academic_calendar.php", $loginid);

                                if ($chkedit == 1 || $loginid == 1) {  ?>
                                    <th width="9%" class="head0">Edit</th>
                                <?php  }
                                $chkdel = $obj->check_delBtn("academic_calendar.php", $loginid);

                                if ($chkdel == 1 || $loginid == 1) {  ?>
                                    <th width="10%" class="head0">Delete</th>
                                <?php } ?>



                            </tr>
                        </thead>
                        <tbody id="record">
                            </span>
                            <?php
                            $slno = 1;
                            $totalqty = 0;
                            $sql = "select * from acadmic_calendar order by acadmic_cal_id desc";
                            $res = $obj->executequery($sql);
                            foreach ($res as $row_get) {


                            ?>
                                <tr>
                                    <td><?php echo $slno++; ?></td>
                                    <td style="text-align: center;"><?php echo $obj->dateformatindia($row_get['from_date']); ?></td>
                                    <td style="text-align: center;"><?php echo $obj->dateformatindia($row_get['to_date']); ?></td>
                                    <td style="text-align: center;"><?php echo $row_get['subject']; ?></td>
                                    <?php

                                    if ($chkedit == 1 || $loginid == 1) {  ?>
                                        <td><a class='icon-edit' title="Edit" href='academic_calendar.php?acadmic_cal_id=<?php echo $row_get['acadmic_cal_id']; ?>'></a></td>
                                    <?php  }
                                    if ($chkdel == 1 || $loginid == 1) {  ?>
                                        <td>
                                            <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['acadmic_cal_id']; ?>);' style='cursor:pointer'></a>
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

        jQuery('#from_date').mask('99-99-9999', {
            placeholder: "dd-mm-yyyy"
        });
        jQuery('#to_date').mask('99-99-9999', {
            placeholder: "dd-mm-yyyy"
        });
        jQuery('#from_date').focus();

        function deleterecord(saledetail_id) {
            tblname = 'saleentry_details';
            tblpkey = 'saledetail_id';
            pagename = '<?php echo $pagename; ?>';
            submodule = '<?php echo $submodule; ?>';
            module = '<?php echo $module; ?>';
            if (confirm("Are you sure! You want to delete this record.")) {
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/delete_master.php',
                    data: 'id=' + saledetail_id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
                    dataType: 'html',
                    success: function(data) {
                        // alert(data);
                        getrecord('<?php echo $keyvalue; ?>');
                        setTotalrate();
                    }

                }); //ajax close
            } //confirm close

        }


        jQuery('#sale_date').mask('99-99-9999', {
            placeholder: "dd-mm-yyyy"
        });
        jQuery('#vdate').mask('99-99-9999', {
            placeholder: "dd-mm-yyyy"
        });
        jQuery('#sale_date').focus();
    </script>
</body>

</html>