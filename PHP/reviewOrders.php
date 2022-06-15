<?php
	include("indexPhotographer.php");
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
		<div class="input_wrap">
			<h3 class="status" style="text-align:center;">'.$_GET["status"].'</h3>
		</div>';
		}
		 $result = mysqli_query($con, "SELECT o.studentId,o.orderId, s.firstName , s.lastName,o.souvenir ,o.dateOfOrder, o.status, o.amount FROM orderSouvenirs o
										JOIN STUDENTINFO s ON s.id=o.StudentId
										where o.photographerId='".$photographerData['id']."'");
	
		  $num_request=(mysqli_num_rows($result));
		  if($num_request===0)
		  {
			   header("Location: ./reviewOrders.php?status=Вие нямате постъпили поръчки!");
				die;	
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
									 <th>Име </th>
									<th>Фамилия</th>
									<th>Вид сувенир</th>
									<th>Дата</th>
									<th>Статус</th>
									<th>Брой</th>
									<th>Потвърди</th>
									<th>Отхвърли</th>
								</tr>
							</thead>
							<tbody>
						';
						while ($row = mysqli_fetch_array($result))
						{
							   echo'	   
								 <tr>
									<td>'.$row['orderId'].'</td>
									<td>'.$row['firstName'].'</td>
									<td>'.$row['lastName'].'</td>
									<td>'.$row['souvenir'].'</td>
									<td>'.$row['dateOfOrder'].'</td>
									<td>'.$row['status'].'</td>
									<td>'.$row['amount'].'</td>
									<td> <a  href="functions.php?orderIdAccept='.$row['orderId'].'" class="accept" style="text-decoration:none;" >Потвърди <span class="fa fa-check"></span></a></td>
									<td> <a  href="functions.php?orderIdDeny='.$row['orderId'].'" class="deny"  style="text-decoration:none;" >Отхвърли <span class="fa fa-close"></span></a></td>							
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
