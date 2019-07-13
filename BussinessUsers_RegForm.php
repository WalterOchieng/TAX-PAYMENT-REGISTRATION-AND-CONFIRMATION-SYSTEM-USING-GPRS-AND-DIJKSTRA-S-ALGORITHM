<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>



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
    <form action="<?php   ?>" method="POST"    class="usersBussSignup"  enctype="multipart/form-data" name="usersBussLogin" id="" >

        <div class="form-group">
            <label for="IdNumber">ID Number</label>
            <input type="text" name="IdNumber" placeholder="Enter ID Number" id="IdNumber"  maxlength="10" onkeyup="formVal_numbers_keyup(this)"  autofocus required/>
        </div>

        <div class="form-group">
            <label for="taxAmount"> PhoneNumber</label>
            <input type="tel" name="phoneNumber" placeholder="Enter Phone Number" maxlength="15" id="phoneNumber"  required/>
        </div>

        <div class="form-group">
            <label for="cEmail"> Email Address</label>
            <input type="email" name="cEmail" placeholder="Enter Email Address" maxlength="60"  id="eEmails"  required/>
        </div>

        <div class="form-group">
            <label for="passsword"> Password</label>
            <input type="password" name="passsword" placeholder="Enter Password"  id="passwords" minlength="8" maxlength="60" requared />
        </div>

        <div class="form-group">
            <label for="confPassword"> Confirm Password</label>
            <input type="password" name="confPassword" placeholder="Confirm Password" minlength="8" id="cPasswords"  requared />
        </div>



        <input name="register" type="submit"   class="btn btn-primary  " value="Register" id="savebutton"  onclick="return countyFormcheckFormsave()" />
        <input name="refresh" type="reset" class="btn btn-primary  " value="Refresh"  />

    <br>

        Do you have an Account? If yes Click  <a href="LoginBussinessUsers.php">here</a><br>
        Forgot Password? <a href="ForgotpasswordForm.php">Yes</a>



    </form>




</div>
<script language='javascript' type='text/javascript'>

    function check(input) {
        if (input.value != document.getElementById('passsword').value) {
            input.setCustomValidity('Password Must be Matching.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }

</script>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>