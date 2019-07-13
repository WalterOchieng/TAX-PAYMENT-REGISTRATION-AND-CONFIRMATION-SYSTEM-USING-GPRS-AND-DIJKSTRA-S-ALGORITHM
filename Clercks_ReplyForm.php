<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/menuDashboard.php"); ?>
<?php  require("_includes/ClercksUsersDashboardLeft.php"); ?>


<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:ClercksUsersDashboardLeft.php");;

}
else
{
    // echo '<h6>USer ID: &nbsp;' .$_SESSION["username"].'</h6>';

}

$start=$_SESSION["username"];



?>

<script>

    $('#exampleModal').modal({backdrop:'static',keyboard:false, show:true});

    $('#loaddata').on('submit', function() {
        $(#exampleModal).on('hide.bs.modal', function (e) {
            e.preventDefault();
        })
    });

</script>

<?php
$sqlpop="select countyName from  county";
try
{
    $stmts=$conn->prepare($sqlpop);
    $stmts->execute();
    $results=$stmts->fetchAll();
}
catch(PDOException $ex)
{
    echo "Data cannot be fetched".$ex->getMessage();
}
?>


<?php


$IDnumbers='';
$bussinesscodes='';
$complain='';
$County='';

function getData()
{
    $posts=array();

    $posts[0]=$_POST['IDNumber'];
    $posts[1]=$_POST['bussinessCode'];
    $posts[2]=$_POST['replys'];
    $posts[3]=$_POST['countyCode'];
    $posts[4]=$_POST['datefrom'];
    $posts[5]=$_POST['complain'];
    $posts[6]=$_POST['displaydata'];



    return $posts;
}

if(isset($_POST['loaddata'])) {
$data = getData();
if (empty($data[1])) {
echo 'Enter the  Bussiness Code to Search';
} else {
$searchStmt = $conn->prepare('SELECT * FROM buss_users_complanits WHERE bussinessCode=:BussinessCodes');
$searchStmt -> execute(array(
':BussinessCodes' => $data[1]
));
if ($searchStmt) {
$user = $searchStmt->fetch();

if (empty($user)) {
echo 'No Bussiness found with such  Bussiness Code';
}
$IDnumbers = $user[1];
$bussinesscodes = $user[2];
$complain=$user[3];
$County=$user[4];

}} }
?>



<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form   action="<?php   ?>" method="POST"    class="thebussinessall"   enctype="multipart/form-data" name="clercksreplyform" id="clercksreplyform">




        <!-- Modal -->
        <div class="modal show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Complaints Reply Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">




                        <div class="form-group">
                            <label for="bussinessCode">Bussiness Code:</label>
                            <input type="text" name="bussinessCode" placeholder="Bussiness Code" value="<?php echo $bussinesscodes?>" id="BussinessCode"   />
                        </div>

                        <input type="submit"  name="loaddata" onClick="stopCloses()" id="loaddata" class="btn btn-primary" value="Load Data">

                        <div class="form-group">
                            <label for="IDNumber">ID Number:</label>
                            <input type="text" name="IDNumber" placeholder="ID Number " id="IDNumber" value="<?php echo $IDnumbers?>" readonly  onkeyup="formVal_numbers_keyup(this)" />
                        </div>


                        <label for="complain">Complain:</label><br/>
                        <textarea  class="form-control" name="complain"    id="Complain" >
                              <?php echo   $complain?>

                         </textarea><br/>


                        <label for="replys">Reply:</label><br/>
                        <textarea  class="form-control" name="replys"    id="Complain" >
                         </textarea><br/>



                        <div class="form-group">

                            <label for="CountyCode"> County  </label>

                            <select class="form-control" name="countyCode"  id="countyCode"   >

                                <option>   <?php echo $County ?>    </option>

                            </select>
                        </div>



                        <div class="form-group">

                            <label for="datefrom">Date Replied </label>
                            <input type="date" name="datefrom"  class="form-control"  size="30"  placeholder="YYYY/MM/DD" value="<?php echo $DOB?>"  id="dateend" />
                        </div>









                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Reply Complain</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- visibility:hidden; -->





        <div class="form-group">

            <label for="CountyCode"> Name </label>

            <select name="countyCode"   id="countyCode"   >
                <option>--- Select County--</option>

                <?php foreach($results as $output) {?>

                    <option> <?php echo $output["countyName"]; ?></option>

                <?php } ?>
            </select>
        </div>
        <input name="search_table" type="submit" class="btn btn-primary " value="Search All" onclick="" />
        <br/>

        <br/>

        <!-- visibility:hidden; -->


        <div class="table-responsive" id="tables">
            <table class=""  style="width:90%;margin-left:3%; align:center;  border: 1px solid black;">

                <th>Complaints ID</th>
                <th>ID Number</th>
                <th>Bussiness Code</th>
                <th>Complains</th>
                <th>County Name</th>
                <th>Status Read</th>
                <th>Posted Time</th>




                <?php
                // Php Code for Search and display in table

                //START OF FUNCTION
                function getPosts()
                {
                    $posts=array();


                    $posts[0]=$_POST['countyCode'];


                    return $posts;
                }
                // END OF FUNCTION


            $compaintsID='';
                $IdNumber='';
                $bussineCode='';
                $complains='';


                if(isset($_POST['search_table'])) {

                        $data=getPosts();

                    $searchStmt = $conn->prepare('SELECT * FROM buss_users_complanits  WHERE countyName=:SearchNo and StatusRead=1 ');
                    $searchStmt->execute(array(

                        ':SearchNo' => $data[0]
                    ));




                /*if ($searchStmt) {
                    $user = $searchStmt->fetch();

                    if (empty($user)) {
                        echo 'No data found with such Code';
                    }

                    $compaintsID=$user[0];
                    $IdNumber=$user[1];
                    $bussineCode=$user[2];
                    $complains=$user[3];

                    echo $compaintsID;
                            */



                        while ($row = $searchStmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr><td>";
                            echo($row['compaintsID']);
                            echo("</td> <td>");
                            echo($row['IdNumber']);
                            echo("</td> <td>");

                            echo($row['bussinessCode']);
                            echo("</td> <td>");

                            echo($row['complains']);
                            echo("</td> <td>");
                            echo($row['countyName']);
                            echo("</td> <td>");

                            echo($row['StatusRead']);
                            echo("</td> <td>");

                            echo($row['posted_time']);
                            echo("</td> <td>");


                            echo('<button type="button"  name="loaddatas" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <a style="color: white;"href="Clercks_ReplyForm.php?displaydata=$row[\'compaintsID\']"> Edit Data</a>
                            </button>');



                            echo('</form>');
                            echo("</td> </tr>\n");


                        }

                    }


                ?>


            </table>

            <script  type="text/javascript">




                var tables= document=getElementById('tables');

                for(var i=0;1<table.rows.length;i++)
                {
                    tables.rows[i].onclick=function()
                    {
                        //rIndex=this.rowsIndex;rIndex
                        //console.log(rIndex);
                        document.getElementById("bussinessType").value=this.cells[0].innerHTML;
                        document.getElementById("taxAmount").value=this.cells[1].innerHTML;
                        document.getElementById("description").value=this.cells[2].innerHTML;



                    };
                }



            </script>
        </div>








    </form>






</div>










<?php  require("_includes/Footer.php"); ?>


</body>
</html>