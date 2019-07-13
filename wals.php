<?php require_once('Connections/MyConnection.php'); ?>

<?php require("_includes/Header.php");
/**
 * Created by PhpStorm.
 * User: Walter
 * Date: 3/12/2018
 * Time: 12:42 PM
 */



?>



<div class="divforms">

    <form  name="LoginForm" id="foms"  method="POST">

        <div class="fc ">
            <br>
            <br>
            <label for="username">Username:</label>
            <input type="text" name="username">

            <label for="name">Password:</label>
            <input type="text" name="password"><br>
            <input class="signinbutton"type="button" name="Reset" value="Reset Password">
            <input type="submit" name="Login" value="Login"><br>

        </div>
    </form>

</div>


</br>
</br>


<?php require("_includes/Footer.php");?>

