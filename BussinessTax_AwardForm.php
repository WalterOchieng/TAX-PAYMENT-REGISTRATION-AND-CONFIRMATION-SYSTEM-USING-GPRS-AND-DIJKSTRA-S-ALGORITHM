<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboardAdmin.php"); ?>
<?php  require("_includes/AdminDashboardLeft.php"); ?>

<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:Systems_UsersForm.php");;

}
else
{

}


$start=$_SESSION["username"];

?>


<?php
//Php Code for Insert into the database


try
{
    // PHP code for inserting into the database : Written By Walter O. Ochieng
    if( isset($_POST['bussinessType']) && isset($_POST['taxAmount'])&& isset($_POST['save']) )// values checked from form attribute names
    {

        $sql = "INSERT  INTO  bussiness_tax_award(BussType,Description,Taxamount) VALUES(:BussinessType,:Description,:taxamount)";
        //values can be any figure, to be inserted are in database

        $smt = $conn->prepare($sql);
        $smt->execute(array(
            ':BussinessType' => $_POST['bussinessType'],//pick values from forms names values and pass them to be inserted
            ':Description' => $_POST['descriptions'],
            ':taxamount' => $_POST['taxAmount']));
        if ($smt) {
            echo 'Data has been Inserted';
        }
    }}
catch(PDOException $e)
{
    echo  $e->getMessage();
}
?>

<?php
//START OF FUNCTION
function getPosts()
{
    $posts=array();

    $posts[0]=$_POST['bussinessType'];
    $posts[1]=$_POST['descriptions'];
    $posts[2]=$_POST['taxAmount'];
    $posts[3]=$_POST['searchField'];


    return $posts;
}
// END OF FUNCTION

if(isset($_POST['update'])) {

    $data = getPosts();

    if (empty($data[0]) || empty($data[1]) ||  empty($data[2])   ) {
        echo 'Enter the User Data to Update';

    }
    elseif (empty($data[3]))
    {
        echo 'Please  Search for Busssiness Type to be updated or the Bussiness Type you have selected does not exist!!';
    }



    else {
        $updateStmt = $conn->prepare('UPDATE bussiness_tax_award SET  BussType=:BussinessType,Description=:Descriptions,Taxamount=:Taxamount WHERE  BussType=:searchField');
        $updateStmt->execute(array(
            ':BussinessType' => $data[0],
            ':Descriptions' => $data[1],
            ':Taxamount' => $data[2],
            ':searchField' => $data[3]
        ));
        if ($updateStmt) {
            echo 'Data updated';
        }
    }
}
// END OF UPDATE STATEMENT

?>


<?php
// Php Code for Search

$BussinessType='';
$Descriptions='';
$Taxamount='';



if(isset($_POST['search'])) {
    $data = getPosts();
    if (empty($data[0])) {
        echo 'Enter Bussiness Type to Search';
    } else {
        $searchStmt = $conn->prepare('SELECT * FROM bussiness_tax_award WHERE BussType=:BussinessType');
        $searchStmt -> execute(array(
            ':BussinessType' => $data[0]
        ));
        if ($searchStmt) {
            $user = $searchStmt->fetch();

            if (empty($user)) {
                echo 'No   Bussiness type of a such';
            }
            $BussinessType = $user[1];
            $Descriptions = $user[2];
            $Taxamount=$user[3];

        }} }
?>


<?php
//PHP  CODE TO DELETE DATA, WRITTEN BY WALTER O.
if(isset($_POST['delete']))
{

    $data = getPosts();

    if (empty($data[0])) {
        echo 'Type the Bussiness Type to Delete';

    } else {
        $deleteStmt = $conn->prepare('DELETE FROM  bussiness_tax_award  WHERE BussType=:BussinessType' );
        $deleteStmt->execute(array(
            ':BussinessType' => $data[0]

        ));
        if ($deleteStmt) {
            echo 'Data Deleted';
        }
    }
}

?>







<div class="panelDisplay">

    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?>  </div>
    <form   action="<?php   ?>" method="POST"    class="bussinessTaxawardform"   enctype="multipart/form-data" name="countyForms" id="countyForm">

        <div class="form-group">
            <label for="bussinessType">Bussiness Type</label>
            <input type="text" name="bussinessType" id="bussinessType"    value="<?php echo $BussinessType?>"  " />
        </div>

        <div class="form-group">

            <label for="taxAmount">Tax Amount</label>
            <input type="text" name="taxAmount" id="taxAmount"  value="<?php echo $Taxamount?>"  />
        </div>

            <label for="descriptions">Description</label><br/>
            <textarea  class="form-control" name="descriptions"    id="description" >

            <?php echo $Descriptions ?>

        </textarea><br/>

            <input type="hidden" name="searchField"  id="SearchField"  value="<?php echo $BussinessType?>" />
            <br />
            <input name="save" type="submit"   class="btn btn-primary  " value="Save" id="savebutton"   />
            <input name="update" type="submit" class="btn btn-primary  " value="Update"  />
            <input name="search" type="submit" class="btn btn-primary " value="Search" onclick="" />
            <input name="refresh" type="reset" class="btn btn-primary "  value="Refresh" onclick="" />

        <input name="delete" type="submit"  class="btn btn-primary " value="Delete" onclick="" />
        <input name="search_table" type="submit" class="btn btn-primary " value="Search All" onclick="" />
        <br/>

        <br/>

        <!-- visibility:hidden; -->

        
        <div class="table-responsive" id="tables">
        <table class=""  style="width:90%;margin-left:3%; align:center;  border: 1px solid black;">


            <?php
            // Php Code for Search and display in table

            if(isset($_POST['search_table'])) {

                $searchStmt = $conn->prepare('SELECT * FROM bussiness_tax_award ');
                $searchStmt->execute(array());



                while ($row = $searchStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>";
                    echo($row['BussType']);
                    echo ("</td> <td>");
                    echo($row['Description']);
                    echo ("</td> <td>");
                    echo($row['Taxamount']);
                   // echo ("</td> <td>");
                    //echo('<form method="post">');
                    //echo('<input type="submit" value="select" name="populate_data"');
                   // echo('</form>');
                    echo ("</td> </tr>\n");


                }

            }

            ?>


        </table>

            <script type="text/javascript">
                var tables= document=getElementById('tables');

                for(var i=0;1<table.rows.length;i++)
                {
                    tables.rows[i].onclick=function()
                    {
                        //rIndex=this.rowsIndex;rIndex
                        //console.log(rIndex);
                        document.getElementById("bussinessType").value=this.cells[0].innerHTML;
                        document.getElementById("taxAmount").value=this.cells[1].innerHTML;
                        document.getElementById("descriptions").value=this.cells[2].innerHTML;



                    };
                }
            </script>
        </div>

    </form>






</div>










<?php  require("_includes/Footer.php"); ?>


</body>
</html>