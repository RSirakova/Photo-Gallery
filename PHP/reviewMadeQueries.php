<?php
	include("indexStudent.php");
	require_once  'connection.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../CSS/reviewQueriesStyles.css">
</head>
<body>

<?php
		if(isset($_GET['status']))
			{
			echo '
				<h3 class="status" style="text-align:center;">'.$_GET["status"].'</h3>';
			}
		 $result = mysqli_query($con, "SELECT r.requestId, p.firstName , p.lastName,r.type , r.dateOfPhotosession, r.status FROM requestphotosession r
										JOIN photographerinfo p ON p.id=r.photographerId
										where r.StudentId='".$studentData['id']."'");
	
		  $num_request=(mysqli_num_rows($result));
		  if($num_request===0)
		  {
			   echo "<div class='mySlides'>";
				echo "<h3 style='text-align:center;'>Нямате направени заявки!</h3>";
			  echo "</div>";
		  }
		  else
		  {
		 
				echo'
						
						<h2>Заявки</h2>
						<div class="table-wrapper">
						<table class="fl-table">
						<thead>
							<tr>
								 <th>Номер на заявка </th>
								 <th>Име на фотографа </th>
								<th>Фамилия на фотографа</th>
								<th>Тип фотосесия</th>
								<th>Дата</th>
								<th>Статус</th>
							</tr>
						</thead>
						<tbody>
						';
						while ($row = mysqli_fetch_array($result)) {
							
						   echo'
						   
						   <tr>
								<td>'.$row['requestId'].'</td>
								<td>'.$row['firstName'].'</td>
								<td>'.$row['lastName'].'</td>
								<td>'.$row['type'].'</td>
								<td>'.$row['dateOfPhotosession'].'</td>
								<td>'.$row['status'].'</td>		
						   </tr>
						'; 
						}
						
					echo'   
					<tbody>
					</table>
					</div>';
		  }
			
	
?>


</body>
</html>
