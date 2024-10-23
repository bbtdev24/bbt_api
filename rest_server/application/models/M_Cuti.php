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
			$this->db_absensi->select('absensi.tbl_hak_cuti.*, absensi.tbl_karyawan_struktur.nip');
			$this->db_absensi->from('absensi.tbl_hak_cuti');
			$this->db_absensi->join('absensi.tbl_karyawan_struktur', 'absensi.tbl_karyawan_struktur.noUrut = absensi.tbl_hak_cuti.no_urut', 'left');

			$get = $this->db_absensi->get();
			return $get->result_array();
		} else {
			$this->db_absensi->select('absensi.tbl_hak_cuti.*, absensi.tbl_karyawan_struktur.nip');
			$this->db_absensi->from('absensi.tbl_hak_cuti');
			$this->db_absensi->join('absensi.tbl_karyawan_struktur', 'absensi.tbl_karyawan_struktur.noUrut = absensi.tbl_hak_cuti.no_urut', 'left');
			$this->db_absensi->where(['absensi.tbl_karyawan_struktur.nip' => $id]);

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
					FROM 
						absensi.tbl_hak_cuti a 
						LEFT JOIN absensi.tbl_karyawan_struktur b 
						ON b.noUrut = a.no_urut
					WHERE 
						a.tahun = '$currentYear'";
		} else {
			$sql = "SELECT 
						a.*, 
						b.nip 
					FROM 
						absensi.tbl_hak_cuti a 
						LEFT JOIN absensi.tbl_karyawan_struktur b 
						ON b.noUrut = a.no_urut 
					WHERE 
						b.nip = '$id' 
						AND a.tahun = '$currentYear'";
		}

		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

}
