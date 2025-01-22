<?php

/**
 * 
 */
class M_Ojt extends CI_Model
{
    
    public function __construct()
    {
        # code...
    }

    public function getOjt($nik = null)
    {
        $where = " `form_ojt`.`id_ojt` is not null";
        if ($nik!='') {
            $where .= " and `form_ojt`.`nik` = '$nik'";
        }
        if ($nik === null) {
            $sql="SELECT * FROM `form_ojt`";
            $hasil = $this->db2->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT * FROM `form_ojt` WHERE $where ";
            $hasil = $this->db2->query($sql);
            return $hasil->result_array();
        }
    }

    public function createOjt($data)
    {
        $this->db2->insert('form_ojt', $data);
        return $this->db2->affected_rows();
    }

    public function updateStatus($data, $id_materi, $nik)
    {
        $this->db2->update('form_ojt', $data, ['id_materi' => $id_materi, 'nik' => $nik]);
        return $this->db2->affected_rows();
    }
}

?>