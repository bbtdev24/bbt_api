<?php
include 'connect2.php';
$tanggal = date('Y-m-d');

$szId = $_POST['szId'];
$nik_ktp = $_POST['nik_ktp'];
$dokumen_ktp = $_POST['dokumen_ktp'];


$sql = "INSERT INTO dms_customer_dokumen
	(szId,
	nik_ktp,
	dokumen_ktp) VALUES (
	'$szId',
	'$nik_ktp',
	'$dokumen_ktp')";
$result = mysqli_query($conn, $sql);
?>