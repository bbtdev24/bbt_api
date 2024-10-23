<?php
include 'connect2.php';
$tanggal = date('Y-m-d');

$szId = $_POST['szId'];
$npwp  = $_POST['npwp'];
$dokumen_npwp = $_POST['dokumen_npwp'];


$sql =" UPDATE dms_customer_dokumen SET 
npwp = '$npwp', 
dokumen_npwp = '$dokumen_npwp'
WHERE szId='$szId'";

$result = mysqli_query($conn, $sql);
?>

