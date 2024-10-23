<?php
include 'connect1.php';

$id = $_POST['id'];

$sql = "DELETE FROM tmp_daily_activity WHERE id = $id";

$result = mysqli_query($conn, $sql);

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}
?>