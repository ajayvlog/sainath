<?php include("../adminsession.php");
$transferid = trim(addslashes($_REQUEST['transferid']));
$attendance_date = $obj->dateformatusa(trim(addslashes($_REQUEST['attendance_date'])));
$attendance_time=date('H:i:s');
$attendance_stamp=date('Y-m-d H:i:s');
$m_student_reg_id = $obj->getvalfield("class_transfer","m_student_reg_id","transferid='$transferid'");
$machine_userid = $obj->getvalfield("m_student_reg","biometric_code","m_student_reg_id='$m_student_reg_id'");
if($transferid !='0')
{
	$count=$obj->getvalfield("attendance_entry","count(*)","attendance_date='$attendance_date' && transferid='$transferid'");
	
	if($count==0)
	{

		$form_data = array('transferid'=>$transferid,'attendance_time'=>$attendance_time,'attendance_date'=>$attendance_date,'ipaddress'=>$ipaddress,'sessionid'=>$sessionid,'attendance_stamp'=>$attendance_stamp,'machine_userid'=>$machine_userid,'createdate'=>$createdate);
        $obj->insert_record("attendance_entry",$form_data);
		$msg="Present";
		$arrayName = array('status' => $msg,'date'=> $attendance_date,'time'=> $attendance_time);
	}
	else
	{
		$where = array('attendance_date'=>$attendance_date,'transferid'=>$transferid);
		$obj->delete_record("attendance_entry",$where);
		$msg="Absent";
		$arrayName = array('status' => $msg,'date'=> '','time'=> '');
	}
	echo json_encode($arrayName);
	//echo $msg;
	
}
?>