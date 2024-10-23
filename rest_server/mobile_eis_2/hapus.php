<?php
include 'connect1.php';

$nik = $_POST['nik'];
$tanggal = DATE('Y-m-d');

$sql = "DELETE FROM tmp_daily_activity WHERE nik = '$nik' AND DATE(submit_date) = '$tanggal'";

$result = mysqli_query($conn, $sql);
?>