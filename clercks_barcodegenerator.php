<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/ClercksUsersDashboardLeft.php"); ?>




<?php
$sqlloc="select bussinessCode from   bussiness";
try
{
    $stmts=$conn->prepare($sqlloc);
    $stmts->execute();
    $resultsbussinesscode=$stmts->fetchAll();
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();

}


?>


<?php
//Barcode Number Generator
function getPosts()
{
    $posts=array();
    $posts[0]=$_POST['bussinessCode'];


    return $posts;
}

$County='';
$BussinessCode='';
$Location='';
$IDNumber='';
;
if(isset($_POST['barcodedata'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Please Load the Busssiness Codes to get your Barcode Data';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM  bussiness WHERE bussinessCode=:BussinessCode');
        $searchStmt -> execute(array(
            ':BussinessCode' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No Bussiness found with such  Bussiness Code';
            }
            $County = $user[3];
            $BussinessCode = $user[0];
            $Location=$user[4];
            $IDNumber=$user[11];

            $barcode=$County.'-'.$BussinessCode.'-'.$Location.'-'.$IDNumber;
           // echo $barcode;



        }} }



?>

<script type="text/javascript">
    function PrintDiv(mybarcoder) {
        var data=document.getElementById(mybarcoder).innerHTML;
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title>Crime Solution</title>');
        /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');
        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload=function(){ // necessary if the div contain images

            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
    }
</script>

<div class="panelDisplay">
    <form   action="<?php   ?>" method="POST"    class="barcodegenerator"   enctype="multipart/form-data" name="BussinesOwner" id="BussinessOwner">

        <?php @ob_start();
        error_reporting(E_ALL & ~E_NOTICE);
        $bdata="typeBussinessCode";
        $height="50";
        $scale="2";
        $bgcolor="#FFFFEC";
        $color="#333366";
        $file="";
        $type="png";

        // March 21, 2017 by Belal for STARTPHP.com
        $myFile=basename(getcwd(), ".php").PHP_EOL;// usign this to identify the page
        $barcodeDir ="getbarcode";// the directory where the scrip it located

        if(isset($_POST['Genrate']))
        {
            $encode=$_POST['encode'];
            $bdata=$_POST['bdata'];
            $height=$_POST['height'];
            $scale=$_POST['scale'];
            $bgcolor=$_POST['bgcolor'];
            $color=$_POST['color'];

            $type=$_POST['type'];
        }

        ?>

        <h5>Bussiness BarCode Generator</h5>

        <input type="text" name="bussinessCode"  id="bussinessCode"   value="<?php echo $start?>" /><br/>

        <input type="submit" style="font-size:80%"class="btn btn-primary btn-lg" name='barcodedata' value='Load BarCode Data'><br/>

        <label> Select Encoding</label>

        <SELECT   class="form-control"  readonly NAME="encode">
            <OPTION value='CODE128' <?php echo $encode=='CODE128'?'selected':''?>>CODE128</OPTION>
            <OPTION value='CODE39' <?php echo $encode=='CODE39'?'selected':''?>>CODE39</OPTION>
            <OPTION value='CODE93' <?php echo $encode=='CODE93'?'selected':''?>>CODE93</OPTION>
            <OPTION value='UPC-A' <?php echo $encode=='UPC-A'?'selected':''?>>UPC-A</OPTION>
            <OPTION value='EAN-13' <?php echo $encode=='EAN-13'?'selected':''?>>EAN-13</OPTION>
            <OPTION value='EAN-8' <?php echo $encode=='EAN-8'?'selected':''?>>EAN-8</OPTION>
            <OPTION value='UPC-E' <?php echo $encode=='UPC-E'?'selected':''?>>UPC-E</OPTION>
            <OPTION value='S205' <?php echo $encode=='S205'?'selected':''?>>STANDARD 2 OF 5</OPTION>
            <OPTION value='I2O5' <?php echo $encode=='I2O5'?'selected':''?>>INDUSTRIAL 2 OF 5</OPTION>
            <OPTION value='I25' <?php echo $encode=='I25'?'selected':''?>>INTERLEAVED</OPTION>
            <OPTION value='POSTNET' <?php echo $encode=='POSTNET'?'selected':''?>>POSTNET</OPTION>
            <OPTION value='CODABAR' <?php echo $encode=='CODABAR'?'selected':''?>>CODABAR</OPTION>

        </SELECT>

        <div class="form-group">
            <label for="bdata"> Barcode Data</label>
            <input name='bdata'  class="form-control" placeholder="yourbarcodedata" readonly value='<?php echo $barcode?>'>
        </div>
        <div class="form-group">
            <label> Barcode Height</label>
            <input name='height' class="form-control"  readonly value='<?php echo $height?>'>
        </div>

        <div class="form-group">
            <label> Scale </label>
            <input name='scale'  class="form-control"  readonly value='<?php echo $scale?>'>
        </div>
        <div class="form-group">
            <label> Background Color</label>
            <input name='bgcolor' class="form-control" readonly value='<?php echo $bgcolor?>'>
        </div>
        <div class="form-group">
            <label> Bar Color</label>
            <input name='color'  class="form-control"   readonly value='<?php echo $color?>'>
        </div>


        <label> <B>File Type</B><span class='note'>*</span></label>
        <SELECT  class="form-control"  NAME="type">
            <option value='png'>PNG</option>
            <option value='gif'>GIF</option>
            <option value='jpg'>JPEG</option>
        </SELECT>

        <br/>
        <input type="submit" class="btn btn-primary" name='Genrate' value='Submit'><br/>



        <TABLE id="mybarcoder" class="mybarcoder" style='border:1px solid #336666;margin: 0 auto; width:300px;height:100%;'>
            <TR>

                <TD align='center'>
                    <?php
                    if(isset($_POST['Genrate']))
                    {
                        if(empty($_POST['file']))
                        {
                            foreach($_POST as $key=>$value)
                                $qstr.=$key."=".urlencode($value)."&";
                            if($myFile == "phpmaker"){
                                echo "<img src='".$barcodeDir."/barcode.php?$qstr'>";

                            }else{
                                echo "<img src='barcode.php?$qstr'>";
                            }
                        }

                    }
                    ?>
                </TD>
            </TR>
        </TABLE>


        <?php echo $myFile ." and ".$barcodeDir; ?>

        <br/>
        <button  class="theprinterbarcode"onclick="PrintDiv('print')">Print BARCODE  </button>
    </form>
</div>
<script >

    $('.theprinterbarcode').click(function()
    {
        var printme= document.getElementById('mybarcoder');
        var  wme=window.open("","","width=900,height=700");
        wme.document.write(printme.outerHTML);
        wme.document.close();
        wme.focus(0);
        wme.print();
        wme.close();


    });


</script>



<?php  require("_includes/Footer.php"); ?>


</body>
</html>