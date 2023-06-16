<?php
include("action.php");
//print_r($_SESSION); die;
if(isset($_POST['login']))
{
//print_r($_POST);die;
	$username = trim(addslashes($_POST['admin_name']));
	$password = trim(addslashes($_POST['admin_pwd']));
	$createdate = date('Y-m-d');
	if($username != "" && $password != "" )
	{
		 $count = $obj->login_method("user",$username,$password);

		if($count>=1)
		{ 
		
			 $session_data = $obj->session_method("user",$username,$password);
			$_SESSION['userid']=$session_data['userid'];
			$_SESSION['usertype']=$session_data['usertype'];
			//$_SESSION['branch_id']=$session_data['branch_id'];
			
			$_SESSION['company_id']='';
			//header("location:admin/index.php");
			echo "<script>location='admin/index.php' </script>" ;
		}
		 else
		    echo "<script>location='index.php?msg=error' </script>" ;
	}
	       echo "<script>location='index.php?msg=blank' </script>" ;
}

?>