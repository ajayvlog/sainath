<?php include("../../adminsession.php");
 $id  = $_REQUEST['id'];
$tblname  =$_REQUEST['tblname'];
$tblpkey  =$_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];
$imgpath = $_REQUEST['imgpath'];
if($id > 0)
{
	$where = array($tblpkey=>$id);
$res = $obj->select_data($tblname,$where);
foreach($res as $rowimg)
	{
		 $oldimg = $rowimg['image'];
		  if($oldimg != "")
			{
					 @unlink("../../images/image/".$oldimg);

				$where = array($tblpkey=>$id);
				$obj->delete_record($tblname,$where);
				
			}
	}
}


?>