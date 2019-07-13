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
    if( isset($_POST['subCountyCode']) && isset($_POST['subCountyName'])    && isset($_POST['save']) )// values checked from from attribute names

    {

        $sql = "INSERT  INTO subcounty(subCounty_code,subco_name,CountyName) VALUES(:SubCountyCode,:SubCountyName,:CountyName)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':SubCountyCode' => $_POST['subCountyCode'],//pick values from forms names values and pass them to be inserted
            ':SubCountyName' => $_POST['subCountyName'],
            ':CountyName' => $_POST['countyCode']));

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

    $posts[0]=$_POST['subCountyCode'];
    $posts[1]=$_POST['subCountyName'];
    $posts[2]=$_POST['countyCode'];
    $posts[3]=$_POST['searchField'];

    return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1]) ||  empty($data[2])   ) {
        echo 'Enter the User Data to Update';

    }
    elseif (empty($data[3]))
    {
        echo 'Please  Search for Data to be updated or the SubCountyCode you have selected does not exist!!';
    }
    elseif($data[2]=="--- Select County--")
    {
        echo 'Select County';

    }

    else {
        $updateStmt = $conn->prepare('UPDATE subcounty SET  subCounty_code=:SubCountyCode,subco_name=:SubCountyName,CountyName=:CountyName WHERE  subCounty_code=:searchField');
        $updateStmt->execute(array(
            ':SubCountyCode' => $data[0],
            ':SubCountyName' => $data[1],
            ':CountyName' => $data[2],
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

$SubcountyCodes='';
$SubcountyNames='';
$countyCodes='';

if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the  Sub County Code to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM subcounty WHERE subCounty_code=:subcountyCode');
        $searchStmt -> execute(array(
            ':subcountyCode' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No data found with such Code';
            }
            $SubcountyCodes = $user[0];
            $SubcountyNames = $user[1];
            $countyCodes=$user[2];
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
        $deleteStmt = $conn->prepare('DELETE FROM  subcounty  WHERE subCounty_code=:subcountyCode' );
        $deleteStmt->execute(array(
            ':subcountyCode' => $data[0]

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

<script>

    function subcountyForm_checkForm_save()
    {
        var SubCountyCode = document.getElementById('SubCountyCode').value;
        var SubCountyName= document.getElementById('SubCountyName').value;
        var countyName=documenet.getElementBuId('countyCode').value;

        if(SubCountyCode==""||SubCountyName==""  )
        {
            alert('Please fill All the fields in the form ');
            return false;
        }
        else
        {
            return true;
        }
    }
</script>

<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?>  </div>
    <form action="<?php   ?>" method="POST"    class="divformsSubCountyReg"  enctype="multipart/form-data" name="countyForms" id="countyForm"  >
        <div class="form-group">
            <label for="subCountyCode">Sub-County Code</label>
            <input type="text" name="subCountyCode" placeholder="SubCounty Code" id="SubCountyCode" maxlength="10" value="<?php echo $SubcountyCodes?>" onkeyup="formVal_numbers_keyup(this)" />
        </div>

        <div class="form-group">

            <label for="subCountyName"> Name </label>
            <input type="text" name="subCountyName" placeholder="SubCounty Name"  id="SubCountyName" maxlength="30" value="<?php echo $SubcountyNames?>" onkeyup="countyForm_keyup(this)" />
        </div>

        <div class="form-group">

            <label for="CountyCode"> County </label>

            <select  name="countyCode"   id="countyCode"   >
                <option>--- Select County--</option>

                <?php foreach($results as $output) {?>

                <option> <?php echo $output["countyName"]; ?></option>

                <?php } ?>
            </select>
        </div>



        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $SubcountyCodes?>" />
        <br />
        <input name="save" type="submit"   class="btn btn-primary  " value="Save" id="savebutton"   onclick=" return subcounty_Validation()"   />
        <input name="update" type="submit" class="btn btn-primary  " value="Update"  onclick=" return subcounty_Validation()"  />
        <input name="search" type="submit" class="btn btn-primary " value="Search" onclick=" return subcountysearch_Validation()" />
        <input name="refresh" type="reset" class="btn btn-primary "  value="Refresh" />
        <input name="delete" type="submit"  class="btn btn-primary " value="Delete" onclick=" return subcountysearch_Validation()" />


    </form>
</div>

<script>


    function subcounty_Validation()
    {
        var subcountycode = document.getElementById('SubCountyCode').value;
        var subcountyname= document.getElementById('SubCountyName').value;

        if(subcountycode==""||subcountyname=="")
        {
            alert('Please fill All the fields');
            return false;
        }
        else
        {        return true;
        }

    }


    function subcountysearch_Validation()
    {
        var subcountycode = document.getElementById('SubCountyCode').value;
        var subcountyname= document.getElementById('SubCountyName').value;

        if(subcountycode=="")
        {
            alert('Please fill in the SubCounty Code');
            return false;
        }
        else
        {        return true;
        }




    }


    function onFormSubmission(e){
        return confirm("do you want to save Yes/No");
    }

    var frm = document.getElementById('countyForm');
    frm.addEventListener("submit", onFormSubmission);


    function onFormUpdate(e){
        return confirm("do you want to update Yes/No");
    }

    var frm = document.getElementById('countyForm');
    frm.addEventListener("update", onFormUpdate);




</script>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>