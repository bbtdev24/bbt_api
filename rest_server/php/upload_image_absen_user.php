<?php

require_once 'global_path.php';


// $nama_foto = $_POST['nama_foto'];
// $image = base64_decode($_POST['foto']);
// $nama_folder = $_POST['nama_folder'];
// $nama = $nama_foto;

// $targer_dir = "C:/xampp/htdocs/project/ess-api-android-bt/rest_server/image/upload_absen_user/" . $nama . ".jpeg";

// if (file_put_contents($targer_dir, $image)) {
//     echo json_encode(array('response' => 'Success'));
// } else {
//     echo json_encode(array("response" => "Image not uploaded"));
// }

$nama_foto = $_POST['nama_foto'];
$image = base64_decode($_POST['foto']);
$nama_folder = $_POST['nama_folder'];
$nama = $nama_foto;

// Windows
// $targer_dir = "C:/xampp/htdocs/project/ess-api-android-bt/rest_server/image/upload_absen_user/" . $nama . ".jpeg";

// Linux
$targer_dir = FILE_UPLOAD_PATH . "absensi/" . $nama . ".jpeg";

// Tambahin pengecekan apakah direktori ada dan bisa di-write
if (!is_writable(dirname($targer_dir))) {
	echo json_encode(array('response' => 'Directory is not writable: ' . dirname($targer_dir)));
	exit;
}

// Tambahin pengecekan apakah base64 image valid
if ($image === false) {
	echo json_encode(array('response' => 'Invalid base64 image data'));
	exit;
}

if (file_put_contents($targer_dir, $image)) {
	echo json_encode(array('response' => 'Success'));
} else {
	// Tambahin error detail ketika gagal menyimpan gambar
	$error = error_get_last();
	echo json_encode(array("response" => "Image not uploaded", "error" => $error['message']));
}
