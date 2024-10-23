<?php
include 'connect2.php';
$tanggal = date('Y-m-d');

$no_pelanggan = $_POST['no_pelanggan'];
$alamat_pelanggan = $_POST['alamat_pelanggan'];
$no_telepon = $_POST['no_telepon'];
$nik_ktp = $_POST['nik_ktp'];
$npwp = $_POST['npwp'];
$longitude = $_POST['longitude'];
$langitude = $_POST['langitude'];



$sql = "INSERT INTO dms_history_dokumen
(szId,
	szAddress,
	szPhone1,
	nik_ktp,
	npwp,
	szLongitude, 
	szLatitude) 
	VALUES (
	'$no_pelanggan',
	'$alamat_pelanggan',
	'$no_telepon',
	'$nik_ktp',
	'$npwp',
	'$longitude',
	'$langitude'
	)";
$result = mysqli_query($conn, $sql);
?>