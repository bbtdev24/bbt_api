<?php
   $no_pengajuan_tahunan = $_POST['nomor'];
    $image = base64_decode($_POST['foto']);
    
    $nama = $no_pengajuan_tahunan;
 
    $targer_dir = "//192.168.4.182/htdocs/eis/uploads/vaksin/".$nama.".jpeg";
    if (file_put_contents($targer_dir, $image)) {
        echo json_encode(array('response'=>'Success'));
    }else{
        echo json_encode(array("response" => "Image not uploaded"));
    }   
?>