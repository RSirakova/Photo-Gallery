<?php
	include("indexStudent.php");
	require_once  'connection.php';
	if(isset($_GET['imageId']))
	{
		if($_SERVER['REQUEST_METHOD']=="POST")
		{	
	
			if(isset($_POST['photographer']))
			{
			$photographer=$_POST['photographer'];
			
				$correct=true;	
				$photographer=$_POST['photographer'];
				$souvenir=$_POST['typeSouvenir'];
				$data=$GLOBALS['d'];
				$amount=$_POST['amount'];
				$studentId=$studentData['id'];			
				$imageId=$_GET['imageId'];
				if($correct==TRUE)
				{	

					$stringPhotographer= explode("_", $photographer);
					$result = mysqli_query($con, "SELECT id FROM photographerinfo WHERE firstName='".$stringPhotographer[0]."' AND lastName='".$stringPhotographer[1]."'");
					$row = mysqli_fetch_array($result);	
					$query="INSERT INTO orderSouvenirs (studentId,idImage ,photographerId,souvenir,dateOfOrder,status,amount)
													 VALUES ('$studentId',".$imageId.",'".$row['id']."', '$souvenir','$data','в очакване',$amount)";
			
					if ($con->query($query) === TRUE) 
					{
						header("Location: ./orderSouvenirs.php?status=Успешно напревена поръчка!");
						die;				
						
					} else 
					{
						header("Location: ./orderSouvenirs.php?status=Възникна грешка при създаването на поръчка!");
						die;						
					}	
				}	
			}
			else
			{
						header("Location: ./orderSouvenirs.php?status=В момента няма регистрирани фотографи!");
						die;		
			}
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
	#photographer,#data,#typeSouvenir{
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
	<?php 	
		if(isset($_GET['status']))
		{
			echo '
			<h3 class="status" style="text-align:center;">'.$_GET["status"].'</h3>';
		}
	?>
	<form method="post">
	<div class="wrapper">
		<div class="registration_form">
			<div class="title">
				Поръчка на сувенири
			</div>
				<div class="form_wrap">
						
						<div  class="input_wrap">
						<label for="photographer">Фотограф</label>
						 <select  id="photographer"  name="photographer">
							<?php
							$result = mysqli_query($con, "select firstName,lastName from photographerinfo ");
							$num_images=(mysqli_num_rows($result));
							if($num_images===0)
							  {
								header("Location: ./orderSouvenirs.php?status=Няма регистрирани фотографи!");
								die;
							  }
							  else
							  {
								while ($row = mysqli_fetch_array($result)) {		
								  echo "<option value=".$row['firstName']."_".$row['lastName'].">".$row['firstName'].' '.$row['lastName']."</option>";
								}
								
							  }
								
							?>
						 
						  </select>
						</div>
						<div class="input_wrap">
							<label for="typeSouvenir">Вид сувенир</label>
						 <select id="typeSouvenir"  name="typeSouvenir">
							<option value="Картичка">Картичка</option>
							<option value=" Чаша">Чаша</option>
							<option value="Календар">Календар</option>
							<option value="Карти за бридж">Карти за бридж</option>
						  </select>
						</div>
							<div class="input_wrap">
							<label for="amount">Количество</label>
							<input type="text" name="amount" id="amount">
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
