<?php
session_start();
session_destroy();


header("Location: LoginBussinessUsers.php");

?>


echo '<a href="logout.php">Logout</a>';
