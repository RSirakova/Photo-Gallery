<?php
	include("indexStudent.php");
	require_once  'connection.php';

	if($_SERVER['REQUEST_METHOD']=="POST")
	{			
			
			if(isset($_POST['photographer']))
			{
			$photographer=$_POST['photographer'];
	
			
			$type=$_POST['typePhotosession'];
			$data=$_POST['data'];
			$studentId=$studentData['id'];			
			
			$stringPhotographer= explode("_", $photographer);
			
			
			$result = mysqli_query($con, "SELECT id FROM photographerinfo WHERE firstName='".$stringPhotographer[0]."' AND lastName='".$stringPhotographer[1]."'");
			$row = mysqli_fetch_array($result);	
			$query="INSERT INTO requestphotosession (studentId, photographerId,type,dateOfPhotosession,status)
											 VALUES ('$studentId','".$row['id']."', '$type','$data','в очакване')";
			
			if ($con->query($query) === TRUE) 
			{
				 echo'
				<div class="successfullRequest">
					<div class="page-header">
						<h3 style="text-align:center;">Успешно направена заявка!</h3>
					</div>
				</div>';			
				die;
			} else 
			{
				echo "Грешка при създаването на заявка!" ;	
				die;
			}	
			}
			else
			{
					echo"<h3 style='text-align:center;'>В момента няма регистрирани фотографи!</h3>";
			}
	}
						
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../CSS/styleNavBar.css">
<link rel="stylesheet" href="../CSS/style_forms.css">
<style>
	#photographer,#data,#typePhotosession{
	width: 100%;
	padding: 10px;
	border: 0;
	border-radius: 3px;
	text-transform: uppercase;
	letter-spacing: 3px;
	cursor: pointer;
	}

</style>
</head>
<body>
	<form method="post">
	<div class="wrapper">
		<div class="registration_form">
			<div class="title">
				Заявяване на фотосесия
			</div>
				<div class="form_wrap">
						
						<div  class="input_wrap">
						<label for="photographer">Фотограф</label>
						 <select  id="photographer"  name="photographer">
							<?php
							$result = mysqli_query($con, "select firstName,lastName from photographerinfo ");
							$num_images=(mysqli_num_rows($result));
							echo "HELLO";
							if($num_images===0)
							  {
								echo "<p style='text-align:center;'>Няма регистрирани фотографи!</p>";
							  }
							else{
								while ($row = mysqli_fetch_array($result)) {		
								  echo "<option value=".$row['firstName']."_".$row['lastName'].">".$row['firstName'].' '.$row['lastName']."</option>";
								}
							}
								
							?>
						 
						  </select>
						</div>
						<div class="input_wrap">
							<label for="data">Дата</label>
								<input type="date" id="data" name="data"
									min="2021-01-01" max="2022-12-31">
						</div>
						<div class="input_wrap">
							<label for="typePhotosession">Вид фотосесия</label>
						 <select id="typePhotosession"  name="typePhotosession">
							<option value="Индивидуална">Индивидуална</option>
							<option value=" Група">На група</option>
							<option value="Специалност">На специалност</option>
							<option value="Випуск">На випуск</option>
						  </select>
						</div>
						<div class="input_wrap">
							<input type="submit" name="submit_btn" value="Заяви" class="submit_btn">
						</div>					
					</div>
				
		</div>	
	</div>
</form>



</body>
</html>
