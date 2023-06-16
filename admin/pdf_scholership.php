<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

$tblpkey = "m_student_reg_id";

$m_student_reg_id = "";
if (isset($_GET[$tblpkey]))
   $m_student_reg_id = $_GET[$tblpkey];
else
if (isset($_SESSION)) {
   $sessionid = $_SESSION['sessionid'];
   if ($sessionid != "") {
      $session_name = $obj->getvalfield("m_session", "session_name", "sessionid='$sessionid'");
   }
} else {
   $sessionid = "";
}


$pagename = "pdf_academic_calendar.php";

$title1 = $obj->getvalfield("college_setting", "college_name", "1 = 1");





class PDF_MC_Table extends FPDF
{
   var $widths;
   var $aligns;

   function Header()
   {
      global $title1, $title2, $session_name, $obj, $from_date, $to_date, $fee_head_id, $fee_head_name;
      // Arial 25
      //$this->SetFillColor(175,238,238);
      $this->Rect('5', '5', '287', '180');
      $this->SetFont('Arial', 'b', 20);
      // Move to the right

      $this->SetFillColor(150, 238, 238);
      $this->SetY(5);
      $this->SetX(5);
      $this->Cell(287, 25, '', '1', 0, 'C', 1);

      $this->SetFillColor(0, 0, 0); //WHITE


      $this->SetFont('Arial', 'b', 25);
      $this->SetY(8);
      $this->SetX(80);
      $this->SetTextColor(0, 0, 0);
      $this->Cell(35, 5, $title1, 0, 0, 'L');

      $this->Ln(12);
      $this->SetFont('Arial', 'b', 15);
      $this->Cell(117);
      $this->Cell(35, 0, $title2, 0, 1, 'C');

      $this->Ln(-1);

      $this->SetFont('Arial', 'b', 11);

      if ($fee_head_id != "") {

         $this->Ln(1);
         $this->SetFont('Arial', 'b', 11);
         $this->Cell(115, 5, "$fee_head_name", 0, 1, 'R');
      }


      $this->Ln(5);
      $this->SetX(5);
      $this->SetFont('Arial', 'B', 7.3);
      $this->SetFillColor(128, 128, 128);
      //$this->SetTextColor(225,225,225);
      $this->Cell(8, 8, 'SNo', '1', 0, 'L', 1);
      $this->Cell(17, 8, 'Scholar No.', 1, 0, 'L', 1);
      $this->Cell(25, 8, 'Student Name', 1, 0, 'L', 1);
      $this->Cell(25, 8, 'Father Name', 1, 0, 'L', 1);
      $this->Cell(25, 8, 'Mother Name', 1, 0, 'L', 1);
      $this->Cell(13, 8, 'Gender', 1, 0, 'L', 1);
      $this->Cell(17, 8, 'DOB', 1, 0, 'L', 1);
      $this->Cell(15, 8, 'Category', 1, 0, 'L', 1);
      $this->Cell(20, 8, 'Adm in course', 1, 0, 'L', 1);
      $this->Cell(17, 8, 'DOA', 1, 0, 'L', 1);
      $this->Cell(20, 8, 'Address', 1, 0, 'L', 1);
      $this->Cell(15, 8, 'Adm No', 1, 0, 'L', 1);
      $this->Cell(20, 8, 'Enrollment No', 1, 0, 'L', 1);
      $this->Cell(20, 8, 'tc_issue_date', 1, 0, 'L', 1);
      $this->Cell(30, 8, 'Photo', 1, 1, 'L', 1);

      $this->SetWidths(array(8, 17, 25, 25, 25, 13, 17, 15, 20, 17, 20, 15, 20, 20, 30));
      $this->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L'));
      $this->SetFont('Arial', '', 6);
      $this->SetX(5);
   }
   // Page footer
   function Footer()
   {
      // Position at 1.5 cm from bottom
      $this->SetY(-15);
      // Arial italic 8
      $this->SetFont('Arial', 'I', 8);
      // Page number
      $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
   }
   function SetWidths($w)
   {
      //Set the array of column widths
      $this->widths = $w;
   }

   function SetAligns($a)
   {
      //Set the array of column alignments
      $this->aligns = $a;
   }

