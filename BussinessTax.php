<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/mainDashboardLeft.php"); ?>


<?php
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['bussinessCode']) && isset($_POST['taxAmount']) && isset($_POST['save']) )// values checked from from attribute names

    {



        $sql = "INSERT  INTO bussiness_tax(bussinessCode,taxAmount) VALUES(:BussinessCode,:TaxAmount)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':BussinessCode' => $_POST['bussinessCode'],//pick values from forms names values and pass them to be inserted
            ':TaxAmount' => $_POST['taxAmount']));

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

    $posts[0]=$_POST['bussinessCode'];
    $posts[1]=$_POST['taxAmount'];
    $posts[2]=$_POST['searchField'];

    return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1])|| empty($data[2])   ) {
        echo 'Enter the User Data to Update /Search data to be updated';

    }

    else {
        $updateStmt = $conn->prepare('UPDATE bussiness_tax SET  bussinessCode=:BussinessCode,taxAmount=:TaxAmount WHERE  bussinessCode=:searchField');
        $updateStmt->execute(array(
            ':BussinessCode' => $data[0],
            ':TaxAmount' => $data[1],
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

$BussinessCode='';
$TaxAmount='';

if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the County Code to Search';
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
            $BussinessCode = $user[0];
            $TaxAmount = $user[1];
        }} }

?>


<?php
//PHP  CODE TO DELETE DATA, WRITTEN BY WALTER O.
if(isset($_POST['delete'])) {

    $data = getPosts();

    if (empty($data[0])) {
        echo 'Enter the Bussiness Code to Delete';

    } else {
        $deleteStmt = $conn->prepare('DELETE FROM  bussiness_tax  WHERE bussinessCode=:BussinessCode' );
        $deleteStmt->execute(array(
            ':BussinessCode' => $data[0]

        ));
        if ($deleteStmt) {
            echo 'Data Deleted';
        }
    }
}

?>

<div class="panelDisplay">
    <form action="<?php   ?>" method="POST"    class="divformsCountyReg"  enctype="multipart/form-data" name="BussinessTax" id="bussinessTax"  >
        <div class="form-group">
            <label for="bussinessCode">Bussiness Code</label>
            <input type="text" name="bussinessCode" placeholder="Bussiness Code" id="BussinessCode"  value="<?php echo $BussinessCode?> " onkeyup="formVal_numbers_keyup(this)" />
        </div>

        <div class="form-group">

            <label for="taxAmount"> Tax Amount</label>
            <input type="text" name="taxAmount" placeholder="Tax Amount"  id="TaxAmount"  value="<?php echo $TaxAmount?>" onkeyup="formVal_numbers_keyup(this)" />
        </div>

        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $BussinessCode?>" />
        <br />
        <input name="save" type="submit"   class="btn btn-primary  " value="Save" id="savebutton"  onclick="return countyFormcheckFormsave()" />
        <input name="update" type="submit" class="btn btn-primary  " value="Update"  />
        <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="return countyForm_checkForm_del_search()" />
        <input name="refresh" type="reset" class="btn btn-primary "  value="Refresh" onclick="return countyForm_checkForm_Refresh()" />
        <input name="delete" type="submit"  class="btn btn-primary " value="Delete" onclick="return countyForm_checkForm_del_search()" />


    </form>
</div>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>