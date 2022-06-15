<?php
	include("indexStudent.php");
	require_once  'connection.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">


<style>
form{
	margin-bottom:20px;
	margin-left:20px;
	margin-top:10px;
}
.btn{
	width: 100px;
	background: #ebd0ce;
	padding: 10px;
	border: 0;
	border-radius: 3px;
	text-transform: uppercase;
	cursor: pointer;
	font-size:15px;
	text-align:center;
}

.btn:hover{
	background: #ffd5d2;
}

div.gallery {
  border: 1px solid #ccc;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: 200px;
}


div.desc {
  padding: 15px;
  text-align: center;
}

* {
  box-sizing: border-box;
}

.responsive {
	margin-top:20px;
	margin-bottom:20px;
  padding: 0 6px;
  float: left;
  width: 24.99999%;
}

@media only screen and (max-width: 700px) {
  .responsive {
    width: 49.99999%;
    margin: 6px 0;
  }
}

@media only screen and (max-width: 500px) {
  .responsive {
    width: 100%;
  }
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

.form_wrap
{
	margin-top:20px;
	margin-bottom:20px;
	margin-left:20px;
	margin-right:20px;
}

.form_wrap ul{
	background: #fff;
	padding: 8px 10px;
	border-radius: 3px;
	display: flex;
	justify-content: center;
}

.form_wrap ul li:first-child{
	margin-right: 15px;
}

.form_wrap ul .radio_wrap{
	position: relative;
	margin-bottom: 0;
}



.form_wrap ul .radio_wrap span{
	display: inline-block;
	font-size: 14px;
	padding: 3px 20px;
	border-radius: 3px;
	color: #545871;
}

.form_wrap .input_radio:checked ~ span{
	background: #ebd0ce;
}

.submit_btn{
	width: 100%;
	background: #ebd0ce;
	padding: 10px;
	border: 0;
	border-radius: 3px;
	text-transform: uppercase;
	letter-spacing: 3px;
	cursor: pointer;
	font-size:15px;
}

.form_wrap .submit_btn:hover{
	background: #ffd5d2;
}

#partition1,#partition2,#partition3,.show
{
	 float: left;
}



</style>
</head>
<body>
<h2>Разглеждане на албуми</h2>
<form id="form" class="form_wrap" method="POST" action="albums.php" enctype="multipart/form-data">
  <div class="input_wrap">
						<label>Изберете филтриране</label>
						<ul>
							<li>
								<label class="radio_wrap">
									<input type="radio" name="filter" value="byGroup" class="input_radio" checked>
									<span>По група</span>
								</label>
							</li>
								
							<li>
								<label class="radio_wrap">
									<input type="radio" name="filter" value="bySpeciality" class="input_radio">
									<span>По специалност</span>
								</label>
							</li>
							<li>
								<label class="radio_wrap">
									<input type="radio" name="filter" value="byIssue" class="input_radio">
									<span>По випуск</span>
								</label>
							</li>
							<li>
								<label class="radio_wrap">
									<input type="radio" name="filter" value="all" class="input_radio">
									<span>По всички</span>
								</label>
							</li>
						</ul>
</div>

  	<button class='btn' type="submit" name="show">Покажи</button>
</form>
<?php
  // If show button is clicked ...
  if (isset($_POST['show']))
  {
	$filter = $_POST["filter"];

	if($filter == "byGroup")
	{ 
	echo "<div id='group1'>";
		filterByGroup($con,$studentData,"","");
	echo "</div>";
	}
	else if ($filter == "byIssue")
	{
		echo "<div id='isuue1'>";
		filterByIssue($con,$studentData,"","");
			echo "</div>";
	}
	else if ($filter == "bySpeciality")
	{
		echo "<div id='speciality1'>";
		filterBySpeciality($con,$studentData,"","");
			echo "</div>";
	}
	else
	{
		$uniqueData=getDateAndHour();
		$current_filter="Всички ";
		$zipname=$current_filter.$uniqueData;
		$archivesDir= createDirForZipFiles();
		$zip_name =$archivesDir."/".$zipname.".zip";
		$zip = new ZipArchive();	
			echo "<div id='partition1'>";
			$byGroup=filterByGroup($con,$studentData,$zip,$zip_name);
			echo "</div>";
			echo "<div id='partition2'>";
			$byIssue=filterByIssue($con,$studentData,$zip,$zip_name);
			echo "</div>";
			echo "<div id='partition3'>";
			$bySpeciality=filterBySpeciality($con,$studentData,$zip,$zip_name);
			echo "</div>";
			if(!$byGroup && !$byIssue && !bySpeciality)
			{
				echo"<p class='show'>Няма снимки по нито една от филтрациите</p>";
			}
			else
			{
				echo"<p class='show'><a href='./Archives/".$zipname.".zip'>Свали архив от снимките</a></p>";
			}
		
	
	}
  }

?>

</body>
</html>
