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
    if( isset($_POST['bussinessCode']) && isset($_POST['bussinessName'])&& isset($_POST['save']) )// values checked from form attribute names
    {
        $data = getPosts();

        if (empty($data[0]) || empty($data[1]) ||  empty($data[2])  ||  empty($data[3]) ||  empty($data[4]) ||  empty($data[5])  ||  empty($data[6])  ||  empty($data[7]) ||  empty($data[8]) ||  empty($data[9])||  empty($data[10]) ||  empty($data[11]) ) {
            echo 'Enter All Data to save ';


        }
        else {


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
        }
    } }
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
    $posts[1]=$_POST['bussinessName'];
    $posts[2]=$_POST['dates'];
    $posts[3]=$_POST['countyCode'];
    $posts[4]=$_POST['locationName'];
    $posts[5]=$_POST['town'];
    $posts[6]=$_POST['subCountyCode'];
    $posts[7]=$_POST['district'];
    $posts[8]=$_POST['status'];
    $posts[9]=$_POST['description'];
    $posts[10]=$_POST['bussinessType'];
    $posts[11]=$_POST['idNumber'];
    $posts[12]=$_POST['searchField'];


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
        echo 'Please  Search for Data to be updated or the SubCountyCode you have selected does not exist!!';
    }

else {
        $updateStmt = $conn->prepare('UPDATE bussiness SET  bussinessCode=:BussinessCode,bussinessName=:BussinessName,reg_date=:Dates,county=:County,location=:Location,town=:Town,subCounty=:SubCounty,district=:District,status=:Status,description=:Description,BussType=:BussnessType,IdNumber=:IdNumber WHERE  bussinessCode=:searchField');
        $updateStmt->execute(array(
            ':BussinessCode' => $data[0],
            ':BussinessName' => $data[1],
            ':Dates' => $data[2],
            ':County' => $data[3],
            ':Location' => $data[4],
            ':Town' => $data[5],
            ':SubCounty' => $data[6],
            ':District' => $data[7],
            ':Status' => $data[8],
            ':Description' => $data[9],
            ':BussnessType' => $data[10],
            ':IdNumber' => $data[11],
            ':searchField' => $data[12]

        ));
        if ($updateStmt) {
            echo 'Data updated';
            $last_id = $conn->lastInsertId();
            echo "New record created successfully. Your Bussiness ID is: " . $last_id;
        }



    }
}
// END OF UPDATE STATEMENT

?>


<?php
// Php Code for Search

$BussinessCodes='';
$BussinessNames='';
$Datess='';
$County='';
$Location='';
$Towns='';
$SubCountys='';
$Districts='';
$Status='';
$Description='';
$BussinessType='';
$IDNumber='';




