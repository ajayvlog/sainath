<?php include("../adminsession.php");
//print_r($_SESSION);die;
$loginid = $_SESSION['userid'];
$pagename = "noduse_certificate_page.php";
$module = "No Dues Certificate";
$submodule = "NO DUES CERTIFICATE";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "complicaction_certificate";
$tblpkey = "cc_id";
$certificate_type = "noduse";

if (isset($_GET['cc_id']))
    $keyvalue = $_GET['cc_id'];
else
    $keyvalue = 0;
if (isset($_GET['m_student_reg_id']))
    $m_student_reg_id = $_GET['m_student_reg_id'];
else
    $m_student_reg_id = "";

if (isset($_GET['action']))
    $action = addslashes(trim($_GET['action']));
else
    $action = "";
$district = "";
$dup = "";
$father_name = "";
// $d_o_m_issue = "";
$m_student_reg_id = "";
$admission_year = "";
$date = date('Y-m-d');
//$behavior = "उत्तम";
$app_no = "";
$course_name = "";
$enroll_no = "";
$address = "";
if (isset($_POST['submit'])) {
    //print_r($_POST);die;
    $m_student_reg_id = $obj->test_input($_POST['m_student_reg_id']);
    $father_name  = $obj->test_input($_POST['father_name']);

    $course_name = $obj->test_input($_POST['course_name']);
    $admission_year =  $obj->test_input($_POST['session']);
    $app_no = $obj->test_input($_POST['app_no']);
    $enroll_no = $obj->test_input($_POST['enroll_no']);
    $address = $obj->test_input($_POST['address']);
    $district = $obj->test_input($_POST['district']);
    // $d_o_m_issue = $obj->dateformatusa($_POST['d_o_m_issue']);



    //check Duplicate
    $cwhere = array("m_student_reg_id" => $_POST['m_student_reg_id'], "certificate_type" => $certificate_type);
    // print_r($cwhere);
    // die;
    $count =  $obj->count_method("complicaction_certificate", $cwhere);
    if ($count > 0) {
        $dup = "<div class='alert alert-danger'>
     <strong>Error!</strong> Duplicate Record.
     </div>";
        //echo $dup; die;
    } else {

        //update
        $form_data = array('m_student_reg_id' => $m_student_reg_id, 'father_name' => $father_name, 'admission_year' => $admission_year, 'course_name' => $course_name, 'address' => $address, 'district' => $district, 't_day' => $date, 'app_no' => $app_no, 'enroll_no' => $enroll_no, 'certificate_type' => $certificate_type, 'createdate' => $createdate, 'ipaddress' => $ipaddress);
        // print_r($form_data);
        // die;
        $obj->insert_record('complicaction_certificate', $form_data);
        $action = 1;
        $process = "insert";
        // die;
        echo "<script>location='noduse_certificate_page.php?action=$action'</script>";

        //}
    }
}
if (isset($_GET['m_student_reg_id'])) {

    $btn_name = "Save";
    $m_student_reg_id = addslashes(trim($_GET['m_student_reg_id']));

    $where = array('m_student_reg_id' => $m_student_reg_id);
    $sqledit = $obj->select_record('m_student_reg', $where);
    $father_name =  $sqledit['father_name'];
    $admission_year =  $sqledit['admission_year'];
    $class_id =  $sqledit['class_id'];
    $course_name = $obj->getvalfield("m_class", "class_name", "class_id='$class_id'");
    $address = $sqledit['address'];
    $dis_id = $sqledit['district'];
    $district = $obj->getvalfield("m_district", "dis_name", "dis_id='$dis_id'");
    $app_no = $sqledit['application_no'];
    $enroll_no = $sqledit['enrollment'];
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
                            <div id="wizard2" class="wizard tabbedwizard">

                                <div>
                                    <h4>No Dues Certificate</h4>
                                    <?php echo $dup; ?>
                                    <div class="lg-12 md-12 sm-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Student Name<span style="color:#F00;">*</span></th>
                                                <th>Father's Name<span style="color:#F00;">*</span></th>
                                                <th>Addmission Year<span style="color:#F00;"></span></th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select name="m_student_reg_id" id="m_student_reg_id" style="width:280px;" class="chzn-select" onChange="getid(this.value);">
                                                        <option value="">--Select--</option>
                                                        <?php


                                                        $res = $obj->executequery("select * from m_student_reg");
                                                        foreach ($res as $row) {
                                                        ?>
                                                            <option value="<?php echo $row['m_student_reg_id']; ?>"><?php echo $row['stu_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <script>
                                                        document.getElementById('m_student_reg_id').value = '<?php echo $m_student_reg_id; ?>';
                                                    </script>
                                                </td>

                                                <td> <input type="text" name="father_name" id="father_name" class="input-xlarge" value="<?php echo $father_name; ?>" autofocus autocomplete="off" placeholder="Enter Father's Name" /></td>

                                                <td> <input type="text" name="session" id="session" class="input-xlarge" value="<?php echo $admission_year; ?>" autofocus autocomplete="off" placeholder="Enter Admission Year" /></td>

                                            </tr>
                                            <tr>
                                                <th>Course Name<span style="color:#F00;"></span></th>
                                                <th>Address<span style="color:#F00;"></span></th>
                                                <th>District<span style="color:#F00;"></span></th>

                                            </tr>
                                            <tr>

                                                <td> <input type="text" name="course_name" id="course_name" placeholder="Enter Course Name" class="input-xlarge" value="<?php echo $course_name; ?>" autofocus autocomplete="off" /></td>


                                                <td> <input type="text" name="address" id="address" placeholder="Enter Address" class="input-xlarge" value="<?php echo $address; ?>" autofocus autocomplete="off" /></td>
                                                </td>

                                                <td>
                                                    <input type="text" name="district" id="district" placeholder="Enter District" class="input-xlarge" value="<?php echo $district; ?>" autofocus autocomplete="off" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Date<span style="color:#F00;"></span></th>
                                                <th>Application Number<span style="color:#F00;"></span></th>
                                                <th>Enrollment Number<span style="color:#F00;"></span></th>
                                            </tr>
                                            <tr>
                                                <td> <input type="text" name="date" id="date" placeholder="dd-mm-yyyy" class="input-xlarge" value="<?php echo $obj->dateformatindia($date); ?>" autofocus autocomplete="off" /></td>

                                                <td>
                                                    <input type="text" name="app_no" id="app_no" placeholder="Enter Application Number" class="input-xlarge" value="<?php echo $app_no; ?>" autofocus autocomplete="off" />
                                                </td>
                                                <td>

                                                    <input type="text" name="enroll_no" id="enroll_no" placeholder="Enter Enrollment Number" class="input-xlarge" value="<?php echo $enroll_no; ?>" autofocus autocomplete="off" />

                                                </td>


                                            </tr>
                                            <tr>
                                                <!-- <th>Marksheet Issue Date<span style="color:#F00;"></span></th> -->
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <!-- <tr>
                                                <td> <input type="text" name="d_o_m_issue" id="d_o_m_issue" class="input-xlarge" value="<?php echo $d_o_m_issue; ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy" /></td>
                                                <td></td>
                                                <td></td>
                                            </tr> -->
                                            <tr>
                                                <td colspan="3">
                                                    <button type="submit" name="submit" class="btn btn-primary" onclick="return checkinputmaster('m_student_reg_id,father_name');">
                                                        <?php echo $btn_name; ?></button>
                                                    <a href="noduse_certificate_page.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                                                    <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    <table class="table table-bordered" id="dyntable">
                        <colgroup>
                            <col class="con0" style="align: center; width: 4%" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="head0 nosort">Sno.</th>
                                <th class="head0">Student Name</th>
                                <th class="head0">Father's Name</th>
                                <th class="head0">Addmission Year</th>
                                <th class="head0">Course Name</th>
                                <th class="head0">Address</th>
                                <th class="head0">District</th>
                                <th class="head0">Date</th>
                                <th class="head0">Admission Number</th>
                                <th class="head0">Enrollment Number</th>
                                <!-- <th class="head0">Marksheet Issue Date</th> -->
                                <th width="10%" class="head0">Print</th>
                                <?php $chkdel = $obj->check_delBtn("noduse_certificate_page.php", $loginid);

                                if ($chkdel == 1 || $loginid == 1) {  ?>
                                    <th width="10%" class="head0">Delete</th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $slno = 1;
                            //$res = $obj->fetch_record("m_product");

                            $res = $obj->executequery("select * from complicaction_certificate where certificate_type='noduse' order by cc_id desc");
                            foreach ($res as $row_get) {
                                $cc_id = $row_get['cc_id'];
                                $print_copy = $row_get['print_copy'];
                                $m_student_reg_id = $row_get['m_student_reg_id'];
                                $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
                            ?>
                                <tr>
                                    <td><?php echo $slno++; ?></td>
                                    <td><?php echo $stu_name; ?></td>
                                    <td><?php echo $row_get['father_name']; ?></td>
                                    <td><?php echo $row_get['admission_year']; ?></td>
                                    <td><?php echo $row_get['course_name']; ?></td>
                                    <td><?php echo $row_get['address']; ?></td>
                                    <td><?php echo $row_get['district']; ?></td>
                                    <td><?php echo $obj->dateformatindia($row_get['t_day']); ?></td>
                                    <td><?php echo $row_get['app_no']; ?></td>
                                    <td><?php echo $row_get['enroll_no']; ?></td>
                                    <!-- <td><?php echo $obj->dateformatindia($row_get['d_o_m_issue']); ?></td> -->
                                    <td width="10%"><a class="icon-print" style="text-align: center; cursor: pointer;" data-toggle="modal_party" title="Print" target="_blank" href="noduse-certificate.php?m_student_reg_id=<?php echo $row_get['m_student_reg_id'] ?>"></a></td>
                                    <?php if ($chkdel == 1 || $loginid == 1) {  ?>
                                        <td width="10%"><a class='icon-remove' title="Delete" onclick='funDel(<?php echo $cc_id; ?>);' style='cursor:pointer'></a></td>
                                    <?php } ?>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>

                </div><!--contentinner-->
            </div><!--maincontent-->
        </div>
        <!--mainright-->
        <!-- END OF RIGHT PANEL -->
        <div class="clearfix"></div>
        <?php include("inc/footer.php"); ?>
        <!-- <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_party">
            <div class="modal-header alert-info">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 id="myModalLabel">No of Copy</h3>
            </div>
            <div class="modal-body">
                <span style="color:#F00;" id="suppler_model_error"></span>
                <table class="table table-condensed table-bordered">
                    <input type="hidden" name="mm_student_reg_id" id="mm_student_reg_id">
                    <tbody>
                        <tr>
                            <td>Copy No.<span style="color: red;">*</span></td>
                            <td><input type="text" name="print_copy" id="print_copy" class="input-large" placeholder="Enter Copy No"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" name="s_save" id="s_save" onClick="printTc();">Print</button>
                <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
        </div> -->
        <!--footer-->
    </div><!--mainwrapper-->
    <script>
        function funDel(id) { //alert(id);   
            tblname = '<?php echo $tblname; ?>';
            tblpkey = '<?php echo $tblpkey; ?>';
            pagename = '<?php echo $pagename; ?>';
            submodule = '<?php echo $submodule; ?>';
            m_student_reg_id = '<?php echo $m_student_reg_id; ?>';
            module = '<?php echo $module; ?>';
            //alert(module); 
            if (confirm("Are you sure! You want to delete this record.")) {
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/delete_master_reg.php',
                    data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
                    dataType: 'html',
                    success: function(data) {
                        //alert(data);
                        location = '<?php echo $pagename . "?action=3"; ?>';
                    }

                }); //ajax close
            } //confirm close
        } //fun close


        jQuery('#date').mask('99-99-9999', {
            placeholder: "dd-mm-yyyy"
        });
        // jQuery('#feesdate').mask('99-99-9999', {
        //     placeholder: "dd-mm-yyyy"
        // });
        // jQuery('#admission_date').focus();

        jQuery(document).ready(function() {
            // Smart Wizard  
            jQuery('#wizard2').smartWizard({
                onFinish: onFinishCallback
            });

            function onFinishCallback() {
                alert('Finish Clicked');
            }

            jQuery(".inline").colorbox({
                inline: true,
                width: '60%',
                height: '500px'
            });
            jQuery('select, input:checkbox').uniform();
        });

        function changetab(pagename) {
            //alert('hi');
            location = pagename;
        }

        function getid(m_student_reg_id) {

            // alert("sshol");
            var $url = 'noduse_certificate_page.php?m_student_reg_id=' + m_student_reg_id;

            location = $url;

        }
    </script>
    <script>
        let print = (doc) => {
            let objFra = document.createElement('iframe'); // Create an IFrame.
            objFra.style.visibility = 'hidden'; // Hide the frame.
            objFra.src = doc; // Set source.
            document.body.appendChild(objFra); // Add the frame to the web page.
            objFra.contentWindow.focus(); // Set focus.
            objFra.contentWindow.print(); // Print it.
        }
    </script>
    <script type="text/javascript">
        // function copyofTc(m_student_reg_id, print_copy) {
        //     jQuery('#myModal_party').modal('show');
        //     jQuery('#mm_student_reg_id').val(m_student_reg_id);
        //     jQuery('#print_copy').val(print_copy);
        // }
    </script>
    <!-- <script type="text/javascript">
        function printTc() {
            var print_copy = document.getElementById('print_copy').value;
            var mm_student_reg_id = document.getElementById('mm_student_reg_id').value;
            if (print_copy == "") {
                alert("Print copy can't be blank");
                return false;
            } else {
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/print_cc.php',
                    data: 'mm_student_reg_id=' + mm_student_reg_id + '&print_copy=' + print_copy,
                    dataType: 'html',
                    success: function(data) {
                        //  alert(data);
                        jQuery('#myModal_party').modal('hide');
                        if (data == 1) {
                            print('noduse-certificate.php?cc_id=<?php echo $cc_id; ?>');
                        }


                    }

                }); //ajax close
            }

        }
    </script> -->
</body>

</html>