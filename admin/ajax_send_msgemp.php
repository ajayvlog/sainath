<?php include("../adminsession.php");
include("../lib/smsinfo.php");
$emp_name = $_REQUEST['emp_name'];
$mobile = $_REQUEST['mobile'];
$message = $_REQUEST['message'];


if($mobile!='' && $message!="")
{
	//$obj->sendsmsGET($username,$pass,$senderid,$message,$serverUrl,$mobile);
	echo "1";
}

?>