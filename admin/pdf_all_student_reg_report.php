<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");
$college_name =  $obj->getvalfield("college_setting","college_name","1 = 1");

$crit = " where 1 = 1 ";

if(isset($_GET['class_id']))
{
  $class_id = trim(addslashes($_GET['class_id']));  
  $crit .=" and m_student_reg.class_id='$class_id' "; 
}
else
$class_id = 0;

if(isset($_GET['s_sessionid']))
{
  $s_sessionid = trim(addslashes($_GET['s_sessionid']));  
  $crit .=" and class_transfer.sessionid='$s_sessionid' "; 
}
else
$s_sessionid = 0;


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

	function Header()
	{
		global $title1,$title2,$college_name;
		
		$this->Rect(5,5,200,287);
	    $this->SetFont('courier','b',15);
		$this->Line(5,20,205,20);
		 // courier 25
		$this->SetFont('courier','b',20);
		// Move to the right
		$this->Cell(95);
		// Title
		$this->Cell(10,0,$title1,0,0,'C');
		// Line break
		$this->Ln(6);
		// Move to the right
		$this->Cell(90);
		 // courier bold 15
		$this->SetFont('courier','b',11);
		$this->Cell(20,0,$title2,0,0,'C');
		  // Move to the right
		$this->Cell(80);
		// Line break
		$this->Ln(5);
		
		$this->Cell(-1);
		$this->SetFont('courier','b',8);
		//$this->Cell(95,5,"".$collect_from,0,0,'L');
		$this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');
		 $this->Ln(1);
		 
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
$title1 = "$college_name";
$pdf->SetTitle($title1);
$title2 = "All Student Registration Report";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(8,6,'Sno','1',0,'L',0);
$pdf->Cell(15,6,'Stu/Mo.',1,0,'L',0);
$pdf->Cell(15,6,'Father',1,0,'L',0);
$pdf->Cell(18,6,'Class/Eroll',1,0,'L',0);
$pdf->Cell(13,6,'Gender',1,0,'L',0);
$pdf->Cell(16,6,'Sem/Year',1,0,'L',0);
$pdf->Cell(23,6,'Cast/Category',1,0,'L',0);
$pdf->Cell(17,6,'Aadharno',1,0,'L',0);
$pdf->Cell(18,6,'DOB',1,0,'L',0);
$pdf->Cell(15,6,'Email',1,0,'L',0);
$pdf->Cell(18,6,'Dist/Pin',1,0,'L',0);
$pdf->Cell(18,6,'Bank/IFSC',1,0,'L',0);
$pdf->Cell(10,6,'A/C NO',1,0,'L',0);
$pdf->Cell(10,6,'Roll',1,0,'L',0); 
$pdf->Cell(22,6,'Address',1,1,'L',0);

$pdf->SetX(5);
$pdf->SetAligns(array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L'));
$pdf->SetWidths(array(8,15,15,18,13,16,23,17,18,15,18,18,10,10,22));
$pdf->SetFont('Arial','',6);
											
    $slno=1;

    $sql = "select * from class_transfer left join m_student_reg
    on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit";
    $res = $obj->executequery($sql);
    foreach($res as $row_get)
    {
    $m_student_reg_id = $row_get['m_student_reg_id'];
    $stu_name = $row_get['stu_name'];
    $class_id=$row_get['class_id'];
    $class_name=$obj->getvalfield("m_class","class_name","class_id=$class_id");
    $father_name = $row_get['father_name'];
    $enrollment = $row_get['enrollment'];
    $gender = $row_get['gender'];
    $mobile = $row_get['mobile'];
    $cast = $row_get['cast'];
    $category_id = $row_get['category_id'];
    $cat_name=$obj->getvalfield("m_category","cat_name","category_id=$category_id");
    $sem_id = $row_get['sem_id'];
    $sem_name=$obj->getvalfield("m_semester","sem_name","sem_id=$sem_id");
    $aadhar_no = $row_get['aadhar_no'];

    $pdf->SetX(5);	
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$stu_name." / ".$mobile,$father_name,$class_name." / ".$enrollment,$gender,$sem_name,$cast." / ".$cat_name,$aadhar_no,$obj->dateformatindia($row_get['dob']),$row_get['email'],$row_get['district']." / ".$row_get['pincode'],$row_get['bank_name']." / ".$row_get['ifsc']));

    //$totamount += $total_amt;	
    }

// $pdf->SetFont('Arial','b',9);
// $pdf->Cell(25,6,'TotalAmount',0,0,'R',0);
// $pdf->Cell(170,6,number_format($totamount,2),0,1,'R',0);
$pdf->Output();
?>                     	
<?php
mysql_close($db_link);
?>