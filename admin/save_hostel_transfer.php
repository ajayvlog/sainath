<?php
include("../adminsession.php");

$m_student_reg_id = $obj->test_input($_REQUEST['m_student_reg_id']);
$sessionid = $obj->test_input($_REQUEST['sessionid']);
$room_id = $obj->test_input($_REQUEST['room_id']);


  $count = $obj->getvalfield("transfer_hostel","count(*)","m_student_reg_id='$m_student_reg_id' and sessionid='$sessionid' and room_id='$room_id'");


 if($m_student_reg_id!="" && $sessionid!="" && $room_id!="")
 {
 	if ($count > 0) 
 	{ 
		echo "0";
 	} 
 	else //insert
 	{
		$form_data = array('m_student_reg_id'=>$m_student_reg_id,'room_id'=>$room_id,'sessionid'=>$sessionid,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);

		$obj->insert_record("transfer_hostel",$form_data);
		echo "1";
		
	}
}
else
echo "2";

?>