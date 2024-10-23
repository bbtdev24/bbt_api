<?php

/**
 * 
 */
class M_Mutasi extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_index_mutasi($nik_baru = null, $id = null)
	{
		$where = " absensi_new.`tbl_karyawan_historical_mutasi`.`no_pengajuan` is not null";
        if ($id!='') {
            $where .= " and absensi_new.`tbl_karyawan_historical_mutasi`.`id_mutasi_rotasi` = '$id'";
        }
        if ($nik_baru!='') {
            $where .= "  and absensi_new.`tbl_karyawan_historical_mutasi`.`nik_pengajuan` = '$nik_baru'";
        }

		if ($nik_baru === null and $id === null) {
			$sql="SELECT 
				absensi_new.`tbl_karyawan_historical_mutasi`.`id_mutasi_rotasi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`no_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`opsi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nama_karyawan_mutasi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`pt_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`dept_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`level_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`permintaan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`pt_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`dept_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru`
				, absensi_new.`tbl_jabatan_karyawan`.`jabatan_karyawan` AS `nama_jabatan_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`level_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`rekomendasi_tanggal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_atasan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_approval`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_1`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_dokumen`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_lama`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_manager`
			FROM absensi_new.`tbl_karyawan_historical_mutasi` INNER JOIN absensi_new.`tbl_jabatan_karyawan`
				ON absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru` = absensi_new.`tbl_jabatan_karyawan`.`no_jabatan_karyawan`" ;
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		} else {
			$sql="SELECT 
				absensi_new.`tbl_karyawan_historical_mutasi`.`id_mutasi_rotasi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`no_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`opsi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nama_karyawan_mutasi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`pt_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`dept_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`level_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`permintaan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`pt_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`dept_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru`
				, absensi_new.`tbl_jabatan_karyawan`.`jabatan_karyawan` AS `nama_jabatan_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`level_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`rekomendasi_tanggal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_atasan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_approval`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_1`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_dokumen`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_lama`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_manager`
			FROM absensi_new.`tbl_karyawan_historical_mutasi` INNER JOIN absensi_new.`tbl_jabatan_karyawan`
				ON absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru` = absensi_new.`tbl_jabatan_karyawan`.`no_jabatan_karyawan`
			WHERE $where";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		}
	}

	public function createMutasi($data)
	{
		$this->db2->insert('tbl_karyawan_historical_mutasi', $data);
		return $this->db2->affected_rows();
	}

	public function updateApproval($data, $id)
	{
		$this->db2->update('tbl_karyawan_historical_mutasi', $data, ['id_mutasi_rotasi' => $id]);
		return $this->db2->affected_rows();
	}

	public function get_index_Mutasi_atasan($jabatan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($jabatan === null) {
			$sql = "SELECT
		        absensi_new.`tbl_karyawan_historical_mutasi`.`id_mutasi_rotasi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`no_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`opsi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nama_karyawan_mutasi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`pt_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`dept_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`level_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`permintaan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`pt_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`dept_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru`
				, absensi_new.`tbl_jabatan_karyawan`.`jabatan_karyawan` AS `nama_jabatan_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`level_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`rekomendasi_tanggal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_atasan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_approval`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_1`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_dokumen`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_lama`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_manager`
			FROM absensi_new.`tbl_karyawan_historical_mutasi` INNER JOIN absensi_new.`tbl_jabatan_karyawan`
				ON absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru` = absensi_new.`tbl_jabatan_karyawan`.`no_jabatan_karyawan`";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else {
			$sql = "SELECT
		        absensi_new.`tbl_karyawan_historical_mutasi`.`id_mutasi_rotasi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`no_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`opsi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nama_karyawan_mutasi`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`pt_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`dept_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`level_awal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`permintaan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`pt_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`dept_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru`
				, absensi_new.`tbl_jabatan_karyawan`.`jabatan_karyawan` AS `nama_jabatan_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`level_baru`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`rekomendasi_tanggal`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_atasan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_approval`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_1`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_dokumen`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_pengajuan`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`nik_lama`
				, absensi_new.`tbl_karyawan_historical_mutasi`.`status_manager`
		    FROM `absensi_new`.`tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_historical_mutasi`
		            ON tbl_karyawan_historical_mutasi.`jabatan_pengajuan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_historical_mutasi.`nik_pengajuan`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		}
	}

	// manager //

	public function get_index_Mutasi_manager($kondisi = null, $date1 = null, $date2 = null)
	{
		$sql = "SELECT 
				  absensi_new.`tbl_karyawan_historical_mutasi`.`id_mutasi_rotasi`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_pengajuan`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`nik_pengajuan`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_pengajuan`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_pengajuan`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`nik_baru`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`no_pengajuan`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`opsi`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`nama_karyawan_mutasi`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`pt_awal`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`dept_awal`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_awal`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_awal`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`level_awal`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`permintaan`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`pt_baru`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`dept_baru`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`lokasi_baru`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru`,
				  absensi_new.`tbl_jabatan_karyawan`.`jabatan_karyawan` AS `nama_jabatan_baru`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`level_baru`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`rekomendasi_tanggal`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`status_atasan`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_approval`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`status_1`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`status_dokumen`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`status_pengajuan`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`nik_lama`,
				  absensi_new.`tbl_karyawan_historical_mutasi`.`status_manager` 
				FROM
				  absensi_new.`tbl_karyawan_historical_mutasi` 
				  INNER JOIN absensi_new.`tbl_jabatan_karyawan` 
				    ON absensi_new.`tbl_karyawan_historical_mutasi`.`jabatan_baru` = absensi_new.`tbl_jabatan_karyawan`.`no_jabatan_karyawan` 
				WHERE DATE(
				    absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_pengajuan`
				  ) BETWEEN '$date1' 
				  AND '$date2' 
				  AND absensi_new.`tbl_karyawan_historical_mutasi`.`status_manager` = '$kondisi'
				  AND absensi_new.`tbl_karyawan_historical_mutasi`.`status_atasan` = '1'
				  ORDER BY DATE(absensi_new.`tbl_karyawan_historical_mutasi`.`tanggal_pengajuan`) DESC ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		
	}

	public function get_NoUrut($nik_baru = null)
	{
		$sql = "SELECT 
				  * 
				FROM
				  `tbl_karyawan_struktur` a 
				WHERE a.`nik_baru` = '$nik_baru' 
				  AND a.`status_karyawan` = '0' ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
	}
}

?>