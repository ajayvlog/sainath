<?php 
include("action.php");
//print_r($_SESSION); die;

if(isset($_SESSION['usertype']) && $_SESSION['usertype'] != "" && isset($_SESSION['userid']) && $_SESSION['userid'] != "")
	{
		
		$ipaddress = $obj->get_client_ip();
		$loginid = $_SESSION['userid']; 
	    $usertype = $_SESSION['usertype'];
		$company_id = isset($_SESSION['company_id'])?$_SESSION['company_id']:'';
	    $sessionid = $obj->getvalfield("m_session","sessionid","status=1");
	    $_SESSION['sessionid'] = $sessionid;
		$createdate = date('Y-m-d H:i:s');		
		}
else
	echo "<script>location='../index.php?msg=invalid' </script>" ;
	
?>