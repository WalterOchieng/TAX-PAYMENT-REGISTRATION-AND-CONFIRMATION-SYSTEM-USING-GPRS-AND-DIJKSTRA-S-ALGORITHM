<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboardAdmin.php"); ?>
<?php  require("_includes/AdminDashboardLeft.php"); ?>

<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:LoginBussinessUsers.php");;

}

$start=$_SESSION["username"];

?>

<?php
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['userID']) && isset($_POST['fullName'])&& isset($_POST['save']) )// values checked from form attribute names
    {

        $sql = "INSERT  INTO  users(userID,fullname,designation,county,subcounty,username,password,previladge,Email) VALUES(:USerID,:FullName,:Designation,:County,:SubCounty,:Username,:Password,:Previledge,:Email)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':USerID' => $_POST['userID'],//pick values from forms names values and pass them to be inserted
            ':FullName' => $_POST['fullName'],
            ':Designation' => $_POST['designation'],
            ':County' => $_POST['countyCode'],
            ':SubCounty' => $_POST['subCountyCode'],
            ':Username' => $_POST['username'],
            ':Password' => $_POST['passswords'],
            ':Previledge' => $_POST['previledge'],
            ':Email' => $_POST['Emails']


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
    $posts[5]=$_POST['username'];
    $posts[6]=$_POST['passswords'];
    $posts[7]=$_POST['previledge'];
    $posts[8]=$_POST['Emails'];


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


            $updateStmt = $conn->prepare('UPDATE users SET  userID=:UserID,fullname=:FullName,designation=:Desg,county=:County,subcounty=:SubCounty,username=:Username,password=:Password,previladge=:Previledge,Email=:Email  WHERE  userID=:UserID');
            $updateStmt->execute(array(
                ':UserID' => $data[0],
                ':FullName' => $data[1],
                ':Desg' => $data[2],
                ':County' => $data[3],
                ':SubCounty' => $data[4],
                ':Username' => $data[5],
                ':Password' => $data[6],
                ':Previledge' => $data[7],
                ':Email' => $data[8]


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
$Username='';
$Password='';
$Previledge='';
$Email='';


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
            $Username=$user[5];
            $Password=$user[6];
            $Previledge=$user[7];
            $Email=$user[8];


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
            <input type="text" name="userID" id="UserID"   placeholder="User ID" value="<?php echo $UserID?>"  />
        </div>

        <div class="form-group">

            <label for="bussinessName">Full Name</label>
            <input type="text" name="fullName" id="fullName" placeholder="Full Name" value="<?php echo $Fullname?>"  />
        </div>
        <div class="form-group">

            <label for="date">Designation</label>
            <input type="text" name="designation"  class="form-control"  size="30"  value="<?php echo $Designation?>"  id="date" />
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


        <div class="form-group">

            <label for="username">Username</label>
            <input type="text" name="username"  class="form-control"  size="30"  value="<?php echo $Username?>"  id="username" />
        </div>


        <div class="form-group">

            <label for="passswords">Password</label>
            <input type="password" name="passswords"  class="form-control"  size="30"  value="<?php echo $Password?>"  id="passwords" />
        </div>


        <label for="previledge"> Previldeges </label><br/>

        <select name="previledge"   id="previledge"   >
            <option>   <?php echo $Previledge ?>    </option>
            <Option> 1</Option>
            <option>2</option>
        </select>

        <div class="form-group">

            <label for="Emails">Email</label>
            <input type="email" name="Emails"  class="form-control"  size="30"  value="<?php echo $Email?>"  id="Emails" />
        </div>






        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $start?>" />
        <br />
        <input name="save" type="submit" class="btn btn-primary  " value="Save"  />
        <input name="update" type="submit" class="btn btn-primary  " value="Update"  />
        <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="" />


    </form>
</div>




<?php  require("_includes/Footer.php"); ?>

