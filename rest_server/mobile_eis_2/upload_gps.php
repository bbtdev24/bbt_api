<?php
   $nama_foto = $_POST['nama_foto'];
    
    $image = base64_decode($_POST['foto']);
    $nama = $nama_foto;

    $targer_dir = "D:/xampp/htdocs/rest_server_android/gps_images/".$nama.".jpeg";
    if (file_put_contents($targer_dir, $image)) {
        echo json_encode(array('response'=>'Success'));
    }else{
        echo json_encode(array("response" => "Image not uploaded"));
    }
   
?>
