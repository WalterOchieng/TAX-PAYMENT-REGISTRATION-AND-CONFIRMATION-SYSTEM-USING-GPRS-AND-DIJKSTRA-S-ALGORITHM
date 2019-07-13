
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/login_menuDash.php"); ?>
<?php  require(  "Connections/connection.php"); ?>

<?php
session_start();




$previldeges='';


$username=$_POST['bsnUsername'];
$passsword=$_POST['txtPassword'];
//$query->bindParam(1, $username);
//$query->bindParam(2, $password);
try{

    if(isset($_POST["login"]))
    {
        if(empty($_POST["bsnUsername"])|| empty($_POST["txtPassword"]))
        {
            $message='<label> all fields are requared</label>';
        }
        else
        {

            $query="SELECT * FROM  users where userID=:username and password=:Password";
            $statement=$conn->prepare($query);
            $statement->execute(
                array(
                    ':username' =>$_POST["bsnUsername"],
                    ':Password'=> $_POST["txtPassword"]

                )
            );

            if ($statement) {
                $users = $statement->fetch();
            }

            $previldeges=$users[7];
            $prev1=1;
            $prev2=2;

            $count=$statement->rowCount();
            if ($count>0)
            {

                if($previldeges==$prev1)
                {
                    $_SESSION["username"]=$_POST["bsnUsername"];


                    header("location:Clercks_Dashboard.php");

                }
                elseif($previldeges==$prev2)
                {

                    $_SESSION["username"]=$_POST["bsnUsername"];


                    header("location:AdminstratorDashBoard.php");

                }



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


?>

<?php

if(isset($message))
{
    echo '<label class="text-danger">'.$message.'</label>';

}
?>


<div class="panelDisplay">
    <form action="<?php   ?>" method="POST"    class="systemusersLogin"  enctype="multipart/form-data" name="usersBussLogin" id="usersBussLoginPage"  >
        <h5 style="font-weight: bold">Tax Payment and Confirmation System Using GRRS and Dijkistra Algorithm </h5>
        <img class="dashboardlogo" src="icons/logo2.jpeg" alt="locator image" >

        <div class="alert-heading" style="width:80%;margin:0 auto">
            Please Enter your Details to Login Here
        </div>

        <div class="form-group">
            <label for="bsnUsername">Username</label>
            <input type="text" name="bsnUsername"  required placeholder="Enter User ID" id="bsnUsername"  />
        </div>

        <div class="form-group">
            <label for="txtPassword"> Password</label>
            <input type="password" name="txtPassword"  required placeholder="Enter Password"  id="txtPassword"  />
        </div>



        <br />
        <input name="login" type="submit"   class="btn btn-primary  " value="Login" id="savebutton"   />
        <input name="refresh" type="reset" class="btn btn-primary  " value="Refresh"  />
        <br>

        Forgot Password? <a href="Forgotpassword_Users.php">Yes</a>

    </form>
</div>

<?php  require("_includes/Footer.php"); ?>

