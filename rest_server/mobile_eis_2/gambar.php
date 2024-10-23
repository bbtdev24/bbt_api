<?php
header('Content-Type: application/json');
include 'connect1.php';

$sql = "SELECT * FROM tbl_event_carousel WHERE STATUS = 'active' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
echo json_encode(array('data' => $rows));
?>