   function Row($data)
   {
      //Calculate the height of the row
      $nb = 0;
      for ($i = 0; $i < count($data); $i++)
         $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
      $h = 8 * $nb;
      //Issue a page break first if needed
      $this->CheckPageBreak($h);
      //Draw the cells of the row
      for ($i = 0; $i < count($data); $i++) {
         $w = $this->widths[$i];
         $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
         //Save the current position
         $x = $this->GetX();
         $y = $this->GetY();
         //Draw the border
         $this->Rect($x, $y, $w, $h);
         //Print the text
         $this->MultiCell($w, 8, $data[$i], 0, $a);
         //Put the position to the right of the cell
         $this->SetXY($x + $w, $y);
      }
      //Go to the next line
      $this->Ln($h);
   }

   function CheckPageBreak($h)
   {
      //If the height h would cause an overflow, add a new page immediately
      if ($this->GetY() + $h > $this->PageBreakTrigger)
         $this->AddPage($this->CurOrientation);
   }

   function NbLines($w, $txt)
   {
      //Computes the number of lines a MultiCell of width w will take
      $cw = &$this->CurrentFont['cw'];
      if ($w == 0)
         $w = $this->w - $this->rMargin - $this->x;
      $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
      $s = str_replace("\r", '', $txt);
      $nb = strlen($s);
      if ($nb > 0 and $s[$nb - 1] == "\n")
         $nb--;
      $sep = -1;
      $i = 0;
      $j = 0;
      $l = 0;
      $nl = 1;
      while ($i < $nb) {
         $c = $s[$i];
         if ($c == "\n") {
            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
            continue;
         }
         if ($c == ' ')
            $sep = $i;
         $l += $cw[$c];
         if ($l > $wmax) {
            if ($sep == -1) {
               if ($i == $j)
                  $i++;
            } else
               $i = $sep + 1;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
         } else
            $i++;
      }
      return $nl;
   }
}

function GenerateWord()
{
   //Get a random word
   $nb = rand(3, 10);
   $w = '';
   for ($i = 1; $i <= $nb; $i++)
      $w .= chr(rand(ord('a'), ord('z')));
   return $w;
}

function GenerateSentence()
{
   //Get a random sentence
   $nb = rand(1, 10);
   $s = '';
   for ($i = 1; $i <= $nb; $i++)
      $s .= GenerateWord() . ' ';
   return substr($s, 0, -1);
}
$pdf = new PDF_MC_Table();

$pdf->SetTitle($title1);
$title2 = "(SCHOLERS REGISTRATION)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4');

$slno = 1;
$totalpaid = 0;
$y = 0;
$res = $obj->executequery("select * from scholer_ship order by scholership_id desc");
foreach ($res as $row_get) {
   $scholership_id = $row_get['scholership_id'];
   $scholer_no = $row_get['scholer_no'];
   $father_name = $row_get['father_name'];
   $mother_name = $row_get['mother_name'];
   $imgname = $row_get['imgname'];
   $dob = $obj->dateformatindia($row_get['dob']);
   $gender = $row_get['gender'];
   //die;
   $enrollment = $row_get['enrollment'];
   $course_name = $row_get['course_name'];
   $doa = $obj->dateformatindia($row_get['doa']);
   $address = $row_get['address'];
   $tc_issue_date = $obj->dateformatindia($row_get['tc_issue_date']);
   $last_qualification = $row_get['last_qualification'];
   $m_student_reg_id = $row_get['m_student_reg_id'];
   $dis_id = $row_get['dis_id'];
   $course_name = $row_get['course_name'];
   $category_id = $row_get['category_id'];
   $enrollment = $row_get['enrollment'];
   $cat_name = $obj->getvalfield("m_category", "cat_name", "category_id='$category_id'");
   $last_qualification = $row_get['last_qualification'];
   $district_name = $obj->getvalfield("m_district", "dis_name", "dis_id='$dis_id'");
   $stu_name = $obj->getvalfield("m_student_reg", "stu_name", "m_student_reg_id='$m_student_reg_id'");
   //$this->Rect(5, 5, 140, 287, 'D');
   if ($imgname != '') {
      $pdf->Image("uploaded/scholer_stu_img/" . $imgname, 268, -100 + $y, 15, '');
   } else {
      $y += 50;
   }

   //$pdf->setCellMargin(5);
   $pdf->SetX(5);
   $pdf->SetFont('Arial', '', 7.3);
   $pdf->SetTextColor(0, 0, 0);
   $pdf->Row(array($slno++, $scholer_no, $stu_name, $father_name, $mother_name, $gender, $dob, $cat_name, $course_name, $doa, $address, $row_get['admissionno'], $enrollment, $tc_issue_date, ''));
   $y += 32;
}

$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Output('Company List', 'I');
?>
                            
<?php
mysqli_close($db_link);
?>