<?php 
include("../action.php");
//print_r($_SESSION); die;

//session check
if(isset($_SESSION['employee_id']) && $_SESSION['employee_id'] != "")
	{
		
		$ipaddress = $obj->get_client_ip();
		$employee_id = $_SESSION['employee_id']; 
		$createdate = date('Y-m-d H:i:s');		
	}
else
	echo "<script>location='index.php?msg=invalid' </script>" ;
	
?>