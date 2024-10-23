<?php

/**
 * 
 */
class M_Resign extends CI_Model
{
    
    public function __construct()
    {
        # code...
    }

    public function getResign($tanggal1 = null, $tanggal2 = null)
    {
        $where = " tbl_resign.`tanggal_efektif_resign` >= '$tanggal1' AND tbl_resign.`tanggal_efektif_resign` <= '$tanggal2'";

        if ($tanggal1 === null and $tanggal2 === null) {
            $sql="SELECT
                tbl_karyawan_struktur.`nik_baru`
                , tbl_karyawan_struktur.`nama_karyawan_struktur`
                , tbl_jabatan_karyawan.`jabatan_karyawan`   
                , tbl_karyawan_struktur.`lokasi_struktur`
                , tbl_karyawan_struktur.`dept_struktur`
                , tbl_karyawan_struktur.`join_date_struktur`
                , tbl_resign.`tanggal_efektif_resign`
                , tbl_resign.`tanggal_efektif_resign` AS tanggal_efektif_resign_2
            FROM tbl_resign
            INNER JOIN tbl_karyawan_struktur
                ON tbl_karyawan_struktur.`nik_baru` = tbl_resign.`nik_resign`
            INNER JOIN tbl_jabatan_karyawan
                ON tbl_karyawan_struktur.`jabatan_struktur` = tbl_jabatan_karyawan.`no_jabatan_karyawan`
            ";
            $hasil = $this->db2->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT
                tbl_karyawan_struktur.`nik_baru`
                , tbl_karyawan_struktur.`nama_karyawan_struktur`
                , tbl_jabatan_karyawan.`jabatan_karyawan`   
                , tbl_karyawan_struktur.`lokasi_struktur`
                , tbl_karyawan_struktur.`dept_struktur`
                , tbl_karyawan_struktur.`join_date_struktur`
                , tbl_resign.`tanggal_efektif_resign`
                , tbl_resign.`tanggal_efektif_resign` AS tanggal_efektif_resign_2
            FROM tbl_resign
            INNER JOIN tbl_karyawan_struktur
                ON tbl_karyawan_struktur.`nik_baru` = tbl_resign.`nik_resign`
            INNER JOIN tbl_jabatan_karyawan
                ON tbl_karyawan_struktur.`jabatan_struktur` = tbl_jabatan_karyawan.`no_jabatan_karyawan`
            WHERE $where
            ";
            $hasil = $this->db2->query($sql);
            return $hasil->result_array();
        }
    }

}

?>