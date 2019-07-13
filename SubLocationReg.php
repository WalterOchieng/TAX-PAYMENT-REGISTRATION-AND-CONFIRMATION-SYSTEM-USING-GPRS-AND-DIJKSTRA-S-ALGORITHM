<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/mainDashboardLeft.php"); ?>

<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:Systems_UsersForm.php");;

}


$start=$_SESSION["username"];

?>

<span class="wb-sessto" data-wb-sessto='{"inactivity": 1200000, "reactionTime": 30000, "sessionalive": 1200000, "logouturl": "Systems_UsersForm.php", "refreshCallbackUrl": "./"}'></span>
<span class="wb-sessto" data-wb-sessto='{logouturl: "Systems_UsersForm.php"}'></span>


<?php
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['subLocationCode']) && isset($_POST['subLocationName'])    && isset($_POST['save']) )// values checked from from attribute names

    {



        $sql = "INSERT  INTO   sublocation(sublocationCode,subLocation_name,locationName) VALUES(:SubLocationCode,:SubLocationName,:LocationName)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':SubLocationCode' => $_POST['subLocationCode'],//pick values from forms names values and pass them to be inserted
            ':SubLocationName' => $_POST['subLocationName'],
            ':LocationName' => $_POST['locationName']));

        if ($smt) {
            echo 'Data has been Inserted';
        }
    }



}
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

    $posts[0]=$_POST['subLocationCode'];
    $posts[1]=$_POST['subLocationName'];
    $posts[2]=$_POST['locationName'];
    $posts[3]=$_POST['searchField'];

    return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1]) ||  empty($data[2]) || empty($data[3])  ) {
        echo 'Enter the User Data to Update';

    }

    else {
        $updateStmt = $conn->prepare('UPDATE   sublocation SET  sublocationCode=:subLocationCode,subLocation_name=:subLocationName,locationName=:LocationName WHERE  sublocationCode=:searchField');
        $updateStmt->execute(array(
            ':subLocationCode' => $data[0],
            ':subLocationName' => $data[1],
            ':LocationName' => $data[2],
            ':searchField' => $data[3]
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

$sublocationCodes='';
$sublocationName='';
$locationName='';

if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the  Sub County Code to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM   sublocation WHERE sublocationCode=:locationCodes');
        $searchStmt -> execute(array(
            ':locationCodes' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No data found with such Code';
            }
            $sublocationCodes = $user[0];
            $sublocationName = $user[1];
            $locationName=$user[2];
        }} }
?>


<?php
//PHP  CODE TO DELETE DATA, WRITTEN BY WALTER O.
if(isset($_POST['delete']))
{

    $data = getPosts();

    if (empty($data[0])) {
        echo 'Enter the  Sub-Location Code to Delete';

    } else {
        $deleteStmt = $conn->prepare('DELETE FROM    sublocation  WHERE sublocationCode=:subLocationCode' );
        $deleteStmt->execute(array(
            ':subLocationCode' => $data[0]

        ));
        if ($deleteStmt) {
            echo 'Sub-Location Data  Deleted';
        }
    }
}

?>

<?php
$sqlpop="select locationName from   location";
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



<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form action="<?php   ?>" method="POST"    class="divformsCountyReg"   enctype="multipart/form-data" name="countyForms" id="LocationForm"  >
        <div class="form-group">
            <label for="subLocationCode"> Sub Location Code</label>
            <input type="text" name="subLocationCode" placeholder="Sub Location Code" id="sublocationCode"  value="<?php echo $sublocationCodes?> " onkeyup="formVal_numbers_keyup(this)" />
        </div>

        <div class="form-group">

            <label for="locationName"> Sub-Location Name </label>
            <input type="text" name="subLocationName" placeholder=" Sub Location Name"  id="subLocationName"  value="<?php echo $sublocationName?>" onkeyup="countyForm_keyup(this)" />
        </div>

        <div class="form-group">

            <label for="Location">  Location </label>

            <select name="locationName"   id="locationName"   >
                <option>--- Select Location--</option>

                <?php foreach($results as $output) {?>

                    <option> <?php echo $output["locationName"]; ?></option>

                <?php } ?>
            </select>
        </div>
        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $sublocationCodes?>" />


        <br />
        <input name="save" type="submit"   class="btn btn-primary  " value="Save" id="savebutton"   />
        <input name="update" type="submit" class="btn btn-primary  " value="Update"  />
        <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="" />
        <input name="refresh" type="reset" class="btn btn-primary "  value="Refresh" onclick="" />
        <input name="delete" type="submit"  class="btn btn-primary " value="Delete" onclick="" />


    </form>
</div>

<?php  require("_includes/Footer.php"); ?>
