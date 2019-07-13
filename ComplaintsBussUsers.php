<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/Buss_usersmenuDashboard.php"); ?>
<?php  require("_includes/BussinessUsersDashboardLeft.php"); ?>
<?php
session_start();

if(!isset($_SESSION["username"]))
{
   // echo '<h6>Login Success,Welcome!!' .$_SESSION["username"].'</h6>';

}
else
{
    header("location:LoginBussinessUsers.php");
}
?>



<?php
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if(  isset($_POST['IDNumber'])&& isset($_POST['Complain_posted']) )// values checked from form attribute names
    {

        $sql = "INSERT  INTO   buss_users_complanits(IdNumber,bussinessCode,complains,countyName,posted_time)
 VALUES(:IdNumber,:BussinessCode,:Complaints,:CountyCode,:DatePosted)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':IdNumber' => $_POST['IDNumber'],
            ':BussinessCode' => $_POST['bussinessCode'],
            ':Complaints' => $_POST['complaints'],
            ':CountyCode' => $_POST['countyCode'],
            ':DatePosted' => $_POST['date_posted']
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
<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form action="<?php   ?>" method="POST"    class="complaintsBussUsers"  enctype="multipart/form-data" name="BussinessTax" id="complaints"  >
        <div class="form-group">
            <label for="IDNumber">ID Number:</label>
            <input type="text" name="IDNumber" placeholder="ID Number " id="IDNumber" value="<?php echo $start?>" readonly  onkeyup="formVal_numbers_keyup(this)" />
        </div>
        <div class="form-group">
            <label for="bussinessCode">Bussiness Code:</label>
            <input type="text" name="bussinessCode" placeholder="Bussiness Code" id="BussinessCode" required  />
        </div>


        <label for="complaints">Complaints:</label><br/>
        <textarea  class="form-control" name="complaints"   required id="Complain" >



        </textarea><br/>




        <div class="form-group">

            <label for="CountyCode"> County  </label>

            <select class="form-control" name="countyCode"  required id="countyCode"   >
                <option>--- Select County--</option>

                <?php foreach($results as $output) {?>

                    <option> <?php echo $output["countyName"]; ?></option>

                <?php } ?>
            </select>
        </div>


        <div class="form-group">
        <label for="date_posted">Date Posted </label>
        <input  class="form-control" name="date_posted"  readonly class="form-control datepicker nonFutureDate past-date"  size="10" required value="<?php echo $DOB?>" placeholder="YYYY/MM/DD" id="date_posted" />
</div>


        <input name="Complain_posted" type="submit"   class="btn btn-primary  " value="Post Complain" id="savebutton"  onclick="return countyFormcheckFormsave()" />



    </form>
</div>

<script>
    $(function () {
        $('#date_posted').datepicker({ minDate: 0 });
    });
</script>

<?php  require("_includes/Footer.php"); ?>

