<?php
session_start();
$username=$_SESSION['user'];
$password= $_SESSION['pwd'];
$Stype=$_SESSION['tp'];
//echo $username;

?>
<?php
//include("sessionHandler.php");
include("headerp.php");
include("config.php");

$selectofficer = "select policestation from officer where name= '$username'";
$result= mysql_query($selectofficer) or die(mysql_error());
$record = mysql_fetch_array($result);
$police=$record["policestation"];
//echo $username;
//echo $police;
$selectAllUserQuery = "select *from crime where policestation ='$police'";
$resultSet = mysql_query($selectAllUserQuery) or die(mysql_error());
?>
<style type="text/css">
    <!--
    @import url("css/template.css");
    .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
    .style4 {font-size: 14px}
    .style5 {
        font-size: 18px;
        font-weight: bold;
    }
    -->
</style>
<script type="text/javascript">
    function PrintDiv(id) {
        var data=document.getElementById(id).innerHTML;
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title>Crime Solution</title>');
        /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');
        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload=function(){ // necessary if the div contain images

            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
    }
</script>
<div id="content">
    <div class="clear">
        <!--right-->
        <!--left-->

        <div id="container" class="wrapper-container">
            <div class="corner-top-left">
                <div class="corner-top-right">
                    <div class="corner-bottom-left">
                        <div class="corner-bottom-right">

                            <div id="print"></strong>
                                </p>
                                <table width="99%">
                                    <tr>
                                        <th height="36" colspan="8" align="left" class="first"><span class="rowBorder">&nbsp;<span class="highlight">Thanks Officer <?php echo $username;?>, here are all Reported Crimes in <?php echo $police;?> station </span></span></th>
                                    </tr>
                                    <tr>
                                        <td colspan="7"></td>
                                    </tr>

                                    <tr>
                                        <td width="3" height="23"><span class="style4 tableHeading style2">&nbsp;crime No. </span></td>
                                        <td width="10" align="center">Date Reported</td>
                                        <td width="10"align="">City</td>
                                        <td width="10"align="">Area</td>
                                        <td width="10"align="">Mobile Number</td>
                                        <td width="10"align="">Crime</td>
                                        <td width="20"align="">Brief Description</td>
                                        <td width="10"align="">Id Proof</td>
                                        <td width="10"align="">Id NO.</td>
                                        <td width="7"align="">Status</td>


                                    </tr>
                                    <?php
                                    $i=1;
                                    while($record = mysql_fetch_array($resultSet))
                                    {
                                        ?>

                                        <tr>
                                            <td align="left"><?php echo $i++; ?></td>
                                            <td><?php echo $record["date"];?></td>
                                            <td><?php echo $record["city"];?></td>
                                            <td><?php echo $record["area"];?></td>
                                            <td><?php echo $record["number"];?></td>
                                            <td><?php echo $record["crime"];?></td>
                                            <td><?php echo $record["description"];?></td>
                                            <td><?php echo $record["idproof"];?></td>
                                            <td><?php echo $record["idno"];?></td>
                                            <td><?php echo $record["status"];?></td>


                                        </tr>
                                        <tr>
                                            <td colspan="7"></td>
                                        </tr>

                                        <?php
                                    }
                                    ?>
                                </table>
                                <form id="form7" align="right" >

                                    <button onclick="PrintDiv('print')">Print Record </button>

                                </form>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("footer.php");?>
    </div>
</div>
</p>