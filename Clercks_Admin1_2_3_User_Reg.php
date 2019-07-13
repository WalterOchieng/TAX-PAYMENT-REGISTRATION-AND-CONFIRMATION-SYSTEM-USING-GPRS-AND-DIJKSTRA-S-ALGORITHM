<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/AdminDashboardLeft.php"); ?>

<?php
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['userId']) && isset($_POST['fullName'])&& isset($_POST['save']) )// values checked from form attribute names
    {

        $sql = "INSERT  INTO   users(userID,fullname,designation,county,subcounty,username,password,previladge) 
VALUES(:UserID,:Fullname,:Designation,:County,:SubCounty,:Username,:Passsword,:Previldge)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':UserID' => $_POST['userId'],//pick values from forms names values and pass them to be inserted
            ':Fullname' => $_POST['fullName'],
            ':Designation' => $_POST['designation'],
            ':County' => $_POST['countyCode'],
            ':SubCounty' => $_POST['subCountyCode'],
            ':Username' => $_POST['userName'],
            ':Passsword' => $_POST['passsWord'],
            ':Previldge' => $_POST['previldges']));
        if ($smt) {
            echo 'User  has been Added into the System';
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

    $posts[0]=$_POST['userId'];
    $posts[1]=$_POST['fullName'];
    $posts[2]=$_POST['designation'];
    $posts[3]=$_POST['countyCode'];
    $posts[4]=$_POST['subCountyCode'];
    $posts[5]=$_POST['userName'];
    $posts[6]=$_POST['passsWord'];
    $posts[7]=$_POST['previldges'];
    $posts[8]=$_POST['searchField'];

    return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1]) ||  empty($data[2])   ) {
        echo 'Enter the User Data to Update';

    }
    elseif (empty($data[8]))
    {
        echo 'Please  Search for Data to be updated or the User ID you have selected does not exist!!';
    }



    else {
        $updateStmt = $conn->prepare('UPDATE users SET  userID=:UserID,fullname=:Fullname,designation=:Designation,county=:County,subcounty=:SubCounty,username=:Username,password=:Passsword,previladge=:Previldge WHERE  userID=:searchField');
        $updateStmt->execute(array(
            ':UserID' => $data[0],
            ':Fullname' => $data[1],
            ':Designation' => $data[2],
            ':County' => $data[3],
            ':SubCounty' => $data[4],
            ':Username' => $data[5],
            ':Passsword' => $data[6],
            ':Previldge' => $data[7],
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

$UserID='';
$FullName='';
$Designation='';
$County='';
$SubCounty='';
$Username='';
$Password='';

$Previldge='';

if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the  ID to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM users WHERE userID=:UserIDs');
        $searchStmt -> execute(array(
            ':UserIDs' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No User found with such  ID';
            }
            $UserID = $user[0];
            $FullName = $user[1];
            $Designation=$user[2];
            $County=$user[3];
            $SubCounty=$user[4];
            $Username=$user[5];
            $Password=$user[6];
            $Previldge=$user[7];

        }} }
?>


<?php
//PHP  CODE TO DELETE DATA, WRITTEN BY WALTER O.
if(isset($_POST['delete']))
{

    $data = getPosts();

    if (empty($data[0])) {
        echo 'Enter the  User ID to Delete';

    } else {
        $deleteStmt = $conn->prepare('DELETE FROM  users   WHERE userID=:UserIDs' );
        $deleteStmt->execute(array(
            ':UserIDs' => $data[0]));
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


<div class="panelDisplay">
    <form   action="<?php   ?>" method="POST"    class="clerck_admin_form"   enctype="multipart/form-data" name="countyForms" id="countyForm">

        <div class="form-group">
            <label for="userId">User ID:</label>
            <input type="text" name="userId" id="userid" placeholder="User ID" value="<?php echo $UserID?>" />
        </div>

        <div class="form-group">

            <label for="fullName">Full Name: </label>
            <input type="text" name="fullName" id="fullNames"  placeholder="Full Name" value="<?php echo $FullName?>"  />
        </div>

        <label for="designation"> Designation </label>
        <select name="designation"   id="subCountyCode"   >
            <option>   <?php echo $Designation ?>    </option>
            <option>--- Select Designation--</option>

            <?php foreach($subcresults as $outputs) {?>

                <option> <?php echo $outputs["subco_name"]; ?></option>

            <?php } ?>
        </select>

            <br>
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
                <option>   <?php echo $SubCounty ?>    </option>
                <option>--- Select Sub County--</option>

                <?php foreach($subcresults as $outputs) {?>

                    <option> <?php echo $outputs["subco_name"]; ?></option>

                <?php } ?>
            </select>

            </br>


        <div class="form-group">

            <label for="userName">Username: </label>
            <input type="text" name="userName" id="userName"   placeholder="User Name"value="<?php echo $Username?>"  />
        </div>


        <div class="form-group">

        <label for="passsWord">Password: </label>
        <input type="password" name="passsWord" id="passwords" placeholder="Password" value="<?php echo $Password?>"  />
</div>

        <div class="form-group">

        <label for="userName">Confirm Password: </label>
        <input type="password" name="confPassword" id="confPassword" placeholder="Confirm Password"    />
        </div>








            <label for="previldges">Previledges</label>
            <select name="previldges" id="prev">
                <option>   <?php echo $Previldge ?>    </option>
                <option value="0">Select Previledge:</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>


            <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $UserID?>" />
            <br />
            <input name="save" type="submit"   class="btn btn-primary  " value="Save" id="savebutton"   />
            <input name="update" type="submit" class="btn btn-primary  " value="Update"  />
            <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="" />
            <input name="refresh" type="reset" class="btn btn-primary "  value="Refresh" onclick="" />
            <input name="delete" type="submit"  class="btn btn-primary " value="Delete" onclick="" />

    </form>
</div>




<?php  require("_includes/Footer.php"); ?>


</body>
</html>