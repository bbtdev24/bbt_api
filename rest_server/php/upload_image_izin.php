<?php
$no_pengajuan_full_day = $_POST['no_pengajuan_full_day'];

$image = base64_decode($_POST['foto']);
$nama = $no_pengajuan_full_day;

//windows
//$targer_dir = "C:/xampp/htdocs/project/ess-api-android-bt/rest_server/image/upload_izin/" . $nama . ".jpeg";

//linux
$targer_dir = "/var/www/html/bbt_api/rest_server/image/upload_izin/" . $nama . ".jpeg";

if (file_put_contents($targer_dir, $image)) {
    echo json_encode(array('response' => 'Success'));
} else {
    echo json_encode(array("response" => "Image not uploaded"));
}
