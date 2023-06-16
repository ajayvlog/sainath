<?php 
include("../adminsession.php");
include("fpdf17/fpdf.php");
$college_name =  $obj->getvalfield("college_setting","college_name","1 = 1");
$emailc =  $obj->getvalfield("college_setting","email","1 = 1");
$addressc =  $obj->getvalfield("college_setting","address","1 = 1");
$mobilec =  $obj->getvalfield("college_setting","mobile","1 = 1");
$cityc =  $obj->getvalfield("college_setting","city","1 = 1");
if(isset($_GET['salary_id']))
{ 
        $salary_id = $_GET['salary_id'];
        $res = $obj->executequery("select * from emp_salary where salary_id = '$salary_id'");
         foreach($res as $row_get)
       {
        $employee_id = $row_get['employee_id'];
        $emp_name = $obj->getvalfield("m_employee","emp_name","employee_id=$employee_id");
        $bank_details = $obj->getvalfield("m_employee","bank_details","employee_id=$employee_id");
        $acc_no = $obj->getvalfield("m_employee","acc_no","employee_id=$employee_id");
        $ifsc = $obj->getvalfield("m_employee","ifsc","employee_id=$employee_id");

        $month = $row_get['month'];
        if($month==1){$month1 = "JAN";}
        if($month==2){$month1 = "FAB";}
        if($month==3){$month1 = "MAR";}
        if($month==4){$month1 = "APRIL";}
        if($month==5){$month1 = "MAY";}
        if($month==6){$month1 = "JUNE";}
        if($month==7){$month1 = "JULY";}
        if($month==8){$month1 = "AUG";}
        if($month==9){$month1 = "SEP";}
        if($month==10){$month1 = "OCT";}
        if($month==11){$month1 = "NOV";}
        if($month==12){$month1 = "DEC";}    
        $year = $row_get['year'];
        $presentdays = $row_get['presentdays'];
        $absentdays = $row_get['absentdays'];
        $cl = $row_get['cl'];
        $presentdays = $presentdays - $absentdays;
        $paymode = $row_get['paymode'];
        $netsalary = number_format($row_get['netsalary'],2);
        $basic_salary = number_format($row_get['basic_salary'],2);
        $days = $row_get['days'];
        $paydate = $obj->dateformatindia($row_get['paydate']);
       
       }
}
else
$salary_id = 0;
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}



