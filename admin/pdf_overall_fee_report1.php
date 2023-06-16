<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");
//$acc_type = "student";
$title1 = $obj->getvalfield("college_setting","college_name","1 = '1'");
$crit = " where class_transfer.sessionid='$sessionid'";

if(isset($_GET['class_id']) && $_GET['class_id']!="")
{
  $class_id = trim(addslashes($_GET['class_id']));  
  $crit .=" and m_student_reg.class_id='$class_id' "; 
}

if(isset($_GET['transferid']) && $_GET['transferid']!="")
{
  
  $transferid = trim(addslashes($_GET['transferid']));  
  $crit .=" and class_transfer.transferid ='$transferid' "; 
}

if(isset($_GET['sem_id']) && $_GET['sem_id']!="")
{
  $sem_id = trim(addslashes($_GET['sem_id']));  
  $crit .=" and class_transfer.sem_id='$sem_id' "; 
}
class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;


	function Header()
	{ 
	global $title1,$title2;
	
	
	    $this->Rect(5, 5, 287,200);
		$this->SetFont('courier','b',25);
		$this->Cell(90);
		$this->Cell(90,0,$title1,0,1,'C');
		$this->Ln(7);
		$this->SetFont('courier','b',15);
		$this->Cell(90);
		$this->Cell(90,0,$title2,0,1,'C');
		$this->Ln(2);
		$this->Cell(-1);
		$this->SetFont('courier','b',11);
		$this->Cell(275,5,"Date : ".date('d-m-Y'),0,1,'R');
		$this->Ln(1);
		$this->setCellMargin(2);
		$this->SetX(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(15,8,'SNo','1',0,'L',0);
		$this->Cell(72,8,'student_Name',1,0,'L',0);
		$this->Cell(40,8,'Class_Name',1,0,'L',0);
		$this->Cell(40,8,'Sem/Year',1,0,'L',0);
		$this->Cell(40,8,'Total_Amt',1,0,'R',0);
		$this->Cell(40,8,'Total_Paid',1,0,'R',0);
		$this->Cell(40,8,'Total_Bal',1,1,'R',0);
		$this->SetWidths(array(15,72,40,40,40,40,40));
		$this->SetAligns(array('L','L','L','L','R','R','R'));
		
	}
	function Footer()
	{ 
	    $this->SetY(-15);
		$this->SetFont('Arial','I',0);
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
function SetCellMargin($margin)
	 {
        // Set cell margin
        $this->cMargin = $margin;
    }
function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=7*$nb;
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
        $this->MultiCell($w,7,$data[$i],0,$a);
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
//$title1 = "Library Management";
$pdf->SetTitle($title1);
$title2 = "(Overall Fee Report)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$slno=1;
$tot_paid = 0;
$tot_bal = 0;
$tot_fee = 0;
$totalfee = 0;
$totalpaid = 0;
$totalbal = 0;
$sql = "select *, stu_name from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit";

$res = $obj->executequery($sql);
foreach($res as $row_get)
{

$transferid = $row_get['transferid'];
$stu_name = $row_get['stu_name'];
$sem_id = $row_get['sem_id'];
$sem_name = $obj->getvalfield("m_semester","sem_name","sem_id=$sem_id");

$class_id = $row_get['class_id'];
$class_name=$obj->getvalfield("m_class","class_name","class_id=$class_id");

$total_fee = $obj->getvalfield("hostel_fee_setting","sum(total_fee)","transferid='$transferid' and sessionid='$sessionid'");

$paid_amt = $obj->getvalfield("fee_payment","sum(paid_amt)"," transferid='$transferid'");

$bal_amount = $total_fee - $paid_amt;
//$pdf->setCellMargin(5);
$pdf->SetX(5);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Row(array($slno++,$stu_name,$class_name,$sem_name,number_format($total_fee,2),number_format($paid_amt,2),number_format($bal_amount,2)));

$tot_fee += $total_fee;
$tot_paid += $paid_amt;
$tot_bal += $bal_amount;

			
}

$pdf->SetX(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(247,8,'Total Amount: ',1,0,'R',0);
$pdf->Cell(40,8,number_format(round($tot_fee),2),1,1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(247,8,'Total Paid Amt: ',1,0,'R',0);
$pdf->Cell(40,8,number_format(round($tot_paid),2),1,1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(247,8,'Total Balance Amt: ',1,0,'R',0);
$pdf->Cell(40,8,number_format(round($tot_bal),2),1,1,'R',0);
		
$pdf->Output('Company List','I');				        
 ?>