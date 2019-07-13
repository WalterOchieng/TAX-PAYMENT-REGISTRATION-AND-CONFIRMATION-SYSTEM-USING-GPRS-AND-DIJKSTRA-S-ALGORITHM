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
if( isset($_POST['countyCode']) && isset($_POST['countyName']) && isset($_POST['saves']) )// values checked from from attribute names

{



        $sql = "INSERT  INTO county(countyCode,countyName) VALUES(:CountyCode,:CountyName)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':CountyCode' => $_POST['countyCode'],//pick values from forms names values and pass them to be inserted
            ':CountyName' => $_POST['countyName']));

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

$posts[0]=$_POST['countyCode'];
$posts[1]=$_POST['countyName'];
$posts[2]=$_POST['searchField'];

return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1])|| empty($data[2])   ) {
        echo 'Search data to be updated';

    }

    else {
        $updateStmt = $conn->prepare('UPDATE county SET  countyCode=:countyCode,countyName=:countyName WHERE  countyCode=:searchField');
        $updateStmt->execute(array(
            ':countyCode' => $data[0],
            ':countyName' => $data[1],
             ':searchField' => $data[2]
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

$countyCodes='';
$countyNames='';

if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the County Code to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM county WHERE countyCode=:countyCode');
        $searchStmt -> execute(array(
            ':countyCode' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No data found with such Code';
            }
            $countyCodes = $user[0];
            $countyNames = $user[1];
        }} }

?>


<?php
//PHP  CODE TO DELETE DATA, WRITTEN BY WALTER O.
if(isset($_POST['delete'])) {

    $data = getPosts();

    if (empty($data[0])) {
        echo 'Enter the County Code to Delete';

    } else {

        $deleteStmt = $conn->prepare('DELETE FROM  county  WHERE countyCode=:countyCode' );
        $deleteStmt->execute(array(
            ':countyCode' => $data[0],

        ));
        if ($deleteStmt) {
            echo 'Data Deleted';
        }
    }
}

?>


<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?>  </div>
  <form action="" method="POST"   name="countyForms"   class="divformsCountyReg"  enctype="multipart/form-data"    >

    <div class="form-group">
      <label for="countyCode">County Code</label>
        <input type="text" name="countyCode" placeholder="County Name"   maxlength="12" id="CountyNumber" value="<?php echo $countyCodes?>" onkeyup="formVal_numbers_keyup(this)" >

    </div>

    <div class="form-group">
    
      <label for="countyName">County Name</label>
      <input type="text" name="countyName" placeholder="County Name"  id="CountyName" maxlength="30"  value="<?php echo $countyNames?>" onkeyup="countyForm_keyup(this)" />
      </div>

          <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $countyCodes?>" />
        <br />
      <input name="saves" type="submit"   class="btn btn-primary  " value="Save" id="savebutton"  onclick=" return countydatasave_Validation()" />
      <input name="update" type="submit" class="btn btn-primary  " value="Update" onclick="return countydatasave_Validation()" />
      <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="return countydatadel_Validation()" />
      <input name="refresh" type="reset" class="btn btn-primary "  value="Refresh"  />
      <input name="delete" type="submit"  class="btn btn-primary " value="Delete" onclick="return countydatadel_Validation()" />

      
    </form>
</div>




<?php  require("_includes/Footer.php"); ?>

</body>



<script>




</script>
</html>