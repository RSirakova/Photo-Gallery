<?php

	global $d, $t;
	 $d=date("Y-m-d");
	 $t= date("h-i-sa");
		require_once  'connection.php';	



	function acceptRequest($requestId)
	{
		$con=$GLOBALS['con'];
		 $sql = mysqli_query($con, "UPDATE  requestphotosession
									SET status = 'Потвърдена'
									WHERE requestId=".$requestId."");
		header("Location: reviewQueries.php");
		die;
	}
	
	function denyRequest($requestId)
	{
		$con=$GLOBALS['con'];
		 $sql = mysqli_query($con, "UPDATE  requestphotosession
									SET status = 'Отхвърлена'
									WHERE requestId=".$requestId."");
		header("Location: reviewQueries.php");
		die;
	}
	
		if(isset($_GET['requestIdAccept'])) {
			acceptRequest($_GET['requestIdAccept']);
		}
		
		if(isset($_GET['requestIdDeny'])) {
			denyRequest($_GET['requestIdDeny']);
		}

		function acceptOrder($orderId)
	{
		$con=$GLOBALS['con'];
		 $sql = mysqli_query($con, "UPDATE  orderSouvenirs
									SET status = 'Потвърдена'
									WHERE orderId=".$orderId."");
		header("Location: reviewOrders.php");
		die;
	}
	
	function denyOrder($orderId)
	{
		$con=$GLOBALS['con'];
		 $sql = mysqli_query($con, "UPDATE  orderSouvenirs
									SET status = 'Отхвърлена'
									WHERE orderId=".$orderId."");
		header("Location: reviewOrders.php");
		die;
	}
	
		if(isset($_GET['orderIdAccept'])) {
			acceptOrder($_GET['orderIdAccept']);
		}
		
		if(isset($_GET['orderIdDeny'])) {
			denyOrder($_GET['orderIdDeny']);
		}
	function check_login($con)
	{
	
		if(isset($_SESSION['fn']))
		{
			$fn=$_SESSION['fn'];
			$query="select * from studentinfo where fn=$fn limit 1";
			
			$result=mysqli_query($con,$query);
			if($result && mysqli_num_rows($result)>0)
			{
				$studentData=mysqli_fetch_assoc($result);
				return $studentData;
			}
			
		}		
		header("Location: loginStudent.php");
		die;
	}	
	function check_login_photographer($con)
	{
			
		if(isset($_SESSION['professionalNumber']))
		{
			$professionalNumber=$_SESSION['professionalNumber'];
			$query="select * from photographerinfo where professionalNumber=$professionalNumber limit 1";
			
			$result=mysqli_query($con,$query);
			if($result && mysqli_num_rows($result)>0)
			{
				$photographerData=mysqli_fetch_assoc($result);
				return $photographerData;
			}
		}		
	}	
	

	function filterByGroup($con,$studentData,$zip,$zip_name)
	{
		$result = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE s.studentGroup=".$studentData['studentGroup']);
		
		$row = mysqli_fetch_array($result);	
		echo"<h2>Група: ".$studentData['studentGroup']."</h2>";
		if($row=='')
		{
			echo"<p>Няма снимки за тази група</p>";
			return false;
		}
		else
		{
			$GLOBALS['emptyGroup']=false;
			$queryResult = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
							join studentinfo s on s.id=si.studentId
							join images i on i.id=si.imageId
							WHERE s.studentGroup=".$studentData['studentGroup']);
			$uniqueData=getDateAndHour();
			$current_filter="Група ".$studentData['studentGroup'];
						
	
			if($zip!="")
			{
				 addToZipArchiveForFilterAll($zip,$zip_name,$queryResult,$current_filter);
			}
			$zipname=$current_filter.$uniqueData;
			$queryResult = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
							join studentinfo s on s.id=si.studentId
							join images i on i.id=si.imageId
							WHERE s.studentGroup=".$studentData['studentGroup']);
			
			
			$zip_name=createZipArchive($zipname,$queryResult,$current_filter);
			echo"<p><a href='./Archives/".$zipname.".zip'>Свали архив от снимките за тази група</a></p>";

			do{
				echo "<div class='responsive'>";
				echo "<div class='gallery'>";
				echo  "<a target='_blank' href='images/".$row['image']."'>";
				echo "<img src='images/".$row['image']."' alt='".$row['image_text']."' >";
				echo "</a>";
				echo " <div class='desc'>".$row['image_text']."</div>";
				echo "</div>";
				echo "</div>";						
				}while ($row = mysqli_fetch_array($result));
		}
		return true;
	}
	
		function filterBySpeciality($con,$studentData,$zip,$zip_name)
	{
		$result = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE s.studentSpeciality='".$studentData['studentSpeciality']."'");
								

		$row = mysqli_fetch_array($result);	
		
		echo"<h2>Специалност: ".$studentData['studentSpeciality']."</h2>";
		if($row=='')
		{
			echo"<p>Няма снимки за тази специалност</p>";
			return false;
		}
		else
		{
		$GLOBALS['emptySpeciality']=false;
		$queryResult = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE s.studentSpeciality='".$studentData['studentSpeciality']."'");
			$uniqueData=getDateAndHour();
			$current_filter="Специалност ".$studentData['studentGroup'];
			
				if($zip!="")
			{
				 addToZipArchiveForFilterAll($zip,$zip_name,$queryResult,$current_filter);
				
			}
			$zipname=$current_filter.$uniqueData;
			$queryResult = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE s.studentSpeciality='".$studentData['studentSpeciality']."'");
			$zip_name=createZipArchive($zipname,$queryResult,$current_filter);
			
			echo"<p><a href='./Archives/".$zipname.".zip'>Свали архив от снимките за тази специалност</a></p>";
			do{
				echo "<div class='responsive'>";
				echo "<div class='gallery'>";
				echo  "<a target='_blank' href='images/".$row['image']."'>";
				echo "<img src='images/".$row['image']."' alt='".$row['image_text']."' >";
				echo "</a>";
				echo " <div class='desc'>".$row['image_text']."</div>";
				echo "</div>";
				echo "</div>";						
				}while ($row = mysqli_fetch_array($result));
		} 
		return true;
	}	
	function filterByIssue($con,$studentData,$zip,$zip_name)
	{
		$result = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE s.studentIssue=".$studentData['studentIssue']);
		$row="";
		$row = mysqli_fetch_array($result);	
		
		echo"<h2>Випуск: ".$studentData['studentIssue']."</h2>";
		if($row=='')
		{
			echo"<p>Няма снимки за този випуск</p>";
			return false;
		}
		else
		{
				$GLOBALS['emptyIssue']=false;
				$queryResult = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE s.studentIssue=".$studentData['studentIssue']);
			$uniqueData=getDateAndHour();
			$current_filter="Випуск ".$studentData['studentGroup'];
		
			
				if($zip!="")
			{
				 addToZipArchiveForFilterAll($zip,$zip_name,$queryResult,$current_filter);
				
			}
			$zipname=$current_filter.$uniqueData;
			$queryResult = mysqli_query($con, "SELECT i.image as image, i.image_text as image_text from studentimages si
								join studentinfo s on s.id=si.studentId
								join images i on i.id=si.imageId
								WHERE s.studentIssue=".$studentData['studentIssue']);
								
			$zip_name=createZipArchive($zipname,$queryResult,$current_filter);
			
			
						
			echo"<p><a href='./Archives/".$zipname.".zip'>Свали архив от снимките за този випуск</a></p>";
			do{
				echo "<div class='responsive'>";
				echo "<div class='gallery'>";
				echo  "<a target='_blank' href='images/".$row['image']."'>";
				echo "<img src='images/".$row['image']."' alt='".$row['image_text']."' >";
				echo "</a>";
				echo " <div class='desc'>".$row['image_text']."</div>";
				echo "</div>";
				echo "</div>";						
				}while ($row = mysqli_fetch_array($result));
		} 
		return true;
	}
	
	function createZipArchive($zipname,$queryResult,$dirName)
	{		
		$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
		$archivesDir= createDirForZipFiles();
		$zip_name =$archivesDir."/".$zipname.".zip";
		$zip = new ZipArchive();
			if ($zip->open($zip_name, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === TRUE){
				if(!$zip->addEmptyDir($dirName)) {
					echo 'Неуспех при създаването на папка.';
				} 
 
				while($row1 = mysqli_fetch_array($queryResult))
				{
					$zip->addFile("./images/".$row1['image'],$dirName.'/'.$row1['image']);
				}
				$zip->close();
			} else {
				echo 'Неуспех при създаването на архив.';
				}
		return $zip_name;
	}
	function addToZipArchiveForFilterAll($zip,$zip_name,$queryResult,$dirName)
	{		
		$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
			if ($zip->open($zip_name,ZIPARCHIVE::CREATE) === TRUE){
				if(!$zip->addEmptyDir($dirName)) {
					echo 'Неуспех при създаването на папка.';
				} 
				while($row1 = mysqli_fetch_array($queryResult))
				{
					$zip->addFile("./images/".$row1['image'],$dirName.'/'.$row1['image']);
				}
				$zip->close();
			} else {
			echo 'Неуспех при създаването на архив.';
				}
	}
	function createDirForZipFiles()
	{
		$nameArchiveDir="Archives";
		if (!file_exists("./".$nameArchiveDir)) 
		{
			mkdir($nameArchiveDir, 0777, true);
		}
		return "./".$nameArchiveDir;
	}
	

	function getDateAndHour()
	{
		return " Дата(".strval($GLOBALS['d']).") "." Час(".strval($GLOBALS['t']).")";
	}
	


?>