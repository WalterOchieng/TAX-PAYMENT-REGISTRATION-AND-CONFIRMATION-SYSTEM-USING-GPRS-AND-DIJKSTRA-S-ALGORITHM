<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/login_menuDash.php"); ?>



<div class="panelDisplay">


    <form   action="<?php   ?>" method="POST"    class="servicesdashout"   enctype="multipart/form-data" name="BussinesOwner" id="BussinessOwner">


        <h1>
            B- Tax Systems

        </h1>

        <h3> What is B-Tax Systems?</h3>

        B Stand for Bussinesses Buildings Tax System.<br/>

        Its is used for;
        <ul >
            <li>Registration of Bussiness,</li>
            <li>Assingment of Bussiness Tax</li>
            <li>Mapping of Bussiness Locations</li>
            <li>Generation of Bussiness Code Identifiries using Barcode</li>
            <li> Location of Nearest Bussiness in Place to check their taxes</li>
            <li> Awarding Penalities to Various bussiness on failure to pay taxes</li>

        </ul>





    </form>
</div>



<?php  require("_includes/Footer.php"); ?>


</body>
</html>