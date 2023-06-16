<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

  $title1 = $obj->getvalfield("college_setting","college_name","1 = '1'");

if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $_GET['from_date'];
    $to_date  =  $_GET['to_date'];
}
else
{
    $to_date =date('Y-m-d');
    $from_date =date('Y-m-d');
    
}

$crit = " where 1 = 1 and createdate between '$from_date' and '$to_date'"; 
if(isset($_GET['class_id']))
{
  $class_id = $_GET['class_id'];
  if($class_id != "")
    $crit .= " and class_id = '$class_id' ";
}

class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$obj, $from_date, $to_date;
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
        $this->Cell(-1);
        $this->SetFont('courier','b',11);
        $this->Cell(60,5,"Form Date : ".$obj->dateformatindia($from_date),0,0,'L');
        $this->Cell(60,5,"To Date : ".$obj->dateformatindia($to_date),0,0,'L');
        $this->Cell(155,5,"Date : ".date('d-m-Y'),0,1,'R');
        $this->Ln(1);
         
        $this->SetX(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(15,8,'SNo.','1',0,'L',0);
        $this->Cell(45,8,'Name',1,0,'L',0);
        $this->Cell(25,8,'Mobile',1,0,'L',0);
        $this->Cell(40,8,'District Name',1,0,'L',0);
        $this->Cell(40,8,'Address',1,0,'L',0);
        $this->Cell(60,8,'Previous School/College',1,0,'L',0);
        $this->Cell(30,8,'Course',1,0,'L',0);
        $this->Cell(32,8,'Date',1,1,'L',0);
        $this->SetWidths(array(15,45,25,40,40,60,30,32));
        $this->SetAligns(array('L','L','L','L','L','L','L','L'));
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
// $title1 = $cmn->getvalfield("company_setting","comp_name","1 = 1");
// $pdf->SetTitle($title1);
// $title2 = "Payment Report";
// $pdf->SetTitle($title2);
// $title3= "From : ".$cmn->dateformatindia($fromdate); 
// $pdf->SetTitle($title3);
// $title4= "To : ".$cmn->dateformatindia($todate); 
// $pdf->SetTitle($title4);
// $pdf->AliasNbPages();
// $pdf->AddPage('P','A4');
$pdf->SetTitle($title1);
$title2 = "(Enquiry Report)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');

$slno=1;
$sql = "select * from enquiry_master $crit order by createdate desc";
$res = $obj->executequery($sql);
foreach($res as $row_get)
{
    $disid = $row_get['dis_id'];
    $districtname=$obj->getvalfield("m_district","dis_name","dis_id='$disid'");
    $enq_name=$row_get['enq_name'];
    $mobile=$row_get['mobile']; 
    $address=$row_get['address'];
    $prv_schl=$row_get['prv_schl']; 
    $course_name=$obj->getvalfield("m_class","class_name","class_id='$row_get[class_id]'");
    $createdate= $obj->dateformatindia($row_get['createdate']); 
//$pdf->setCellMargin(5);
$pdf->SetX(5);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Row(array($slno++,$enq_name,$mobile,$districtname,$address,$prv_schl,$course_name,$createdate));
}

// $pdf->SetX(5);
// $pdf->SetFont('Arial','B',12);
// $pdf->Cell(247,8,'Total Amount: ',1,0,'R',0);
// $pdf->Cell(40,8,number_format(round($tot_fee),2),1,1,'R',0);

// $pdf->SetX(5);
// $pdf->SetFont('Arial','B',12);
// $pdf->Cell(247,8,'Total Paid Amt: ',1,0,'R',0);
// $pdf->Cell(40,8,number_format(round($tot_paid),2),1,1,'R',0);

// $pdf->SetX(5);
// $pdf->SetFont('Arial','B',12);
// $pdf->Cell(247,8,'Total Balance Amt: ',1,0,'R',0);
// $pdf->Cell(40,8,number_format(round($tot_bal),2),1,1,'R',0);
        
$pdf->Output('Company List','I');                       
 ?>
                            
<?php
mysql_close($db_link);
?>