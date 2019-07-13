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
else
{
    //echo '<h6>Login Success,Welcome!!' .$_SESSION["username"].'</h6>';
}

$start=$_SESSION["username"];

?>

<?php
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if(  isset($_POST['ownerName'])&& isset($_POST['save']) )// values checked from form attribute names
    {

        $sql = "INSERT  INTO   owner(owner_name,Id_Number,DOB,county,subcounty,location,sublocation)
 VALUES(:OwnerName,:IdNumber,:DOB,:County,:SubCounty,:Location,:Sublocation)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':OwnerName' => $_POST['ownerName'],
            ':IdNumber' => $_POST['idNumber'],
            ':DOB' => $_POST['dates'],
            ':County' => $_POST['countyCode'],
            ':SubCounty' => $_POST['subCountyCode'],
            ':Location' => $_POST['locationName'],
            ':Sublocation' => $_POST['sublocationName']));
        if ($smt) {
            echo 'Data has been Inserted';
        }
    }}
catch(PDOException $e)
{
    echo  $e->getMessage();
}
?>

<?php
//START OF FUNCTION
function getPosts()
{
    $posts=array();

    $posts[0]=$_POST['ownerName'];
    $posts[1]=$_POST['idNumber'];
    $posts[2]=$_POST['dates'];
    $posts[3]=$_POST['countyCode'];
    $posts[4]=$_POST['subCountyCode'];
    $posts[5]=$_POST['locationName'];
    $posts[6]=$_POST['sublocationName'];
    $posts[7]=$_POST['searchField'];
    return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1])    ) {
        echo 'Enter the User Data to Update';

    }
    elseif (empty($data[1]))
    {
        echo 'Seems Your Data is Inccorec. Please Fill in the correct details to update ';
    }

    else {
        $updateStmt = $conn->prepare('UPDATE  owner SET owner_name=:OwnerName,Id_Number=:IdNumber,DOB=:DOB,county=:County,subcounty=:SubCounty,location=:Location,sublocation=:Sublocation,subCounty=:SubCounty WHERE  Id_Number=:searchField');
        $updateStmt->execute(array(

            ':OwnerName' => $data[0],
            ':IdNumber' => $data[1],
            ':DOB' => $data[2],
            ':County' => $data[3],
            ':SubCounty' => $data[4],
            ':Location' => $data[5],
            ':Sublocation' => $data[6],
            ':searchField' => $data[7]

        ));
        if ($updateStmt) {
            echo 'Data updated';
        }
    }
}
// END OF UPDATE STATEMENT

?>


<?php
// Php Code for Search


$OwnerName='';
$IdNumber='';
$DOB='';
$County='';
$SubCounty='';
$Location='';
$Sublocation='';
if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[1])) {
        echo 'Enter the  ID Number to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM  owner WHERE Id_Number=:IDNumber');
        $searchStmt -> execute(array(
            ':IDNumber' => $data[1]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'Your Details Have Complications ';
            }

            $OwnerName = $user[0];
            $IdNumber=$user[1];
            $DOB=$user[2];
            $County=$user[3];
            $SubCounty=$user[4];
            $Location=$user[5];
            $Sublocation=$user[6];
        }} }
?>


<?php
$sqlpop="select countyName from  county";
try
{
    $stmts=$conn->prepare($sqlpop);
    $stmts->execute();
    $results=$stmts->fetchAll();
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();
}
?>




<?php
$sqlsubc="select subco_name from  subcounty";
try
{
    $stmts=$conn->prepare($sqlsubc);
    $stmts->execute();
    $subcresults=$stmts->fetchAll();
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();

}
?>


<?php
$sqlloc="select locationName from   location";
try
{
    $stmts=$conn->prepare($sqlloc);
    $stmts->execute();
    $resultslocation=$stmts->fetchAll();
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();

}


?>



<?php
$sqllocs="select subLocation_name from   sublocation";
try
{
    $stmts=$conn->prepare($sqllocs);
    $stmts->execute();
    $resultssublocation=$stmts->fetchAll();
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();

}


?>




<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form   action="<?php   ?>" method="POST"    class="bussiness_owner_personaldetails"   enctype="multipart/form-data" name="BussinesOwner" id="BussinessOwner">


        <div class="form-group">
            <label for="idNumber">ID Number</label>
            <input type="text" name="idNumber" id="idNumber"  placeholder="ID Number" readonly value="<?php echo $start?>" onkeyup="formVal_numbers_keyup(this)"  />
        </div>


        <div class="form-group">
            <label for="ownerName"> Name</label>
            <input type="text" name="ownerName" id="ownerName"  placeholder="Owner Name" value="<?php echo $OwnerName?>" onkeyup="countyForm_keyup(this)" />
        </div>




        <div class="form-group">
            <label for="date">Date of Birth</label>
            <input  name="dates"  class="form-control"   readonly size="10"  value="<?php echo $DOB?>" placeholder="YYYY/MM/DD" id="dates" />
        </div>




        <label for="countyCode"> County </label>
        <select  name="countyCode"    id="countyCode"   >

            <option>   <?php echo $County ?>    </option>
            <option>--- Select County--</option>
            <?php foreach($results as $output) {?>

                <option> <?php echo $output["countyName"]; ?></option>

            <?php } ?>
        </select>

        <br/>
        <label for="subCountyCode"> Sub  County </label>

        <select name="subCountyCode"   id="subCountyCode"   >
            <option>   <?php echo $SubCounty ?>    </option>
            <option>--- Select County--</option>

            <?php foreach($subcresults as $outputs) {?>

                <option> <?php echo $outputs["subco_name"]; ?></option>

            <?php } ?>
        </select>

        <br>




        <label for="locationName">Location</label>
        <select name="locationName"   id="LocationName"   >
            <option>   <?php echo $Location ?>    </option>
            <option>--- Select Location--</option>

            <?php foreach($resultslocation as $outputl) {?>

                <option> <?php echo $outputl["locationName"]; ?></option>

            <?php } ?>
        </select>

        </br>
        <label for="sublocationName">SubLocation</label>
        <select name="sublocationName"   id="SubLocationName"   >
            <option>   <?php echo $Sublocation ?>    </option>
            <option>--- Select  Sub Location--</option>

            <?php foreach($resultssublocation as $outputsl) {?>

                <option> <?php echo $outputsl["subLocation_name"]; ?></option>

            <?php } ?>
        </select>



        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $IdNumber?>" />
        <br />

        <input name="update" type="submit" class="btn btn-primary  " value="Update" onclick="return personal_details()" />
        <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="" />



    </form>
</div>

<script>

    $(function () {
        $('#dates').datepicker({ minDate: 0 });
    });

    $('#dates').datepicker({
        format: 'mm-dd-yyyy',
        autoclose:true,
        endDate: "today",
        maxDate: today
    });


    $(function(){
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();

        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        $('#dates').attr('max', maxDate);
    });


    function personal_details()
    {
        var Idnumber = document.getElementById('idNumber').value;
        var ownerNumbers= document.getElementById('ownerName').value;
        var datess= document.getElementById('dates').value;
        var countyCodes= document.getElementById('countyCode').value;

        if(Idnumber=="" ||ownerNumbers=="" ||datess==""||countyCodes=="")
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


</body>
</html>