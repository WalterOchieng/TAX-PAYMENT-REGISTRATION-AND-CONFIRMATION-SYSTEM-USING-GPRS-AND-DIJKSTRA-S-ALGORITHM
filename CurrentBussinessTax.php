<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/Buss_usersmenuDashboard.php"); ?>
<?php  require("_includes/BussinessUsersDashboardLeft.php"); ?>



<?php
session_start();

if(!isset($_SESSION["username"]))
{
    header("location:LoginBussinessUsers.php");;

}
else
{
    //echo '<h6>Login Success,Welcome!!' .$_SESSION["username"].'</h6>';
}

$start=$_SESSION["username"];

?>



<?php
// Php Code for Search
function getPosts()
{
    $posts=array();

    $posts[0]=$_POST['bussinessName'];
    $posts[1]=$_POST['searchField'];

    return $posts;
}


$bussinessCode='';
$taxAmount='';
$currentTax='';
$penality='';
$date_last_paid='';
$idsearch='';

if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Select Bussiness to see Tax details';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM bussiness_tax WHERE bussinessCode=:BussinessCode');
        $searchStmt -> execute(array(
            ':BussinessCode' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No data found with such Code';
            }
            $bussinessCode = $user[1];
            $taxAmount = $user[2];
            $currentTax = $user[3];
            $penality = $user[4];
            $date_last_paid = $user[6];

        }} }

?>

<?php
//Penality Calculator Algorithm

$currentdate=date("Y-m-d");

$datelastpaiyed=$date_last_paid;


$start = strtotime($datelastpaiyed);
$end = strtotime($currentdate);

$days_between = ceil(abs($end - $start) / 86400);


if($days_between>10)
{
    $penalities1=0.1*$currentTax;
    $penalities=$penalities1+$penality;


}


?>


<?php
$datas = getPosts();

$sqlpop="select bussinessCode from  bussiness ";

try
{



    $stmts=$conn->prepare($sqlpop);
    $stmts->execute();

   // $stmts -> execute(array(
   //     ':IDNumber' => $datas[1]
 //   ));

    $results=$stmts->fetchAll();



}

catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();
}
?>




<?php

try {
    if (isset($_POST['load'])) {

        $data = getPosts();
        //$sqlloc = "select bussinessCode from   bussiness  WHERE  IdNumber=:IDNumber";
        $searchStmt = $conn->prepare('SELECT bussinessCode FROM bussiness WHERE IdNumber=:IDNumber');
        // $stmts = $conn->prepare($sqlloc);
        $searchStmt->execute(array(

            ':IDNumber' => $data[1]

        ));

        $resultsbussinesscode = $searchStmt->fetchAll();


    }
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();

}


?>



<div class="panelDisplay">

    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form  method="POST"    class="currentbussinesstax"  enctype="multipart/form-data" name="BussinessTax" id="bussinessTax"  >
        <input type="text" name="searchField"  id="SearchField"  value="<?php echo $start?>" />
        <input type="submit" name="load"  class="btn btn-primary " value="Load Bussiness Code">
        <div class="form-group">


            <label for="bussinessName"> Select Bussiness Code </label>
            <br/>

            <select name="bussinessName"   id="bussinessName"   >

                <?php foreach($resultsbussinesscode as $output) {?>

                    <option> <?php echo $output["bussinessCode"]; ?></option>

                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="bussinessCode">Bussiness Code</label>
            <input type="text" name="bussinessCode" placeholder="Bussiness Code" id="BussinessCode"  value="<?php echo $bussinessCode?>"  readonly />
        </div>


        <div class="form-group">

            <label for="taxAmount"> Tax Amount</label>
            <input type="text" name="taxAmount" placeholder="Tax Amount"  id="TaxAmount" value="<?php echo $taxAmount?>"   />
        </div>


        <div class="form-group">

            <label for="currentTax"> Current Tax </label>
            <input type="text" name="currentTax" placeholder="Current Tax"  id="currentTax" value="<?php echo $currentTax?>" readonly/>
        </div>



        <div class="form-group">

            <label for="penality"> Penality </label>
            <input type="text" name="penality" placeholder="Penality "  id="penality"  value="<?php echo $penalities?>"  />
        </div>

        <div class="form-group">

            <label for="date_last_paid"> Date last fully tax paid </label>
            <input type="text" name="date_last_paid" placeholder="Date tax last paid fully "  id="date_last_paid"   value="<?php echo $date_last_paid?>"   />
        </div>

        <input name="search" type="submit" class="btn btn-primary " value="Search"  />
        <button class="printdetails ">Print</button>
        <button type="submit" formaction="ReportCurrentTax.php" >Generate Report</button>
    </form>
</div>
<script >

    $('.printdetails').click(function()
    {
        var printme= document.getElementById('bussinessTax');
        var  wme=window.open("","","width=900,height=700");
        wme.document.write(printme.outerHTML);
        wme.document.close();
        wme.focus(0);
        wme.print();
        wme.close();


    });


</script>


<?php


?>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>