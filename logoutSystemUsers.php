<?php
session_start();
session_destroy();


header("Location: Systems_UsersForm.php");

?>


echo '<a href="logout.php">Logout</a>';
