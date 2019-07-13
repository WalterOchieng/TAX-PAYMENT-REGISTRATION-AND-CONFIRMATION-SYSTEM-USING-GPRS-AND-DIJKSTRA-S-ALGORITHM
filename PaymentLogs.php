<?php require('Connections/connection.php'); ?>
<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/Buss_usersmenuDashboard.php"); ?>
<?php  require("_includes/BussinessUsersDashboardLeft.php"); ?>


<?php
session_start();


if(!isset($_SESSION["username"]))
{
    header("location:LoginBussinessUsers.php");;

}


$start=$_SESSION["username"];

?>






<div class="panelDisplay">
    <div  style="float:top; color:green">  User ID: <?php echo  $start=$_SESSION["username"]; ?> </div>
    <form   action="<?php   ?>" method="POST"    class="thebussinessall"   enctype="multipart/form-data" name="bussinessall" id="bussinessall">


        <label> Type Bussiness Code to Display Logs</label>
        <input type="text" name="searchField"  id="SearchField"  />
        <input name="search_table" type="submit" class="btn btn-primary " value="Search All" onclick="" />



        <button type="submit" formaction="ReportPaymentLogs.php" >Generate Report</button>




        <div class="table-responsive" id="tables">
            <table class=""  style="width:90%;margin-left:3%;  border: 1px solid black;">

                <th>Payment Code</th>
                <th>Bussiness Code</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Payment Name</th>




                <?php
                // Php Code for Search and display in table

                //START OF FUNCTION
                function getPosts()
                {
                    $posts=array();


                    $posts[0]=$_POST['searchField'];

                    return $posts;
                }
                // END OF FUNCTION




                if(isset($_POST['search_table'])) {

                    $data = getPosts();

                    $searchStmt = $conn->prepare('SELECT * FROM payments WHERE bussinessCode=:IDNumber');
                    $searchStmt->execute(array(

                        ':IDNumber'=> $data[0]
                    ));



                    while ($row = $searchStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr><td>";
                        echo($row['paymentCode']);
                        echo ("</td> <td>");
                        echo($row['bussinessCode']);
                        echo ("</td> <td>");

                        echo($row['amount']);
                        echo ("</td> <td>");

                        echo($row['date']);
                        echo ("</td> <td>");
                        echo($row['paymentName']);
                        echo ("</td> <td>");


                        //echo('<form method="post">');
                        //echo('<input type="submit" value="select" name="populate_data"');
                        // echo('</form>');
                        echo ("</td> </tr>\n");


                    }

                }

                ?>


            </table>

            <script>
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