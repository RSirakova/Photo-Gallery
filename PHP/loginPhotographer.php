<?php
session_start();
	
	include("functions.php");
	require_once  'connection.php';
	
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
			$correct=true;
			$passwordUser=$_POST['password'];
			$number=$_POST['number'];
				
			
			$query="select * from photographerinfo where professionalNumber=$number limit 1";
			$result=mysqli_query($con,$query);
				
			if($result)
			{
				if($result && mysqli_num_rows($result)>0)
				{
						$photographerData=mysqli_fetch_assoc($result);
					if(password_verify($passwordUser, $photographerData['password']))
					{
						$_SESSION['professionalNumber']=$photographerData['professionalNumber'];
						$_SESSION['firstName']=$photographerData['firstName'];
						$_SESSION['lastName']=$photographerData['lastName'];
						header("Location: indexPhotographer.php");
						die;
					}
					else
					{
						$password="Невалидна парола!";
					}
				}
				else
				{
					$numberMsg="Невалиден професионален номер!";
				}
			}
			else
			{
				$inputAll="Попълнете всички полета!";
			}
		header("Location: ./loginPhotographer.php?password=".$password."&number=".$numberMsg."&inputAll=".$inputAll);
		die;
	}
	
?>


<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="UTF-8">
	<title>Вход фотограф</title>
	<link rel="stylesheet" href="../CSS/style_forms.css">
	<link rel="stylesheet" href="../CSS/styleNavBar.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<body>
	<ul class="topnav">
		<li id='indexPage'><a  href="index.php">Начало <i class="fa fa-home" aria-hidden="true"></i></a></li>
	</ul>
	
<form method="post">
	<div class="wrapper">
		<div class="registration_form">
			<div class="title">
				Вход
			</div>
				<div class="form_wrap">
					<div class="input_wrap">
					
						<div class="input_wrap">
							<label for="number">Професионален номер</label>
							<input type="text" name="number" id="number">
						</div>
							<?php 	
							if(isset($_GET['number']))
							{
								echo '
									<div class="input_wrap">
										<p class="status">'.$_GET["number"].'</p>
									</div>';
							}
							?>
					</div>
					<div class="input_wrap">
						<label for="password">Парола</label>
						<input type="password" name="password" id="password">
					</div>
						<?php 	
							if(isset($_GET['password']))
							{
								echo '
									<div class="input_wrap">
										<p class="status">'.$_GET["password"].'</p>
									</div>';
							}
						?>
					
					<div class="input_wrap">
						<input type="submit" name="submit_btn" value="Вход" class="submit_btn">
					</div>
						<?php 	
							if(isset($_GET['inputAll']))
							{
								echo '
									<div class="input_wrap">
										<p class="status">'.$_GET["inputAll"].'</p>
									</div>';
							}
							?>
					<div class="input_wrap">
						<div class="submit_btn"><p style="text-align:center;"> <a style="color:black;font-size:15px;text-decoration: none;" href="registrationPhotographer.php" >Регистрация</a> </p> </div>
					</div>
				</div>
		</div>
	</div>
	<a href="registrationStudent.php">Регистрация</a>
</form>

</body>
</html>

