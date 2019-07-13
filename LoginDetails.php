<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/Buss_usersmenuDashboard.php"); ?>
<?php  require("_includes/BussinessUsersDashboardLeft.php"); ?>
<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:LoginBussinessUsers.php");;

}
else
{
   // echo '<h6>USer ID: &nbsp;' .$_SESSION["username"].'</h6>';

}

$start=$_SESSION["username"];



?>
<?php
function getPosts()
{
    $posts=array();
    $posts[0]=$_POST['IdNumber'];
    $posts[1]=$_POST['phoneNumber'];
    $posts[2]=$_POST['cEmail'];
    $posts[3]=$_POST['passsword'];

    return $posts;
}
?>


<?php
$IdNumber='';
$phoneNumber='';
$Email='';
$Password='';


try {

        if(isset($_POST['display'])) {
            $data = getPosts();
            if (empty($data[0])) {
                echo 'Details are not available...Contact Administrator';
            } else {
                $data = getPosts();

                $searchStmt = $conn->prepare('SELECT * FROM bussness_users WHERE IdNumber=:IDNumber');
                $searchStmt->execute(array(

                    ':IDNumber' => $data[0]
                ));


                if ($searchStmt) {
                    $user = $searchStmt->fetch();

                    if (empty($user)) {
                        echo 'Sorry your Details Could not be loaded.......Contact Administrator';
                    }
                    $phoneNumber = $user[1];
                    $Email = $user[2];
                    $Password = $user[3];

                }
            }
        }

}
catch (PDOException $ex)
{
    echo $ex;
}

?>



<?php






if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1]) ||  empty($data[2])   || empty($data[3])   ) {
        echo 'Enter the User Data to Update';

    }


    else {
        try
        {


        $updateStmt = $conn->prepare('UPDATE  bussness_users SET  IdNumber=:IDNumber,PhoneNumber=:PhoneNumber,Email=:Emails,Password=:Passwords WHERE  IdNumber=:IDNumber');
        $updateStmt->execute(array(
            ':IDNumber' => $data[0],
            ':PhoneNumber' => $data[1],
            ':Emails' => $data[2],
            ':Passwords' => $data[3]
        ));
        if ($updateStmt) {
            echo 'Data updated';
        }
    }
    catch (PDOException $ex)
    {
        echo $ex;

    }
    }

}
?>


<div class="paneldisplaylogins">

    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?>  </div>

    <form action="<?php   ?>" method="POST"    class="loginDetails"  enctype="multipart/form-data" name="usersBussLogin" id=""  >

        <div class="form-group">
            <label for="IdNumber">ID Number</label>
            <input type="text" name="IdNumber" placeholder="Enter ID Number" id="IdNumber" value="<?php echo $start?>" readonly maxlength="15" onkeyup="formVal_numbers_keyup(this)"  autofocus required/>
        </div>
        <div class="form-group">
            <label for="taxAmount"> PhoneNumber</label>
            <input type="tel" name="phoneNumber" placeholder="Enter Phone Number" value="<?php echo $phoneNumber?>" id="phoneNumber"  />
        </div>
        <div class="form-group">
            <label for="cEmail"> Email Address</label>
            <input type="email" name="cEmail" placeholder="Enter Email Address"  id="eEmails"  value="<?php echo $Email?>" />
        </div>
        <div class="form-group">
            <label for="passsword"> Password</label>
            <input type="password" name="passsword" placeholder="Enter Password"  id="passwords" value="<?php echo $Password?>" requared />
        </div>

        <input name="display" type="submit"   class="btn btn-primary  " value="Display Data" id="display"  />
        <input name="update" type="submit"   class="btn btn-primary  " value="Save edited Data" id="edited"  onclick="return login_details()" />

    </form>




</div>
<script>
    function login_details()
    {
        var phoneNumber = document.getElementById('phoneNumber').value;
        var emailed= document.getElementById('eEmails').value;
         var passwordse= document.getElementById('passwords').value;
        if(phoneNumber==""||emailed==""||passwordse=="")
        {
            alert('Please fill All the fields');
            return false;
        }
        else
        {        return true;
        }

    }

</script>

<?php  require("_includes/Footer.php"); ?>

