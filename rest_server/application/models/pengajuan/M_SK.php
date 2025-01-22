<?php

/**
 * 
 */
class M_SK extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function get_index_sk($nik_baru = null, $id = null)
	{
		$where = " `tbl_karyawan_sk`.`no_urut` is not null";
		if ($id != '') {
			$where .= " and `tbl_karyawan_sk`.`id` = '$id'";
		}
		if ($nik_baru != '') {
			$where .= "  and `tbl_karyawan_sk`.`nik_baru` = '$nik_baru'";
		}
		if ($nik_baru === null and $id === null) {
			$sql = "SELECT 
				`tbl_karyawan_sk`.`id`
				, `tbl_karyawan_sk`.`submit_date`
				, `tbl_karyawan_sk`.`no_urut`
				, `tbl_karyawan_sk`.`nik_baru`
				, `tbl_karyawan_sk`.`jabatan_karyawan`
				, `tbl_karyawan_sk`.`keperluan`
				, `tbl_karyawan_sk`.`analisa`
				, `tbl_karyawan_sk`.`status_atasan`
				, `tbl_karyawan_sk`.`status_hrd`
			FROM `tbl_karyawan_sk`";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
				`tbl_karyawan_sk`.`id`
				, `tbl_karyawan_sk`.`submit_date`
				, `tbl_karyawan_sk`.`no_urut`
				, `tbl_karyawan_sk`.`nik_baru`
				, `tbl_karyawan_sk`.`jabatan_karyawan`
				, `tbl_karyawan_sk`.`keperluan`
				, `tbl_karyawan_sk`.`analisa`
				, `tbl_karyawan_sk`.`status_atasan`
				, `tbl_karyawan_sk`.`status_hrd`
			FROM `tbl_karyawan_sk`
			where $where";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_index_SK_atasan($jabatan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($jabatan === null) {
			$sql = "
	            SELECT
		           	`tbl_karyawan_sk`.`id`
					, `tbl_karyawan_sk`.`submit_date`
					, `tbl_karyawan_sk`.`no_urut`
					, `tbl_karyawan_sk`.`nik_baru`
					, `tbl_karyawan_sk`.`jabatan_karyawan`
					, `tbl_karyawan_sk`.`keperluan`
					, `tbl_karyawan_sk`.`analisa`
					, `tbl_karyawan_sk`.`status_atasan`
					, `tbl_karyawan_sk`.`status_hrd`
			        , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
		            , tbl_jabatan_karyawan.`jabatan_karyawan`
		            , tbl_karyawan_struktur.`jabatan_struktur`
		            , tbl_karyawan_struktur.`lokasi_struktur`
		           
		        FROM `tbl_jabatan_karyawan_approva`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_sk`
		            ON tbl_karyawan_sk.`jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_sk.`nik_baru`
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else if ($jabatan === '253') {
			$sql = "
	            SELECT
		            `tbl_karyawan_sk`.`id`
					, `tbl_karyawan_sk`.`submit_date`
					, `tbl_karyawan_sk`.`no_urut`
					, `tbl_karyawan_sk`.`nik_baru`
					, `tbl_karyawan_sk`.`jabatan_karyawan`
					, `tbl_karyawan_sk`.`keperluan`
					, `tbl_karyawan_sk`.`analisa`
					, `tbl_karyawan_sk`.`status_atasan`
					, `tbl_karyawan_sk`.`status_hrd`
					, tbl_karyawan_struktur.`nama_karyawan_struktur`
					, tbl_jabatan_karyawan.`jabatan_karyawan`
					, tbl_karyawan_struktur.`jabatan_struktur`
					, 'Pusat' AS lokasi_struktur
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_sk`
		            ON tbl_karyawan_sk.`jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_sk.`nik_baru`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='253' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='253')
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "
	            SELECT
		            `tbl_karyawan_sk`.`id`
					, `tbl_karyawan_sk`.`submit_date`
					, `tbl_karyawan_sk`.`no_urut`
					, `tbl_karyawan_sk`.`nik_baru`
					, `tbl_karyawan_sk`.`jabatan_karyawan`
					, `tbl_karyawan_sk`.`keperluan`
					, `tbl_karyawan_sk`.`analisa`
					, `tbl_karyawan_sk`.`status_atasan`
					, `tbl_karyawan_sk`.`status_hrd`
			        , tbl_karyawan_struktur.`nama_karyawan_struktur`
		            , tbl_jabatan_karyawan.`jabatan_karyawan`
		            , tbl_karyawan_struktur.`jabatan_struktur`
		            , tbl_karyawan_struktur.`lokasi_struktur`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_sk`
		            ON tbl_karyawan_sk.`jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_sk.`nik_baru`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}

	public function createSK($data)
	{
		$this->db_absensi->insert('tbl_karyawan_sk', $data);
		return $this->db_absensi->affected_rows();
	}

	public function updateApproval($data, $id)
	{
		$this->db_absensi->update('tbl_karyawan_sk', $data, ['id' => $id]);
		return $this->db_absensi->affected_rows();
	}

	//---------------------------------------------------------------------

	public function get_index_pengajuan_sk($nik_baru = null, $id = null)
	{
		$where = " `tbl_karyawan_sk`.`no_urut` is not null";
		if ($id != '') {
			$where .= " and `tbl_karyawan_sk`.`id` = '$id'";
		}
		if ($nik_baru != '') {
			$where .= "  and `tbl_karyawan_sk`.`nik_baru` = '$nik_baru'";
		}
		if ($nik_baru === null and $id === null) {
			$sql = "SELECT 
				`tbl_karyawan_sk`.`id`
				, `tbl_karyawan_sk`.`submit_date`
				, `tbl_karyawan_sk`.`no_urut`
				, `tbl_karyawan_sk`.`nik_baru`
				, `tbl_karyawan_sk`.`jabatan_karyawan`
				, `tbl_karyawan_sk`.`keperluan`
				, `tbl_karyawan_sk`.`analisa`
				, `tbl_karyawan_sk`.`status_atasan`
				, `tbl_karyawan_sk`.`status_hrd`
			FROM `tbl_karyawan_sk`";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
				`tbl_karyawan_sk`.`id`
				, `tbl_karyawan_sk`.`submit_date`
				, `tbl_karyawan_sk`.`no_urut`
				, `tbl_karyawan_sk`.`nik_baru`
				, `tbl_karyawan_sk`.`jabatan_karyawan`
				, `tbl_karyawan_sk`.`keperluan`
				, `tbl_karyawan_sk`.`analisa`
				, `tbl_karyawan_sk`.`status_atasan`
				, `tbl_karyawan_sk`.`status_hrd`
			FROM `tbl_karyawan_sk`
			where $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_last_nomor_pengajuan_sk()
	{
		$sql = "SELECT `tbl_karyawan_sk`.`no_urut` 
		FROM `tbl_karyawan_sk`
		ORDER BY `tbl_karyawan_sk`.`no_urut`  DESC
		LIMIT 0, 1";

		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function post_pengajuan_sk($data)
	{
		$this->db_absensi->insert('tbl_karyawan_sk', $data);
		return $this->db_absensi->affected_rows();
	}

	public function get_index_sk_approval_atasan_new($id_divisi = null, $id_bagian = null, $jabatan = null)
    {
        $sql = "SELECT 
				`tbl_karyawan_sk`.`id`,
				`tbl_karyawan_sk`.`submit_date`,
				`tbl_karyawan_sk`.`no_urut`,
				`tbl_karyawan_sk`.`nik_baru`,
				`tbl_karyawan_sk`.`jabatan_karyawan`,
				`tbl_karyawan_sk`.`keperluan`,
				`tbl_karyawan_sk`.`analisa`,
				`tbl_karyawan_sk`.`status_atasan`,
				`tbl_karyawan_sk`.`status_hrd`,
				tbl_karyawan_struktur.namaKaryawan AS nama_karyawan_struktur,
				tbl_jabatan.`jabatanKaryawan`,
				tbl_karyawan_struktur.`idLokasiHrd` AS lokasi_struktur
				FROM
				`tbl_jabatan_approval` 
				INNER JOIN `tbl_jabatan` 
					ON tbl_jabatan.`idJabatan` = tbl_jabatan_approval.`idJabatan` 
				INNER JOIN `tbl_karyawan_sk` 
					ON tbl_karyawan_sk.`jabatan_karyawan` = tbl_jabatan_approval.`idJabatan` 
				INNER JOIN `tbl_karyawan_struktur` 
					ON tbl_karyawan_struktur.`nip` = tbl_karyawan_sk.`nik_baru` 
				WHERE (
					tbl_karyawan_struktur.idDivisi = '$id_divisi' 
					OR tbl_karyawan_struktur.idBagian = '$id_bagian'
				) 
				AND (
					tbl_jabatan_approval.idJabatanAtasan1 = '$jabatan' 
					OR tbl_jabatan_approval.idJabatanAtasan2 = '$jabatan')";
        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }
}
