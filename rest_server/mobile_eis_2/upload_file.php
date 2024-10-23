<?php
   $no_pengajuan_full_day = $_POST['no_pengajuan_full_day'];
   $jenis = $_POST['jenis'];
    
    $image = base64_decode($_POST['foto']);
    $nama = $no_pengajuan_full_day;

    $targer_dir = "//192.168.4.182/htdocs/eis/uploads/dokumen_customer/$jenis/".$nama.".jpeg";
    if (file_put_contents($targer_dir, $image)) {
        echo json_encode(array('response'=>'Success'));
    }else{
        echo json_encode(array("response" => "Image not uploaded"));
    }
   
?>
<!-- 192.168.4.180/xampp/htdoc/eis/uploads/izin/full_day -->