if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter the  Bussiness Code to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM bussiness WHERE bussinessCode=:BussinessCodes');
        $searchStmt -> execute(array(
            ':BussinessCodes' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No Bussiness found with such  Bussiness Code';
            }
            $BussinessCodes = $user[0];
            $BussinessNames = $user[1];
            $Datess=$user[2];
            $County=$user[3];
            $Location=$user[4];
            $Towns=$user[5];
            $SubCountys=$user[6];
            $Districts=$user[7];
            $Status=$user[8];
            $Description=$user[9];
            $BussinessType=$user[10];
            $IDNumber=$user[11];

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
$sqlloc="select BussType from   bussiness_tax_award";
try
{
$stmts=$conn->prepare($sqlloc);
$stmts->execute();
$resultsbussinestype=$stmts->fetchAll();
}
catch(PDOException $ex)
{
echo "Data cannot be fetched".$ex->getMessage();

}


?>


<?php
$sqllocs="select Description from   bussiness_tax_award WHERE BussType='+$data[9]+'";
try
{
    $stmts=$conn->prepare($sqllocs);
    $stmts->execute();
    $resultdesc=$stmts->fetchAll();

   // $descriptionss=$resultdec[9];


 if ($stmts) {
     $user = $stmts->fetch();

 }

    $descriptionss=$user[9];
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();

}


?>


<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
  <form   action="<?php   ?>" method="POST"    class="divforms"   enctype="multipart/form-data" name="countyForms" id="countyForm">

    <div class="form-group">
      <label for="bussinessCode">Bussiness Number</label>
      <input type="text" name="bussinessCode" id="$BussinessCodes" placeholder="Bussiness Code" value="<?php echo $BussinessCodes?>"  onkeyup="formVal_numbers_keyup(this)" />
      </div>
      
    <div class="form-group">
    
      <label for="bussinessName">Bussiness Name</label>
      <input type="text" name="bussinessName" id="bussinessName" placeholder="Bussinesss Name" value="<?php echo $BussinessNames?>" onkeyup="countyForm_keyup(this)" />
      </div>
    <div class="form-group">
    
      <label for="date">Date</label>
      <input  name="dates"  class="form-control"  readonly size="30"  value="<?php echo $Datess?>" placeholder="YYYY/MM/DD" id="dates" />
      </div>
    
      <div class="selectItems">


          <label for="CountyCode"> County </label>

              <select  name="countyCode"    id="countyCode">

                  <option>   <?php echo $County ?>    </option>
                  <option>--- Select County--</option>
                  <?php foreach($results as $output) {?>

                      <option> <?php echo $output["countyName"]; ?></option>

                  <?php } ?>
              </select>


          <label for="subCountyCode"> Sub  County </label>

          <select name="subCountyCode"   id="subCountyCode">
              <option>   <?php echo $SubCountys ?>    </option>
              <option>--- Select County--</option>

              <?php foreach($subcresults as $outputs) {?>

                  <option> <?php echo $outputs["subco_name"]; ?></option>

              <?php } ?>
          </select>

           <label for="district">District</label>
          <select name="district" id="district">
              <option>   <?php echo $Districts ?>    </option>
                 <option value="Mt.Elgon">Mt.Elgon</option>
                 <option value="Bumula">Bumula</option>
                 <option value="Cheptais">Cheptais</option>
                 <option value="Bungoma South">Bungoma South</option>
                 <option value="Bungoma East">Bungoma East</option>
                 <option value="Bungoma Central">Bungoma Central</option>
                 <option value="Bungoma North">Bungoma North</option>
                 <option value="Kimilili">Kimilili</option>
          </select>
            
          <label for="location">Location</label>
              <select name="locationName"   id="LocationName">
                  <option>   <?php echo $Location ?>    </option>
                  <option>--- Select Location--</option>

                  <?php foreach($resultslocation as $outputl) {?>

                      <option> <?php echo $outputl["locationName"]; ?></option>

                  <?php } ?>
              </select>


          <br />
          <label for="town">
            Town</label>
          <select name="town" id="town">
              <option>   <?php echo $Towns ?>    </option>
            <option value="Kandui">Kandui</option>
            <option value="Bungoma">Bungoma</option>
            <option value="Kimilili">Kimilili</option>
            <option value="Chwele">Chwele</option>
            <option value="Webuye">Webuye</option>
            <option value="Sirisia">Sirisia</option>
            
          </select>

          <label for="status">status</label>
          <select name="status" id="status">
              <option>   <?php echo $Status ?>    </option>
            <option value="0">Select Status:</option> 
            <option value="1">1</option>   
            <option value="2">2</option> 
          </select>

<br/>
          <label for="bussinessType">Bussiness Type</label>
          <select name="bussinessType"   id="bussinessType"   >

              <option>   <?php echo $BussinessType ?>    </option>

              <option>--- Select Bussiness Type--</option>
              <?php foreach($resultsbussinestype as $outputl) {?>

                  <option> <?php echo $outputl["BussType"]; ?></option>

              <?php } ?>
          </select>



      </div>

      <br/>
        <label for="description">Description</label>
        <textarea class="form-control" name="description"    id="description" >

            <?php echo $Description ?>

        </textarea>

      <div class="form-group">

          <label for="idNumber">ID Number </label>
          <input type="text" name="idNumber" id="idNumber" readonly value="<?php echo $start?>"  />
      </div>

          <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $BussinessCodes?>" />
          <br />
          <input name="save" type="submit"   class="btn btn-primary  " value="Save" id="savebutton"  onclick=" return bussinesssave_data()"  />
          <input name="update" type="submit" class="btn btn-primary  " value="Update"  />
          <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="" />
          <input name="refresh" type="reset" class="btn btn-primary "  value="Refresh" onclick="" />

      
      </form>
</div>



<script>

    $(function () {
        $('#dates').datepicker({ minDate: 0});
    });




    function bussinesssave_data()
    {
        var busscode = document.getElementById('BussinessCodes').value;
        var bussName= document.getElementById('bussinessName').value;
        var datess= document.getElementById('dates').value;
        var countyCodes= document.getElementById('countyCode').value;


        if(busscode=="" ||bussName=="" ||datess==""||countyCodes=="")
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

