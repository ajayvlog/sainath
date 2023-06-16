<?php
include("../adminsession.php");

$tblname = "emp_attendance_entry";
$tblpkey = "customer_id";


$halfday = $_REQUEST['halfday'];  
$employee_id = $_REQUEST['employee_id']; 
$emp_attendance_date = $obj->dateformatusa(trim(addslashes($_REQUEST['emp_attendance_date'])));
$attendance_time=date('H:i:s');

$form_data = array('employee_id'=>$employee_id,'halfday'=>$halfday,'emp_attendance_date'=>$emp_attendance_date,'attendance_time'=>$attendance_time);
$obj->insert_record($tblname, $form_data);





?>







