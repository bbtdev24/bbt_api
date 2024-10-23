<?php
    $nik = $_POST['nik'];
    $image = base64_decode($_POST['foto']);
    
    $nama = $nik;
 
    $targer_dir = "//192.168.4.182/htdocs/eis/uploads/karyawan_refund/".$nama.".jpeg";
    if (file_put_contents($targer_dir, $image)) {
        echo json_encode(array('response'=>'Success'));
    }else{
        echo json_encode(array("response" => "Image not uploaded"));
    }
   
?>