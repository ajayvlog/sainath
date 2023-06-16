<?php include("../adminsession.php");
require("fpdf17/fpdf.php");
//require('rotation.php');
//$imgpath = "uploaded/studentimg/";
$college_name = $obj->getvalfield("college_setting","college_name","1=1"); 
$college_mobile = $obj->getvalfield("college_setting","mobile","1=1"); 
$company_address = $obj->getvalfield("college_setting","address","1=1"); 
$city = $obj->getvalfield("college_setting","city","1=1"); 

$imgname = "";

if(isset($_GET['employee_id']))
{
    $employee_id = addslashes(trim($_GET['employee_id']));
    $res = $obj->executequery("select * from m_employee where employee_id = '$employee_id'");
    foreach($res as $row_get)
    {
      $employee_id = $row_get['employee_id'];
      $emp_name = $row_get['emp_name'];
      $post = $row_get['post'];
      $mobile = $row_get['mobile'];
      $dob = $obj->dateformatindia($row_get['dob']);
      $join_date = $obj->dateformatindia($row_get['join_date']);
      $address = $row_get['address'];
      $biometric_id = $row_get['biometric_id'];
      $imgname = $row_get['imgname'];
      
    }
}
function getinwordsbyindia()
{
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? 'and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] :'';
          
        
          
if($points !='' && $points !='0')
{
 $words=  "$result Rupees $points  Paise";
}
else
{
    $words=  "$result Rupees ";
}
   
   return $words;
}

