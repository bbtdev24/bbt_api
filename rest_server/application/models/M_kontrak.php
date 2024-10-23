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
                absensi_new.`tbl_karyawan_struktur`.`nik_baru`
                , absensi_new.`tbl_karyawan_struktur`.`nama_karyawan_struktur`
                , absensi_new.`tbl_jabatan_karyawan`.`jabatan_karyawan`
                , absensi_new.`tbl_karyawan_struktur`.`lokasi_struktur`
                , absensi_new.`tbl_karyawan_struktur`.`perusahaan_struktur`
                , (SELECT absensi_new.`tbl_karyawan_kontrak`.`tanggal_kontrak`
                FROM absensi_new.`tbl_karyawan_kontrak`
                WHERE absensi_new.`tbl_karyawan_kontrak`.`nik_baru` = absensi_new.`tbl_karyawan_struktur`.`nik_baru`
                GROUP BY absensi_new.`tbl_karyawan_kontrak`.`nik_baru`) AS tanggal_kontrak
                , (SELECT absensi_new.`tbl_karyawan_kontrak`.`start_date`
                FROM absensi_new.`tbl_karyawan_kontrak`
                WHERE absensi_new.`tbl_karyawan_kontrak`.`nik_baru` = absensi_new.`tbl_karyawan_struktur`.`nik_baru`
                ORDER BY absensi_new.`tbl_karyawan_kontrak`.`kontrak` DESC
                LIMIT 1) AS start_date
                , (SELECT absensi_new.`tbl_karyawan_kontrak`.`end_date`
                FROM absensi_new.`tbl_karyawan_kontrak`
                WHERE absensi_new.`tbl_karyawan_kontrak`.`nik_baru` = absensi_new.`tbl_karyawan_struktur`.`nik_baru`
                ORDER BY absensi_new.`tbl_karyawan_kontrak`.`kontrak` DESC
                LIMIT 1) AS end_date
                , (SELECT absensi_new.`tbl_karyawan_kontrak`.`kontrak`
                FROM absensi_new.`tbl_karyawan_kontrak`
                WHERE absensi_new.`tbl_karyawan_kontrak`.`nik_baru` = absensi_new.`tbl_karyawan_struktur`.`nik_baru`
                ORDER BY absensi_new.`tbl_karyawan_kontrak`.`kontrak` DESC
                LIMIT 1) AS kontrak
            FROM absensi_new.`tbl_karyawan_struktur`
            INNER JOIN absensi_new.`tbl_karyawan_induk`
                ON absensi_new.`tbl_karyawan_struktur`.`nik_baru` = absensi_new.`tbl_karyawan_induk`.`nik_baru`
            INNER JOIN absensi_new.`tbl_jabatan_karyawan`
                ON absensi_new.`tbl_karyawan_struktur`.`jabatan_struktur` = absensi_new.`tbl_jabatan_karyawan`.`no_jabatan_karyawan`
            WHERE absensi_new.`tbl_karyawan_struktur`.`status_karyawan` = '0' 
            AND (absensi_new.`tbl_karyawan_struktur`.`status_karyawan_struktur` <> 'Tetap'
            AND (absensi_new.`tbl_karyawan_struktur`.`perusahaan_struktur` = 'TVIP'
            OR absensi_new.`tbl_karyawan_struktur`.`perusahaan_struktur` = 'ASA')
            AND absensi_new.`tbl_karyawan_struktur`.`nik_baru` NOT LIKE '%.%')
            GROUP BY absensi_new.`tbl_karyawan_struktur`.`nik_baru`
            LIMIT 100000000
        ";
        $hasil = $this->db->query($sql);
        return $hasil->result_array();

	}

}

?>