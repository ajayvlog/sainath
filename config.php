<?php 
date_default_timezone_set('Asia/Kolkata');
class Database
{
	public $con;
	public function __construct(){

		//echo $_SERVER["SERVER_NAME"];die;
		if($_SERVER["SERVER_NAME"]=="localhost" || $_SERVER["SERVER_NAME"]=="laravel" || $_SERVER["SERVER_NAME"]=="192.168.0.8")
		{
			//echo "asdfasd";die;
			$dbhost = "localhost";
			$dbuser = "root";
			$dbpass = "";
			$db = "sainath";
		    $this->con = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
			//$conn = mysqli_connect("$host_name","$db_user","$db_pwd","$db_name");
			//return $this->con;
		}
		else
		{	
			// $dbhost = "localhost";
			// $dbuser = "spacefb1_cipsusr";
			// $dbpass = "vB$49im}#JDv";
			// $db = "spacefb1_vishnukantsir";
			// $this->con = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
			//print_r($this->con);die;

		}

		//$this->con = mysqli_connect("$host_name","$db_user","$db_pwd","$db_name");
		if (!$this->con) {
			die('Could not connect:'. mysqli_connect_error());
		}

		// $servername = "localhost";
		// $database = "spacefb1_trinitybill";
		// $username = "spacefb1_trinity";
		// $password = "7eMr--tyD7lg";
		// // Create connection
		// $this->con = mysqli_connect($servername, $username, $password, $database);
		// // Check connection
		// if (!$this->con) {

		//     die("Connection failed: " . mysqli_connect_error());
		// }
		// //echo "Connected successfully";
		

	}//constructor close
}
?>