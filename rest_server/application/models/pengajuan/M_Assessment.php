<?php

/**
 * 
 */
class M_Assessment extends CI_Model
{

	public function __construct()
	{
		# code...
	}


	public function createAssesment($data)
	{
		$this->db_absensi->insert('tbl_self_covid', $data);
		return $this->db_absensi->affected_rows();
	}

	public function get_count($nik_baru = null, $tanggal = null)
	{
		$sql = "SELECT SUM(b.`bobot`) AS hasil
				FROM `tbl_self_covid` `a`
				INNER JOIN `tbl_jawaban_covid` `b` ON a.`id_jawaban` = b.`id`
				WHERE a.`nik_baru` = '$nik_baru'
				AND DATE(a.submit_date) = '$tanggal'";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function getSoal()
	{
		$sql = "SELECT * FROM tbl_pertanyaan_covid";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function getJawaban($id = null)
	{
		$sql = "SELECT * FROM tbl_jawaban_covid WHERE no_pertanyaan = '$id'";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}
}
