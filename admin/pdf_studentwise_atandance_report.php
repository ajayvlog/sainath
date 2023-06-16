<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

  $title1 = $obj->getvalfield("college_setting","college_name","1 = '1'");
  

$month = "";


$crit1 = " where 1 = 1";
$crit2 = " where 1 = 1";

if(isset($_GET['month']) && isset($_GET['year']) )
{
    $month = $obj->test_input($_GET['month']);  
    $month_name = date("F", mktime(0, 0, 0, $month, 10));

    $year = $obj->test_input($_GET['year']);
    $year_month = $year.'-'.$month;
    $crit1 .= " and DATE_FORMAT(attendance_date,'%Y-%m')='$year_month' ";

}



if(isset($_GET['transferid']) || $transferid !='')
{
    $transferid = $obj->test_input($_GET['transferid']);  
    $crit2 .= " and transferid='$transferid' ";      
}



$qry = $obj->executequery("select * from attendance_entry where transferid='$transferid'");
foreach ($qry as $key) 
{
   $transferid = $key['transferid'];
   $m_student_reg_id = $obj->getvalfield("class_transfer","m_student_reg_id","transferid='$transferid'");
  $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id='$m_student_reg_id'");
  $class_id = $obj->getvalfield("m_student_reg","class_id","m_student_reg_id='$m_student_reg_id'");
  $class_name = $obj->getvalfield("m_class","class_name","class_id='$class_id'");
}

class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$stu_name,$year,$month_name,$class_name;
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

        
        $this->Ln(5);
        $this->Cell(-1);
        $this->SetFont('courier','b',11);
        $this->setX(6);
        $this->Cell(50,10,"Date : ".date('d-m-Y'),0,1,'L');


        
        $this->SetFont('courier','b',11);
        $this->setY(22);
        $this->setX(60);
        $this->Cell(100,10,"Student : ".$stu_name,0,1,'L');

        $this->SetFont('courier','b',11);
        $this->setY(22);
        $this->setX(120);
        $this->Cell(100,10,"Class : ".$class_name,0,1,'L');

        $this->SetFont('courier','b',11);
        $this->setY(22);
        $this->setX(250);
        $this->Cell(40,10,"Year : ".$year,0,1,'L');

        $this->SetFont('courier','b',11);
        $this->setY(22);
        $this->setX(190);
        $this->Cell(40,10,"Month : ".$month_name,0,1,'L');
        
        

        $this->Ln(5);
        $this->SetX(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(23,8,'SNo','1',0,'L',0);
        $this->Cell(80,8,'Date',1,0,'L',0);
        $this->Cell(80,8,'Status',1,0,'L',0);
        $this->Cell(52,8,'In_Time',1,0,'L',0);
         $this->Cell(52,8,'Out_Time',1,1,'L',0);
        
        
        
        $this->SetWidths(array(23,80,80,52,52));
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

$pdf->SetTitle($title1);
$title2 = "(STUDENT WISE ATTENDANCE REPORT LIST)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');

$slno=1;
$tot = 0;
$tot_present = 0;
$res = $obj->executequery("select * from attendance_entry $crit2");

$month_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
$ldate = date("$month_days-$month-$year");

for($d=1; $d<=$month_days; $d++) {

if($d < 10)
$d='0'.$d; 
$mydate = "$year-$month-$d";
 $nameOfDay = date('D', strtotime($mydate));
 $aday = date($month);

$count = $obj->getvalfield("attendance_entry","count(*)","attendance_date='$mydate' && transferid='$transferid'"); 

$in_entry = $obj->getvalfield("attendance_entry","attendance_time","transferid='$transferid' and attendance_date='$mydate' order by attendance_id asc limit 0,1");

if($count > 1)
{
$out_entry = $obj->getvalfield("attendance_entry","attendance_time","transferid='$transferid' and attendance_date='$mydate' order by attendance_id desc limit 0,1");
}
else
$out_entry = "";
                           
$attendance_time = $obj->getvalfield("attendance_entry","attendance_time","transferid='$transferid' and attendance_date='$mydate'");
 $attendanceday = $obj->getvalfield("attendance_entry","count(attendance_date)","transferid='$transferid' and DATE_FORMAT(attendance_date,'%m')='$aday'");
 $searh_year_month = $year.'-'.$month;
$no_of_holiday = $obj->getvalfield("m_holiday","count(holiday_date)","DATE_FORMAT(holiday_date,'%Y-%m')='$searh_year_month'");
$count_sunday = $obj->total_sundays($month,$year);
$sumholiday = $no_of_holiday + $count_sunday;
$presentdays = $attendanceday + $sumholiday;

if($attendance_time == "")
$atype = "Absent";
else
$atype = "Present";

$tot_present = $presentdays;
$total_absnt = $month_days - $tot_present;

$searh_year_month = $year.'-'.$month;
$isholiday = $obj->getvalfield("m_holiday","count(*)","holiday_date='$mydate'");

if($isholiday > 0)
$atype = "Holiday";

if(strtolower($nameOfDay) == 'sun')
$atype = "Sunday";

    $pdf->SetX(5);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$obj->dateformatindia($mydate),$atype,$in_entry,$out_entry));

   
}

    
    $pdf->SetFont('courier','b',15);
    $pdf->setX(210);
    $pdf->Cell(40,10,"Total Present : ".$tot_present.' Days',0,1,'L');

    $pdf->SetFont('courier','b',15);
    $pdf->setX(210);
    $pdf->Cell(40,10,"Total Absent  : ".$total_absnt.' Days',0,1,'L');
        
$pdf->Output('Company List','I');                       
 ?>
                            
<?php
mysql_close($db_link);
?>