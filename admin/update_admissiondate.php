<?php

include("../adminsession.php");

// print_r($_REQUEST);

if (isset($_REQUEST['tid'])) {
    $tid = $obj->test_input($_REQUEST['tid']);
    $admission_date = $obj->dateformatusa($obj->test_input($_REQUEST['admission_date']));

    $where = array("transferid" => $tid);
    $fields = array("admission_date" => $admission_date);
    $obj->update_record("class_transfer", $where, $fields);
    echo 1;
}
