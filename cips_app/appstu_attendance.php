<?php include("adminsession.php");
$employee_id = $_SESSION['employee_id'];
$transferid = trim(addslashes($_REQUEST['transferid']));
$attendate = $obj->dateformatusa(trim(addslashes($_REQUEST['attendate'])));
$sem_id = trim(addslashes($_REQUEST['sem_id']));
$class_id = trim(addslashes($_REQUEST['class_id']));
$stu_subject_id = trim(addslashes($_REQUEST['stu_subject_id']));
$attendanc_time = date('H:i:s');
//print_r($_REQUEST);
if($transferid !='0')
{
	$count=$obj->getvalfield("app_subject_attendence","count(*)","attendate='$attendate' && transferid='$transferid' && employee_id='$employee_id'");
	
	if($count==0)
	{

		$form_data = array('transferid'=>$transferid,'attendate'=>$attendate,'stu_subject_id'=>$stu_subject_id,'class_id'=>$class_id,'sem_id'=>$sem_id,'employee_id'=>$employee_id,'attendanc_time'=>$attendanc_time);
        $obj->insert_record("app_subject_attendence",$form_data);
		//$msg="Present";
		echo "1";
		//$arrayName = array('status' => $msg,'date'=> $attendate);
	}
	else
	{
		$where = array('attendate'=>$attendate,'transferid'=>$transferid,'employee_id'=>$employee_id);
		$obj->delete_record("app_subject_attendence",$where);
		//$msg="Absent";
		echo "0";
		//$arrayName = array('status' => $msg,'date'=> '');
	}
	//echo json_encode($arrayName);
	//echo $msg;
	
}
?>