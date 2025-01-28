<?php

/**
 * 
 */
class M_Nomor_Pengajuan extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function getFullday()
	{
		$sql = " SELECT * FROM `tbl_izin_full_day`
		ORDER BY `tbl_izin_full_day`.`id_full_day` DESC
		LIMIT 0, 1
		";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function getNonfullday()
	{
		$sql = " SELECT * FROM `tbl_izin_non_full`
		ORDER BY `tbl_izin_non_full`.`id_non_full` DESC
		LIMIT 0, 1
		";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function getCutikhusus()
	{
		$sql = " SELECT * FROM `tbl_karyawan_cuti_khusus`
		ORDER BY `tbl_karyawan_cuti_khusus`.`id_cuti_khusus` DESC
		LIMIT 0, 1";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function getCutitahunan()
	{
		$sql = " SELECT * FROM `tbl_karyawan_cuti_tahunan`
		ORDER BY `tbl_karyawan_cuti_tahunan`.`id_sisa_cuti` DESC
		LIMIT 0, 1";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function getKontrak()
	{
		$sql = " SELECT * FROM `tbl_karyawan_kontrak`
		ORDER BY `tbl_karyawan_kontrak`.`no_urut` DESC
		LIMIT 0, 1
		";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function getFullday_new()
	{
		$sql = " SELECT * FROM `tbl_izin_full_day`
		ORDER BY `tbl_izin_full_day`.`id_full_day` DESC
		LIMIT 0, 1
		";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}
}
