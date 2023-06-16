<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

$title1 = $obj->getvalfield("college_setting","college_name","1 = 1");

if(isset($_GET['class_id']))
$class_id = $_GET['class_id'];
$class_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'");
// else
// $class_id = 0;

if(isset($_GET['sem_id']))
$sem_id = $_GET['sem_id'];
$sem_name = $obj->getvalfield("m_semester","sem_name","sem_id='$sem_id'");
// else
// $sem_id = 0;


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$class_name,$sem_name;
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
         $this->Ln(8);
        $this->SetFont('courier','b',15);
        $this->Cell(90);
        $this->setX(10);
        $this->Cell(90,0,'Class    :'.$class_name,0,1,'L');

        $this->Ln(8);
        $this->SetFont('courier','b',15);
        $this->Cell(90);
        $this->setX(10);
        $this->Cell(90,0,'Semester :'.$sem_name,0,1,'L');
         
        
        $this->Ln(3);
        $this->Cell(-1);
        $this->SetFont('courier','b',11);
        // $this->Cell(60,5,"From Date : ".$obj->dateformatindia($from_date),0,0,'L');
        // $this->Cell(60,5,"To Date : ".$obj->dateformatindia($to_date),0,0,'L');
        $this->Cell(275,5,"Date : ".date('d-m-Y'),0,1,'R');
        $this->Ln(1);
         
        $this->SetX(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(20,8,'SNo','1',0,'L',0);
        $this->Cell(67,8,'Course Name',1,0,'L',0);
        $this->Cell(70,8,'Total Fee',1,0,'R',0);
        $this->Cell(60,8,'Pay Fee',1,0,'R',0);
        //$this->Cell(50,8,'Fee Head',1,0,'L',0);
        //$this->Cell(90,8,'Remark',1,0,'L',0);
        $this->Cell(70,8,'Balance',1,1,'R',0);
        //$this->Cell(25,8,'Class',1,0,'L',0);
        //$this->Cell(25,8,'D.O.B.',1,0,'L',0);
        //$this->Cell(35,8,'Par_Mobile',1,1,'L',0);
        $this->SetWidths(array(20,67,70,60,70));
        $this->SetAligns(array('L','L','R','R','R'));
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
$title2 = "(HEAD WISE FEE REPORT LIST)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');

$slno=1;
$total_pay_all = 0;
$total_fee_all = 0;
$total_balance = 0;

$sql = "select * from m_fee_head";
$res = $obj->executequery($sql);
foreach($res as $row_get)
{
    $fee_head_id = $row_get['fee_head_id'];
    $sql_head_fee = "select sum(total_fee) as totfee from hostel_fee_setting as A left join class_transfer as B on A.transferid = B.transferid left join m_student_reg as C on C.m_student_reg_id = B.m_student_reg_id  where A.fee_head_id='$fee_head_id' and class_id='$class_id' and sem_id='$sem_id' and B.sessionid = '$sessionid'";
    $row_head_fee = $obj->executequery($sql_head_fee);
    $totfee = $row_head_fee[0]['totfee'];
    $sql_head_pay = "select sum(paid_amt) as totfee from fee_payment as A left join class_transfer as B on A.transferid = B.transferid left join m_student_reg as C on C.m_student_reg_id = B.m_student_reg_id  where A.fee_head_id='$fee_head_id' and class_id='$class_id' and sem_id='$sem_id' and B.sessionid = '$sessionid'"; 
    $headname = $row_get['fee_head_name'];
    $row_head_pay = $obj->executequery($sql_head_pay);
    $totpay = $row_head_pay[0]['totfee'];
    $balance = $totfee - $totpay;
    $total_pay_all += $totpay;
    $total_fee_all += $totfee;
    $total_balance += $balance;

//$pdf->setCellMargin(5);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$headname,number_format($totfee,2),number_format($totpay,2),number_format($balance,2)));
}
$pdf->SetX(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(87,8,'Total Amount: ',1,0,'L',0);
$pdf->Cell(70,8,number_format(round($total_fee_all),2),1,0,'R',0);
$pdf->Cell(60,8,number_format(round($total_pay_all),2),1,0,'R',0);
$pdf->Cell(70,8,number_format(round($total_balance),2),1,1,'R',0);    
$pdf->Output('Company List','I');                       
 ?>
                            
<?php
mysql_close($db_link);
?>