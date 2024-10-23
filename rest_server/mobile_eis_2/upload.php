<?php
   $no_pengajuan_full_day = $_POST['no_pengajuan_full_day'];
    
    $image = base64_decode($_POST['foto']);
    $nama = $no_pengajuan_full_day;

    $targer_dir = "D:/xampp/htdocs/rest_server_android/upload_izin/".$nama.".jpeg";
    if (file_put_contents($targer_dir, $image)) {
        echo json_encode(array('response'=>'Success'));
    }else{
        echo json_encode(array("response" => "Image not uploaded"));
    }
   
?>
