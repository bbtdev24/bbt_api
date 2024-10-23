<?php
   $no_pengajuan_tahunan = $_POST['no_pengajuan_tahunan'];
    $image = base64_decode($_POST['foto']);
    
    $nama = $no_pengajuan_tahunan;
 
    $targer_dir = "D:/xampp/htdocs/rest_server_android/upload_cuti_tahunan/".$nama.".jpeg";
    if (file_put_contents($targer_dir, $image)) {
        echo json_encode(array('response'=>'Success'));
    }else{
        echo json_encode(array("response" => "Image not uploaded"));
    }
   
?>