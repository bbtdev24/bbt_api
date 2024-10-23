<?php
    $ktp = $_POST['ktp'];
    $image = base64_decode($_POST['foto']);
    
    $nama = $ktp;
 
    $targer_dir = "//192.168.4.182/htdocs/eis/uploads/data_induk/ktp/".$nama.".jpg";
    if (file_put_contents($targer_dir, $image)) {
        echo json_encode(array('response'=>'Success'));
    }else{
        echo json_encode(array("response" => "Image not uploaded"));
    }   

?>
