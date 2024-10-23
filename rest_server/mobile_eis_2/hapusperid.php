<?php
include 'connect1.php';

$id = $_POST['id'];
$tanggal = DATE('Y-m-d');

$sql = "DELETE FROM tmp_daily_activity WHERE id = '$id'";

$result = mysqli_query($conn, $sql);
?>