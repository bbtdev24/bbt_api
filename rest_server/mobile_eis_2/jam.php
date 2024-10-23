<?php
header('Content-Type: application/json');
include 'connect1.php';

$sql = "SELECT * FROM tbl_shifting";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
echo json_encode(array('data' => $rows));
?>