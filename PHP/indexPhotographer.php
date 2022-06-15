<?php
	session_start();
	include("functions.php");
	require_once  'connection.php';
	$_SESSION;
	$photographerData=check_login_photographer($con);
?>

<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Начална страница</title>
	<link rel="stylesheet" href="../CSS/style_forms.css">
	<link rel="stylesheet" href="../CSS/styleNavBar.css">	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<style>
		#current_user
	{
		float:left;
		padding: 20px 16px;
		color: white;
	}
	</style>
</head>
<body>
	<ul class="topnav">
		<p id='current_user'><i class="fa fa-camera-retro fa-lg"></i> Здравейте, <?php echo $photographerData["firstName"];echo " "; echo $photographerData["lastName"]; echo "." ?>
		  <li><a class="logout" href="logout.php">Изход</a></li>
		  <li><a href="reviewQueries.php">Преглед на заявките</a></li>
		  <li><a href="reviewOrders.php">Преглед на поръчките</a></li>
	</ul>
</body>
</html>

