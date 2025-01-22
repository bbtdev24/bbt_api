<?php

/**
 * 
 */
class M_Cuti_tahunan extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function get_index_cuti_tahunan($nik_baru = null, $id = null)
	{
		$where = " `tbl_karyawan_cuti_tahunan`.`no_pengajuan_tahunan` is not null";
		if ($id != '') {
			$where .= " and `tbl_karyawan_cuti_tahunan`.`id_sisa_cuti` = '$id'";
		}
		if ($nik_baru != '') {
			$where .= "  and `tbl_karyawan_cuti_tahunan`.`nik_sisa_cuti` = '$nik_baru'";
		}

		if ($nik_baru === null and $id === null) {
			$sql = "SELECT 
			`tbl_karyawan_cuti_tahunan`.`id_sisa_cuti`,
			`tbl_karyawan_cuti_tahunan`.`no_pengajuan_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`tanggal_pengajuan`,
			`tbl_karyawan_cuti_tahunan`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline,
			`tbl_karyawan_cuti_tahunan`.`nik_sisa_cuti` AS nik_baru,
			`tbl_karyawan_struktur`.`namaKaryawan`,
			`tbl_karyawan_struktur`.`namaKaryawan` AS nama_karyawan_struktur,
			`tbl_karyawan_cuti_tahunan`.`jabatan_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`start_cuti_tahunan` AS tanggal_absen,
			`tbl_karyawan_cuti_tahunan`.`ket_tambahan_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`opsi_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`status_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`tanggal_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`feedback_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`status_cuti_tahunan_2`,
			`tbl_karyawan_cuti_tahunan`.`tanggal_cuti_tahunan_2`,
			`tbl_karyawan_cuti_tahunan`.`feedback_cuti_tahunan_2`,
			`tbl_karyawan_cuti_tahunan`.`dok_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`lat`,
			`tbl_karyawan_cuti_tahunan`.`lon` 
			FROM `tbl_karyawan_cuti_tahunan` 
			INNER JOIN `tbl_karyawan_struktur` ON tbl_karyawan_struktur.`noUrut` = tbl_karyawan_cuti_tahunan.`no_urut` 
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
			`tbl_karyawan_cuti_tahunan`.`id_sisa_cuti`,
			`tbl_karyawan_cuti_tahunan`.`no_pengajuan_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`tanggal_pengajuan`,
			`tbl_karyawan_cuti_tahunan`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline,
			`tbl_karyawan_cuti_tahunan`.`nik_sisa_cuti` AS nik_baru,
			`tbl_karyawan_struktur`.`namaKaryawan`,
			`tbl_karyawan_struktur`.`namaKaryawan` AS nama_karyawan_struktur,
			`tbl_karyawan_cuti_tahunan`.`jabatan_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`start_cuti_tahunan` AS tanggal_absen,
			`tbl_karyawan_cuti_tahunan`.`ket_tambahan_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`opsi_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`status_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`tanggal_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`feedback_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`status_cuti_tahunan_2`,
			`tbl_karyawan_cuti_tahunan`.`tanggal_cuti_tahunan_2`,
			`tbl_karyawan_cuti_tahunan`.`feedback_cuti_tahunan_2`,
			`tbl_karyawan_cuti_tahunan`.`dok_cuti_tahunan`,
			`tbl_karyawan_cuti_tahunan`.`lat`,
			`tbl_karyawan_cuti_tahunan`.`lon` 
			FROM `tbl_karyawan_cuti_tahunan` 
			INNER JOIN `tbl_karyawan_struktur` ON tbl_karyawan_struktur.`noUrut` = tbl_karyawan_cuti_tahunan.`no_urut` 
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}

	public function createCuti_tahunan($data)
	{
		$this->db_absensi->insert('tbl_karyawan_cuti_tahunan', $data);
		return $this->db_absensi->affected_rows();
	}

	public function updateApproval($data, $id)
	{
		$this->db_absensi->update('tbl_karyawan_cuti_tahunan', $data, ['id_sisa_cuti' => $id]);
		return $this->db_absensi->affected_rows();
	}

	public function update_data($data, $shift_day, $badgenumber, $status)
	{
		if ($status == 1) {
			$this->db_absensi->update('tarikan_absen_adms', $data, ['shift_day' => $shift_day, 'badgenumber' => $badgenumber]);
			return $this->db_absensi->affected_rows();
		}
	}

	public function updateHakCuti($data, $nik_sisa_cuti, $tahun)
	{
		$this->db_absensi->update('tbl_hak_cuti', $data, ['no_urut' => $nik_sisa_cuti, 'tahun' => $tahun]);
		return $this->db_absensi->affected_rows();
	}

	public function get_index_cuti_tahunan_atasan($jabatan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($jabatan === null) {
			$sql = "
	            SELECT
		            tbl_karyawan_cuti_tahunan.`id_sisa_cuti`
		            ,tbl_karyawan_cuti_tahunan.`no_pengajuan_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_pengajuan`
		            ,tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_karyawan_cuti_tahunan.`start_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`ket_tambahan_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`opsi_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`dok_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`hak_cuti_utuh`
		          
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_cuti_tahunan`
		            ON tbl_karyawan_cuti_tahunan.`jabatan_cuti_tahunan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else if ($jabatan == 306) {
			$sql = " SELECT
			            tbl_karyawan_cuti_tahunan.`id_sisa_cuti`
			            ,tbl_karyawan_cuti_tahunan.`no_pengajuan_tahunan`
			            ,tbl_karyawan_cuti_tahunan.`tanggal_pengajuan`
			            ,tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
			            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
			            ,tbl_jabatan_karyawan.`jabatan_karyawan`
			            ,tbl_karyawan_struktur.`jabatan_struktur`
			             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
			            ,tbl_karyawan_cuti_tahunan.`start_cuti_tahunan`
			            ,tbl_karyawan_cuti_tahunan.`ket_tambahan_tahunan`
			            ,tbl_karyawan_cuti_tahunan.`opsi_cuti_tahunan`
			            ,tbl_karyawan_cuti_tahunan.`dok_cuti_tahunan`
			            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan`
			            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan`
			            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan`
			            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan_2`
			            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan_2`
			            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan_2`
			            ,tbl_karyawan_cuti_tahunan.`hak_cuti_utuh`
			        FROM `tbl_jabatan_karyawan_approval`
			        INNER JOIN `tbl_jabatan_karyawan` 
			            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			        INNER JOIN `tbl_karyawan_cuti_tahunan`
			            ON tbl_karyawan_cuti_tahunan.`jabatan_cuti_tahunan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			        INNER JOIN `tbl_karyawan_struktur`
			            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
			        WHERE 
				        dept_struktur = 'Warehouse Operation' AND level_jabatan_karyawan = '1' OR level_jabatan_karyawan = '2'
			            OR level_jabatan_karyawan = '3'";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "
	            SELECT
		            tbl_karyawan_cuti_tahunan.`id_sisa_cuti`
		            ,tbl_karyawan_cuti_tahunan.`no_pengajuan_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_pengajuan`
		            ,tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_karyawan_cuti_tahunan.`start_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`ket_tambahan_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`opsi_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`dok_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`hak_cuti_utuh`
		          
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_cuti_tahunan`
		            ON tbl_karyawan_cuti_tahunan.`jabatan_cuti_tahunan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
		            ORDER BY tbl_karyawan_cuti_tahunan.`id_sisa_cuti` DESC;
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_index_tahunan_atasan_lokasi($jabatan = null, $lokasi = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($lokasi == 'Pusat') {
			$sql = "
	           SELECT
		            tbl_karyawan_cuti_tahunan.`id_sisa_cuti`
		            ,tbl_karyawan_cuti_tahunan.`no_pengajuan_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_pengajuan`
		            ,tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_karyawan_cuti_tahunan.`start_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`ket_tambahan_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`opsi_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`dok_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`hak_cuti_utuh`
		            ,tbl_karyawan_cuti_tahunan.`status_notifikasi`
		          
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_cuti_tahunan`
		            ON tbl_karyawan_cuti_tahunan.`jabatan_cuti_tahunan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "
	           SELECT
		            tbl_karyawan_cuti_tahunan.`id_sisa_cuti`
		            ,tbl_karyawan_cuti_tahunan.`no_pengajuan_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_pengajuan`
		            ,tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_karyawan_cuti_tahunan.`start_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`ket_tambahan_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`opsi_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`dok_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan`
		            ,tbl_karyawan_cuti_tahunan.`status_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan_2`
		            ,tbl_karyawan_cuti_tahunan.`hak_cuti_utuh`
		            ,tbl_karyawan_cuti_tahunan.`status_notifikasi`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_cuti_tahunan`
		            ON tbl_karyawan_cuti_tahunan.`jabatan_cuti_tahunan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
		            AND tbl_karyawan_struktur.`lokasi_struktur` = '$lokasi'
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_index_tahunan_feedback($nik_baru = null, $tanggal = null)
	{
		$sql = "SELECT 
				`tbl_karyawan_cuti_tahunan`.`id_sisa_cuti`
				, `tbl_karyawan_cuti_tahunan`.`no_pengajuan_tahunan`
				, `tbl_karyawan_cuti_tahunan`.`tanggal_pengajuan`
				, `tbl_karyawan_cuti_tahunan`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
				, `tbl_karyawan_cuti_tahunan`.`nik_sisa_cuti` AS nik_baru
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, `tbl_karyawan_cuti_tahunan`.`jabatan_cuti_tahunan`
				, `tbl_karyawan_cuti_tahunan`.`start_cuti_tahunan` AS tanggal_absen
				, `tbl_karyawan_cuti_tahunan`.`ket_tambahan_tahunan`
				, `tbl_karyawan_cuti_tahunan`.`opsi_cuti_tahunan`
				, `tbl_karyawan_cuti_tahunan`.`status_cuti_tahunan`
				, `tbl_karyawan_cuti_tahunan`.`tanggal_cuti_tahunan`
				, `tbl_karyawan_cuti_tahunan`.`feedback_cuti_tahunan`
				, `tbl_karyawan_cuti_tahunan`.`status_cuti_tahunan_2`
				, `tbl_karyawan_cuti_tahunan`.`tanggal_cuti_tahunan_2`
				, `tbl_karyawan_cuti_tahunan`.`feedback_cuti_tahunan_2`
				, `tbl_karyawan_cuti_tahunan`.`dok_cuti_tahunan`
				, `tbl_karyawan_cuti_tahunan`.`lat`
				, `tbl_karyawan_cuti_tahunan`.`lon`
			FROM `tbl_karyawan_cuti_tahunan`
			INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`
		WHERE nik_sisa_cuti = '$nik_baru' AND tanggal_cuti_tahunan = '$tanggal'";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	// approval hr manager //

	public function get_index_tahunan_manager($status = null, $date1 = null, $date2 = null)
	{
		$sql = "SELECT 
			  tbl_karyawan_cuti_tahunan.`id_sisa_cuti`,
			  tbl_karyawan_cuti_tahunan.`no_pengajuan_tahunan`,
			  tbl_karyawan_cuti_tahunan.`tanggal_pengajuan`,
			  tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`,
			  tbl_karyawan_struktur.`nama_karyawan_struktur`,
			  tbl_jabatan_karyawan.`jabatan_karyawan`,
			  tbl_karyawan_struktur.`jabatan_struktur`,
			  tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur,
			  tbl_karyawan_cuti_tahunan.`start_cuti_tahunan`,
			  tbl_karyawan_cuti_tahunan.`ket_tambahan_tahunan`,
			  tbl_karyawan_cuti_tahunan.`opsi_cuti_tahunan`,
			  tbl_karyawan_cuti_tahunan.`dok_cuti_tahunan`,
			  tbl_karyawan_cuti_tahunan.`status_cuti_tahunan`,
			  tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan`,
			  tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan`,
			  tbl_karyawan_cuti_tahunan.`status_cuti_tahunan_2`,
			  tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan_2`,
			  tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan_2`,
			  tbl_karyawan_cuti_tahunan.`hak_cuti_utuh`,
			  tbl_karyawan_cuti_tahunan.`feedback_cuti_manager`,
			  tbl_karyawan_cuti_tahunan.`status_cuti_manager` 
			FROM
			  `tbl_jabatan_karyawan_approval` 
			  INNER JOIN `tbl_jabatan_karyawan` 
			    ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan` 
			  INNER JOIN `tbl_karyawan_cuti_tahunan` 
			    ON tbl_karyawan_cuti_tahunan.`jabatan_cuti_tahunan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan` 
			  INNER JOIN `tbl_karyawan_struktur` 
			    ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_cuti_tahunan.`nik_sisa_cuti` 
			AND tbl_karyawan_struktur.`dept_struktur` = 'Human Resource Development'
			  AND tbl_karyawan_cuti_tahunan.`status_cuti_tahunan` = '1' 
			  AND tbl_karyawan_cuti_tahunan.`status_cuti_manager` = '$status' 
			  AND DATE(tbl_karyawan_cuti_tahunan.`start_cuti_tahunan`) BETWEEN '$date1' AND '$date2'
			ORDER BY tbl_karyawan_cuti_tahunan.`id_sisa_cuti` DESC ";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}


		public function get_index_cuti_tahunan_atasan_new($id_divisi = null, $id_bagian = null, $jabatan = null)
    {
        $sql = "SELECT 
				tbl_karyawan_cuti_tahunan.`id_sisa_cuti`,
				tbl_karyawan_cuti_tahunan.`no_pengajuan_tahunan`,
				tbl_karyawan_cuti_tahunan.`tanggal_pengajuan`,
				tbl_karyawan_cuti_tahunan.`nik_sisa_cuti`,
				tbl_karyawan_struktur.namaKaryawan AS nama_karyawan_struktur,
				tbl_jabatan.`jabatanKaryawan`,
				tbl_karyawan_struktur.`idLokasiHrd` AS lokasi_struktur,
				tbl_karyawan_cuti_tahunan.`start_cuti_tahunan`,
				tbl_karyawan_cuti_tahunan.`ket_tambahan_tahunan`,
				tbl_karyawan_cuti_tahunan.`opsi_cuti_tahunan`,
				tbl_karyawan_cuti_tahunan.`dok_cuti_tahunan`,
				tbl_karyawan_cuti_tahunan.`status_cuti_tahunan`,
				tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan`,
				tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan`,
				tbl_karyawan_cuti_tahunan.`status_cuti_tahunan_2`,
				tbl_karyawan_cuti_tahunan.`tanggal_cuti_tahunan_2`,
				tbl_karyawan_cuti_tahunan.`feedback_cuti_tahunan_2`,
				tbl_karyawan_cuti_tahunan.`hak_cuti_utuh` 
				FROM
				`tbl_jabatan_approval` 
				INNER JOIN `tbl_jabatan` 
					ON tbl_jabatan.`idJabatan` = tbl_jabatan_approval.`idJabatan` 
				INNER JOIN `tbl_karyawan_cuti_tahunan` 
					ON tbl_karyawan_cuti_tahunan.`jabatan_cuti_tahunan` = tbl_jabatan_approval.`idJabatan` 
				INNER JOIN `tbl_karyawan_struktur` 
					ON tbl_karyawan_struktur.`nip` = tbl_karyawan_cuti_tahunan.`nik_sisa_cuti` 
				WHERE (
					tbl_karyawan_struktur.idDivisi = '$id_divisi' 
					OR tbl_karyawan_struktur.idBagian = '$id_bagian'
				) 
				AND (
					tbl_jabatan_approval.idJabatanAtasan1 = '$jabatan' 
					OR tbl_jabatan_approval.idJabatanAtasan2 = '$jabatan'
				) 
				ORDER BY tbl_karyawan_cuti_tahunan.`id_sisa_cuti` DESC";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }
}
