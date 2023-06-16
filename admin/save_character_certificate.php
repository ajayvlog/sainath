<?php
include("../adminsession.php");
$m_student_reg_id = $obj->test_input($_REQUEST['m_student_reg_id']);
$sem_id = $obj->test_input($_REQUEST['sem_id']);
$sessionid = $obj->test_input($_REQUEST['sessionid']);
//print_r($_REQUEST);die;


$count = $obj->getvalfield("charcter_certificate","count(*)","m_student_reg_id='$m_student_reg_id' and sem_id = '$sem_id' and sessionid='$sessionid'");
//echo $count;die;


if($m_student_reg_id!="" && $sem_id!="" && $sessionid!="")
{
	if ($count > 0) 
	{ 
		echo "0";
	} 
	else //insert
	{
		$form_data = array('m_student_reg_id'=>$m_student_reg_id,'sem_id'=>$sem_id,'sessionid'=>$sessionid,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);

		$obj->insert_record("charcter_certificate",$form_data);
		echo "1";
		
	}
}
else
echo "2";

?>