<?php include("../adminsession.php");
$employee_id = trim(addslashes($_REQUEST['employee_id']));
$emp_attendance_date = $obj->dateformatusa(trim(addslashes($_REQUEST['emp_attendance_date'])));
$attendance_time=date('H:i:s');
$attendance_stamp=date('Y-m-d H:i:s');

$machine_userid = $obj->getvalfield("m_employee","biometric_id","employee_id='$employee_id'");
if($employee_id !='0')
{
	$count=$obj->getvalfield("emp_attendance_entry","count(*)","emp_attendance_date='$emp_attendance_date' && employee_id='$employee_id'");
	
	if($count==0)
	{

		$form_data = array('employee_id'=>$employee_id,'attendance_time'=>$attendance_time,'emp_attendance_date'=>$emp_attendance_date,'ipaddress'=>$ipaddress,'sessionid'=>$sessionid,'attendance_stamp'=>$attendance_stamp,'machine_userid'=>$machine_userid,'createdate'=>$createdate);
        $obj->insert_record("emp_attendance_entry",$form_data);
		$msg="Present";
		$arrayName = array('status' => $msg,'date'=> $emp_attendance_date,'time'=> $attendance_time);
	}
	else
	{
		$where = array('emp_attendance_date'=>$emp_attendance_date,'employee_id'=>$employee_id);
		$obj->delete_record("emp_attendance_entry",$where);
		$msg="Absent";
		$arrayName = array('status' => $msg,'date'=> '','time'=> '');
	}
	echo json_encode($arrayName);
	//echo $msg;
	
}
?>