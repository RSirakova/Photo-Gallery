<?php

	session_start();
	include("functions.php");
	require_once  'connection.php';
	
	

	if($_SERVER['REQUEST_METHOD']=="POST")
	{
			$correct=true;
				$fname = $_POST['fname'];
				
					if (!$fname) 
					{
						$errors['fname'] = 'Името е задължително поле.';
					
						
					} elseif (strlen($fname)<5 || strlen($fname) > 40)
					{
						$errors['fname'] = 'Името има дължина от 5 до 40 символа.';
					    $correct=false;
					} else 
					{
					  $valid['fname'] = $fname;
					}
				
						
				
					$lname=$_POST['lname'];
					if (!$lname) 
					{
						$errors['lname']='Фамилията е задължително поле.';
					} elseif (strlen($fname)<5 || strlen($lname) > 40) 
					{
						$errors['lname']= 'Фамилията има дължина от 5 до 40 символа.';
						$correct=false;
					} else 
					{
						$valid['lname'] = $lname;
					}
					
					$str = $_POST['password'];
                    $passwordUser=password_hash($str, PASSWORD_DEFAULT);
                    if (!$passwordUser) 
                    {
                        $errors['password']='Паролата е задължително поле.';
                        $correct=false;
                    } 
                    elseif (strlen($str)<5 || strlen($str) > 50) 
                    {
						$errors['password']='Паролата има дължина от 5 до 50 символа.';
						$correct=false;
					} 
					else
					{
					  $valid['password'] = $passwordUser;
					}
					$email=$_POST['email'];
					if (!filter_var($email, FILTER_VALIDATE_EMAIL))
					{
						$errors['email']= 'Невалиден e-mail.';
						echo "<br>";
						$correct=false;
					}
					else
					{
						$valid['email'] = $email;
					}
					$number=$_POST['number'];
					if(!$number)
					{
						$errors['number']= 'Професионалният номер е задължително поле.';			
					}
					elseif (!$number && $number<100000 ||((is_int($number) ||ctype_digit($number)) && (int)$number > 0)) 
					{
						$valid['number'] = $fnumbern;
					} else 
					{
						$errors['number']= 'Невалиден номер. Моля въведете 5-цифрено положително число.';			
						$correct=false;						
					}
					if($correct)
					{
							$query="select * from photographerinfo where professionalNumber=$number";
							
							$result=mysqli_query($con,$query);
							if($result && mysqli_num_rows($result)>0)
							{
								header("Location: ./registrationPhotographer.php?status=Този фотограф вече се е регистрирал!");
							}
							else
							{
								$query="INSERT INTO photographerinfo (firstName, lastName,password,email,professionalNumber)
								VALUES ('$fname', '$lname', '$passwordUser','$email','$number')";
								mysqli_query($con,$query);
								
								header("Location: ./registrationPhotographer.php?status=Успешна регистрация!");
								die;
							}
					}
					else
					{
							header("Location: ./registrationPhotographer.php?fname=".$errors['fname']."&lname=".$errors['lname']."&password=".$errors['password'].'&email='.$errors['email']."&number=".$errors['number']);
					}
	}
	
?>


<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="UTF-8">
	<title>Регистрация фотограф</title>
	<link rel="stylesheet" href="../CSS/styleNavBar.css">
	<link rel="stylesheet" href="../CSS/style_forms.css">
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
				Регистрация
			</div>
				<div class="form_wrap">
			
					<div class="input_grp">
						<div class="input_wrap">
							
							<label for="fname">Име</label>
							<input type="text" name="fname" id="fname">
						</div>
						<div class="input_wrap">
							<label for="lname">Фамилия</label>
							<input type="text" name="lname" id="lname">
						</div>
					</div>
						<?php 	
							if(isset($_GET['fname'])||isset($_GET['lname']))
							{
								echo '
								<div class="input_grp">
									<div class="input_wrap">
										<p class="status">'.$_GET["fname"].'</p>
									</div>
										<div class="input_wrap">
										<p class="status" >'.$_GET["lname"].'</p>
									</div>	
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
									</div>
									';
							}
						?>
					<div class="input_wrap">
						<label for="email">E-mail</label>
						<input type="text" name="email" id="email">
					</div>
						<?php 	
							if(isset($_GET['email']))
							{
								echo '
									<div class="input_wrap">
										<p class="status">'.$_GET["email"].'</p>
									</div>
									';
							}
						?>					
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
									</div>
									';
							}
						?>						
					<div class="input_wrap">
						<input type="submit" name="submit_btn" value="Регистрация" class="submit_btn">
					</div>
						<?php 	
							if(isset($_GET['status']))
							{
								echo '
									<div class="input_wrap">
										<p class="success">'.$_GET["status"].'</p>
									</div>
									';
							}
						?>		
					<div class="input_wrap">
						<div class="submit_btn"><p style="text-align:center;"> <a style="color:black;font-size:15px;text-decoration: none;" href="loginPhotographer.php" >Вход</a> </p> </div>
					</div>
						
					</div>
				</div>
		</div>	
	</div>
</form>
</body>
</html>

