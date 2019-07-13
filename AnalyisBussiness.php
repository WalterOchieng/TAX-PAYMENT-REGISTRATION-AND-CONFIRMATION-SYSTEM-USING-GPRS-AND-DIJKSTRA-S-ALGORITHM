<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/ClercksUsersDashboardLeft.php"); ?>


<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:ClercksUsersDashboardLeft.php");;

}
else
{
    // echo '<h6>USer ID: &nbsp;' .$_SESSION["username"].'</h6>';

}

$start=$_SESSION["username"];



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


    <form   action="<?php   ?>" method="POST"    class="theanalyisis"   enctype="multipart/form-data" name="clercksreplyform" id="clercksreplyform">

        <h3> Analyis Selection Criteria</h3>

        <div class="form-group">

            <label for="CountyCode"> County </label>

            <select name="countyCode"   class="form-control"  id="countyCode"   >


                <?php foreach($results as $output) {?>

                    <option> <?php echo $output["countyName"]; ?></option>

                <?php } ?>
            </select>
        </div>




        <div class="form-group">

            <label for="typestatus"> Status </label>

            <select name="typestatus"  class="form-control"   id="typestatus"   >
                <option>No Criteria</option>
                <option>Registered</option>
                <option>Terminated</option>

            </select>
        </div>


        <div class="form-group">

            <label for="taxpayment"> Tax Payment </label>

            <select name="taxpayment"  class="form-control"   id="taxpayment"   >
                <option>Paid</option>
                <option>Not Paid</option>

            </select>
        </div>


        <div class="form-group">

            <label for="penalties"> Penalities Status </label>

            <select name="penalties"  class="form-control"   id="penalities"   >
                <option>Not Selected</option>
                <option>Null</option>
                <option>Present</option>

            </select>
        </div>



        <div class="form-group">

            <label for="datefrom">Date From </label>
            <input type="date" name="datefrom"  class="form-control"  size="30"   placeholder="YYYY/MM/DD" id="date" />
        </div>


        <div class="form-group">

            <label for="datefrom">Date To </label>
            <input type="date" name="datefrom"  class="form-control"  size="30"  placeholder="YYYY/MM/DD" id="dateend" />
        </div>



        <input type="submit"  class="form-control btn btn-primary "  name="analyize" value="Analyze Data" />



        table Data
        <input type="submit"  class="form-control btn btn-primary "  name="analyize" value="Print  Data" />

    </form>

</div>

<?php  require("_includes/Footer.php"); ?>
