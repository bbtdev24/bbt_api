<?php

/**
 * 
 */
class M_Materi extends CI_Model
{
    
    public function __construct()
    {
        # code...
    }

    public function getMateri($kode = null)
    {
        $where = "absensi_new.`materi`.`id` is not null";
        if ($kode!='') {
            $where .= " and absensi_new.`materi`.`kode` = '$kode'";
        }
        if ($kode === null) {
            $sql="SELECT * FROM absensi_new.`materi`";
            $hasil = $this->db2->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT * FROM absensi_new.`materi` WHERE $where";
            $hasil = $this->db2->query($sql);
            return $hasil->result_array();
        }
    }
}

?>