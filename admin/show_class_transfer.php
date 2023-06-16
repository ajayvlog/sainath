<?php
include("../adminsession.php");
 $m_student_reg_id=trim(addslashes($_REQUEST['m_student_reg_id']));

$where = array("m_student_reg_id"=>$m_student_reg_id);
$res = $obj->select_data("class_transfer",$where);

$sn=1;
?>
<table width="100%" class="table table-bordered table-condensed">
            <thead>
                <tr>
                <th width="5%">SN</th>
                <th width="22%">Student Name</th>  
                <th width="25%">Semester Name</th> 
                <th width="21%">Session Name</th>
                <th width="21%">Admission_Date</th> 
                 <th width="15%" class="center">Edit</th>        
                               
                <!-- <th width="15%" class="center">Action</th> -->
           
                </tr>
            </thead>
            <tbody>
            <?php
			foreach($res as $rowget)
            {
				$transferid = $rowget['transferid'];
				 $m_student_reg_id=$rowget['m_student_reg_id'];
				 $sem_id=$rowget['sem_id'];
				 $sessionid=$rowget['sessionid'];
                 $admission_date = $obj->dateformatusa($rowget['admission_date']);
				
				 $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id=$m_student_reg_id");
				 $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id=$sem_id");
				 	$session_name = $obj->getvalfield("m_session","session_name","sessionid=$sessionid");
				
										?>
                                            <tr>
                                                <td><?php echo $sn++; ?></td>
                                                <td><?php echo $stu_name; ?></td>
                                                <td><?php echo $sem_name; ?></td>
                                                <td><?php echo $session_name; ?></td>
                                                <td><?php echo $admission_date; ?></td>
                                                <td class="center">

                                                <button class="btn btn-info btn-small" type="button" onClick="editdate_modal('<?php echo $transferid; ?>','<?php echo $admission_date; ?>');"> + </button>

                                                </td>
                                           
                                            </tr>
                                            <?php }?>
                                       
                                        </tbody>
                                    </table>
