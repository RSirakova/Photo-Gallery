<!DOCTYPE html>
<html>
<head>
<style> 
body {
  background-image: url(../snimki/snimka.jpg);
  
  background-repeat: no-repeat;
  
  background-attachment: fixed;
  
  background-size: cover;
  
  background-color: #464646;
}

.button{
	width: 100%;
	background: #ebd0ce;
	padding: 15px;
	border: 0;
	border-radius: 3px;
	text-transform: uppercase;
	letter-spacing: 3px;
	cursor: pointer;
	font-size:15px;
}

.button:hover{
	background: #ffd5d2;
}
.content{
  margin: auto;
  width: 40%;
  padding: 9px;
}
.right,.left{
	
	margin-top:10px;
	margin-bottom:10px;
	opacity:90%;
}

a{
	color:black;
	text-decoration: none;
}

</style>
</head>
<body>
	<div class="content">
		<div class="left">
			<div class="button"> <p style="text-align:center;"><a href="loginStudent.php" >Студент</a> </p></div>
		</div>
			<div class="right">
				<div class="button"> <p style="text-align:center;"><a href="loginPhotographer.php" >Фотограф</a> </p></div>
		</div>
		
		
	</div>
</body>
</html>
