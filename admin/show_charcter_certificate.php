<?php
include("../adminsession.php");
 $m_student_reg_id=trim(addslashes($_REQUEST['m_student_reg_id']));

$where = array("m_student_reg_id"=>$m_student_reg_id);
$res = $obj->select_data("charcter_certificate",$where);

$sn=1;
?>
<table width="100%" class="table table-bordered table-condensed">
            <thead>
                <tr>
                <th width="5%">SN</th>
                <th width="22%">Student Name</th>  
                <th width="25%">Semester Name</th> 
                <th width="21%">Session Name</th>                             
                <th width="21%" class="center">Print CC</th>                             
                <th width="15%" class="center">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
			foreach($res as $rowget)
            {
				$cc_id = $rowget['cc_id'];
				 $m_student_reg_id=$rowget['m_student_reg_id'];
				 $sem_id=$rowget['sem_id'];
				 $sessionid=$rowget['sessionid'];
				
				 $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id=$m_student_reg_id");
				 $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id=$sem_id");
				 	$session_name = $obj->getvalfield("m_session","session_name","sessionid=$sessionid");
				
										?>
                                            <tr>
                                            	<td><?php echo $sn++; ?></td>
                                                <td><?php echo $stu_name; ?></td>
                                                <td><?php echo $sem_name; ?></td>
                                                 <td><?php echo $session_name; ?></td>
                                                 <td class="center"><a class="btn btn-info btn-small" onclick="print('character_certificate.php?m_student_reg_id=<?php echo $m_student_reg_id;?>')" >Print</a></td>
                                              
                                                <td class="center"><a class="btn btn-danger btn-small" onClick="funDelete('<?php echo $cc_id; ?>');"> X </a>   </td>
                                            </tr>
                                            <?php }?>
                                       
                                        </tbody>
                                    </table>

