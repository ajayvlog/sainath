<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

$title1 = $obj->getvalfield("college_setting","college_name","1 = '1'");

$class_id = "";
$sem_id = "";
$stu_subject_id = "";
$crit = " where 1 = 1";


if(isset($_GET['attendate']))
{
    $attendate = $_GET['attendate'];
    //$crit1 .= " and attendate='$attendate' ";      
}
else
{
    $attendate= date('d-m-Y');
}

if(isset($_GET['class_id']) || $class_id !='')
{
    $class_id = $obj->test_input($_GET['class_id']);  
    $crit .= " and B.class_id='$class_id' ";      
}

if(isset($_GET['sem_id']) || $sem_id !='')
{
    $sem_id = $obj->test_input($_GET['sem_id']);
    $crit .= " and A.sem_id='$sem_id' ";      
}

if(isset($_GET['stu_subject_id']) || $stu_subject_id !='')
{
    $stu_subject_id = $obj->test_input($_GET['stu_subject_id']);
    //$crit1 .= " and stu_subject_id='$stu_subject_id' ";      
}
$sem_name = $obj->getvalfield("m_semester","sem_name","sem_id='$sem_id'");
$subject_name = $obj->getvalfield("student_subject_master","subject_name","stu_subject_id='$stu_subject_id'");
$class_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'");
class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$class_name,$sem_name,$subject_name,$attendate;
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
        $this->Cell(90,0,'Course   :'.$class_name,0,1,'L');
  
        $this->Ln(8);
        $this->SetFont('courier','b',15);
        $this->Cell(90);
        $this->setX(10);
        $this->Cell(90,0,'Semester :'.$sem_name,0,1,'L');

        $this->Ln(8);
        $this->SetFont('courier','b',15);
        $this->Cell(90);
        $this->setX(10);
        $this->Cell(90,0,'Subject  :'.$subject_name,0,1,'L');
        
        $this->Ln(2);
        $this->Cell(-1);
        $this->SetFont('courier','b',11);
        $this->Cell(275,5,"Date : ".$attendate,0,1,'R');
        $this->Ln(1);
         
        $this->SetX(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(15,8,'SNo','1',0,'L',0);
        $this->Cell(70,8,'Student Name',1,0,'L',0);
        $this->Cell(35,8,'Biometric_code',1,0,'L',0);
        $this->Cell(70,8,'Father Name',1,0,'L',0);
        $this->Cell(32,8,'Mobile',1,0,'L',0);
        $this->Cell(32,8,'Status',1,0,'L',0);
        $this->Cell(33,8,'Time',1,1,'L',0);
        
        $this->SetWidths(array(15,70,35,70,32,32,33));
        $this->SetAligns(array('L','L','L','L','L','L','L'));
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
$title2 = "(APP STUDENT ATTENDENCE REPORT LIST)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');

$slno=1;
$res = $obj->executequery("select B.stu_name,B.father_name,B.biometric_code,B.mobile,A.transferid from class_transfer as A left join m_student_reg as B on A.m_student_reg_id=B.m_student_reg_id $crit and A.sessionid = '$sessionid'");
foreach($res as $rowget)
{
$transferid=$rowget['transferid'];
$stu_name=$rowget['stu_name'];
$father_name=$rowget['father_name'];
$mobile=$rowget['mobile'];
$biometric_code = $rowget['biometric_code'];
$count = $obj->getvalfield("app_subject_attendence","count(*)","attendate = '$attendate' and stu_subject_id = '$stu_subject_id' and transferid = '$transferid'");
if($count > 0)
$status = "Present";

else
$status = "Absent";


$attendanc_time = $obj->getvalfield("app_subject_attendence","attendanc_time","attendate = '$attendate' and stu_subject_id = '$stu_subject_id' and transferid = '$transferid'");

//$pdf->setCellMargin(5);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$stu_name,$biometric_code,$father_name,$mobile,$status,$attendanc_time));
}
    // $pdf->SetFont('courier','b',15);
    // $pdf->setX(210);
    // $pdf->Cell(40,10,"Total Present : ".$tot_present.' Days',0,1,'L');

    // $pdf->SetFont('courier','b',15);
    // $pdf->setX(210);
    // $pdf->Cell(40,10,"Total Absent  : ".$total_absnt.' Days',0,1,'L');
        
$pdf->Output('Company List','I');                       
 ?>
                            
<?php
mysql_close($db_link);
?>