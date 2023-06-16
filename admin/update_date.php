<?php
include("../adminsession.php");

$tblpkey = "salary_id";
if(isset($_GET['salary_id']))
$keyvalue = $_GET['salary_id'];
else
$keyvalue = 0;

$payment_date = $obj->dateformatusa($_REQUEST['payment_date']); 
$employee_id = $_REQUEST['employee_id'];
//print_r($_REQUEST);die;

	  //update
		$form_data = array('payment_date'=>$payment_date);
		$where = array($tblpkey=>$keyvalue,'employee_id'=>$employee_id);
		$keyvalue = $obj->update_record("emp_salary",$where,$form_data);
			
		
 
?>
