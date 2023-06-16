<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

  $title1 = $obj->getvalfield("college_setting","college_name","1 = '1'");

$month = "";
$class_id = "";
$sem_id = "";
$year = "";
$year_month = "";

$crit1 = " 1 = 1 ";
$crit2 = " where 1 = 1";

if(isset($_GET['month']) && isset($_GET['year']) )
{
    $month = $obj->test_input($_GET['month']); 
    $month_name = date("F", mktime(0, 0, 0, $month, 10));  
    $year = $obj->test_input($_GET['year']);
    $year_month = $year.'-'.$month;
    $crit1 .= " and DATE_FORMAT(attendance_date,'%Y-%m')='$year_month' ";
}

if(isset($_GET['class_id']) || $class_id !='')
{
    $class_id = $obj->test_input($_GET['class_id']); 
    $class_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'"); 
    $crit2 .= " and B.class_id='$class_id' ";      
}

if(isset($_GET['sem_id']) || $sem_id !='')
{
    $sem_id = $obj->test_input($_GET['sem_id']);
    $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id='$sem_id'");
    $crit2 .= " and A.sem_id='$sem_id' ";      
}


  $no_of_holiday = $obj->getvalfield("m_holiday","count(holiday_date)","DATE_FORMAT(holiday_date,'%Y-%m')='$year_month'");

if($month!='' && $year!='')
$count_sunday = $obj->total_sundays($month,$year);
else
$count_sunday = 0;
class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$month_name,$year,$class_name,$sem_name;
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
        $this->Cell(90,0,'Month    :'.$month_name,0,1,'L');

        $this->Ln(8);
        $this->SetFont('courier','b',15);
        $this->Cell(90);
        $this->setX(10);
        $this->Cell(90,0,'Year     :'.$year,0,1,'L');
  
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
         
        
        $this->Ln(2);
        $this->Cell(-1);
        $this->SetFont('courier','b',11);
        $this->Cell(275,5,"Date : ".date('d-m-Y'),0,1,'R');
        $this->Ln(1);
         
        $this->SetX(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(15,8,'SNo','1',0,'L',0);
        $this->Cell(50,8,'Student Name/Bio_code',1,0,'L',0);
        $this->Cell(50,8,'Father Name',1,0,'L',0);
        $this->Cell(28,8,'Mobile',1,0,'L',0);
        $this->Cell(28,8,'Month_Day',1,0,'L',0);
        $this->Cell(25,8,'Present',1,0,'L',0);
        $this->Cell(25,8,'Holiday',1,0,'L',0);
        $this->Cell(25,8,'Sunday',1,0,'L',0);
        $this->Cell(41,8,'Attendance(%)',1,1,'L',0);
        
        
        $this->SetWidths(array(15,50,50,28,28,25,25,25,41));
        $this->SetAligns(array('L','L','L','L','L','L','L','L','L'));
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
$title2 = "(STUDENT PERCENTAGE REPORT LIST)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$slno=1;
$res = $obj->executequery("select * from class_transfer as A left join m_student_reg as B on A.m_student_reg_id=B.m_student_reg_id $crit2 and A.sessionid = '$sessionid'");
foreach($res as $rowget)
{
$transferid=$rowget['transferid'];
$m_student_reg_id=$rowget['m_student_reg_id'];
$stu_name=$obj->getvalfield("m_student_reg","stu_name","m_student_reg_id=$m_student_reg_id");
$father_name=$obj->getvalfield("m_student_reg","father_name","m_student_reg_id=$m_student_reg_id");
$mobile=$obj->getvalfield("m_student_reg","mobile","m_student_reg_id=$m_student_reg_id");

$biometric_code=$obj->getvalfield("m_student_reg","biometric_code","m_student_reg_id=$m_student_reg_id");


$pday=$obj->getvalfield("attendance_entry","count(distinct(attendance_date))","$crit1 and transferid='$transferid' and WEEKDAY(attendance_date) <> 6");
//die;
$month_days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
$tot_pday = $pday + $no_of_holiday + $count_sunday;
$tot_percen_stu = ($tot_pday / $month_days) * 100;

//$pdf->setCellMargin(5);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$stu_name." / ".$biometric_code,$father_name,$mobile,$month_days,$pday,$no_of_holiday,$count_sunday,round($tot_percen_stu)."%"));
}
//}
        
$pdf->Output('Company List','I');                       
 ?>
                            
<?php
mysql_close($db_link);
?>