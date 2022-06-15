<?php
	session_start();
	include("functions.php");
	require_once  'connection.php';
	$_SESSION;
	$studentData=check_login($con);
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
		<p id="current_user"> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Здравейте, <?php echo $studentData["firstName"];echo " "; echo $studentData["lastName"]; echo "." ?>
  <li><a class="logout" href="logout.php">Изход</a></li>

  <li><a href="uploadPhoto.php">Kaчване на снимка</a></li>
  <li><a href="myPictures.php">Моите снимки</a></li>
  <li><a href="albums.php">Албуми</a></li>
  <li><a href="requestPhotosession.php">Заявяване на фотосесия</a></li>
  <li><a href="reviewMadeQueries.php">Състояния на заявките</a></li>
  <li><a href="reviewMadeOrders.php">Състояния на поръчките</a></li>

</ul>

</body>
</html>

