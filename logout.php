<?php
	session_start();
	unset($_SESSION["number"]);
	unset($_SESSION["name"]);
	unset($_SESSION["nof"]);
	session_destroy();
	header("location:index.php");
?>