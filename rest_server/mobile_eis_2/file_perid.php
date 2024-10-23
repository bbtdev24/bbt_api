<?php
header('Content-Type: application/json');
include 'connect2.php';

$dokumen_npwp = $_GET['dokumen_npwp'];

$sql = "SELECT * FROM dms_customer_dokumen WHERE szId = '$dokumen_npwp'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
echo json_encode(array('data' => $rows));
?>
