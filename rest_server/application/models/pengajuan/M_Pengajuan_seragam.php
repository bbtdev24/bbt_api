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
		$where = " absensi.`tbl_karyawan_seragam`.`no_pengajuan` is not null";

		if ($nik_baru != '') {
			$where .= "  and absensi.`tbl_karyawan_seragam`.`nik_pengajuan` = '$nik_baru'";
		}

		if ($nik_baru === null) {
			$sql = "SELECT 
				absensi.`tbl_karyawan_seragam`.`id_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`submit_date`
				, absensi.`tbl_karyawan_seragam`.`nik_pengajuan`
				, absensi.`tbl_karyawan_seragam`.`no_pengajuan`
				, absensi.`tbl_karyawan_seragam`.`ket_pengajuan`
				, absensi.`tbl_karyawan_seragam`.`nik_baru`
				, absensi.`tbl_karyawan_seragam`.`nama_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`jabatan_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`dept_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`lokasi_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`kode_seragam`
				, absensi.`tbl_karyawan_seragam`.`nama_seragam`
				, absensi.`tbl_karyawan_seragam`.`qty_seragam`
				, absensi.`tbl_seragam`.`nama_seragam` AS uniform  
				, absensi.`tbl_karyawan_seragam`.`harga_satuan`
				, absensi.`tbl_karyawan_seragam`.`total_harga`
				, absensi.`tbl_karyawan_seragam`.`tanggal_distribusi`
				, absensi.`tbl_karyawan_seragam`.`ket_tambahan`
				, absensi.`tbl_karyawan_seragam`.`status_realisasi`
				, absensi.`tbl_karyawan_seragam`.`status_distribusi`
			FROM absensi.`tbl_karyawan_seragam` INNER JOIN absensi.`tbl_seragam`
				ON absensi.`tbl_karyawan_seragam`.`nama_seragam` = absensi.`tbl_seragam`.
				`id_seragam`";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
				absensi.`tbl_karyawan_seragam`.`id_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`submit_date`
				, absensi.`tbl_karyawan_seragam`.`nik_pengajuan`
				, absensi.`tbl_karyawan_seragam`.`no_pengajuan`
				, absensi.`tbl_karyawan_seragam`.`ket_pengajuan`
				, absensi.`tbl_karyawan_seragam`.`nik_baru`
				, absensi.`tbl_karyawan_seragam`.`nama_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`jabatan_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`dept_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`lokasi_karyawan_seragam`
				, absensi.`tbl_karyawan_seragam`.`kode_seragam`
				, absensi.`tbl_karyawan_seragam`.`nama_seragam`
				, absensi.`tbl_karyawan_seragam`.`qty_seragam`
				, absensi.`tbl_seragam`.`nama_seragam` AS uniform  
				, absensi.`tbl_karyawan_seragam`.`harga_satuan`
				, absensi.`tbl_karyawan_seragam`.`total_harga`
				, absensi.`tbl_karyawan_seragam`.`tanggal_distribusi`
				, absensi.`tbl_karyawan_seragam`.`ket_tambahan`
				, absensi.`tbl_karyawan_seragam`.`status_realisasi`
				, absensi.`tbl_karyawan_seragam`.`status_distribusi`
			FROM absensi.`tbl_karyawan_seragam` INNER JOIN absensi.`tbl_seragam`
				ON absensi.`tbl_karyawan_seragam`.`nama_seragam` = absensi.`tbl_seragam`.
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
