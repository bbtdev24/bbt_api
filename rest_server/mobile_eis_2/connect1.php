<?php  
 $servername = "203.100.57.36";  
 $username = "pandu";  
 $password = "tester@";  
 $dbname = "absensi";  
 $host = 3306;

 $conn = new mysqli($servername, $username, $password, $dbname, $host);  
	
 if ($conn->connect_error) {  
   die("Connection failed: " . $conn->connect_error);  
 }     
?> 