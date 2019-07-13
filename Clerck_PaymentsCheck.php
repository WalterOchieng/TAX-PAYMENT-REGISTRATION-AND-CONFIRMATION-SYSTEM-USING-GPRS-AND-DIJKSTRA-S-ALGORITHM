<?php  require(  "Connections/connection.php"); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/ClercksUsersDashboardLeft.php"); ?>



<?php
session_start();

if(!isset($_SESSION["username"]))
{
    header("location:Systems_UsersForm.php");;

}
else
{
    //echo '<h6>Login Success,Welcome!!' .$_SESSION["username"].'</h6>';
}

$start=$_SESSION["username"];

?>



<?php
// Php Code for Search
function getPosts()
{
    $posts=array();

    $posts[0]=$_POST['paymentCode'];
    $posts[1]=$_POST['bussCode'];
    $posts[2]=$_POST['amounts'];
    $posts[3]=$_POST['paymenttype'];


    return $posts;
}

?>




<?php
//Php Code for Insert into the database
try
{


    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['paymentCode']) && isset($_POST['bussCode'])&& isset($_POST['save']) )// values checked from form attribute names
    {
        $data = getPosts();

        if (empty($data[0]) || empty($data[1]) ||  empty($data[2])  ||  empty($data[3]) ) {
            echo 'Enter All Data to save ';


        }
        else {


            $sql = "INSERT  INTO  payments(paymentCode,bussinessCode,amount,paymentName) VALUES(:PaymentCode,:BussinessCode,:Amount,:PaymentName)";
            //values can be any figure, to be inserted are in database

            $smt = $conn->prepare($sql);
            $smt->execute(array(
                ':PaymentCode' => $_POST['paymentCode'],//pick values from forms names values and pass them to be inserted
                ':BussinessCode' => $_POST['bussCode'],
                ':Amount' => $_POST['amounts'],
                ':PaymentName' => $_POST['paymenttype']


            ));
            if ($smt) {
                echo 'Data has been Inserted';
            }







        }
    } }
catch(PDOException $e)
{
    echo  $e->getMessage();
}
?>
















<div class="panelDisplay">

    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form action="<?php   ?>" method="POST"    class="paymentchecks"  enctype="multipart/form-data" name="BussinessTax" id="bussinessTax"  >
        <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $start?>" />

        <div class="form-group">
            <label for="paymentCode">Payment Code</label>
            <input type="text" name="paymentCode" placeholder="Payment Code" id="PaymentCode"    />
        </div>


        <div class="form-group">

            <label for="bussCode"> Bussiness Code</label>
            <input type="text" name="bussCode" placeholder="Bussiness Code"  id="bussCode"   />
        </div>


        <div class="form-group">

            <label for="amounts"> Amount Paid </label>
            <input type="text" name="amounts" placeholder="Amount Paid"  id="amounts" />
        </div>



        <div class="form-group">

            <label for="paymenttype"> Payment Type </label>
            <select name="paymenttype" id="town">
               <option> M-PESA</option>
                <option>T-KaSh</option>
                <option>Airtel Money</option>

            </select>

        </div>



        <input type="hidden" name="satusfield"  id="StatusField"  value="<?php echo $status?>" />



        <input name="save" type="submit" class="btn btn-primary " value="Make Payment" onclick="return checkpayments()" />




    </form>
</div>


<script>

    function checkpayments()
    {
        var paymentcode = document.getElementById('paymentCode').value;
        var bussicodes= document.getElementById('bussCode').value;
        var amounts= document.getElementById('amounts').value;


        if(paymentcode=="" ||bussicodes=="" ||amounts=="")
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

</body>
</html>