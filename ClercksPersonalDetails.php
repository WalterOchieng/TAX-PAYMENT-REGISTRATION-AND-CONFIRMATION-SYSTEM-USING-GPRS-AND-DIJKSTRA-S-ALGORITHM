<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/ClercksUsersDashboardLeft.php"); ?>

<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:Systems_UsersForm.php");;

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
    if( isset($_POST['bussinessCode']) && isset($_POST['bussinessName'])&& isset($_POST['save']) )// values checked from form attribute names
    {

        $sql = "INSERT  INTO  bussiness(bussinessCode,bussinessName,reg_date,county,location,town,subCounty,district,status,description,BussType,IdNumber) VALUES(:BussinessCode,:BussinessName,:Dates,:County,:Location,:Town,:SubCounty,:District,:Status,:Description,:BussinessTypes,:IDNumber)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':BussinessCode' => $_POST['bussinessCode'],//pick values from forms names values and pass them to be inserted
            ':BussinessName' => $_POST['bussinessName'],
            ':Dates' => $_POST['dates'],
            ':County' => $_POST['countyCode'],
            ':Location' => $_POST['locationName'],
            ':Town' => $_POST['town'],
            ':SubCounty' => $_POST['subCountyCode'],
            ':District' => $_POST['district'],
            ':Status' => $_POST['status'],
            ':Description' => $_POST['description'],
            ':BussinessTypes' => $_POST['bussinessType'],
            ':IDNumber' => $_POST['idNumber']


        ));
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

    $posts[0]=$_POST['userID'];
    $posts[1]=$_POST['fullName'];
    $posts[2]=$_POST['designation'];
    $posts[3]=$_POST['countyCode'];
    $posts[4]=$_POST['subCountyCode'];

    //$posts[5]=$_POST['searchField'];

    return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1]) ||  empty($data[2])   ) {
        echo 'Enter the User Data to Update';

    }
    else {
        try{


        $updateStmt = $conn->prepare('UPDATE users SET  userID=:UserID,fullname=:FullName,designation=:Desg,county=:County,subcounty=:SubCounty WHERE  userID=:UserID');
        $updateStmt->execute(array(
            ':UserID' => $data[0],
            ':FullName' => $data[1],
            ':Desg' => $data[2],
            ':County' => $data[3],
            ':SubCounty' => $data[4]


        ));
        if ($updateStmt) {
            echo 'Your Details is  updated';
        }
    }
    catch(PDOException $ex)
    {
     echo $ex;
    }
    }
}
// END OF UPDATE STATEMENT

?>


<?php
// Php Code for Search

$UserID='';
$Fullname='';
$Designation='';
$County='';
$SubCountys='';

if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the  Bussiness Code to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM users WHERE userID=:UserID');
        $searchStmt -> execute(array(
            ':UserID' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No Bussiness found with such  Bussiness Code';
            }
            $UserID = $user[0];
            $Fullname = $user[1];
            $Designation=$user[2];
            $County=$user[3];
            $SubCountys=$user[4];


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
        $deleteStmt = $conn->prepare('DELETE FROM  bussiness  WHERE bussinessCode=:BussinessCodes' );
        $deleteStmt->execute(array(
            ':BussinessCodes' => $data[0]

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


<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form   action="<?php   ?>" method="POST"    class="clercksperosnaldetails"   enctype="multipart/form-data" name="countyForms" id="countyForm">

        <div class="form-group">
            <label for="userID">User ID</label>
            <input type="text" name="userID" id="UserID"  maxlength="30" readonly placeholder="User ID" value="<?php echo $start?>"  />
        </div>

        <div class="form-group">

            <label for="bussinessName">Full Name</label>
            <input type="text" name="fullName" id="fullName" maxlength="60" placeholder="Full Name" value="<?php echo $Fullname?>"  />
        </div>
        <div class="form-group">

            <label for="date">Designation</label>
            <input type="text" name="designation"  class="form-control" maxlength="30" size="30"  value="<?php echo $Designation?>"  id="designations" />
        </div>



        <div class="selectItems">


            <label for="CountyCode"> County </label>

            <select  name="countyCode"    id="countyCode"   >

                <option>   <?php echo $County ?>    </option>
                <option>--- Select County--</option>
                <?php foreach($results as $output) {?>

                    <option> <?php echo $output["countyName"]; ?></option>

                <?php } ?>
            </select>


            <label for="subCountyCode"> Sub  County </label>

            <select name="subCountyCode"   id="subCountyCode"   >
                <option>   <?php echo $SubCountys ?>    </option>
                <option>--- Select County--</option>

                <?php foreach($subcresults as $outputs) {?>

                    <option> <?php echo $outputs["subco_name"]; ?></option>

                <?php } ?>
            </select>

        </div>



        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $start?>" />
        <br />
        <input name="update" type="submit" class="btn btn-primary  " value="Update" onclick=" return clerckspersonaldetails()"  />
        <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="" />


    </form>
</div>

<script>

    function clerckspersonaldetails()
    {
        var cleckuserid = document.getElementById('UserID').value;
        var cleckfllname= document.getElementById('fullName').value;
        var deisg= document.getElementById('designations').value;

        if(cleckuserid=="" ||cleckfllname=="" ||deisg=="" )
        {
            alert('Please fill All the fields');
            return false;
        }


        else
        {        return true;
        }

    }






</script>
</script>


<?php  require("_includes/Footer.php"); ?>

