<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/ClercksUsersDashboardLeft.php"); ?>

<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:LoginBussinessUsers.php");;

}


$start=$_SESSION["username"];

?>



<div style="text-align:center">

    <div class="panelDisplay">

        <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
        <h4> Welcome to B-Tax System </h4>
        <br/>


        <h5> The System Dashboard is accessed using the Left Menu which provides various facilities like.<br/>
            <ul>
                <ol>  Checking Personal Details</ol>
                <ol>  Register Your Bussiness</ol>
                <ol>  Generate Bar code</ol>
                <ol>  Locate Nearest Bussiness</ol>
                <ol> Increasing Penalities</ol>
                <ol>  Making Penalities</ol>
                <ol> Reply Complaints</ol>
                <ol>Payment Logs</ol>
                <ol>  Analyze Business</ol>
            </ul>

            <img src="icons/ClerckSubmenu.png" height="30%" width="30%"/> <br/>

        </h5>

        <h4><b> The Checking personal Details subMenu</b></h4>

        This Facility is used to check the users personal Details he/ she used to register with in the system<br/>


        You can load your data by Clicking the Search Button and Decide to update the details by clicking the update button<br/>
        below the Form





        The Screen for personal details  is as follows<br/>


        <img src="help_images/bussinuserpersonal.png" height="30%" width="30%"/>
        <br/>


        <h4><b> The Register Bussiness subMenu</b></h4>

        This Facility is used  Register a new Bussiness or CHange details of your Bussiness that you have registered <br/>


        You Can fill the relevant details that is need within the system  like Bussiness Number, Name,county<br/>
        ,location,sub county,Description , bussiness type





        The Screen for Register Bussiness   is as follows<br/>



        <img src="help_images/registerbuss.png" height="30%" width="30%"/>
        <br/>









        <h4><b> The Barcode Generator Submenu</b></h4>

        This Facility is used  Facility is used to Generate Barcode used to be placed in the front of Bussiness Premises
        <br/>
        First you load the busssiness to check all your bussiness that are registered by Clicking load Bussiness Data<br/>
        The second you load the barcode data that can be used to generate the barcode by clicking load Barcode Data<br/>
        Lastly you generate the barcode by clicking submit button then click print to print your barcode.<br/>





        The Screen for Barcode generator   is as follows<br/>



        <img src="help_images/barcodegen1.png" height="30%" width="30%"/>
        <br/>
        <img src="help_images/barcodegen2.png" height="30%" width="30%"/>
        <br/>



        <h4><b> The Increase Penalities  Submenu</b></h4>

        This Facility is used  Increase  Bussiness Penalities that exist
        <br/>
        you  can then print the data if you fill so for filling.


        The Screen for  Increase Penalities for Bussiness   is as follows<br/>



        <img src="help_images/IncreasePenality.png" height="30%" width="30%"/>



        <h4><b> The Make Payments Submenu</b></h4>

        his Facility is used  by the Clerck to Make Payments for bussiness that have paid <br/>




        The Screen for Make Payments    is as follows<br/>



        <img src="help_images/Makepayments.png" height="30%" width="30%"/>

        <h4><b> The Reply Complaints   Submenu</b></h4>

        This Facility is used  by the Clerck to Reply complaints by bussiness  users that have make complaints  <br/>




        The Screen for Make Payments    is as follows<br/>



        <img src="help_images/M.png" height="30%" width="30%"/>


        <img src="help_images/Makepayments.png" height="30%" width="30%"/>

        <h4><b> The Payment Logs    Submenu</b></h4>

        This Facility is used  by the Clerck to check Payment Logs  of Bussiness  <br/>




        The Screen for Make Payments    is as follows<br/>



        <img src="help_images/PaymenLogs.png" height="30%" width="30%"/>


        <h4><b> Login Details   Submenu</b></h4>

        This Facility is used  by the Clerck to check their Login Details  <br/>




        The Screen for Login Details   is as follows<br/>



        <img src="help_images/LoginDetails.png" height="30%" width="30%"/>


    </div>

    <?php  require("_includes/Footer.php"); ?>

