<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/BussinessUsersDashboardLeft.php"); ?>




<div class="paneldisplaylogins">
    <form action="<?php   ?>" method="POST"    class="personaldetails"  enctype="multipart/form-data" name="usersBussLogin" id=""  >

        <div class="form-group">
            <label for="IdNumber">ID Number</label>
            <input type="text" name="IdNumber" placeholder="Enter ID Number" id="IdNumber" readonly maxlength="15" onkeyup="formVal_numbers_keyup(this)"  autofocus required/>
        </div>

        <div class="form-group">
            <label for="taxAmount"> PhoneNumber</label>
            <input type="tel" name="phoneNumber" placeholder="Enter Phone Number"  id="phoneNumber"  required/>
        </div>

        <div class="form-group">
            <label for="cEmail"> Email Address</label>
            <input type="email" name="cEmail" placeholder="Enter Email Address"  id="eEmails"  required/>
        </div>

        <div class="form-group">
            <label for="passsword"> Password</label>
            <input type="password" name="passsword" placeholder="Enter Password"  id="passwords"  requared />
        </div>




        <input name="edit" type="submit"   class="btn btn-primary  " value="Edit" id="savebutton"  />





    </form>




</div>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>