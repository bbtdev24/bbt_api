<?php

/**
 * 
 */
class M_Pengajuan_seragam extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function get_index_seragam($nik_baru = null)
	{
		$where = " `tbl_karyawan_seragam`.`no_pengajuan` is not null";

		if ($nik_baru != '') {
			$where .= "  and `tbl_karyawan_seragam`.`nik_pengajuan` = '$nik_baru'";
		}

		if ($nik_baru === null) {
			$sql = "SELECT 
				`tbl_karyawan_seragam`.`id_karyawan_seragam`
				, `tbl_karyawan_seragam`.`submit_date`
				, `tbl_karyawan_seragam`.`nik_pengajuan`
				, `tbl_karyawan_seragam`.`no_pengajuan`
				, `tbl_karyawan_seragam`.`ket_pengajuan`
				, `tbl_karyawan_seragam`.`nik_baru`
				, `tbl_karyawan_seragam`.`nama_karyawan_seragam`
				, `tbl_karyawan_seragam`.`jabatan_karyawan_seragam`
				, `tbl_karyawan_seragam`.`dept_karyawan_seragam`
				, `tbl_karyawan_seragam`.`lokasi_karyawan_seragam`
				, `tbl_karyawan_seragam`.`kode_seragam`
				, `tbl_karyawan_seragam`.`nama_seragam`
				, `tbl_karyawan_seragam`.`qty_seragam`
				, `tbl_seragam`.`nama_seragam` AS uniform  
				, `tbl_karyawan_seragam`.`harga_satuan`
				, `tbl_karyawan_seragam`.`total_harga`
				, `tbl_karyawan_seragam`.`tanggal_distribusi`
				, `tbl_karyawan_seragam`.`ket_tambahan`
				, `tbl_karyawan_seragam`.`status_realisasi`
				, `tbl_karyawan_seragam`.`status_distribusi`
			FROM `tbl_karyawan_seragam` INNER JOIN `tbl_seragam`
				ON `tbl_karyawan_seragam`.`nama_seragam` = `tbl_seragam`.
				`id_seragam`";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
				`tbl_karyawan_seragam`.`id_karyawan_seragam`
				, `tbl_karyawan_seragam`.`submit_date`
				, `tbl_karyawan_seragam`.`nik_pengajuan`
				, `tbl_karyawan_seragam`.`no_pengajuan`
				, `tbl_karyawan_seragam`.`ket_pengajuan`
				, `tbl_karyawan_seragam`.`nik_baru`
				, `tbl_karyawan_seragam`.`nama_karyawan_seragam`
				, `tbl_karyawan_seragam`.`jabatan_karyawan_seragam`
				, `tbl_karyawan_seragam`.`dept_karyawan_seragam`
				, `tbl_karyawan_seragam`.`lokasi_karyawan_seragam`
				, `tbl_karyawan_seragam`.`kode_seragam`
				, `tbl_karyawan_seragam`.`nama_seragam`
				, `tbl_karyawan_seragam`.`qty_seragam`
				, `tbl_seragam`.`nama_seragam` AS uniform  
				, `tbl_karyawan_seragam`.`harga_satuan`
				, `tbl_karyawan_seragam`.`total_harga`
				, `tbl_karyawan_seragam`.`tanggal_distribusi`
				, `tbl_karyawan_seragam`.`ket_tambahan`
				, `tbl_karyawan_seragam`.`status_realisasi`
				, `tbl_karyawan_seragam`.`status_distribusi`
			FROM `tbl_karyawan_seragam` INNER JOIN `tbl_seragam`
				ON `tbl_karyawan_seragam`.`nama_seragam` = `tbl_seragam`.
				`id_seragam` 
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}

	public function createPengajuan($data)
	{
		$this->db_absensi->insert('tbl_karyawan_seragam', $data);
		return $this->db_absensi->affected_rows();
	}
}
