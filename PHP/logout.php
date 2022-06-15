<?php
session_start();
if(isset($_SESSION['fn']))
{
	unset($_SESSION['fn']);
	unset($_SESSION['firstName']);
	unset($_SESSION['lastName']);
}


if(isset($_SESSION['professionalNumber']))
{
	unset($_SESSION['professionalNumber']);
	unset($_SESSION['firstName']);
	unset($_SESSION['lastName']);
}
header("Location: index.php");
die;
?>