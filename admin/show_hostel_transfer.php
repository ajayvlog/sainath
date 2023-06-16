<?php
include("../adminsession.php");
$m_student_reg_id=trim(addslashes($_REQUEST['m_student_reg_id']));

$where = array("m_student_reg_id"=>$m_student_reg_id);
$res = $obj->select_data("transfer_hostel",$where);

$sn=1;
?>
<table width="100%" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th >SN</th>
            <th >Student Name</th>  
            <th >Room No</th>
            <th >Floor</th>
            <th >Hostel</th>
            <th >Session Name</th> 
            <?php   $chkdel = $obj->check_delBtn("transfer_hostel.php",$loginid);
                            if($chkdel == 1 || $loginid == 1){  ?>                            
            <th class="center">Action</th>
          <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($res as $rowget)
        {
            $transfer_hostelid = $rowget['transfer_hostelid'];
            $m_student_reg_id=$rowget['m_student_reg_id'];
            $room_id=$rowget['room_id'];
            //$m_student_reg_id = $obj->getvalfield("class_transfer","m_student_reg_id","transferid='$transferid'");
            $sessionid=$rowget['sessionid'];

            $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id='$m_student_reg_id'");

            $room_no = $obj->getvalfield("m_room","room_no","room_id='$room_id'");

            $hostel_id = $obj->getvalfield("m_room","hostel_id","room_id='$room_id'");
            $floor_id = $obj->getvalfield("m_room","floor_id","room_id='$room_id'");

            $hostelname=$obj->getvalfield("m_hostel","hostel_name","hostel_id='$hostel_id'");
            $floor_name=$obj->getvalfield("m_floor","floor_name","floor_id='$floor_id'");
            $session_name = $obj->getvalfield("m_session","session_name","sessionid='$sessionid'");

            ?>
            <tr>
               <td><?php echo $sn++; ?></td>
               <td><?php echo $stu_name; ?></td>
               <td><?php echo $room_no; ?></td>
               <td><?php echo $floor_name; ?></td>
               <td><?php echo $hostelname; ?></td>
               <td><?php echo $session_name; ?></td>
               <?php   if($chkdel == 1 || $loginid == 1){  ?>
               <td class="center"><a class="btn btn-danger btn-small" onClick="funDelete('<?php echo $transfer_hostelid; ?>');"> X </a>   </td>
             <?php } ?>
           </tr>
       <?php }?>

   </tbody>
</table>