function convert_number_to_words($number)
 {
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
        global $title1,$title,$emp_name,$mobile,$pan_no,$img_name,$email,$blood_grp,$join_date,$post,$dob,$session_name,$father_name,$imgname,$class_name,$imgpath,$sem_name,$address,$company_address,$city,$college_name,$college_mobile;
        $this->SetFont('Arial','B',15);
        // Calculate width of title and position
        $w = $this->GetStringWidth($title)+6;
        $this->SetX((210-$w)/2);
        // Colors of frame, background and text
        // $this->SetDrawColor(0,80,180);
        // $this->SetFillColor(230,230,0);
        // $this->SetTextColor(220,50,50);
        // Thickness of frame (1 mm)
        $this->SetLineWidth(1);
        // Title
        $this->Cell($w,9,$title,1,1,'C',true);
        // Line break
        $this->Ln(5);

        $this->SetFont('Arial','b',5);
        $this->Image('background11.jpg',0,0,90,55);
        //if ($img_name !='') {
        //$this->Image('uploaded/customer_img/'.$img_name,2,2,20,20);
       // }
       // else
      //  {
      if($imgname!="")
      {
       $this->Image("images/emp_pic/".$imgname,2,10,20,20);
      }
      else
      {
        $this->Image('images1.jpg',2,10,20,20);
      }
      
        //$this->Image('images1.jpg',2,4,20,20);
      //  }
        // $this->Image('images/cips_logo.png',2,28,20,20);
      $this->SetFont( 'Arial', 'b',6); 
       // $this->SetTextColor(220,20,60);
        $this->SetY(37);
        $this->SetX(3);
        $this->Cell(10,10,"Signature",0,1,'L');

       // $this->SetY(1); 

        $this->SetFont( 'Arial', 'b',10); 
        $this->SetTextColor(220,20,60);
        $this->SetY(1);
        $this->SetX(38);
        $this->Cell(10,10,strtoupper($college_name),0,1,'C');
        
        // $this->SetY(5.5);
        // $this->SetX(51);
        // $this->Cell(2,3,':',0,0,'');
        // $this->SetFont( 'Arial', '',8);
        // $this->SetY(5);
        // $this->SetX(53);
        // $this->MultiCell(30,4,,0,'L');

        $this->SetTextColor(0,0,0);
        $this->SetFont( 'Arial', 'b',7); 
        $this->SetY(6);
        $this->SetX(25);
        $this->Cell(10,10,'Employee Name',0,0,'');
        
        $this->SetY(9.5);
        $this->SetX(45);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'Arial', '',7);
        $this->SetY(9);
        $this->SetX(48);
        $this->MultiCell(50,4,strtoupper($emp_name),0,'L');
         
        $this->SetFont( 'Arial', 'b',7); 
        $this->SetY(10);
        $this->SetX(25);
        $this->Cell(10,10,'Mobile No.',0,0,'');
        $this->SetY(13.5);
        $this->SetX(45);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'Arial', '',7); 
        $this->SetY(10);
        $this->SetX(48);
        $this->Cell(0,10,$mobile,0,0,'');
        
        $this->SetFont( 'Arial', 'b',7);
        $this->SetY(13.5);  
        $this->SetX(25);
        $this->Cell(0,10,'dob',0,0,'L');
        $this->SetY(17);
        $this->SetX(45);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'Arial', '',7);
        $this->SetY(13.5);
        $this->SetX(48);
        $this->Cell(0,10,$dob,0,0,'L');

          
        $this->SetFont( 'Arial', 'b',7);
        $this->SetY(17.5); 
        $this->SetX(25);
        $this->Cell(0,10,'Join Date',0,0,'L');
        $this->SetY(21);
        $this->SetX(45);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'Arial', '',7);
        $this->SetY(17.5);
        $this->SetX(48);
        $this->Cell(0,10,$join_date,0,0,'L');

        $this->SetFont( 'Arial', 'b',7);
        $this->SetY(21.5); 
        $this->SetX(25);
        $this->Cell(0,10,'Post',0,0,'L');
        $this->SetY(25);
        $this->SetX(45);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'Arial', '',7);
        $this->SetY(25);
        $this->SetX(48);
        $this->MultiCell(38,3,$post,0,'L');

        $this->SetFont( 'Arial', 'b',7);
        $this->SetY(26); 
        $this->SetX(25);
        $this->Cell(0,10,'Address',0,0,'L');
        $this->SetY(29.5);
        $this->SetX(45);
        $this->Cell(2,3,':',0,0,'');
        $this->SetFont( 'Arial', '',7);
        $this->SetY(30);
        $this->SetX(48);
        $this->MultiCell(38,3,$address,0,'L');


        
        
       
        $this->SetY(45); 
        $this->SetFont( 'Arial', '',6); 
        $this->SetX(13);
       
       // $this->Cell(10,10,'Address',0,0,'C');
        // $this->SetY(48.5);
        // $this->SetX(22);
        // $this->Cell(2,3,':',0,0,'C');
        $this->SetFont( 'Arial','',6); 
        $this->SetY(45);
        $this->SetX(0);
         $this->SetFillColor(220,60,60);
         $this->SetTextColor(230,230,230);

        $this->MultiCell(88,10,$company_address." ".$city,0,'C',1);
        
        // $this->SetY(45); 
        // $this->SetFont( 'Arial', '',10); 
        // $this->SetX(30);
        // $this->Cell(0,10,$pan_no,0,0,'L');
        
    }

    // function RotatedText($x, $y, $txt, $angle)
    //     {
    //     /* Text rotated around its origin */
    //     $this->Rotate($angle,$x,$y);
    //     $this->Text($x,$y,$txt);
    //     $this->Rotate(0);
    //     }
      // Page footer
    function Footer()
    {

        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Text color in gray
        $this->SetTextColor(128);
        // Page number
       // $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
        //global $comp_name;
        // Position at 1.5 cm from bottom
        $this->SetY(-11);
        // Arial italic 8
        $this->SetFont('Arial','I',8); 
        // Page number
        $this->SetX(5);
        //$this->Image('cardprint.jpg',5,5,50,60);
        //$this->MultiCell(140,5,'|| Developed By Trinity Solutions Raipur, Contact us- +91-9770131555,+91-8871181890,Visit us- www.trinitysolutions.in ||',0,'C');

        // $this->SetY(180);
        //       $this->SetX(120);
        // $this->SetFont('courier','b',9);
        // $this->Cell(29,10,"Signature",0,0,'L');
       
    }

    function ChapterTitle($num, $label)
{
    // Arial 12
    $this->SetFont('Arial','',12);
    // Background color
    $this->SetFillColor(200,220,255);
    // Title
    $this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
    // Line break
    $this->Ln(4);
}

function ChapterBody($file)
{
    // Read text file
    $txt = file_get_contents($file);
    // Times 12
    $this->SetFont('Times','',12);
    // Output justified text
    $this->MultiCell(0,5,$txt);
    // Line break
    $this->Ln();
    // Mention in italics
    $this->SetFont('','I');
    $this->Cell(0,5,'(end of excerpt)');
}

function PrintChapter($num, $title, $file)
{
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody($file);
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
        $this->MultiCell($w,8,$data[$i],0,$a);
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
$title1 = "PRINT CARD";
$pdf->SetTitle($title1);
$pdf->AliasNbPages();
$pdf->AddPage('L',array(85,53));
//$pdf = new FPDF('L','mm',array(85,53));


$pdf->Output();

// $pdf = new PDF();
// $title = '20000 Leagues Under the Seas';
// $pdf->SetTitle($title);
// $pdf->SetAuthor('Jules Verne');
// $pdf->PrintChapter(1,'A RUNAWAY REEF','20k_c1.txt');
// $pdf->PrintChapter(2,'THE PROS AND CONS','20k_c2.txt');
// $pdf->Output();
?> 
                            
<?php
mysql_close($db_link);

?>
