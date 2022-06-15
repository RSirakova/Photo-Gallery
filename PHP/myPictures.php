<?php
	include("indexStudent.php");
	require_once  'connection.php';

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script defer src="../JS/myPicturesScript.js"></script>
<link rel="stylesheet" href="../CSS/styleNavBar.css">
<link rel="stylesheet" href="../CSS/styleMyPictures.css">


<style>
.addSouvenir
{
	position:absolute;
  cursor: pointer;
  top: 20px; 
  width: auto;
  padding: 16px;
  color: white;
  font-weight: bold;
  font-size: 15px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
  text-decoration:none;
float:right;
}

</style>
</head>
<body>

<h2 style="text-align:center">Моите снимки</h2>


    <div class="container">  
	
  <?php

  $result = mysqli_query($con, "SELECT i.id,i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE si.studentId=".$studentData['id']);
  $slideNumber=1;
  $num_images=(mysqli_num_rows($result));
  if($num_images===0)
  {
	   echo "<div class='mySlides'>";
      	echo "<p style='text-align:center;'>Вие нямате качени снимки!</p>";
      echo "</div>";
  }
   
    while ($row = mysqli_fetch_array($result)) {
		
      echo "<div class='mySlides'>";

	    echo "<div class='numbertext'>".$slideNumber."/".$num_images."</div>";
		
		echo  "<a class='prev' onclick='plusSlides(-1)'><</a>";
		 echo '<a  href="orderSouvenirs.php?imageId='.$row['id'].'" class="addSouvenir">Поръчай сувенир с тази снимка <i class="fa fa-gift" aria-hidden="true"> </i> </a>';
		echo "<a class='next' onclick='plusSlides(1)'>></a>";
      	echo "<p style='text-align:center;'><img src='images/".$row['image']."' alt='".$row['image_text']."' style='margin-top:20px;max-width:400px; max-height:400px;' > </p>"; 
		
      echo "</div>";
	   $slideNumber+=1;
	  
    }
	 $slideNumber=1;
		echo "<div class='caption-container'>";
		echo "<p style='color:white;' id='caption'></p>";
		echo"</div>";
	  $result = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE si.studentId=".$studentData['id']);
	   
	   
	   while ($row = mysqli_fetch_array($result)) 
	   {
		if($slideNumber%6==0)
			{echo"<div class='row'>";}
			echo "<div class='column'>";
			echo "<img class='demo cursor' src='images/".$row['image']."' alt='".$row['image_text']."' style='max-width:300px;height:100px;width:100%' onclick='currentSlide(". $slideNumber.")'>";
			echo"</div>";
		if($slideNumber%6==0)
			{echo"</div>";}
		  $slideNumber+=1;	
		}
  ?>
    

</div>


</body>
</html>
