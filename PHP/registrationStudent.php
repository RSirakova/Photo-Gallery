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
					
					$fn=$_POST['fn'];
					if(!$fn)
					{
						$errors['fn']= 'Факултетният номер е задължително поле.';			
					}
					elseif (!$fn && $fn<100000 ||((is_int($fn) ||ctype_digit($fn)) && (int)$fn > 0)) 
					{
						$valid['fn'] = $fn;
					} else 
					{
						$errors['fn']= 'Невалиден номер. Моля въведете 5-цифрено положително число.';			
						$correct=false;						
					}
					
					$specialty=$_POST['specialty'];
					$course=$_POST['course'];
					$group=$_POST['group'];
					$issue=$_POST['issue'];
					
					
					if($correct)
					{
							$query="select * from studentinfo where fn=$fn limit 1";
							$result=mysqli_query($con,$query);
								
						if($result && mysqli_num_rows($result)>0)
						{
							header("Location: ./registrationStudent.php?status=Този студент вече се е регистрирал!");
						}
						else
						{
							$query="INSERT INTO studentinfo (firstName, lastName,password,email,fn,studentSpeciality,studentCourse,studentGroup,studentIssue)
							VALUES ('$fname', '$lname', '$passwordUser','$email','$fn','$specialty','$course','$group','$issue')";
							
							if ($con->query($query) === TRUE) 
							{
								header("Location: ./registrationStudent.php?status=Успешна регистрация!");
								die;
							} else 
							{
								header("Location: ./registrationStudent.php?status=Грешка при вмъкването на данните в БД!");
								die;
							}	
						}
					}
					else
					{
							header("Location: ./registrationStudent.php?fname=".$errors['fname']."&lname=".$errors['lname']."&password=".$errors['password'].'&email='.$errors['email']."&fn=".$errors['fn']);
					}
	}
?>


<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="UTF-8">
	<title>Регистрация</title>
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
							<label for="fn">Факултетен номер</label>
							<input type="text" name="fn" id="fn">
						</div>
						<?php 	
							if(isset($_GET['fn']))
							{
								echo '
									<div class="input_wrap">
										<p class="status">'.$_GET["fn"].'</p>
									</div>
									';
							}
						?>	
					<div class="input_wrap">
						<label for="specialty">Специалност</label>
						 <select id="specialty"  name="specialty">
							<option value="КН">КН</option>
							<option value="СИ">СИ</option>
							<option value="М">М</option>
							<option value="МИ">МИ</option>
							<option value="ПМ">ПМ</option>
							<option value="ИС">ИС</option>
							<option value="И">И</option>
							<option value="С">С</option>
						  </select>
					</div>
					<div class="input_wrap">
							<label for="course">Курс</label>
						<select id="course"  name="course">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
						</select>
					</div>
						<div class="input_wrap">
						<label for="group">Група</label>
						<select id="group"  name="group">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
						</select>
					</div>
					<div class="input_wrap">
						<label for="issue">Випуск</label>
							<select id="issue"  name="issue">
							<option value="2010">2010</option>
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
							
						</select>
					</div>
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
						<div class="submit_btn"><p style="text-align:center;"> <a style="color:black;font-size:15px;text-decoration: none;" href="loginStudent.php" >Вход</a> </p> </div>
					</div>
						
					</div>
				</div>
		</div>	
		
		
	</div>

</form>


</body>
</html>

