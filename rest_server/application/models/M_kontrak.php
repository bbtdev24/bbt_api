<?php

/**
 * 
 */
class M_Kontrak extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getKontrak()
	{
        $sql = "
            SELECT 
                `tbl_karyawan_struktur`.`nik_baru`
                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
                , `tbl_karyawan_struktur`.`lokasi_struktur`
                , `tbl_karyawan_struktur`.`perusahaan_struktur`
                , (SELECT `tbl_karyawan_kontrak`.`tanggal_kontrak`
                FROM `tbl_karyawan_kontrak`
                WHERE `tbl_karyawan_kontrak`.`nik_baru` = `tbl_karyawan_struktur`.`nik_baru`
                GROUP BY `tbl_karyawan_kontrak`.`nik_baru`) AS tanggal_kontrak
                , (SELECT `tbl_karyawan_kontrak`.`start_date`
                FROM `tbl_karyawan_kontrak`
                WHERE `tbl_karyawan_kontrak`.`nik_baru` = `tbl_karyawan_struktur`.`nik_baru`
                ORDER BY `tbl_karyawan_kontrak`.`kontrak` DESC
                LIMIT 1) AS start_date
                , (SELECT `tbl_karyawan_kontrak`.`end_date`
                FROM `tbl_karyawan_kontrak`
                WHERE `tbl_karyawan_kontrak`.`nik_baru` = `tbl_karyawan_struktur`.`nik_baru`
                ORDER BY `tbl_karyawan_kontrak`.`kontrak` DESC
                LIMIT 1) AS end_date
                , (SELECT `tbl_karyawan_kontrak`.`kontrak`
                FROM `tbl_karyawan_kontrak`
                WHERE `tbl_karyawan_kontrak`.`nik_baru` = `tbl_karyawan_struktur`.`nik_baru`
                ORDER BY `tbl_karyawan_kontrak`.`kontrak` DESC
                LIMIT 1) AS kontrak
            FROM `tbl_karyawan_struktur`
            INNER JOIN `tbl_karyawan_induk`
                ON `tbl_karyawan_struktur`.`nik_baru` = `tbl_karyawan_induk`.`nik_baru`
            INNER JOIN `tbl_jabatan_karyawan`
                ON `tbl_karyawan_struktur`.`jabatan_struktur` = `tbl_jabatan_karyawan`.`no_jabatan_karyawan`
            WHERE `tbl_karyawan_struktur`.`status_karyawan` = '0' 
            AND (`tbl_karyawan_struktur`.`status_karyawan_struktur` <> 'Tetap'
            AND (`tbl_karyawan_struktur`.`perusahaan_struktur` = 'TVIP'
            OR `tbl_karyawan_struktur`.`perusahaan_struktur` = 'ASA')
            AND `tbl_karyawan_struktur`.`nik_baru` NOT LIKE '%.%')
            GROUP BY `tbl_karyawan_struktur`.`nik_baru`
            LIMIT 100000000
        ";
        $hasil = $this->db->query($sql);
        return $hasil->result_array();

	}

}

?>