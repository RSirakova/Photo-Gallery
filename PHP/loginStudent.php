<?php
session_start();
	
	include("functions.php");
	
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require_once  'connection.php';
			$passwordUser=$_POST['password'];
			$fn=$_POST['fn'];
			$query="select * from studentinfo where fn=$fn limit 1";
			$result=mysqli_query($con,$query);
			if($result)
			{
				if(mysqli_num_rows($result)==1)
				{		
					$studentData=mysqli_fetch_assoc($result);						
                    if(password_verify($passwordUser, $studentData['password']))
                     {
						$_SESSION['fn']=$studentData['fn'];
						$_SESSION['id']=$studentData['id'];
						$_SESSION['firstName']=$studentData['firstName'];
						$_SESSION['lastName']=$studentData['lastName'];
						header("Location: indexStudent.php");
						die;
					 }
					else
					{	
						$password="Невалидна парола!";
					}
				}
				else
				{
					$number="Невалиден факултетен номер!";
				}
			}
			else
			{
				$inputAll="Попълнете всички полета!";
			}
		header("Location: ./loginStudent.php?password=".$password."&number=".$number."&inputAll=".$inputAll);
		die;
		
	}
	
?>


<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="UTF-8">
	<title>Вход</title>
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
							<label for="fn">ФН</label>
							<input type="text" name="fn" id="fn">
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
						<div class="submit_btn"><p style="text-align:center;"> <a style="color:black;font-size:15px;text-decoration: none;" href="registrationStudent.php" >Регистрация</a> </p> </div>
					</div>
				</div>
		</div>
	</div>
</form>

</body>
</html>

