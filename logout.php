<?php
session_start();
	if(!isset($_SESSION['usuario'])){	
		header("Location:index.php");
	}
	$_SESSION = array();
	session_destroy();	
	header("Location:index.php");
?>
