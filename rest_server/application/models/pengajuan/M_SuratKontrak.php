<?php

/**
 * 
 */
class M_SuratKontrak extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function get_index_kontrak($nik_baru = null)
	{
		if ($nik_baru === null) {
			$sql = "SELECT 
			`tbl_karyawan_kontrak`.`id`,
			`tbl_karyawan_kontrak`.`submit_date`,
			`tbl_karyawan_kontrak`.`no_urut`,
			`tbl_karyawan_kontrak`.`nik_baru`,
			`tbl_karyawan_struktur`.`namaKaryawan`,
			`tbl_karyawan_kontrak`.`kontrak`,
			`tbl_karyawan_kontrak`.`tanggal_kontrak`,
			`tbl_karyawan_kontrak`.`start_date`,
			`tbl_karyawan_kontrak`.`end_date` 
			FROM `tbl_karyawan_kontrak` 
			INNER JOIN `tbl_karyawan_struktur` ON `tbl_karyawan_struktur`.`nip` = `tbl_karyawan_kontrak`.`nik_baru`";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
			`tbl_karyawan_kontrak`.`id`,
			`tbl_karyawan_kontrak`.`submit_date`,
			`tbl_karyawan_kontrak`.`no_urut`,
			`tbl_karyawan_kontrak`.`nik_baru`,
			`tbl_karyawan_struktur`.`namaKaryawan`,
			`tbl_karyawan_kontrak`.`kontrak`,
			`tbl_karyawan_kontrak`.`tanggal_kontrak`,
			`tbl_karyawan_kontrak`.`start_date`,
			`tbl_karyawan_kontrak`.`end_date` 
			FROM `tbl_karyawan_kontrak` 
			INNER JOIN `tbl_karyawan_struktur` ON `tbl_karyawan_struktur`.`nip` = `tbl_karyawan_kontrak`.`nik_baru`
			WHERE `tbl_karyawan_kontrak`.`nik_baru` = '$nik_baru'";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}
}
