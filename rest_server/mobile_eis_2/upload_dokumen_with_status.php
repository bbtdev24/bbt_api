<?php
include 'connect2.php';
$tanggal = date('Y-m-d');

$szId = $_POST['szId'];
$nik_ktp = $_POST['nik_ktp'];
$dokumen_ktp = $_POST['dokumen_ktp'];
$status_ktp = $_POST['status_ktp'];
$ket_ktp = $_POST['ket_ktp'];

if($status_ktp == 1){
	$sql = "INSERT INTO dms_customer_dokumen
		(szId,
		nik_ktp,
		dokumen_ktp,
		status_ktp,
		ket_ktp) VALUES (
		'$szId',
		'$nik_ktp',
		'$dokumen_ktp',
		'$status_ktp',
		'$ket_ktp')";
	$result = mysqli_query($conn, $sql);
} else {
	$sql = "INSERT INTO dms_customer_dokumen
		(szId,
		status_ktp,
		ket_ktp) VALUES (
		'$szId',
		'$status_ktp',
		'$ket_ktp')";
	$result = mysqli_query($conn, $sql);
}



?>