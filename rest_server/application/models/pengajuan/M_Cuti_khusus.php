<?php

/**
 * 
 */
class M_Cuti_khusus extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function get_index_cuti_khusus($nik_baru = null, $id = null)
	{
		$where = " `tbl_karyawan_cuti_khusus`.`no_pengajuan_khusus` is not null";
		if ($id != '') {
			$where .= " and `tbl_karyawan_cuti_khusus`.`id_cuti_khusus` = '$id'";
		}
		if ($nik_baru != '') {
			$where .= "  and `tbl_karyawan_cuti_khusus`.`nik_cuti_khusus` = '$nik_baru'";
		}

		if ($nik_baru === null and $id === null) {
			$sql = "SELECT 
				`tbl_karyawan_cuti_khusus`.`id_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`no_pengajuan_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
				, `tbl_karyawan_cuti_khusus`.`nik_cuti_khusus` AS nik_baru
				, `tbl_karyawan_cuti_khusus`.`jabatan_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`jenis_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`kondisi`
				, `tbl_karyawan_cuti_khusus`.`start_cuti_khusus` AS tanggal_absen
				, `tbl_karyawan_cuti_khusus`.`ket_tambahan_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`dokumen_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`lat`
				, `tbl_karyawan_cuti_khusus`.`lon`
			FROM `tbl_karyawan_cuti_khusus`
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
				`tbl_karyawan_cuti_khusus`.`id_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`no_pengajuan_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
				, `tbl_karyawan_cuti_khusus`.`nik_cuti_khusus` AS nik_baru
				, `tbl_karyawan_cuti_khusus`.`jabatan_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`jenis_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`kondisi`
				, `tbl_karyawan_cuti_khusus`.`start_cuti_khusus` AS tanggal_absen
				, `tbl_karyawan_cuti_khusus`.`ket_tambahan_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`dokumen_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`lat`
				, `tbl_karyawan_cuti_khusus`.`lon`
			FROM `tbl_karyawan_cuti_khusus`
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}

	public function createCuti_khusus($data)
	{
		$this->db_absensi->insert('tbl_karyawan_cuti_khusus', $data);
		return $this->db_absensi->affected_rows();
	}

	public function updateApproval($data, $id)
	{
		$this->db_absensi->update('tbl_karyawan_cuti_khusus', $data, ['id_cuti_khusus' => $id]);
		return $this->db_absensi->affected_rows();
	}

	public function update_data($data, $shift_day, $badgenumber, $status)
	{
		if ($status == 1) {
			$this->db_absensi->update('tarikan_absen_adms', $data, ['shift_day' => $shift_day, 'badgenumber' => $badgenumber]);
			return $this->db_absensi->affected_rows();
		}
	}

	public function get_index_cuti_khusus_atasan($jabatan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($jabatan === null) {
			$sql = "
	            SELECT
		            tbl_karyawan_cuti_khusus.`id_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`no_pengajuan_khusus`
		            ,tbl_karyawan_cuti_khusus.`tanggal_pengajuan`
		            ,tbl_karyawan_cuti_khusus.`nik_cuti_khusus`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_karyawan_cuti_khusus.`jenis_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`kondisi`
		            ,tbl_karyawan_cuti_khusus.`start_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`end_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`ket_tambahan_khusus`
		            ,tbl_karyawan_cuti_khusus.`status_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`feedback_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`status_cuti_khusus_2`
		            ,tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus_2`
		            ,tbl_karyawan_cuti_khusus.`feedback_cuti_khusus_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_cuti_khusus`
		            ON tbl_karyawan_cuti_khusus.`jabatan_cuti_khusus` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_khusus.`nik_cuti_khusus`
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "
	            SELECT
		            tbl_karyawan_cuti_khusus.`id_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`no_pengajuan_khusus`
		            ,tbl_karyawan_cuti_khusus.`tanggal_pengajuan`
		            ,tbl_karyawan_cuti_khusus.`nik_cuti_khusus`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_karyawan_cuti_khusus.`jenis_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`kondisi`
		            ,tbl_karyawan_cuti_khusus.`start_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`end_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`ket_tambahan_khusus`
		            ,tbl_karyawan_cuti_khusus.`status_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`feedback_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`status_cuti_khusus_2`
		            ,tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus_2`
		            ,tbl_karyawan_cuti_khusus.`feedback_cuti_khusus_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_cuti_khusus`
		            ON tbl_karyawan_cuti_khusus.`jabatan_cuti_khusus` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_khusus.`nik_cuti_khusus`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ORDER BY tbl_karyawan_cuti_khusus.`id_cuti_khusus` DESC";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_index_keterangan($keterangan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($keterangan === null) {
			$sql = "SELECT * FROM tbl_cuti_khusus";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT * FROM tbl_cuti_khusus WHERE kondisi_cuti_khusus = '$keterangan'";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_index_khusus_atasan_lokasi($jabatan = null, $lokasi = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($lokasi == 'Pusat') {
			$sql = "
	           SELECT
		            tbl_karyawan_cuti_khusus.`id_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`no_pengajuan_khusus`
		            ,tbl_karyawan_cuti_khusus.`tanggal_pengajuan`
		            ,tbl_karyawan_cuti_khusus.`nik_cuti_khusus`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_karyawan_cuti_khusus.`jenis_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`kondisi`
		            ,tbl_karyawan_cuti_khusus.`start_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`end_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`ket_tambahan_khusus`
		            ,tbl_karyawan_cuti_khusus.`status_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`feedback_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`status_cuti_khusus_2`
		            ,tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus_2`
		            ,tbl_karyawan_cuti_khusus.`feedback_cuti_khusus_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_cuti_khusus`
		            ON tbl_karyawan_cuti_khusus.`jabatan_cuti_khusus` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_khusus.`nik_cuti_khusus`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "
	           SELECT
		            tbl_karyawan_cuti_khusus.`id_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`no_pengajuan_khusus`
		            ,tbl_karyawan_cuti_khusus.`tanggal_pengajuan`
		            ,tbl_karyawan_cuti_khusus.`nik_cuti_khusus`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_karyawan_cuti_khusus.`jenis_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`kondisi`
		            ,tbl_karyawan_cuti_khusus.`start_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`end_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`ket_tambahan_khusus`
		            ,tbl_karyawan_cuti_khusus.`status_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`feedback_cuti_khusus`
		            ,tbl_karyawan_cuti_khusus.`status_cuti_khusus_2`
		            ,tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus_2`
		            ,tbl_karyawan_cuti_khusus.`feedback_cuti_khusus_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_cuti_khusus`
		            ON tbl_karyawan_cuti_khusus.`jabatan_cuti_khusus` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_khusus.`nik_cuti_khusus`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
		            AND tbl_karyawan_struktur.`lokasi_struktur` = '$lokasi'
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_index_khusus_feedback($nik_baru = null, $tanggal = null)
	{
		$sql = "SELECT 
				`tbl_karyawan_cuti_khusus`.`id_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`no_pengajuan_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
				, `tbl_karyawan_cuti_khusus`.`nik_cuti_khusus` AS nik_baru
				, `tbl_karyawan_cuti_khusus`.`jabatan_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`jenis_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`kondisi`
				, `tbl_karyawan_cuti_khusus`.`start_cuti_khusus` AS tanggal_absen
				, `tbl_karyawan_cuti_khusus`.`ket_tambahan_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`dokumen_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`lat`
				, `tbl_karyawan_cuti_khusus`.`lon`
			FROM `tbl_karyawan_cuti_khusus`
		WHERE nik_cuti_khusus = '$nik_baru' AND tanggal_approval_cuti_khusus = '$tanggal'";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function get_index_groupby_cuti_khusus($nik_baru = null)
	{
		$sql = "SELECT 
				`tbl_karyawan_cuti_khusus`.`id_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`no_pengajuan_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
				, `tbl_karyawan_cuti_khusus`.`nik_cuti_khusus` AS nik_baru
				, `tbl_karyawan_cuti_khusus`.`jabatan_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`jenis_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`kondisi`
				, `tbl_karyawan_cuti_khusus`.`start_cuti_khusus` AS tanggal_absen
				, `tbl_karyawan_cuti_khusus`.`ket_tambahan_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`dokumen_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`lat`
				, `tbl_karyawan_cuti_khusus`.`lon`
			FROM `tbl_karyawan_cuti_khusus`
			WHERE `tbl_karyawan_cuti_khusus`.`nik_cuti_khusus` = '$nik_baru'
			GROUP BY `tbl_karyawan_cuti_khusus`.`no_pengajuan_khusus`";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function get_index_khusus_approval($nik_baru = null, $no_pengajuan_khusus = null)
	{
		$sql = "SELECT 
				`tbl_karyawan_cuti_khusus`.`id_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`no_pengajuan_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan`
				, `tbl_karyawan_cuti_khusus`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
				, `tbl_karyawan_cuti_khusus`.`nik_cuti_khusus` AS nik_baru
				, `tbl_karyawan_cuti_khusus`.`jabatan_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`jenis_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`kondisi`
				, `tbl_karyawan_cuti_khusus`.`start_cuti_khusus` AS tanggal_absen
				, `tbl_karyawan_cuti_khusus`.`ket_tambahan_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`status_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`tanggal_approval_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`feedback_cuti_khusus_2`
				, `tbl_karyawan_cuti_khusus`.`dokumen_cuti_khusus`
				, `tbl_karyawan_cuti_khusus`.`lat`
				, `tbl_karyawan_cuti_khusus`.`lon`
			FROM `tbl_karyawan_cuti_khusus`
		WHERE nik_cuti_khusus = '$nik_baru' AND no_pengajuan_khusus = '$no_pengajuan_khusus'";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}


	public function get_index_cuti_khusus_atasan_new($id_divisi = null, $id_bagian = null, $jabatan = null)
    {
        $sql = "SELECT 
				tbl_karyawan_cuti_khusus.`id_cuti_khusus`,
				tbl_karyawan_cuti_khusus.`no_pengajuan_khusus`,
				tbl_karyawan_cuti_khusus.`tanggal_pengajuan`,
				tbl_karyawan_cuti_khusus.`nik_cuti_khusus`,
				tbl_karyawan_struktur.namaKaryawan AS nama_karyawan_struktur,
				tbl_jabatan.`jabatanKaryawan`,
				tbl_karyawan_struktur.`idLokasiHrd` AS lokasi_struktur,
				tbl_karyawan_cuti_khusus.`jenis_cuti_khusus`,
				tbl_karyawan_cuti_khusus.`kondisi`,
				tbl_karyawan_cuti_khusus.`start_cuti_khusus`,
				tbl_karyawan_cuti_khusus.`end_cuti_khusus`,
				tbl_karyawan_cuti_khusus.`ket_tambahan_khusus`,
				tbl_karyawan_cuti_khusus.`status_cuti_khusus`,
				tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus`,
				tbl_karyawan_cuti_khusus.`feedback_cuti_khusus`,
				tbl_karyawan_cuti_khusus.`status_cuti_khusus_2`,
				tbl_karyawan_cuti_khusus.`tanggal_approval_cuti_khusus_2`,
				tbl_karyawan_cuti_khusus.`feedback_cuti_khusus_2` 
				FROM
				`tbl_jabatan_approval` 
				INNER JOIN `tbl_jabatan` 
					ON tbl_jabatan.`idJabatan` = tbl_jabatan_approval.`idJabatan` 
				INNER JOIN `tbl_karyawan_cuti_khusus` 
					ON tbl_karyawan_cuti_khusus.`jabatan_cuti_khusus` = tbl_jabatan_approval.`idJabatan` 
				INNER JOIN `tbl_karyawan_struktur` 
					ON tbl_karyawan_struktur.`nip` = tbl_karyawan_cuti_khusus.`nik_cuti_khusus` 
				WHERE (
					tbl_karyawan_struktur.idDivisi = '$id_divisi' 
					OR tbl_karyawan_struktur.idBagian = '$id_bagian'
				) 
				AND (
					tbl_jabatan_approval.idJabatanAtasan1 = '$jabatan' 
					OR tbl_jabatan_approval.idJabatanAtasan2 = '$jabatan'
				) 
				ORDER BY tbl_karyawan_cuti_khusus.`id_cuti_khusus` DESC";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }
}
