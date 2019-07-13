<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboardAdmin.php"); ?>
<?php  require("_includes/AdminDashboardLeft.php"); ?>
<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:System_UsersForm.php");;

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
    $posts[1]=$_POST['userName'];
    $posts[2]=$_POST['Passwords'];
    $posts[3]=$_POST['cEmail'];

    return $posts;
}
?>


<?php
$IdNumber='';
$username='';
$password='';
$Email='';


try {

    if(isset($_POST['display'])) {
        $data = getPosts();
        if (empty($data[0])) {
            echo 'Details are not available...Contact Administrator';
        } else {
            $data = getPosts();

            $searchStmt = $conn->prepare('SELECT * FROM users WHERE userID=:IDNumber');
            $searchStmt->execute(array(

                ':IDNumber' => $data[0]
            ));


            if ($searchStmt) {
                $user = $searchStmt->fetch();

                if (empty($user)) {
                    echo 'Sorry your Details Could not be loaded.......Contact Administrator';
                }
                $IdNumber = $user[0];
                $username = $user[5];
                $password = $user[6];
                $Email=$user[8];
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


            $updateStmt = $conn->prepare('UPDATE  users SET  username=:Username,password=:Password,Email=:Emails WHERE  userID=:UserID');
            $updateStmt->execute(array(
                ':Username' => $data[1],
                ':Password' => $data[2],
                ':Emails' => $data[3]

            ));
            if ($updateStmt) {
                echo 'Your Details Are updated';
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

    <form action="<?php   ?>" method="POST"    class="clercksadminlogindetails"  enctype="multipart/form-data" name="usersBussLogin" id=""  >

        <div class="form-group">
            <label for="IdNumber">User Number</label>
            <input type="text" name="IdNumber" placeholder="Enter User  Number" id="IdNumber"  value="<?php echo $start?>" readonly maxlength="30" onkeyup="formVal_numbers_keyup(this)"  autofocus required/>
        </div>
        <div class="form-group">
            <label for="userName"> Username</label>
            <input type="text" name="userName" placeholder="Enter User Name" value="<?php echo $username?>" maxlength="30" id="userName"  />
        </div>
        <div class="form-group">
            <label for="Passwords"> Password</label>
            <input type="password" name="Passwords" placeholder="*******" value="<?php echo $password?>" maxlength="30" id="password"  />
        </div>

        <div class="form-group">
            <label for="cEmail"> Email Address</label>
            <input type="email" name="cEmail" placeholder="Enter Email Address"  id="eEmails"  maxlength="60" value="<?php echo $Email?>" />
        </div>


        <input name="display" type="submit"   class="btn btn-primary  " value="Display Data" id="display"  />
        <input name="update" type="submit"   class="btn btn-primary  " value="Save edited Data" id="edited"  />

    </form>




</div>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>