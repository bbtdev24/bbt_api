<?php  
 $servername = "192.168.4.195";  
 $username = "phpwaterout";  
 $password = "Databa53";  
 $dbname = "dms_customer";  
 $host = 3307;

 $conn = new mysqli($servername, $username, $password, $dbname, $host);  
	
 if ($conn->connect_error) {  
   die("Connection failed: " . $conn->connect_error);  
 }     
?> 