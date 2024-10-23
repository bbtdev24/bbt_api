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
			absensi.`tbl_karyawan_kontrak`.`id`,
			absensi.`tbl_karyawan_kontrak`.`submit_date`,
			absensi.`tbl_karyawan_kontrak`.`no_urut`,
			absensi.`tbl_karyawan_kontrak`.`nik_baru`,
			absensi.`tbl_karyawan_struktur`.`namaKaryawan`,
			absensi.`tbl_karyawan_kontrak`.`kontrak`,
			absensi.`tbl_karyawan_kontrak`.`tanggal_kontrak`,
			absensi.`tbl_karyawan_kontrak`.`start_date`,
			absensi.`tbl_karyawan_kontrak`.`end_date` 
			FROM absensi.`tbl_karyawan_kontrak` 
			INNER JOIN absensi.`tbl_karyawan_struktur` ON absensi.`tbl_karyawan_struktur`.`nip` = absensi.`tbl_karyawan_kontrak`.`nik_baru`";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
			absensi.`tbl_karyawan_kontrak`.`id`,
			absensi.`tbl_karyawan_kontrak`.`submit_date`,
			absensi.`tbl_karyawan_kontrak`.`no_urut`,
			absensi.`tbl_karyawan_kontrak`.`nik_baru`,
			absensi.`tbl_karyawan_struktur`.`namaKaryawan`,
			absensi.`tbl_karyawan_kontrak`.`kontrak`,
			absensi.`tbl_karyawan_kontrak`.`tanggal_kontrak`,
			absensi.`tbl_karyawan_kontrak`.`start_date`,
			absensi.`tbl_karyawan_kontrak`.`end_date` 
			FROM absensi.`tbl_karyawan_kontrak` 
			INNER JOIN absensi.`tbl_karyawan_struktur` ON absensi.`tbl_karyawan_struktur`.`nip` = absensi.`tbl_karyawan_kontrak`.`nik_baru`
			WHERE absensi.`tbl_karyawan_kontrak`.`nik_baru` = '$nik_baru'";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}
}
