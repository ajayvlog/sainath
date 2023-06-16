<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

  $title1 = $obj->getvalfield("college_setting","college_name","1 = 1");
$crit = " where 1 = 1 "; 

if(isset($_GET['transferid']) && $_GET['transferid']!="")
{
  $transferid = trim(addslashes($_GET['transferid']));  
  $m_student_reg_id = $obj->getvalfield("class_transfer","m_student_reg_id","transferid='$transferid'");
  $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id='$m_student_reg_id'");
  $crit .=" and transferid='$transferid' "; 
}
else
{
  $transferid = "";
}
class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$stu_name,$transferid;
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
        if($transferid!="") {
        $this->Ln(8);
        $this->SetFont('courier','b',15);
        $this->Cell(90);
        $this->Cell(90,0,$stu_name,0,1,'C');
        }
        if($transferid =="") {
        $this->Ln(8);
        $this->SetFont('courier','b',15);
        $this->Cell(90);
        $this->Cell(90,0,"All Record Selected",0,1,'C');
        }
        $this->Ln(2);
        $this->Cell(-1);
        $this->SetFont('courier','b',11);
        $this->Cell(275,5,"Date : ".date('d-m-Y'),0,1,'R');
        $this->Ln(1);
         
        $this->SetX(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(15,8,'SNo','1',0,'L',0);
        $this->Cell(30,8,'Receipt_no',1,0,'L',0);
        $this->Cell(35,8,'Payment_date',1,0,'L',0);
        $this->Cell(41,8,'Fee_Head',1,0,'L',0);
        $this->Cell(35,8,'Payment_Type',1,0,'L',0);
         $this->Cell(41,8,'Paid_amount',1,0,'R',0);
        $this->Cell(90,8,'Remark',1,1,'L',0);
       
        //$this->Cell(25,8,'Class',1,0,'L',0);
        //$this->Cell(25,8,'D.O.B.',1,0,'L',0);
        //$this->Cell(35,8,'Par_Mobile',1,1,'L',0);
        $this->SetWidths(array(15,30,35,41,35,41,90));
        $this->SetAligns(array('L','L','L','L','L','R','L'));
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
$title2 = "(STUDENT WISE FEE REPORT LIST)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');

$slno=1;
$totalpaid = 0;
$sql = "select * from fee_payment $crit";
$res = $obj->executequery($sql);
foreach($res as $row_get)
{
    $transferid = $row_get['transferid'];
    $fee_head_id = $row_get['fee_head_id'];
    $fee_head_name=$obj->getvalfield("m_fee_head","fee_head_name","fee_head_id='$fee_head_id'");
    $reciept_no = $row_get['reciept_no'];
    $pay_date = $obj->dateformatindia($row_get['pay_date']);
    $payment_type = $row_get['payment_type'];
    $paid_amt = $row_get['paid_amt'];
    $remark = $row_get['remark'];

//$pdf->setCellMargin(5);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$reciept_no,$pay_date,$fee_head_name,$payment_type,number_format($paid_amt,2),$remark));
    $totalpaid += $paid_amt;
}
$pdf->SetX(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(246,8,'Total Amount: ',1,0,'R',0);
$pdf->Cell(41,8,number_format(round($totalpaid),2),1,1,'R',0);    
$pdf->Output('Company List','I');                       
 ?>
                            
<?php
mysql_close($db_link);
?>