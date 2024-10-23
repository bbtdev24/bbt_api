<?php

/**
 * 
 */
class M_Vaksin extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function getData($nik_baru = null)
	{
		$sql = "SELECT * FROM tbl_karyawan_vaksin WHERE 
		nik = '$nik_baru'";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function createvaksin($data)
	{
		$this->db_absensi->insert('tbl_karyawan_vaksin', $data);
		return $this->db_absensi->affected_rows();
	}
}
