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
        $where = " ojt_v1.`materi`.`id` is not null";
        if ($kode!='') {
            $where .= " and ojt_v1.`materi`.`kode` = '$kode'";
        }
        if ($kode === null) {
            $sql="SELECT * FROM ojt_v1.`materi`";
            $hasil = $this->db5->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT * FROM ojt_v1.`materi` WHERE $where ";
            $hasil = $this->db5->query($sql);
            return $hasil->result_array();
        }
    }
}

?>