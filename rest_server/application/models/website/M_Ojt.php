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
        $where = " ojt_v1.`form_ojt`.`id_ojt` is not null";
        if ($nik!='') {
            $where .= " and ojt_v1.`form_ojt`.`nik` = '$nik'";
        }
        if ($nik === null) {
            $sql="SELECT 
                ojt_v1.`form_ojt`.`id_ojt`
                , ojt_v1.`form_ojt`.`id_materi`
                , ojt_v1.`materi`.`materi`
                , ojt_v1.`form_ojt`.`kode_materi`
                , ojt_v1.`form_ojt`.`nama_pembimbing`
                , ojt_v1.`form_ojt`.`tanggal_pelaksana_pembimbing`
                , ojt_v1.`form_ojt`.`status_atasan`
                , ojt_v1.`form_ojt`.`nik`
                , ojt_v1.`form_ojt`.`jabatan`
                , ojt_v1.`form_ojt`.`tanggal_pelaksana_peserta`
                , ojt_v1.`form_ojt`.`status_user`
                , ojt_v1.`form_ojt`.`lokasi`
                , ojt_v1.`form_ojt`.`remark_user`
                , ojt_v1.`form_ojt`.`remark_atasan`
            FROM ojt_v1.`form_ojt` INNER JOIN ojt_v1.`materi`
            ON ojt_v1.`form_ojt`.`id_materi` = ojt_v1.`materi`.`id`";
            $hasil = $this->db5->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT 
                ojt_v1.`form_ojt`.`id_ojt`
                , ojt_v1.`form_ojt`.`id_materi`
                , ojt_v1.`materi`.`materi`
                , ojt_v1.`form_ojt`.`kode_materi`
                , ojt_v1.`form_ojt`.`nama_pembimbing`
                , ojt_v1.`form_ojt`.`tanggal_pelaksana_pembimbing`
                , ojt_v1.`form_ojt`.`status_atasan`
                , ojt_v1.`form_ojt`.`nik`
                , ojt_v1.`form_ojt`.`jabatan`
                , ojt_v1.`form_ojt`.`tanggal_pelaksana_peserta`
                , ojt_v1.`form_ojt`.`status_user`
                , ojt_v1.`form_ojt`.`lokasi`
                , ojt_v1.`form_ojt`.`remark_user`
                , ojt_v1.`form_ojt`.`remark_atasan`
            FROM ojt_v1.`form_ojt` INNER JOIN ojt_v1.`materi`
            ON ojt_v1.`form_ojt`.`id_materi` = ojt_v1.`materi`.`id` WHERE $where ";
            $hasil = $this->db5->query($sql);
            return $hasil->result_array();
        }
    }

    public function createOjt($data)
    {
        $this->db5->insert('form_ojt', $data);
        return $this->db5->affected_rows();
    }

    public function updateStatus($data, $id_materi, $nik)
    {
        $this->db5->update('form_ojt', $data, ['id_materi' => $id_materi, 'nik' => $nik]);
        return $this->db5->affected_rows();
    }
}

?>