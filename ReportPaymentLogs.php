<?php  require(  "Connections/connection.php"); ?>
<?php

require('fpdf181/fpdf.php');
class PDF extends FPDF {
    function Header(){
        $this->SetFont('Arial', 'B',15);
        //dummy cell to put log
        //this->Cell(12,0,'',0,0);
        //is equivalent to,
        $this->Ln(12);

        //put logo

        $this->Image('icons/logo2.jpeg',92,10,15);


        $this->Cell(35,5,'',0,1);
        $this->Cell(35,5,'',0,0);
        $this->Cell(110,3,'B Tax System ',0,2,C);
        //$this->Cell(100,5,'',0,1);
        $this->SetFont('Arial', 'B',10);
        $this->Cell(40,10,'',0,0);
        $this->Cell(30,10,'Future of Kenya',0,0,C);
        $this->Cell(52,10,'',0,1);


        //----------------------------------------------get name


        date_default_timezone_set('Africa/Nairobi');
        $now = new DateTime();
        $time = $now->format('H:i:s');
        $date = $now->format('Y-m-d');
        $this->SetFont('Arial', '',7);
        $this->Cell(45,10,'',0,0);
        $this->Cell(137,10,'Document generated on '.$date.', '.$time,0,1,R);
        $this->Cell(45,10,'',0,0);

        $this->Ln(5);

        $this->SetFont('Arial','',11);
        $this->Cell(70,5,'',0,0);
        $this->Cell(91,5,'Report Payment Logs',0,0);
        $this->Cell(52,5,'',0,1);

        //dummy ceil to give line spacing
        //this->Cell(0,5,'',0,1);
        //is equivalent to
        $this->Ln(5);
        $this->SetFont('Arial','B',11);

        $this->SetFillColor(180,180,255);
        $this->SetDrawColor(50,50,100);

        $this->Cell(40,5,'Payment Code',1,0,'',true);


        $this->Cell(40,5,'Bussiness Code',1,0,'',true);
        $this->Cell(40,5,' Amount',1,0,'',true);
        $this->Cell(40,5,'Date',1,0,'',true);
        $this->Cell(40,5,'Paymeent Name',1,0,'',true);
       // $this->Cell(40,5,'Date last Tax Paid',1,0,'',true);

        //$this->Cell(20,5,'Total Cost',1,1,'',true);


        //$this->Cell(30,5,$even_name,1,0);


    }
    function Footer(){
        //Go to 1.5cm from bottom
        $this->SetY(-15);

        $this->SetFont('Arial','',8);

        $this->Cell(0,10,'Page'.$this->PageNo()."/{pages}",0,0,'C');



    }
}
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages('{pages}');

$pdf->AddPage();
$pdf->SetFont('Arial','',11);
/*$sqlfetch1="SELECT * FROM `schedule` WHERE status='Pending...'" ;
$result1=mysqli_query($con,$sqlfetch1);
while($row1=mysqli_fetch_array($result1))
{
    $cust_id=$row1['customer_id'];
    $cust_name=$row1['customer_name'];
    $sch_id=$row1['schedule_id'];
    $even_name=$row1['event_name'];
    $even_cost=$row1['event_cost'];
    $start_date=$row1['start_date'];
    $end_date=$row1['end_date'];
    $expect_p=$row1['expected_persons'];
    $venue_name=$row1['venue_name'];
    $venue_cost=$row1['venue_cost'];
    $transport_cost=$row1['transport_cost'];
    $catering_cost=$row1['catering_cost'];
    $total_cost=$row1['total_cost'];
    $stutus=$row1['Status'];


    $pdf->Cell(30,5,$cust_name,1,0);


    $pdf->Cell(30,5,$even_name,1,0);

    $pdf->Cell(25,5,$start_date,1,0);

    $pdf->Cell(25,5,$end_date,1,0);
    $pdf->Cell(25,5,$venue_name,1,0);

    $pdf->Cell(20,5,$even_cost,1,0);

    $pdf->Cell(20,5,$total_cost,1,1);
}
*/

$bussinessName=$_POST['bussinessName'];
$busssinessCode=$_POST['bussinessCode'];
$taxAmount=$_POST['taxAmount'];
$currentTax=$_POST['currentTax'];
$penality=$_POST['penality'];
$datelastpaid=$_POST['date_last_paid'];


$pdf->Cell(55,5,$bussinessName,1,1);


$pdf->Cell(40,5,$busssinessCode,1,0);

$pdf->Cell(40,5,$taxAmount,1,0);

$pdf->Cell(40,5,$currentTax,1,0);
$pdf->Cell(40,5,$datelastpaid,1,0);

$pdf->Cell(40,5,$penality,1,0);

$pdf->Cell(35,5,$datelastpaid,1,0);

//$pdf->Cell(100,5,'Welcome nnnnnn',1,2);



$pdf->Output();

?>