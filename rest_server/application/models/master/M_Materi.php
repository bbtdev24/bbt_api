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
        $where = "`materi`.`id` is not null";
        if ($kode!='') {
            $where .= " and `materi`.`kode` = '$kode'";
        }
        if ($kode === null) {
            $sql="SELECT * FROM `materi`";
            $hasil = $this->db2->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT * FROM `materi` WHERE $where";
            $hasil = $this->db2->query($sql);
            return $hasil->result_array();
        }
    }
}

?>