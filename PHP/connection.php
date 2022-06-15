<?php
	include ("./config.php");
	$configs = new Config();
    $con = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);

	 if(!$con){
        die("Connection failed: ".mysqli_connect_error());
    }

?>