<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

if(isset($_GET['expanse_id']))
{
    $expanse_id = $_GET['expanse_id'];
}
else
{
    $expanse_id = "";
}

  $title1 = $obj->getvalfield("college_setting","college_name","1 = 1");

  $res = $obj->executequery("select * from expanse where expanse_id='$expanse_id'");
foreach($res as $row_get)
    {
      $exp_name = $row_get['exp_name'];
      $mode = $row_get['mode'];
      $exp_date = $obj->dateformatindia($row_get['exp_date']);
      $pay_type = $row_get['pay_type'];
      $exp_amount = $row_get['exp_amount'];
      $voucher_no = $row_get['voucher_no'];
      $remark = $row_get['remark'];
      
      $ex_group_id = $row_get['ex_group_id'];
      $groupname = $obj->getvalfield("m_expanse_group","group_name","ex_group_id='$ex_group_id'");
  }

class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$voucher_no,$exp_date,$groupname,$mode,$exp_name,$pay_type,$exp_amount;
         // courier 25
         // first rect outer
         $this->Rect('5','5','200','287');
         //first rect line
          $this->Line('5','20','205','20');
         // second rect 
         $this->Rect('12','25','186','110');
         $this->Line('12','36','198','36');
         // third line vertical
       $this->Rect('12','25','110','50');
        $this->Line('120','75','198','75');
        
          $this->SetFont('courier','b',20);
        // Move to the right
        $this->SetFont('courier','b',15);
        $this->Cell(50);
        $this->Cell(90,0,$title1,0,1,'C');
        // Line break
        $this->Ln(7);
        $this->SetFont('courier','b',11);
        $this->Cell(50);
        $this->Cell(90,0,$title2,0,1,'C');
          // Move to the right
        $this->Ln(1);
         
        $this->SetTextColor(0,0,0);
        $this->SetFont( 'Arial', 'b',9); 
        $this->SetY(26);
        $this->SetX(15);
        $this->Cell(10,10,'Voucher No.',0,0,'');
        
        $this->SetY(29.3);
        $this->SetX(40);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'courier', '',9);
        $this->SetY(29);
        $this->SetX(45);
        $this->MultiCell(50,4,$voucher_no,0,'L');

        $this->SetTextColor(0,0,0);
        $this->SetFont( 'Arial', 'b',9); 
        $this->SetY(26);
        $this->SetX(125);
        $this->Cell(10,10,'Date ',0,0,'');
        
        $this->SetY(29.3);
        $this->SetX(138);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'courier', '',9);
        $this->SetY(29);
        $this->SetX(141);
        $this->MultiCell(50,4,$exp_date,0,'L');

        $this->SetTextColor(0,0,0);
        $this->SetFont( 'Arial', 'b',9); 
        $this->SetY(36);
        $this->SetX(15);
        $this->Cell(10,10,'Expanse Group name ',0,0,'');
        
        $this->SetY(39.3);
        $this->SetX(55);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'courier', '',9);
        $this->SetY(39.3);
        $this->SetX(59);
        $this->MultiCell(50,4,$groupname,0,'L');

        $this->SetTextColor(0,0,0);
        $this->SetFont( 'Arial', 'b',9); 
        $this->SetY(36);
        $this->SetX(125);
        $this->Cell(10,10,'Payment Type ',0,0,'');
        
        $this->SetY(39.3);
        $this->SetX(150);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'courier', '',9);
        $this->SetY(39);
        $this->SetX(154);
        $this->MultiCell(50,4,$pay_type,0,'L');
       // $this->Line(59,55,150,55);

        $this->SetTextColor(0,0,0);
        $this->SetFont( 'Arial', 'b',9); 
        $this->SetY(46);
        $this->SetX(15);
        $this->Cell(10,10,'Expanse  name ',0,0,'');
        
        $this->SetY(49.3);
        $this->SetX(55);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'courier', '',9);
        $this->SetY(49.3);
        $this->SetX(59);
        $this->MultiCell(50,4,$exp_name,0,'L');

        $this->SetTextColor(0,0,0);
        $this->SetFont( 'Arial', 'b',9); 
        $this->SetY(46);
        $this->SetX(125);
        $this->Cell(10,10,'Amount ',0,0,'');
        
        $this->SetY(49.3);
        $this->SetX(150);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'courier', '',9);
        $this->SetY(49.3);
        $this->SetX(155);
        $this->MultiCell(50,4,$exp_amount.""."/-",0,'L');
        //$this->Line(59,65,150,65);

        $this->SetTextColor(0,0,0);
        $this->SetFont( 'Arial', 'b',9); 
        $this->SetY(56);
        $this->SetX(15);
        $this->Cell(10,10,'Payment Mode ',0,0,'');
        
        $this->SetY(59.5);
        $this->SetX(55);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'courier', '',9);
        $this->SetY(59.5);
        $this->SetX(59);
        $this->MultiCell(50,4,strtoupper($mode),0,'L');
        //$this->Line(59,79,150,79);
         
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
$title2 = "Voucher Receipt";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');



        
$pdf->Output('Company List','I');                       
 ?>
  