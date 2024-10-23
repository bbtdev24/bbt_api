<?php
$no_pengajuan_tahunan = $_POST['no_pengajuan_khusus'];
$image = base64_decode($_POST['foto']);

$nama = $no_pengajuan_tahunan;

$targer_dir = "C:/xampp/htdocs/project/ess-api-android-bt/rest_server/image/upload_cuti_khusus/" . $nama . ".jpeg";

if (file_put_contents($targer_dir, $image)) {
    echo json_encode(array('response' => 'Success'));
} else {
    echo json_encode(array("response" => "Image not uploaded"));
}
