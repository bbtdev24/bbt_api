<?php

/**
 * 
 */
class M_Cuti extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function getCuti_old($id = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($id === null) {
			$this->db_absensi->select('tbl_hak_cuti.*, tbl_karyawan_struktur.nip');
			$this->db_absensi->from('tbl_hak_cuti');
			$this->db_absensi->join('tbl_karyawan_struktur', 'tbl_karyawan_struktur.noUrut = tbl_hak_cuti.no_urut', 'left');

			$get = $this->db_absensi->get();
			return $get->result_array();
		} else {
			$this->db_absensi->select('tbl_hak_cuti.*, tbl_karyawan_struktur.nip');
			$this->db_absensi->from('tbl_hak_cuti');
			$this->db_absensi->join('tbl_karyawan_struktur', 'tbl_karyawan_struktur.noUrut = tbl_hak_cuti.no_urut', 'left');
			$this->db_absensi->where(['tbl_karyawan_struktur.nip' => $id]);

			$get = $this->db_absensi->get();
			return $get->result_array();
		}
	}

	public function getCuti($id = null)
	{
		$currentYear = date('Y'); // Mendapatkan tahun berjalan

		if ($id === null) {

			$sql = "SELECT 
						a.*, 
						b.nip 
					FROM tbl_hak_cuti a LEFT JOIN tbl_karyawan_struktur b ON b.`nip` = a.`nik_sisa_cuti` 
					WHERE a.tahun = '$currentYear'";
		} else {

			$sql = "SELECT 
						a.*, 
						b.nip 
					FROM tbl_hak_cuti a LEFT JOIN tbl_karyawan_struktur b ON b.`nip` = a.`nik_sisa_cuti`
					WHERE b.nip = '$id' AND a.tahun = '$currentYear'";
		}

		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

}
