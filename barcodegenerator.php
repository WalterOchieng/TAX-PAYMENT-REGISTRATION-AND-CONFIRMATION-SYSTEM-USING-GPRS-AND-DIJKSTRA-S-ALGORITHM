<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/Buss_usersmenuDashboard.php"); ?>
<?php  require("_includes/BussinessUsersDashboardLeft.php"); ?>

<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:LoginBussinessUsers.php");;

}


$start=$_SESSION["username"];

?>




<?php

function getPosts()
{
    $posts=array();
    $posts[0]=$_POST['searchField'];
    $posts[1]=$_POST['bussinessType'];

    return $posts;
}

try {
    if (isset($_POST['load'])) {

        $data = getPosts();
        //$sqlloc = "select bussinessCode from   bussiness  WHERE  IdNumber=:IDNumber";
        $searchStmt = $conn->prepare('SELECT bussinessCode FROM bussiness WHERE IdNumber=:IDNumber');
        // $stmts = $conn->prepare($sqlloc);
        $searchStmt->execute(array(

            ':IDNumber' => $data[0]

        ));

        $resultsbussinesscode = $searchStmt->fetchAll();


    }
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();

}


?>



<?php
//Barcode Number Generator


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
        $searchStmt = $conn->prepare('SELECT * FROM  bussiness WHERE IdNumber=:IDNumber');
        $searchStmt -> execute(array(
            ':IDNumber' => $data[0]
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
            echo $barcode;



        }} }



?>

<div class="panelDisplay">
    <form   action="<?php   ?>" method="POST"    class="barcodegenerator"   enctype="multipart/form-data" name="BussinesOwner" id="BussinessOwner">

        <?php @ob_start();
        error_reporting(E_ALL & ~E_NOTICE);
        $bdata="yourbussinesscode";
        $bdata=$barcode;
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

        <label for="bussinessCode">Bussiness Code</label>
        <select name="bussinessType"    class="form-control"  id="bussinessType"   >

            <?php foreach($resultsbussinesscode as $outputl) {?>

                <option> <?php echo $outputl["bussinessCode"]; ?></option>

            <?php } ?>
        </select><br/>







        <input type="hidden" name="searchField"  id="SearchField" readonly  value="<?php echo $start?>" />
        <input type="submit" style="font-size:80%"class="btn btn-primary btn-lg" name='load' value='Load Bussiness Codes'>
        <input type="submit" style="font-size:80%"class="btn btn-primary btn-lg" name='barcodedata' value='Load BarCode Data'><br/>
                            <label> Select Encoding</label>

                            <SELECT   class="form-control"  NAME="encode">
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
                            <input name='bdata'   readonly class="form-control"  value='<?php echo $bdata?>'>
                            </div>
                            <div al class="form-group">
                            <label> Barcode Height</label>
                            <input name='height' class="form-control"  value='<?php echo $height?>'>
                            </div>

                            <div class="form-group">
                            <label> Scale </label>
                                <input name='scale'  class="form-control" value='<?php echo $scale?>'>
                            </div>
                            <div class="form-group">
                            <label> Background Color</label>
                            <input name='bgcolor' class="form-control"  value='<?php echo $bgcolor?>'>
                            </div>
                            <div class="form-group">
                            <label> Bar Color</label>
                            <input name='color'  class="form-control"  value='<?php echo $color?>'>
                            </div>


                            <label> <B>File Type</B><span class='note'>*</span></label>
                                    <SELECT  class="form-control"  NAME="type">
                                        <option value='png'>PNG</option>
                                        <option value='gif'>GIF</option>
                                        <option value='jpg'>JPEG</option>
                                    </SELECT>

                                    <br/>
                            <input type="submit" class="btn btn-primary btn-lg btn-block" name='Genrate' value='Submit'><br/>


                    <div class="container">

               <TABLE class="mybarcoder" id="mybarcoder"style='border:1px solid #336666;margin: 0 auto; width:300px;height:100%;'>
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

                    </div>

        <br/>
        <button class="printbarcode">Print BARCODE  </button>
    </form>
</div>


<script >

    $('.printbarcode').click(function()
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


