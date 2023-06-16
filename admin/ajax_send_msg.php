<?php include("../adminsession.php");
include("../lib/smsinfo.php");
$stu_name = $_REQUEST['stu_name'];
$mobile = $_REQUEST['mobile'];
$message = $_REQUEST['message'];


if($mobile!='' && $message!="")
{
	//$obj->sendsmsGET($username,$pass,$senderid,$message,$serverUrl,$mobile);
	echo "1";
}

?>