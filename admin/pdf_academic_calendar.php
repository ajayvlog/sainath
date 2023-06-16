<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");
if(isset($_SESSION))
{
    $sessionid = $_SESSION['sessionid'];
    if($sessionid!="")
    {
        $session_name = $obj->getvalfield("m_session","session_name","sessionid='$sessionid'");
    }
}else{
    $sessionid = "";
}


$pagename = "pdf_academic_calendar.php";

  $title1 = $obj->getvalfield("college_setting","college_name","1 = 1");





class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$session_name,$obj,$from_date,$to_date,$fee_head_id,$fee_head_name;
         // Arial 25
        //$this->SetFillColor(175,238,238);
        $this->Rect('5','5','200','280');
         $this->SetFont('Arial','b',20);
        // Move to the right

       $this->SetFillColor(175,238,238);
        $this->SetY(5);
        $this->SetX(5);
        $this->Cell(200,31,'','1',0,'L',1); 
        
        $this->SetFillColor(0, 0, 0);//WHITE
       

        $this->SetFont('Arial','b',25);
        $this->SetY(8);
        $this->SetX(25);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(35,5,$title1,0,0,'L');

         $this->Ln(12);
        $this->SetFont('Arial','b',15);
        $this->Cell(78);
        $this->Cell(35,0,$title2,0,1,'C');
       
      

      /*  $this->SetFont('Arial','b',25);
        $this->Cell(78);
        $this->SetY(5);
        $this->SetX(10);
        $this->Cell(35,5,$title1,1,1,'C');
        // Line break
        $this->Ln(7);
        $this->SetFont('Arial','b',15);
        $this->Cell(78);
        $this->Cell(35,0,$title2,0,1,'C');*/
          // Move to the right

        
        $this->Ln(-1);
        
        $this->SetFont('Arial','b',11);
        
        $this->Cell(190,5,"Session : ".$session_name,0,1,'R');
        $this->Ln(1);

        if($fee_head_id == "")
        {
        
        $this->Ln(1);
        $this->SetFont('Arial','b',11);
        $this->Cell(115,5,"Academic Calendar",0,1,'R');
       
        }
        if($fee_head_id!="")
        {
       
        $this->Ln(1);
        $this->SetFont('Arial','b',11);
        $this->Cell(115,5,"$fee_head_name",0,1,'R');
        
        }


        $this->Ln(5);
        $this->SetX(5);
        $this->SetFont('Arial','B',12);
        $this->SetFillColor(128,128,128);
        //$this->SetTextColor(225,225,225);
        $this->Cell(15,8,'SNo','1',0,'L',1);
        $this->Cell(30,8,'From Date',1,0,'L',1);
        $this->Cell(30,8,'To Date',1,0,'L',1);
        $this->Cell(124.5,8,'Subject',1,1,'L',1);
        
        $this->SetWidths(array(15,30,30,124.5));  
        $this->SetAligns(array('L','L','L','L'));
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
$title2 = "(ACADMIC CALENDAR)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');

$slno=1;
$totalpaid = 0;
  $sql = "select * from acadmic_calendar order by acadmic_cal_id desc";
$res = $obj->executequery($sql);
foreach($res as $row_get)
{
    $from_date = $row_get['from_date'];
    $to_date = $row_get['to_date'];
    $subject = $row_get['subject'];
    

//$pdf->setCellMargin(5);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$obj->dateformatindia($from_date),$obj->dateformatindia($to_date),$subject));
    
}
$pdf->SetX(5);
$pdf->SetFont('Arial','B',12);   
$pdf->Output('Company List','I');                       
 ?>
                            
<?php
mysqli_close($db_link);
?>