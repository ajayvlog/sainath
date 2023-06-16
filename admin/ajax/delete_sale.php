<?php include("../../adminsession.php");
$saleid  = $_REQUEST['id'];
$tblname  =$_REQUEST['tblname'];
$tblpkey  =$_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];

//echo "delete from saleentry_detail where saleid = '$saleid'";die;
$res1 = mysql_query("delete from saleentry_detail where saleid = '$saleid'");
if($res1)
{
	$cmn->InsertLog($pagename, $module, $submodule, "saleentry_detail", "billdetailid", $saleid, "deleted");
	
	
	$res =  mysql_query("delete from $tblname where $tblpkey = '$saleid' ");
	if($res)
	{
	$cmn->InsertLog($pagename, $module, $submodule, $tblname, $tblpkey, $saleid, "deleted");
	}
	echo "<script>location='$pagename?action=3';</script>";
}


?>