class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

  

    function Header()
    { 
       global $title1,$title2,$mobile_no,$reg_date,$city,$email,$address,$college_name,$emailc,$addressc,$mobilec,$cityc,$emp_name,$month1,$year,$presentdays,$absentdays,$cl,$netsalary,$basic_salary,$days,$paydate,$bank_details,$acc_no,$ifsc,$paymode;

        $this->SetFont('courier','b',9);
        $this->Rect(10,5,130,203); //uper table1
        $this->SetFont('courier','b',9);
       
        $this->Line(140,35,10,35);  
      //  $this->Rect(10,5,130,203);//upper rect1
        $this->SetFillColor(170,170,170); 

        $this->SetFont('courier','',10);
        $this->SetY(111);
        $this->SetX(52);
        $this->Cell(5);
        $this->Cell(40,5,strtoupper($address),0,1,'L');

        $this->SetFont('arial','b',10);
        $this->SetY(40);
        $this->SetX(10);
        $this->Cell(40,5,"Employee Name",0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(40);
        $this->SetX(40);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(40);
        $this->SetX(38);
        $this->Cell(5);
        $this->Cell(35,5,strtoupper($emp_name),0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(48);
        $this->SetX(10);
        $this->Cell(40,5,"Bank Details",0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(48);
        $this->SetX(40);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(48);
        $this->SetX(38);
        $this->Cell(5);
        $this->Cell(40,5,$bank_details,0,1,'L');

        $this->SetFont('arial','b',10);
        $this->SetY(56);
        $this->SetX(10);
        $this->Cell(40,5,"IFSC Code",0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(56);
        $this->SetX(40);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(56);
        $this->SetX(38);
        $this->Cell(5);
        $this->Cell(40,5,$ifsc,0,1,'L');

        $this->SetFont('arial','b',10);
        $this->SetY(56);
        $this->SetX(79);
        $this->Cell(40,5,"Month/Year",0,1,'L');

         $this->SetFont('arial','b',10);
        $this->SetY(56);
        $this->SetX(105);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(56);
        $this->SetX(110);
        //$this->Cell(5);
        $this->Cell(40,5,$month1."/".$year,0,1,'L');

        $this->SetFont('arial','b',10);
        $this->SetY(64);
        $this->SetX(10);
        $this->Cell(40,5,"Total Days",0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(64);
        $this->SetX(40);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(64);
        $this->SetX(38);
        $this->Cell(5);
        $this->Cell(40,5,$days,0,1,'L');

        $this->SetFont('arial','b',10);
        $this->SetY(64);
        $this->SetX(79);
        $this->Cell(40,5,"CL Days",0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(64);
        $this->SetX(105);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(64);
        $this->SetX(105);
        $this->Cell(5);
        $this->Cell(40,5,$cl,0,1,'L');

        $this->SetFont('arial','b',10);
        $this->SetY(72);
        $this->SetX(10);
        $this->Cell(40,5,"Absent Days",0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(72);
        $this->SetX(40);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(72);
        $this->SetX(38);
        $this->Cell(5);
        $this->Cell(40,5,$absentdays,0,1,'L');

        $this->SetFont('arial','b',10);
        $this->SetY(72);
        $this->SetX(79);
        $this->Cell(40,5,"Present Days",0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(72);
        $this->SetX(105);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(72);
        $this->SetX(105);
        $this->Cell(5);
        $this->Cell(40,5,$presentdays,0,1,'L');

        

       

        // $this->SetFont('arial','b',10);
        // $this->SetY(53);
        // $this->SetX(79);
        // $this->Cell(40,5,"Account No.",0,1,'L');
        
        // $this->SetFont('arial','b',10);
        // $this->SetY(53);
        // $this->SetX(105);
        // $this->Cell(3,5,":",0,1,'L');

        // $this->SetFont('courier','',10);
        // $this->SetY(53);
        // $this->SetX(105);
        // $this->Cell(5);
        // $this->Cell(40,5,$acc_no,0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(45);
        $this->SetX(80);
        $this->Cell(40,5,"Date",0,1,'L');
        
        $this->SetFont('arial','b',10);
        $this->SetY(45);
        $this->SetX(105);
        $this->Cell(3,5,":",0,1,'L');

        $this->SetFont('courier','',10);
        $this->SetY(45);
        $this->SetX(110);
       // $this->Cell(5);
        $this->Cell(40,5,"$paydate",0,1,'L');

        $this->SetFont('courier','b',17);
        $this->SetY(2);
        $this->SetX(48);
        $this->Cell(2);
        $this->Cell(48,18,"$college_name",0,1,'C');

        $this->SetY(13.5);
        $this->SetX(25);
        $this->SetFont('courier','b',9);
        $this->MultiCell(115,5,"$addressc".","."$cityc",0,'L');

        $this->SetY(11);
        $this->SetX(27);
        $this->SetFont('courier','b',9);
        $this->Cell(35,18,"Email ID :",0,1,'R');

        $this->SetY(11);
        $this->SetX(62);
        $this->SetFont('courier','b',9);
        $this->Cell(80,18,"$emailc",0,1,'L');
        
        $this->SetY(15.5);
        $this->SetX(50);
        $this->SetFont('courier','b',9);
        $this->Cell(15,18,"Mobile No.:",0,1,'L');
        
        $this->SetY(15.5);
        $this->SetX(75);
        $this->SetFont('courier','b',9);
        $this->Cell(15,18,"$mobilec",0,1,'L');
        
        
        
        

       
        
        

        $this->SetY(22);
        $this->SetX(31);
        $this->SetFont('courier','b',9);
       //uper table
       // $this->Ln(1);
        $this->SetY(80);
        $this->SetX(4);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(170, 170, 170); //gray
        $this->SetTextColor(0,0,0);
        $this->SetX(10);
        $this->Cell(70,5,'Earnings',1,0,'L',1);
       // $this->Cell(60,5,'Amount',1,1,'R',1);
       // $this->Cell(60,5,'Amount',1,1,'R',1);
        $this->Cell(60,5,'Amount',1,1,'R',1);
        $this->SetX(10);
        $this->SetWidths(array(70,60));
        $this->SetAligns(array("L","R"));

    }

    function Footer()
    { 
        global $comp_name;
        $this->SetY(-20);
        $this->SetFont('Arial','I',9);
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

        //$this->SetX(4);
//$this->SetY(184);
// $this->SetFont('Arial','b',8);
// $this->SetTextColor(0,0,0);
// $this->Cell(90,5,'Sign of Customer',0,0,'L',0);
// $this->SetFont('Arial','b',8);
// $this->SetTextColor(0,0,0);
// $this->Cell(40,5,'For :-'.$comp_name,0,0,'R',0);
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
$pdf->SetTitle("Bilty Entry");
$pdf->AliasNbPages();
$pdf->AddPage('P','A5');

//$slno = 1;
$res = $obj->executequery("select * from emp_salary where salary_id = '$salary_id'");
         foreach($res as $row_get)
       {
        $basic_salary1 = "Basic Salary";
        //$basic_salary = $row_get['basic_salary'];
        $presentdays = $row_get['presentdays'];
        $netsalary = number_format($row_get['netsalary'],2);
        $basic_salary = number_format($row_get['basic_salary'],2);
        $days = $row_get['days'];
        $paydate = $obj->dateformatindia($row_get['paydate']);

        $pdf->SetX(10);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(0,0,0);

        $pdf->Row(array($basic_salary1,$basic_salary));
     //$slno++;
}

        $pdf->SetFont('arial','b',10);
        $pdf->SetX(10);
        $pdf->Cell(70,5,"Gross Earnings",1,1,'L');
        
        $pdf->SetFont('arial','b',10);
        //$pdf->SetY(50);
        $pdf->SetX(80);
        $pdf->Cell(60,-5,$netsalary,1,1,'R');

        
        

       //  $pdf->SetFont('courier','',10);
       // // $pdf->SetY(85);
       //  $pdf->SetX(80);
       // // $pdf->Cell(5);
       //  $pdf->Cell(60,5,$netsalary,1,1,'R');

$pdf->Output();   
?>
