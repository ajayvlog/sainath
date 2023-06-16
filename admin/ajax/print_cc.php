
<?php include("../../adminsession.php");
//print_r($_REQUEST); die;

$mm_student_reg_id  = $_REQUEST['mm_student_reg_id'];
$print_copy  = $_REQUEST['print_copy'];
if ($mm_student_reg_id != "") {
    $form_data = array('print_copy' => $print_copy);
    $where = array('m_student_reg_id' => $mm_student_reg_id);
    $obj->update_record('complicaction_certificate', $where, $form_data);
    echo "1";
}
