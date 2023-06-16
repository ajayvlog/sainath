<?php include("../../adminsession.php");

$id  = $_REQUEST['id'];
$tblname  = $_REQUEST['tblname'];
$tblpkey  = $_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];
if($id > 0)
{

  $where = array($tblpkey=>$id);
  $obj->delete_record($tblname,$where);
}


?>