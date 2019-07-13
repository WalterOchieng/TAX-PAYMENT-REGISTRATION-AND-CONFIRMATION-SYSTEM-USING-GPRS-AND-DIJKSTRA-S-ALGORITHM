<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboardAdmin.php"); ?>
<?php  require("_includes/AdminDashboardLeft.php"); ?>

<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:Systems_UsersForm.php");;

}


$start=$_SESSION["username"];

?>


<?php
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['locationCode']) && isset($_POST['locationName'])&& isset($_POST['save']) )// values checked from from attribute names

    {



        $sql = "INSERT  INTO  location(locationCode,locationName,subco_name) VALUES(:LocationCode,:LocationName,:SubcountyName)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':LocationCode' => $_POST['locationCode'],//pick values from forms names values and pass them to be inserted
            ':LocationName' => $_POST['locationName'],
            ':SubcountyName' => $_POST['subcountyCode']));

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

    $posts[0]=$_POST['locationCode'];
    $posts[1]=$_POST['locationName'];
    $posts[2]=$_POST['subcountyCode'];
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
        $updateStmt = $conn->prepare('UPDATE  location SET  locationCode=:LocationCode,locationName=:LocationName,subco_name=:subCountyName WHERE  locationCode=:searchField');
        $updateStmt->execute(array(
            ':LocationCode' => $data[0],
            ':LocationName' => $data[1],
            ':subCountyName' => $data[2],
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

$locationCodes='';
$locationName='';
$subCountyCode='';

if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the  Sub County Code to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM  location WHERE locationCode=:locationCodes');
        $searchStmt -> execute(array(
            ':locationCodes' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No data found with such Code';
            }
            $locationCodes = $user[0];
            $locationName = $user[1];
            $subCountyCode=$user[2];
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
        $deleteStmt = $conn->prepare('DELETE FROM   location  WHERE locationCode=:LocationCode' );
        $deleteStmt->execute(array(
            ':LocationCode' => $data[0]

        ));
        if ($deleteStmt) {
            echo 'Data Deleted';
        }


    }
}

?>

<?php
$sqlpop="select subco_name from  subcounty";
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
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?>  </div>
    <form action="<?php   ?>" method="POST"    class="divformsLocationsReg"   enctype="multipart/form-data" name="countyForms" id="LocationForm"  >

        <div class="form-group">
            <label for="locationCode">Location Code</label>
            <input type="text" name="locationCode" placeholder="Location Code" id="locationCode"  maxlength="10" value="<?php echo $locationCodes?>" onkeyup="formVal_numbers_keyup(this)"   />
        </div>

        <div class="form-group">

            <label for="locationName"> Location Name </label>
            <input type="text" name="locationName" placeholder="Location Name"  id="locationName"  value="<?php echo $locationName?>" onsubmit="return locationsearch_Validation()" onkeyup="countyForm_keyup(this)" />
        </div>

        <div class="form-group">

            <label for="Sub CountyCode"> Sub County </label><br/>

            <select name="subcountyCode"   id="countyCode">
                <option>--- Select Sub County--</option>

                <?php foreach($results as $output) {?>

                    <option> <?php echo $output["subco_name"]; ?></option>

                <?php } ?>
            </select>
        </div>
        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $locationCodes?>" />


        <br />
        <input name="save" type="submit"   class="btn btn-primary  " value="Save" id="savebutton"  onclick="return location_Validation()"  />
        <input name="update" type="submit" class="btn btn-primary  " value="Update"  onclick="return locationsearch_Validation()" />
        <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="return locationsearch_Validation()" />
        <input name="refresh" type="reset" class="btn btn-primary "  value="Refresh"/>
        <input name="delete" type="submit"  class="btn btn-primary " value="Delete" onclick="return locationsearch_Validation()" />


    </form>
</div>

<script>


    function location_Validation()
    {
        var locationCode = document.getElementById('locationCode').value;
        var locationName= document.getElementById('locationName').value;

        if(locationCode==""||locationName=="")
        {
            alert('Please fill All the fields');
            return false;
        }
        else
        {        return true;
        }

    }


    function locationsearch_Validation()
    {
        var locationCode = document.getElementById('locationCode').value;

        if(locationCode=="")
        {
            alert('Please fill in the Location Code');
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