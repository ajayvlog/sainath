<?php include("../adminsession.php");
include("../fpdf17/fpdf.php");

if (isset($_GET['expanse_id'])) {
    $expanse_id = $_GET['expanse_id'];
} else {
    $expanse_id = "";
}
if (isset($_GET['type']))
    $type = $obj->test_input($_GET['type']);
else
    $type = "";

$title1 = $obj->getvalfield("college_setting", "college_name", "1 = 1");

$res = $obj->executequery("select * from expanse where expanse_id='$expanse_id'");
foreach ($res as $row_get) {
    $exp_name = $row_get['exp_name'];
    $mode = $row_get['mode'];
    $exp_date = $obj->dateformatindia($row_get['exp_date']);
    $pay_type = $row_get['pay_type'];
    $exp_amount = $row_get['exp_amount'];
    $voucher_no = $row_get['voucher_no'];
    $remark = $row_get['remark'];

    if ($pay_type == 'Payment') {
        $payment_type = 'to';
    }
    if ($pay_type == 'Received') {
        $payment_type = 'from';
    }

    $ex_group_id = $row_get['ex_group_id'];
    $groupname = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id='$ex_group_id'");
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
        global $title1, $title2, $company_name, $mobile, $email, $address, $customer_name, $voucher_no, $payment_type;

        $this->SetFont('courier', 'b', 15);
        $this->Cell(10);
        $this->Cell(90, 10, $title1, 0, 1, 'L');
        $this->Ln(6);
        $this->SetFont('courier', 'b', 15);
        $this->Cell(80);
        $this->Cell(90, 0, $title2, 0, 1, 'C');
        $this->Ln(3);
        $this->Cell(-1);
        $this->SetFont('courier', 'b', 11);
        //$this->Cell(95,5,"".$collect_from,0,0,'L');
        //$this->Cell(280,5,"Date : ".date('d-m-Y'),0,1,'R');
        $this->Ln(1);
        //$this->Ln(10);

        $this->SetFont('courier', 'b', 9);
        // $this->Rect(5, 5, 200, 80, 'D'); //For A4


    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9);
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}


function GenerateWord()
{
    //Get a random word
    $nb = rand(3, 10);
    $w = '';
    for ($i = 1; $i <= $nb; $i++)
        $w .= chr(rand(ord('a'), ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++)
        $s .= GenerateWord() . ' ';
    return substr($s, 0, -1);
}



$pdf = new PDF_MC_Table();
$pdf->SetTitle(ucfirst($type) . " Voucher Receipt");
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A5');
//$pdf->MultiCell(80,5,"Customer Copy",0,'L');

$pdf->SetY(10);
$pdf->SetX(20);

$pdf->SetFont('courier', 'b', 9);
$pdf->Rect(4, 10, 140, 80, 'D'); //For A4

$pdf->SetFont('courier', 'b', 9);
$pdf->Rect(4, 10, 140, 16, 'D'); //For A4


$pdf->SetY(13);

$pdf->SetFont('Arial', 'b', 12);
$pdf->SetTextColor(0, 0, 0);
//$pdf->Cell(120,4,$company_name,'0',1,'C',0);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'b', 7);
//$pdf->Cell(71,1,"Mobile No:".$mobile.",",'0',1,'C',0);

$pdf->SetFont('Arial', 'b', 7);
//$pdf->Cell(145,-1,"Email Id:".$email.",",'0',1,'C',0);


$pdf->Ln(2);
$pdf->SetFont('Arial', 'b', 7);
//$pdf->Cell(120,4,"Address:".ucwords($address),'0',1,'C',0);
$pdf->Ln(4);
if($type == 'expense')
{
   $heading = 'Voucher'; 
}
else
{
   $heading = 'Receipt';  
}

$pdf->SetFont('Arial', 'b', 13);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(130, 5, $heading, '0', 1, 'C', 0);
$pdf->Ln(3);
$pdf->SetFont('Arial', 'b', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetY(35);
$pdf->Cell(30, 4, 'Voucher No. : ' . $voucher_no, '0', 0, 'L', 0);
// //$pdf->Ln(2);
$pdf->SetX(90);
$pdf->SetFont('Arial', 'b', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(30, 4, 'Payment Date : ' . $exp_date, '0', 1, 'L', 0);

$pdf->SetFont('Arial', 'b', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(10);
$pdf->Cell(30, 13, ucfirst($type) . ' Group Name : ' . $groupname, '0', 1, 'L', 0);
$pdf->Ln(3);
$pdf->SetY(50);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'b', 8);
$pdf->Cell(100, 5, $pay_type . " with thanks " . " " . $payment_type . " " . $exp_name, 0, 1, 'L');

$pdf->Ln(3);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'b', 8);
$pdf->MultiCell(135, 0, "Rs." . $exp_amount . " In Word " . strtoupper(convert_number_to_words(round($exp_amount))) . " " . "ONLY" . " " . "/-", 0, 'L');
$pdf->SetY(80);
$pdf->Cell(100, 5, "By " . strtoupper($mode), 0, 1, 'L');

$pdf->Ln(-21);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'b', 8);
$pdf->MultiCell(135, 5, "Remark : " . $remark, 0, 'L');

$pdf->SetY(80);
$pdf->SetX(120);

$pdf->SetFont('Arial', 'b', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(90, 5, 'Signature', 0, 0, 'L', 0);
$pdf->SetFont('Arial', 'b', 8);
$pdf->SetTextColor(0, 0, 0);
//$pdf->Cell(40,5,'For :-'.$company_name,0,0,'R',0);
$pdf->Ln(3);





$pdf->Output();
?>
