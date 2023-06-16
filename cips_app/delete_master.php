<?php include("adminsession.php");
echo $id  = $_REQUEST['id'];die;
$tblname  = $_REQUEST['tblname'];
$tblpkey  = $_REQUEST['tblpkey'];
$pagename = $_REQUEST['pagename'];
print_r($_REQUEST);die;
$where = array($tblpkey=>$id);
$keyvalue = $obj->delete_record($tblname,$where);
if($keyvalue)
{
	echo "<script>location='$pagename';</script>";
}
?>