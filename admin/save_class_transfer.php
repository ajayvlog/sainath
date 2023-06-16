<?php
include("../adminsession.php");

$m_student_reg_id = $obj->test_input($_REQUEST['m_student_reg_id']);
$sem_id = $obj->test_input($_REQUEST['sem_id']);
$sessionid = $obj->test_input($_REQUEST['sessionid']);


$count = $obj->getvalfield("class_transfer","count(*)","m_student_reg_id='$m_student_reg_id' and sem_id = '$sem_id' and sessionid='$sessionid'");


if($m_student_reg_id!="" && $sem_id!="" && $sessionid!="")
{
	if ($count > 0) 
	{ 
		echo "0";
	} 
	else //insert
	{
		$form_data = array('m_student_reg_id'=>$m_student_reg_id,'sem_id'=>$sem_id,'sessionid'=>$sessionid,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);

		$obj->insert_record("class_transfer",$form_data);
		echo "1";
		
	}
}
else
echo "2";

?>