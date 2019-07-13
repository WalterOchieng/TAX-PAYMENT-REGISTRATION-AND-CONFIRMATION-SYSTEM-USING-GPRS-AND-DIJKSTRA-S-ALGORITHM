<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/BussinessUsersDashboardLeft.php"); ?>


<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:LoginBussinessUsers.php");;

}
else
{
    echo '<h6>Login Success,Welcome!!' .$_SESSION["username"].'</h6>';
}

$start=$_SESSION["username"];

?>


<?php
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['bussinessCode']) && isset($_POST['ownerName'])&& isset($_POST['save']) )// values checked from form attribute names
    {

        $sql = "INSERT  INTO   owner(BussinessCode,owner_name,Id_Number,DOB,county,subcounty,location,sublocation)
 VALUES(:BussinessCode,:OwnerName,:IdNumber,:DOB,:County,:SubCounty,:Location,:Sublocation)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':BussinessCode' => $_POST['bussinessCode'],//pick values from forms names values and pass them to be inserted
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
    $posts[0]=$_POST['bussinessCode'];
    $posts[1]=$_POST['ownerName'];
    $posts[2]=$_POST['idNumber'];
    $posts[3]=$_POST['dates'];
    $posts[4]=$_POST['countyCode'];
    $posts[5]=$_POST['subCountyCode'];
    $posts[6]=$_POST['locationName'];
    $posts[7]=$_POST['sublocationName'];
    $posts[8]=$_POST['searchField'];
    return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1]) ||  empty($data[2])   ) {
        echo 'Enter the User Data to Update';

    }
    elseif (empty($data[0]))
    {
        echo 'Please  Search for Data to be updated or the BussinessCode you have selected does not exist!!';
    }

    else {
        $updateStmt = $conn->prepare('UPDATE  owner SET  BussinessCode=:BussinessCode,owner_name=:OwnerName,Id_Number=:IdNumber,DOB=:DOB,county=:County,subcounty=:SubCounty,location=:Location,sublocation=:Sublocation,subCounty=:SubCounty WHERE  BussinessCode=:searchField');
        $updateStmt->execute(array(
            ':BussinessCode' => $data[0],
            ':OwnerName' => $data[1],
            ':IdNumber' => $data[2],
            ':DOB' => $data[3],
            ':County' => $data[4],
            ':SubCounty' => $data[5],
            ':Location' => $data[6],
            ':Sublocation' => $data[7],
            ':searchField' => $data[8]

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

$BussinessCode='';
$OwnerName='';
$IdNumber='';
$DOB='';
$County='';
$SubCounty='';
$Location='';
$Sublocation='';
if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the  Bussiness Code to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM  owner WHERE BussinessCode=:BussinessCode');
        $searchStmt -> execute(array(
            ':BussinessCode' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No Bussiness found with such  Bussiness Code';
            }
            $BussinessCode = $user[0];
            $OwnerName = $user[1];
            $IdNumber=$user[2];
            $DOB=$user[3];
            $County=$user[4];
            $SubCounty=$user[5];
            $Location=$user[6];
            $Sublocation=$user[7];
        }} }
?>
<?php
//PHP  CODE TO DELETE DATA, WRITTEN BY WALTER O.
if(isset($_POST['delete']))
{

    $data = getPosts();

    if (empty($data[0])) {
        echo 'Enter the  Sub-County Code to Delete';

    } else {
        $deleteStmt = $conn->prepare('DELETE FROM  owner  WHERE BussinessCode=:BussinessCode' );
        $deleteStmt->execute(array(
            ':BussinessCode' => $data[0]

        ));
        if ($deleteStmt) {
            echo 'Data Deleted';
        }
    }
}

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
    <form   action="<?php   ?>" method="POST"    class="divforms"   enctype="multipart/form-data" name="BussinesOwner" id="BussinessOwner">
        <div class="form-group">
            <label for="idNumber">ID Number</label>
            <input type="text" name="idNumber" id="idNumber"  placeholder="ID Number"  readonly value="<?php echo $IdNumber?>" onkeyup="formVal_numbers_keyup(this)"  />
        </div>

        <div class="form-group">
            <label for="bussinessCode">Bussiness Number</label>
            <input type="text" name="bussinessCode" id="$BussinessCodes" placeholder="Bussiness Number" value="<?php echo $BussinessCode?>"  onkeyup="formVal_numbers_keyup(this)" />
        </div>



        <div class="form-group">
            <label for="ownerName">Owner Name</label>
            <input type="text" name="ownerName" id="ownerName"  placeholder="Owner Name" readonly value="<?php echo $OwnerName?>" onkeyup="countyForm_keyup(this)" />
        </div>




        <div class="form-group">
            <label for="date">Date of Birth</label>
            <input type="date" name="dates"  class="form-control"  size="10"  value="<?php echo $DOB?>" placeholder="YYYY/MM/DD" id="date" />
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



        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $BussinessCode?>" />
        <br />
        <input name="update" type="submit" class="btn btn-primary  " value="Update"  />
        <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="" />


    </form>
</div>




<?php  require("_includes/Footer.php"); ?>


</body>
</html>