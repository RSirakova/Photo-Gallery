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
			<h3 class="status" style="text-align:center;">'.$_GET["status"].'</h3>';
		}
		 $result = mysqli_query($con, "SELECT r.studentId,r.requestId, s.firstName , s.lastName,r.type , r.dateOfPhotosession, r.status FROM requestphotosession r
										JOIN STUDENTINFO s ON s.id=r.StudentId
										where r.photographerId='".$photographerData['id']."'");
	
		  $num_request=(mysqli_num_rows($result));
		  if($num_request===0)
		  {
			echo "<h3 style='text-align:center;'>Няма постъпили заявки!</h3>";
			
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
								 <th>Име </th>
								<th>Фамилия</th>
								<th>Тип фотосесия</th>
								<th>Дата</th>
								<th>Статус</th>
								<th>Потвърди</th>
								<th>Отхвърли</th>
								<th>Качи снимки</th>
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
							';
							if($row['status']==="Завършена")
							{
								echo'
								<td>-</td>
								<td>-</td>
								<td>-</td>';
							}
							else
							{
							echo'
							<td> <a  href="functions.php?requestIdAccept='.$row['requestId'].'" class="accept" style="text-decoration:none;" >Потвърди <span class="fa fa-check"></span></a></td>
							<td> <a  href="functions.php?requestIdDeny='.$row['requestId'].'" class="deny"  style="text-decoration:none;" >Отхвърли <span class="fa fa-close"></span></a></td>				
							<td> <a  href="uploadByPhotographer.php?studentId='.$row['studentId'].'&requestId='.$row['requestId'].'"  style="text-decoration:none;" >Качи <i class="fa fa-file-image-o" aria-hidden="true"></i></a></td>				
							</tr>
							'; 
							}
						
						}
						
					echo'   
					<tbody>
				</table>
			</div>';
		  }
			

?>


</body>
</html>
