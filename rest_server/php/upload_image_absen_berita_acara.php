<?php
$nama_foto = $_POST['nama_foto'];
$image = base64_decode($_POST['foto']);
$nama_folder = $_POST['nama_folder'];
$nama = $nama_foto;

$targer_dir = "C:/xampp/htdocs/project/ess-api-android-bt/rest_server/image/upload_absen_berita_acara/" . $nama . ".jpeg";

if (file_put_contents($targer_dir, $image)) {
    echo json_encode(array('response' => 'Success'));
} else {
    echo json_encode(array("response" => "Image not uploaded"));
}
