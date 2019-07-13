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

        <input type="text" name="searchField"  id="SearchField" readonly  value="<?php echo $start?>" />
        <input name="search_table" type="submit" class="btn btn-primary " value="Search All" onclick="" />


      <!--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Edit Data
        </button>


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bussiness Edit Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
         <!-- Modal -->

        <!-- visibility:hidden; -->


        <div class="table-responsive" id="tables">
            <table class=""  style="width:90%;margin-left:3%;  border: 1px solid black;">

            <th>Bussiness Number</th>
                <th>Bussiness Name</th>
                <th>Registration Date</th>
                <th>County</th>
                <th>Location</th>
                <th>Town</th>
                <th>SubCounty</th>
                <th>District</th>
                <th>Status</th>
                <th>Description</th>
                <th>Bussiness Type</th>



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

                    $searchStmt = $conn->prepare('SELECT * FROM bussiness WHERE IdNumber=:IDNumber');
                    $searchStmt->execute(array(

                        ':IDNumber'=> $data[0]
                    ));



                    while ($row = $searchStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr><td>";
                        echo($row['bussinessCode']);
                        echo ("</td> <td>");
                        echo($row['bussinessName']);
                        echo ("</td> <td>");

                        echo($row['reg_date']);
                        echo ("</td> <td>");

                        echo($row['county']);
                        echo ("</td> <td>");
                        echo($row['location']);
                        echo ("</td> <td>");

                        echo($row['town']);
                        echo ("</td> <td>");

                        echo($row['subCounty']);
                        echo ("</td> <td>");

                        echo($row['district']);
                        echo ("</td> <td>");

                        echo($row['status']);
                        echo ("</td> <td>");

                        echo($row['description']);
                        echo ("</td> <td>");
                        echo($row['BussType']);
                        //echo ("</td> <td>");
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