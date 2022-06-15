<?php

	require_once  'connection.php';
	include("indexStudent.php");
	
	if(isset($_GET['status']))
	{
		echo "<h3 style='padding-top:10px;text-align:center;'>".$_GET['status']."</h3>";
	}
	
	if(isset($_POST['submit']))
	{ 
		  $studentId=$studentData['id'];
		  if (!file_exists("./images")) {
			mkdir("./images", 0777, true);
		}
		$targetDir = "images/"; 
		$allowTypes = array('jpg','png','jpeg','gif','JPG','JPEG'); 
		 
			$image = $_FILES['files']['name'];
		if($image!='')
		{
			$image_text = mysqli_real_escape_string($con, $_POST['image_text']);
			if($image_text==='')
			{
				$image_text="Няма добавено описание.";
			}
		}
	   $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType=$names = ''; 
	   $fileNames = array_filter($_FILES['files']['name']); 
			    if(!empty($fileNames))
				{ 
				foreach($_FILES['files']['name'] as $key=>$val)
				{ 
       
					$fileName = basename($_FILES['files']['name'][$key]); 
					$targetFilePath = $targetDir . $fileName;            
					$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
					if(in_array($fileType, $allowTypes))
					{ 
						if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath))
						{ 
							$insertValuesSQL .= "('".$fileName."', '".$image_text."'),"; 
							$names.=$fileName.">";
						}
						else
						{ 
							$errorUpload .= $_FILES['files']['name'][$key].' | '; 
						} 
					}
					else	
					{ 
						$errorUploadType .= $_FILES['files']['name'][$key].' | '; 
					} 
				}	
				if(!empty($insertValuesSQL))
				{ 
					$insertValuesSQL = trim($insertValuesSQL, ','); 
					$sql = "INSERT INTO images (image, image_text) VALUES $insertValuesSQL"; 
					 
					if ($con->query($sql) === FALSE) 
					{
						echo "Грешка при вмъкването в images" ;
					} 
					$stringNames= explode(">", $names);
					$error=false;
					for ($x = 0; $x <sizeof($stringNames)-1; $x++) 
					{
	
						$query="SELECT id FROM images where image='".$stringNames[$x]."'";
						$result = mysqli_query($con, $query);
						$row=mysqli_fetch_array($result);
						$imageId=$row['id'];
						$sql = "INSERT INTO studentimages (studentId, imageId) VALUES ('$studentId','$imageId')";
						if ($con->query($sql) === TRUE) 
						{
							$error=false;
						}
						else 
						{
							$error=true;
						}
					}	
					if($error)
					{
						header("Location: ./uploadPhoto.php?status=Грешка при качването на файла в таблица studentimages!");
					}
					else
					{
						header("Location: ./uploadPhoto.php?status=Успешно качени файлове!");
					}
				}
				else
				{ 
					header("Location: ./uploadPhoto.php?status=Невалиден формат на качения файл!");
				} 
		
			}
			else
			{		
				header("Location: uploadPhoto.php?status=Моля изберетe поне един файл!");
			}
			
	}
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">	
<link rel="stylesheet" href="../CSS/styleNavBar.css">
<link rel="stylesheet" href="../CSS/styleUploadPhoto.css">

<body>

		<div id="content">
		<form action="" method="post" enctype="multipart/form-data">
			<div>
				Изберете снимки:
			<input type="file" name="files[]" multiple >
			</div>
			<div>
			  <textarea 
				id="text" 
				cols="40" 
				rows="4" 
				name="image_text" 
				placeholder="Описание на снимката.."></textarea>
			</div>
			<div>
				  <input type="submit" name="submit" class="btn" value="Качи">
			</div>
		  </form>
		</div>

    
</body>
</html>
