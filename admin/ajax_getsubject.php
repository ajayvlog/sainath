<?php include("../adminsession.php");
$class_id = $_REQUEST['class_id'];

?>

<option value="">---Select---</option>
<?php
$slno=1;
$res = $obj->executequery("select * from m_subject WHERE class_id = '$class_id' order by subject asc");
foreach($res as $row_get)
{
  ?> 
  <option value="<?php echo $row_get['subject_id']; ?>"> <?php echo $row_get['subject']; ?></option>                                                     
<?php } ?>