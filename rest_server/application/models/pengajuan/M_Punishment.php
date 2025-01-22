<?php

/**
 * 
 */
class M_Punishment extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function get_index_punishment($nik_baru = null)
	{
		if ($nik_baru === null) {
			$sql = "SELECT 
				`tbl_karyawan_historical_violance`.`id_historical_violance`
				, `tbl_karyawan_historical_violance`.`submit_date`
				, `tbl_karyawan_historical_violance`.`user_submit` 
				, `tbl_karyawan_historical_violance`.`no_surat`
				, `tbl_karyawan_historical_violance`.`nik_baru`
				, `tbl_karyawan_historical_violance`.`nama_karyawan_violance`
				, `tbl_karyawan_historical_violance`.`jabatan_historical_violance`
				, `tbl_karyawan_historical_violance`.`rekomondasi_historical_violance`
				, `tbl_karyawan_historical_violance`.`pelanggaran_historical_violance`
				, `tbl_karyawan_historical_violance`.`punishment_historical_violance` 
				, `tbl_karyawan_historical_violance`.`tanggal_surat`
				, `tbl_karyawan_historical_violance`.`warning_start_historical_violance`
				, `tbl_karyawan_historical_violance`.`warning_end_historical_violance`
				, `tbl_karyawan_historical_violance`.`tanggal_notif`
				, `tbl_karyawan_historical_violance`.`warning_note_historical_violance`
				, `tbl_karyawan_historical_violance`.`status_dokumen`
				, `tbl_karyawan_historical_violance`.`dokumen_historical_violance`
			FROM `tbl_karyawan_historical_violance`";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
				`tbl_karyawan_historical_violance`.`id_historical_violance`
				, `tbl_karyawan_historical_violance`.`submit_date`
				, `tbl_karyawan_historical_violance`.`user_submit` 
				, `tbl_karyawan_historical_violance`.`no_surat`
				, `tbl_karyawan_historical_violance`.`nik_baru`
				, `tbl_karyawan_historical_violance`.`nama_karyawan_violance`
				, `tbl_karyawan_historical_violance`.`jabatan_historical_violance`
				, `tbl_karyawan_historical_violance`.`rekomondasi_historical_violance`
				, `tbl_karyawan_historical_violance`.`pelanggaran_historical_violance`
				, `tbl_karyawan_historical_violance`.`punishment_historical_violance` 
				, `tbl_karyawan_historical_violance`.`tanggal_surat`
				, `tbl_karyawan_historical_violance`.`warning_start_historical_violance`
				, `tbl_karyawan_historical_violance`.`warning_end_historical_violance`
				, `tbl_karyawan_historical_violance`.`tanggal_notif`
				, `tbl_karyawan_historical_violance`.`warning_note_historical_violance`
				, `tbl_karyawan_historical_violance`.`status_dokumen`
				, `tbl_karyawan_historical_violance`.`dokumen_historical_violance`
			FROM `tbl_karyawan_historical_violance`
			where `tbl_karyawan_historical_violance`.`nik_baru` = '$nik_baru'";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}
}
