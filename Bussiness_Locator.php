<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
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


<style>

    #map
    {
        height: 100%;
    }
</style>




<?php

function getPosts()
{
    $posts=array();
    $posts[0]=$_POST['searchField'];


    return $posts;
}

try {
    if (isset($_POST['load'])) {

        $data = getPosts();
        //$sqlloc = "select bussinessCode from   bussiness  WHERE  IdNumber=:IDNumber";
        $searchStmt = $conn->prepare('SELECT bussinessCode FROM bussiness WHERE IdNumber=:IDNumber');
        // $stmts = $conn->prepare($sqlloc);
        $searchStmt->execute(array(

            ':IDNumber' => $data[0]





        ));

        $resultsbussinesscode = $searchStmt->fetchAll();


    }
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();

}


?>




<?php
$sqlloc="select bussinessCode from   bussiness";
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
//Php Code for Insert into the database
try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['IdNumber']) && isset($_POST['phoneNumber'])&& isset($_POST['register']) )// values checked from form attribute names
    {

        $sql = "INSERT  INTO   bussness_users(IdNumber,PhoneNumber,Email,Password)
 VALUES(:IDNumbers,:PhoneNumbers,:Emails,:Passwords)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':IDNumbers' => $_POST['IdNumber'],//pick values from forms names values and pass them to be inserted
            ':PhoneNumbers' => $_POST['phoneNumber'],
            ':Emails' => $_POST['cEmail'],
            ':Passwords' => $_POST['passsword']));
        if ($smt) {
            echo ' <span  class="alert alert-success"> You have been registered into the system...you can now loginin to access your account</span>  ';
        }
    }}
catch(PDOException $e)
{
    echo  $e->getMessage();
}
?>
<div class="paneldisplaylogins">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>

    <form action="<?php   ?>" method="POST"    class="bussiness_maper"  enctype="multipart/form-data" name="usersBussLogin">
        <input type="hidden" name="searchField"  id="SearchField" readonly  value="<?php echo $start?>"/>
        <input type="submit" style="font-size:80%"class="btn btn-primary btn-lg" name='load' value='Load Bussiness Codes'/>

        <label for="bussinessNo">Bussiness Number</label>
        <select name="locationName"   id="LocationName">

            <?php foreach($resultsbussinesscode as $outputl) {?>

                <option> <?php echo $outputl["bussinessCode"]; ?></option>

            <?php } ?>
        </select>


        <div class="form-group">

            Bussiness Name
            <input type="text" name="bussinessName" id="bussinessName"  placeholder=" Bussiness Name"  />
        </div>
        <label for="floorNo">Floor Number</label>
        <select name="floorNo"   id="floorNo"   >
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>

        </select>



        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1021334.3226614587!2d34.5251332!3d0.6167146!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d90c4e1ce6561b%3A0xc9e20e9d0f84c328!2sClacton-on-Sea%2C+UK!5e0!3m2!1sen!2ske!4v1529590715261" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>  -->


        <input name="btnLocation" type="submit"   class="btn btn-primary  " value="Save Location" id="savebutton"   />
        <input name="refresh" type="button" class="btn btn-primary  " value="Back"  />

        <br>













    </form>




</div>


<?php  require("_includes/Footer.php"); ?>

