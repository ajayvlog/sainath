<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

  $title1 = $obj->getvalfield("college_setting","college_name","1 = 1");

class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2;
         // courier 25
         
         $this->Rect('5','5','287','289');
          $this->SetFont('courier','b',20);
        // Move to the right
        $this->SetFont('courier','b',25);
        $this->Cell(90);
        $this->Cell(90,0,$title1,0,1,'C');
        // Line break
        $this->Ln(7);
        $this->SetFont('courier','b',15);
        $this->Cell(90);
        $this->Cell(90,0,$title2,0,1,'C');
          // Move to the right
         
        
        $this->Ln(2);
        $this->Cell(-1);
        $this->SetFont('courier','b',11);
        $this->Cell(275,5,"Date : ".date('d-m-Y'),0,1,'R');
        $this->Ln(1);
         
        $this->SetX(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(15,8,'SNo','1',0,'L',0);
        $this->Cell(42,8,'Stu_Name',1,0,'L',0);
        $this->Cell(42,8,'FatherName',1,0,'L',0);
        $this->Cell(41,8,'MotherName',1,0,'L',0);
        $this->Cell(30,8,'Mobile',1,0,'L',0);
        $this->Cell(25,8,'Adm_Year',1,0,'L',0);
        $this->Cell(32,8,'Hostel',1,0,'L',0);
        //$this->Cell(25,8,'Class',1,0,'L',0);
        $this->Cell(25,8,'D.O.B.',1,0,'L',0);
        $this->Cell(35,8,'Par_Mobile',1,1,'L',0);
        $this->SetWidths(array(15,42,42,41,30,25,32,25,35));
        $this->SetAligns(array('L','L','L','L','L','L','L','L','R'));
        $this->SetFont('Arial','',6);
        $this->SetX(5);
         
    }
      // Page footer
    function Footer()
    {
    // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8); 
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>
<?php
function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}
$pdf=new PDF_MC_Table();

$pdf->SetTitle($title1);
$title2 = "(HOSTEL LIST)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');

$slno=1;
$res = $obj->executequery("select A.room_id, B.* from transfer_hostel as A left join m_student_reg B on A.m_student_reg_id = B.m_student_reg_id where A.sessionid ='$sessionid'");
          foreach($res as $row_get)
          {

           $m_student_reg_id = $row_get['m_student_reg_id'];
           $stu_name  = $row_get['stu_name'];
           $father_name = $row_get['father_name'];

           $room_id = $row_get['room_id'];
           $room_no = $obj->getvalfield("m_room","room_no","room_id='$room_id'");

           $hostel_id = $obj->getvalfield("m_room","hostel_id","room_id='$room_id'");
           $floor_id = $obj->getvalfield("m_room","floor_id","room_id='$room_id'");
           $hostel_name=$obj->getvalfield("m_hostel","hostel_name","hostel_id='$hostel_id'");
           $floor_name=$obj->getvalfield("m_floor","floor_name","floor_id='$floor_id'");

           $mobile = $row_get['mobile'];
           $admission_year = $row_get['admission_year'];
           $dob = $row_get['dob'];
           $mother_name = $row_get['mother_name'];
           $parent_mobile = $row_get['parent_mobile'];

//$pdf->setCellMargin(5);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$stu_name,$father_name,$mother_name,$mobile,$admission_year,$room_no." / ".$floor_name." / ".$hostel_name,$dob,$parent_mobile));
}
        
$pdf->Output('Company List','I');                       
 ?>
                            
<?php
mysql_close($db_link);
?>