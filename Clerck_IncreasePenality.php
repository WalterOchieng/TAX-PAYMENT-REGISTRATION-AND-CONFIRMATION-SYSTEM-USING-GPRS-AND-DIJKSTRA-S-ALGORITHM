<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/ClercksUsersDashboardLeft.php"); ?>



<?php
session_start();

if(!isset($_SESSION["username"]))
{
    header("location:Systems_UsersForm.php");;

}




?>



<?php
// Php Code for Search
function getPosts()
{
    $posts=array();

    $posts[0]=$_POST['bussinessCode'];
    $posts[1]=$_POST['taxAmount'];
    $posts[2]=$_POST['currentTax'];
    $posts[3]=$_POST['penality'];
    $posts[4]=$_POST['satusfield'];
    $posts[5]=$_POST['date_last_paid'];


    return $posts;
}


$bussinessCode='';
$taxAmount='';
$currentTax='';
$penalitys='';
$status='';
$date_last_paid='';


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
            $penalitys = $user[4];
            $status=$user[5];
            $date_last_paid = $user[6];

        }} }

?>



<?php

if(isset($_POST['update'])) {

if (empty($data[0]) || empty($data[1]) ||  empty($data[2]) ) {
    echo 'The Bussiness Tax has been Increased';

}
else {
    $updateStmt = $conn->prepare('UPDATE bussiness_tax SET  bussinessCode=:BussinessCode,taxAmount=:Taxamount,CurrentTax=:currentTax,Penality=:Penality,Status_of_payment=2, date_last_paid=:datelastpaid WHERE  bussinessCode=:BussinessCode');
    $updateStmt->execute(array(
        ':BussinessCode' => $data[0],
        ':Taxamount' => $data[1],
        ':currentTax' => $data[2],
        ':Penality' => $data[3],
        ':datelastpaid' => $data[5]
    ));
    if ($updateStmt) {
        echo 'Data updated';
    }
}

}

?>











<?php

//Penality Calculator Algorithm

$currentdate=date("Y-m-d");

$datelastpaiyed=$date_last_paid;


$start = strtotime($datelastpaiyed);
$end = strtotime($currentdate);

$days_between = ceil(abs($end - $start) / 86400);


if($days_between>40)
{
    $penalities1=0.1*$currentTax;
    $penalities=$penalities1+$penality;


}
else
{
    $penalities=0;
}



?>







<div class="panelDisplay">

    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>

    <form  method="POST"    class="currentbussinesstax"  enctype="multipart/form-data" name="BussinessTax" id="bussinessTax"  >
        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $start?>" />

        <div class="form-group">
            <label for="bussinessCode">Bussiness Code</label>
            <input type="text" name="bussinessCode" placeholder="Bussiness Code" id="BussinessCode"  value="<?php echo $bussinessCode?>"   />
        </div>


        <div class="form-group">

            <label for="taxAmount"> Tax Amount</label>
            <input type="text" name="taxAmount" placeholder="Tax Amount"  id="TaxAmount" value="<?php echo $taxAmount?>"   />
        </div>


        <div class="form-group">

            <label for="currentTax"> Current Tax </label>
            <input type="text" name="currentTax" placeholder="Current Tax"  id="currentTax" value="<?php echo $currentTax?>" />
        </div>



        <div class="form-group">

            <label for="penality"> Penality </label>
            <input type="text" name="penality" placeholder="Penality "  id="penality"  value="<?php echo $penalities?>"  />
        </div>


        <div class="form-group">

            <label for="date_last_paid"> Date last fully tax paid </label>

            <input type="text" name="date_last_paid" placeholder="Date tax last paid fully "  id="date_last_paid"   value="<?php echo $date_last_paid?>"   />
        </div>
        <input type="hidden" name="satusfield"  id="StatusField"  value="<?php echo $status?>" />
        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $bussinessCode?>"/>

        <input name="search" type="submit" class="btn btn-primary " value="Search"/>
        <input name="update" type="submit" class="btn btn-primary " value="Increase Penality" onclick="return increasepenaliy()" />



    </form>
</div>


<script>

    function increasepenaliy()
    {
        var cleckuserid = document.getElementById('BussinessCode').value;
        var clecrcksusername= document.getElementById('TaxAmount').value;
        var passwds= document.getElementById('currentTax').value;
        var emails=document.getElementById('penality').value;

        if(cleckuserid=="" ||clecrcksusername=="" ||passwds==""||emails=="")
        {
            alert('Please fill All the fields');
            return false;
        }


        else
        {        return true;
        }

    }
</script>
<?php  require("_includes/Footer.php"); ?>
