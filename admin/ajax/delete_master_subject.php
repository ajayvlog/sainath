<?php include("../../adminsession.php");
//print_r($_REQUEST); die;
$id  = $_POST['id'];
$tblname  = $_REQUEST['tblname'];
$tblpkey  = $_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];

$where = array($tblpkey=>$id);
$obj->delete_record($tblname,$where);

$where = array($tblpkey=>$id);
$obj->delete_record("assign_subject",$where);
//$keyvalue = $obj->delete_record($tblname,$where);
// if($keyvalue)
// {
// 	echo "<script>location='$pagename?action=3';</script>";
// }
?>