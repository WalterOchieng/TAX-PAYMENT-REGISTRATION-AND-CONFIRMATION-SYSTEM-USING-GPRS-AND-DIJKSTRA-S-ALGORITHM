<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:Systems_UsersForm.php");;

}
else
{
    //  echo '<h6>Login Success,Welcome!!' .$_SESSION["username"].'</h6>';
}



?>


<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/ClercksUsersDashboardLeft.php"); ?>



<div class="panelDisplay">
    <div  style="float:top; color:green"> Welcome Home!! User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form action="<?php   ?>" method="POST"    class="dashboardcleckss"  enctype="multipart/form-data" name="BussinessTax" id="bussinessTax"  >


       <h5 style="font-weight: bold">Tax Payment and Confirmation System Using GRRS and Dijkistra Algorithm </h5>

        <img class="dashboardlogo" src="icons/logo2.jpeg" alt="locator image" >
        <h6 style="font-style: italic;" > Work towards bulding the Nation </h6>


</div>




<?php  include("_includes/Footer.php");

?>
