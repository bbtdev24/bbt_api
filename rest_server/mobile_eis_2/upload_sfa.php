<?php
    $nik = $_POST['nik'];
    $image = base64_decode($_POST['foto']);
    $nama_folder = $_POST['nama_folder'];    
    $nama = $nik;
 
    $targer_dir = "D:/xampp/htdocs/rest_server_android/image_sfa_apps/".$nama_folder."/".$nama.".jpeg";
    if (file_put_contents($targer_dir, $image)) {
        echo json_encode(array('response'=>'Success'));
    }else{
        echo json_encode(array("response" => "Image not uploaded"));
    }
   
?>