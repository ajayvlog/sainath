<?php
include("../adminsession.php");
$tblname = "emp_salary";
$tblpkey = "salary_id";

$employee_id = $_REQUEST['employee_id'];  
$paid_date = $obj->dateformatusa($_REQUEST['paid_date']); 
$id_no = $_REQUEST['id_no'];
$paymode = $_REQUEST['paymode'];
$paid_amtt = $_REQUEST['paid_amt'];
if($employee_id != "")
{
	$old_paid_amt = $obj->getvalfield("emp_salary","paid_amt","employee_id='$employee_id'");
	$paid_amt = $old_paid_amt + $paid_amtt;
	$form_data = array('paid_date'=>$paid_date,'id_no'=>$id_no,'paymode'=>$paymode,'paid_amt'=>$paid_amt);
	$where = array('employee_id'=>$employee_id);
	$keyvalue = $obj->update_record($tblname,$where,$form_data);
	$action=2;
	$process = "updated";
}
?>