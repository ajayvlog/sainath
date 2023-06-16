<?php include("../adminsession.php");
//print_r($_SESSION);die;
$loginid = $_SESSION['userid'];
$pagename = "scholership_form.php";
$module = "SCHOLARS REGISTRATION";
$submodule = "Scholars Registration";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "scholer_ship";
$tblpkey = "scholership_id";

require_once __DIR__ . '/mpdf/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);

$pdfcontent = "<table class='table table-bordered' id='' border='1' cellpadding='0' cellspacing='0'>
              <thead>
                <tr>
                  <th colspan='15' bgcolor='#96eeee'>
					<div style='font-size:34px;font-weight: bold'>Shri Sainath Paramedical College</div>
					  <div style='font-size:22px;font-weight: bold'>(SCHOLARS REGISTRATION)</div>
					</th>
                </tr>
                <tr>
                  <th class='head0 nosort'>Sno.</th>
                  <th class='head0 nosort'>Scholar No.</th>
                  <th class='head0 nosort'>Student Name</th>
                  <th class='head0 nosort'>Father Name</th>
                  <th class='head0 nosort'>Mother Name</th>
				  <th class='head0 nosort'>Gender</th>
                  <th class='head0'>DOB</th>
                  <th class='head0 nosort'>Category</th>
                  <th class='head0'>Address</th>   
				  <th class='head0'>Adm in Course</th>
                  <th class='head0'>DOA</th>
				                 
                  <th class='head0'>Adm No.</th>
                  <th class='head0'>Enrollment No.</th>
                  <th class='head0'>TC Issu Date</th>
                  <th class='head0'>Photo</th>
                 </tr>
              </thead> <tbody>";
 
                $slno = 1;

                $res = $obj->executequery("select * from scholer_ship order by scholership_id desc");
                foreach ($res as $row_get) {
                  $scholership_id = $row_get['scholership_id'];
                  $imgname = $row_get['imgname'];
                  $category_id = $row_get['category_id'];
                  $dis_id = $row_get['dis_id'];
                  $m_student_reg_id = $row_get['m_student_reg_id'];
                  $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
                  $district_name = $obj->getvalfield("m_district", "dis_name", "dis_id='1'");
                  $cat_name = $obj->getvalfield("m_category", "cat_name", "category_id='$category_id'");

                  $dd = $obj->dateformatindia($row_get['tc_issue_date']);
                
                $pdfcontent .= "<tr>
                    <td>".$slno++."</td>
                    <td>".$row_get['scholer_no']."</td>
                    <td>".$stu_name."</td>
                    <td>".$row_get['father_name']."</td>
                    <td>".$row_get['mother_name']."</td>
                    <td>".$row_get['gender']."</td>
                    <td>".$obj->dateformatindia($row_get['dob'])."<br></td>

                    <td>".$cat_name."</td>
                    <td>".$row_get['address']."</td>
                    <td>".$row_get['course_name']."</td>
                    <td>".$obj->dateformatindia($row_get['doa'])."</td>
                    <td>".$row_get['admissionno']."</td>
                    <td>".$row_get['enrollment']."</td>
                    <td>".$dd."
                    </td><td>";
 
                      if ($imgname != ""){  
                      $pdfcontent .= '<img width="70" style="height: 50px;" src="uploaded/scholer_stu_img/'.$imgname.'">';
                      }

                      $pdfcontent .= "</td></tr>";
                      }

$pdfcontent .= "</tbody></table>";
$mpdf->WriteHTML($pdfcontent);
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0; 
//call watermark content and image
// $mpdf->SetWatermarkText('etutorialspoint');
// $mpdf->showWatermarkText = true;
// $mpdf->watermarkTextAlpha = 0.1;

// $mpdf->allow_charset_conversion = true; 
// $mpdf->showImageErrors = true; 
//output in browser
$mpdf->Output();  

?>
 