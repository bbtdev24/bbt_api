<?php
error_reporting(0);
session_start();
$url    = "http://hrd.tvip.co.id/rest_server/api/login/?";
$pass = null;

if($_POST){
	$nik   = urlencode($_POST['nik']);
	$url   .= "nik_baru=".$nik;
	$pass = md5($_POST['pass']);
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
curl_close($ch);

$result = json_decode($output); 

if ($nik == $result->data[0]->nik_baru) {
	if ($pass == $result->data[0]->password) {
 	 		echo json_encode(Array('status' => 'success'));
 	 	} else {
 	 		echo json_encode(Array('status' => 'wrong data'));
 	 	}
} 
	
if ($nik !== $result->data[0]->nik_baru) {
	echo json_encode(Array('status' => 'wrong data'));
}
?>