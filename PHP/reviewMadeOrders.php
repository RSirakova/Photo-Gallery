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

		 $result = mysqli_query($con, "SELECT o.orderId, p.firstName , p.lastName,o.souvenir , o.dateOfOrder, o.status, o.amount FROM orderSouvenirs o
										JOIN photographerinfo p ON p.id=o.photographerId
										where o.StudentId='".$studentData['id']."'");
										
	
		  $num_request=(mysqli_num_rows($result));
		  if($num_request===0)
		  {
			   echo "<div class='mySlides'>";
				echo "<h3 style='text-align:center;'>Вие нямате направени поръчки!</h3>";
			  echo "</div>";
		  }
		  else
		  {
		 
				echo'
						
						<h2>Поръчки</h2>
						<div class="table-wrapper">
						<table class="fl-table">
						<thead>
							<tr>
								 <th>Номер на заявка </th>
								 <th>Име на фотограф </th>
								<th>Фамилия на фотограф</th>
								<th>Вид сувенир</th>
								<th>Дата</th>
								<th>Статус</th>
								<th>Брой</th>
							</tr>
						</thead>
						<tbody>
						';
						while ($row = mysqli_fetch_array($result)) {
							
						   echo'
						   
						   <tr>
						<td>'.$row['orderId'].'</td>
						<td>'.$row['firstName'].'</td>
						<td>'.$row['lastName'].'</td>
						<td>'.$row['souvenir'].'</td>
						<td>'.$row['dateOfOrder'].'</td>
						<td>'.$row['status'].'</td>		
						<td>'.$row['amount'].'</td>		
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
