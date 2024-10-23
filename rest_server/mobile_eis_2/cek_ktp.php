<?php
header('Content-Type: application/json');
include 'connect1.php';

$idktp = $_GET['idktp'];

$sql = "SELECT * FROM upload_npwp WHERE nik_ktp = '$idktp'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
echo json_encode(array('data' => $rows));
?>
