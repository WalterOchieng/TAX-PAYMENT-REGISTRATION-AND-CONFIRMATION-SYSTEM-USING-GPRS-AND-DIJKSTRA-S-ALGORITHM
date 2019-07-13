
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/login_menuDash.php"); ?>
<?php  require(  "Connections/connection.php"); ?>

<?php
session_start();

try{

    if(isset($_POST["login"]))
    {
        if(empty($_POST["bsnUsername"])|| empty($_POST["txtPassword"]))
        {
            $message='<label> all fields are requared</label>';
        }
        else
        {

            $query="SELECT * FROM  bussness_users where IdNumber=:username and Password=:password";
            $statement=$conn->prepare($query);
            $statement->execute(
                    array(
                            ':username' =>$_POST["bsnUsername"],
                            ':password'=> $_POST["txtPassword"]

                    )
            );

            $count=$statement->rowCount();
            if ($count>0)
            {
                $_SESSION["username"]=$_POST["bsnUsername"];


                header("location:DashBoardBussinessUsers.php");

            }
            else
            {
                $message='<label> Wrong Password or Username </label>';

            }

        }
    }


}

catch(PDOException $error)

{
$message= $error->getMessage();

}

//
?>

<?php

if(isset($message))
{
    echo '<label class="text-danger">'.$message.'</label>';

}
?>


<div class="panelDisplay">

    <form action="<?php   ?>" method="POST"    class="usersBussLoginPage"  enctype="multipart/form-data" name="usersBussLogin" id="usersBussLoginPage"  >
        <h5 style="font-weight: bold">Tax Payment and Confirmation System Using GRRS and Dijkistra Algorithm </h5>
        <img class="dashboardlogo" src="icons/logo2.jpeg" alt="locator image" >

        <div class="alert-success" style="width:80%;margin:0 auto">
            Please Enter your Details to Login Here
        </div>

        <div class="form-group">
            <label for="bsnUsername">Username</label>
            <input type="text" name="bsnUsername" placeholder="Enter ID or Email" id="bsnUsername" " />
        </div>

        <div class="form-group">
            <label for="txtPassword"> Password</label>
            <input type="password" name="txtPassword" placeholder="Enter Password"  id="txtPassword" " />
        </div>



        <br />
        <input name="login" type="submit"   class="btn btn-primary  " value="Login" id="savebutton"  onclick="return countyFormcheckFormsave()" />
        <input name="refresh" type="reset" class="btn btn-primary  " value="Refresh"  />
        <br>

         You dont  have an Account? If No Click  <a href="BussinessUsers_RegForm.php">here</a><br>
        Forgot Password? <a href="ForgotpasswordForm.php">Yes</a>

    </form>
</div>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>