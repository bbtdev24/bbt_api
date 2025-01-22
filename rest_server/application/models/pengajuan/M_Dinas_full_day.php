<?php

/**
 * 
 */
class M_Dinas_full_day extends CI_Model
{

	public function __construct()
	{
		    // $absensi = $this->config->item('db_absensi');
	}

	public function get_index_dinas_full_day($nik_baru = null, $id = null)
	{
		$where = " `tbl_izin_full_day`.`jenis_full_day` = 'DN'";
		if ($id != '') {
			$where .= " and `tbl_izin_full_day`.`id_full_day` = '$id'";
		}
		if ($nik_baru != '') {
			$where .= "  and `tbl_izin_full_day`.`nik_full_day` = '$nik_baru'";
		}

		if ($nik_baru === null) {
			$sql = "SELECT `tbl_izin_full_day`.`id_full_day`,
					`tbl_izin_full_day`.`no_pengajuan_full_day`,
					`tbl_izin_full_day`.`tanggal_pengajuan`,
					`tbl_izin_full_day`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline,
					`tbl_izin_full_day`.`nik_full_day` AS nik_baru,
					`tbl_karyawan_struktur`.`namaKaryawan` AS`nama_karyawan_struktur`,
					`tbl_lokasi`.`namaLokasi` AS lokasi_struktur,
					`tbl_izin_full_day`.`jabatan_full_day`,
					`tbl_izin_full_day`.`jenis_full_day`,
					`tbl_izin_full_day`.`start_full_day` AS tanggal_absen,
					`tbl_izin_full_day`.`karyawan_pengganti`,
					`tbl_izin_full_day`.`ket_tambahan`,
					`tbl_izin_full_day`.`status_full_day`,
					`tbl_izin_full_day`.`feedback_full_day`,
					`tbl_izin_full_day`.`tanggal_approval`,
					`tbl_izin_full_day`.`status_full_day_2`,
					`tbl_izin_full_day`.`feedback_full_day_2`,
					`tbl_izin_full_day`.`tanggal_approval_2`,
					`tbl_izin_full_day`.`upload_full_day`,
					`tbl_izin_full_day`.`lat`,
					`tbl_izin_full_day`.`lon` 
					FROM `tbl_izin_full_day` 
					INNER JOIN `tbl_karyawan_struktur` ON `tbl_karyawan_struktur`.`nip` = `tbl_izin_full_day`.`nik_full_day` 
					INNER JOIN `tbl_lokasi` ON `tbl_lokasi`.`idLokasi` = `tbl_karyawan_struktur`.`idLokasiHrd`
					WHERE $where";

			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT `tbl_izin_full_day`.`id_full_day`,
					`tbl_izin_full_day`.`no_pengajuan_full_day`,
					`tbl_izin_full_day`.`tanggal_pengajuan`,
					`tbl_izin_full_day`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline,
					`tbl_izin_full_day`.`nik_full_day` AS nik_baru,
					`tbl_karyawan_struktur`.`namaKaryawan` AS`nama_karyawan_struktur`,
					`tbl_lokasi`.`namaLokasi` AS lokasi_struktur,
					`tbl_izin_full_day`.`jabatan_full_day`,
					`tbl_izin_full_day`.`jenis_full_day`,
					`tbl_izin_full_day`.`start_full_day` AS tanggal_absen,
					`tbl_izin_full_day`.`karyawan_pengganti`,
					`tbl_izin_full_day`.`ket_tambahan`,
					`tbl_izin_full_day`.`status_full_day`,
					`tbl_izin_full_day`.`feedback_full_day`,
					`tbl_izin_full_day`.`tanggal_approval`,
					`tbl_izin_full_day`.`status_full_day_2`,
					`tbl_izin_full_day`.`feedback_full_day_2`,
					`tbl_izin_full_day`.`tanggal_approval_2`,
					`tbl_izin_full_day`.`upload_full_day`,
					`tbl_izin_full_day`.`lat`,
					`tbl_izin_full_day`.`lon` 
					FROM `tbl_izin_full_day` 
					INNER JOIN `tbl_karyawan_struktur` ON `tbl_karyawan_struktur`.`nip` = `tbl_izin_full_day`.`nik_full_day` 
					INNER JOIN `tbl_lokasi` ON `tbl_lokasi`.`idLokasi` = `tbl_karyawan_struktur`.`idLokasiHrd`
					WHERE $where";

			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_index_dinas_full_day_hari_ini($nik_baru = null, $tanggal = null)
	{
		$sql = "SELECT * FROM tbl_izin_full_day WHERE nik_full_day = '$nik_baru' AND jenis_full_day = 'DN' AND start_full_day = '$tanggal'";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function createDinas_Full_day($data)
	{
		$this->db_absensi->insert('tbl_izin_full_day', $data);
		return $this->db_absensi->affected_rows();
	}

	public function updateApproval($data, $id)
	{
		$this->db_absensi->update('tbl_izin_full_day', $data, ['id_full_day' => $id]);
		return $this->db_absensi->affected_rows();
	}

	public function update_data($data, $shift_day, $badgenumber, $status)
	{
		if ($status == 1) {
			$this->db_absensi->update('tarikan_absen_adms', $data, ['shift_day' => $shift_day, 'badgenumber' => $badgenumber]);
			return $this->db_absensi->affected_rows();
		}
	}

	public function get_index_dinas_full_day_atasan($jabatan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($jabatan === null) {
			$sql = "
	            SELECT
		            tbl_izin_full_day.`id_full_day`
		            ,tbl_izin_full_day.`no_pengajuan_full_day`
		            ,tbl_izin_full_day.`tanggal_pengajuan`
		            ,tbl_izin_full_day.`nik_full_day`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_izin_full_day.`jenis_full_day`
		            ,tbl_izin_full_day.`start_full_day`
		            ,tbl_izin_full_day.`karyawan_pengganti`
		            ,tbl_izin_full_day.`ket_tambahan`
		            ,tbl_izin_full_day.`status_full_day`
		            ,tbl_izin_full_day.`feedback_full_day`
		            ,tbl_izin_full_day.`tanggal_approval`
		            ,tbl_izin_full_day.`status_full_day_2`
		            ,tbl_izin_full_day.`feedback_full_day_2`
		            ,tbl_izin_full_day.`tanggal_approval_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_izin_full_day`
		            ON tbl_izin_full_day.`jabatan_full_day` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_izin_full_day.`nik_full_day`
		        WHERE tbl_izin_full_day.`jenis_full_day` = 'DN'
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else if ($jabatan == 306) {
			$sql = "SELECT
			            tbl_izin_full_day.`id_full_day`
			            ,tbl_izin_full_day.`no_pengajuan_full_day`
			            ,tbl_izin_full_day.`tanggal_pengajuan`
			            ,tbl_izin_full_day.`nik_full_day`
			            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
			            ,tbl_karyawan_struktur.`jabatan_struktur`
			            ,tbl_jabatan_karyawan.`jabatan_karyawan`
			             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
			            ,tbl_izin_full_day.`jenis_full_day`
			            ,tbl_izin_full_day.`start_full_day`
			            ,tbl_izin_full_day.`karyawan_pengganti`
			            ,tbl_izin_full_day.`ket_tambahan`
			            ,tbl_izin_full_day.`status_full_day`
			            ,tbl_izin_full_day.`feedback_full_day`
			            ,tbl_izin_full_day.`tanggal_approval`
			            ,tbl_izin_full_day.`status_full_day_2`
			            ,tbl_izin_full_day.`feedback_full_day_2`
			            ,tbl_izin_full_day.`tanggal_approval_2`
			        FROM `tbl_jabatan_karyawan_approval`
			        INNER JOIN `tbl_jabatan_karyawan` 
			            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			        INNER JOIN `tbl_izin_full_day`
			            ON tbl_izin_full_day.`jabatan_full_day` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			        INNER JOIN `tbl_karyawan_struktur`
			            ON tbl_karyawan_struktur.`nik_baru` = tbl_izin_full_day.`nik_full_day`
			        WHERE tbl_izin_full_day.`jenis_full_day` = 'DN'
				        AND dept_struktur = 'Warehouse Operation' AND level_jabatan_karyawan = '1' OR level_jabatan_karyawan = '2'
			            OR level_jabatan_karyawan = '3'";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "
	            SELECT
		            tbl_izin_full_day.`id_full_day`
		            ,tbl_izin_full_day.`no_pengajuan_full_day`
		            ,tbl_izin_full_day.`tanggal_pengajuan`
		            ,tbl_izin_full_day.`nik_full_day`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_izin_full_day.`jenis_full_day`
		            ,tbl_izin_full_day.`start_full_day`
		            ,tbl_izin_full_day.`karyawan_pengganti`
		            ,tbl_izin_full_day.`ket_tambahan`
		            ,tbl_izin_full_day.`status_full_day`
		            ,tbl_izin_full_day.`feedback_full_day`
		            ,tbl_izin_full_day.`tanggal_approval`
		            ,tbl_izin_full_day.`status_full_day_2`
		            ,tbl_izin_full_day.`feedback_full_day_2`
		            ,tbl_izin_full_day.`tanggal_approval_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_izin_full_day`
		            ON tbl_izin_full_day.`jabatan_full_day` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_izin_full_day.`nik_full_day`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
		            AND tbl_izin_full_day.`jenis_full_day` = 'DN'
		            ORDER BY tbl_izin_full_day.`id_full_day` DESC
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}


	//-----------------------------------------------------------------------------------------


	public function get_index_rekap_dinas_full_day($nik_baru = null, $id = null)
	{
		$where = " `tbl_izin_full_day`.`jenis_full_day` = 'DN'";

		if ($id != '') {
			$where .= " and `tbl_izin_full_day`.`id_full_day` = '$id'";
		}
		if ($nik_baru != '') {
			$where .= "  and `tbl_izin_full_day`.`nik_full_day` = '$nik_baru'";
		}

		if ($nik_baru === null) {
			$sql = "SELECT `tbl_izin_full_day`.`id_full_day`,
			`tbl_izin_full_day`.`no_pengajuan_full_day`,
			`tbl_izin_full_day`.`tanggal_pengajuan`,
			`tbl_izin_full_day`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline,
			`tbl_izin_full_day`.`nik_full_day` AS nik_baru,
			`tbl_karyawan_struktur`.`namaKaryawan` AS nama_karyawan_struktur,
			`tbl_lokasi`.`namaLokasi` AS lokasi_struktur,
			`tbl_izin_full_day`.`jabatan_full_day`,
			`tbl_izin_full_day`.`jenis_full_day`,
			`tbl_izin_full_day`.`start_full_day` AS tanggal_absen,
			`tbl_izin_full_day`.`karyawan_pengganti`,
			`tbl_izin_full_day`.`ket_tambahan`,
			`tbl_izin_full_day`.`status_full_day`,
			`tbl_izin_full_day`.`feedback_full_day`,
			`tbl_izin_full_day`.`tanggal_approval`,
			`tbl_izin_full_day`.`status_full_day_2`,
			`tbl_izin_full_day`.`feedback_full_day_2`,
			`tbl_izin_full_day`.`tanggal_approval_2`,
			`tbl_izin_full_day`.`upload_full_day`,
			`tbl_izin_full_day`.`lat`,
			`tbl_izin_full_day`.`lon` 
			FROM `tbl_izin_full_day` 
			INNER JOIN `tbl_karyawan_struktur` ON `tbl_karyawan_struktur`.`nip` = `tbl_izin_full_day`.`nik_full_day` 
			LEFT JOIN `tbl_lokasi` ON `tbl_lokasi`.`idLokasi` = `tbl_karyawan_struktur`.`idLokasi` 
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT `tbl_izin_full_day`.`id_full_day`,
			`tbl_izin_full_day`.`no_pengajuan_full_day`,
			`tbl_izin_full_day`.`tanggal_pengajuan`,
			`tbl_izin_full_day`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline,
			`tbl_izin_full_day`.`nik_full_day` AS nik_baru,
			`tbl_karyawan_struktur`.`namaKaryawan` AS nama_karyawan_struktur,
			`tbl_lokasi`.`namaLokasi` AS lokasi_struktur,
			`tbl_izin_full_day`.`jabatan_full_day`,
			`tbl_izin_full_day`.`jenis_full_day`,
			`tbl_izin_full_day`.`start_full_day` AS tanggal_absen,
			`tbl_izin_full_day`.`karyawan_pengganti`,
			`tbl_izin_full_day`.`ket_tambahan`,
			`tbl_izin_full_day`.`status_full_day`,
			`tbl_izin_full_day`.`feedback_full_day`,
			`tbl_izin_full_day`.`tanggal_approval`,
			`tbl_izin_full_day`.`status_full_day_2`,
			`tbl_izin_full_day`.`feedback_full_day_2`,
			`tbl_izin_full_day`.`tanggal_approval_2`,
			`tbl_izin_full_day`.`upload_full_day`,
			`tbl_izin_full_day`.`lat`,
			`tbl_izin_full_day`.`lon` 
			FROM `tbl_izin_full_day` 
			INNER JOIN `tbl_karyawan_struktur` ON `tbl_karyawan_struktur`.`nip` = `tbl_izin_full_day`.`nik_full_day` 
			LEFT JOIN `tbl_lokasi` ON `tbl_lokasi`.`idLokasi` = `tbl_karyawan_struktur`.`idLokasi` 
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}

	}

	public function get_index_dinas_atasan_new($id_divisi = null, $id_bagian = null, $jabatan = null)
    {
        $sql = "SELECT 
				tbl_izin_full_day.`id_full_day`,
				tbl_izin_full_day.`no_pengajuan_full_day`,
				tbl_izin_full_day.`tanggal_pengajuan`,
				tbl_izin_full_day.`nik_full_day`,
				tbl_karyawan_struktur.namaKaryawan AS nama_karyawan_struktur,
				tbl_jabatan.`jabatanKaryawan`,
				tbl_karyawan_struktur.`idLokasiHrd` AS lokasi_struktur,
				tbl_izin_full_day.`jenis_full_day`,
				tbl_izin_full_day.`start_full_day`,
				tbl_izin_full_day.`karyawan_pengganti`,
				tbl_izin_full_day.`ket_tambahan`,
				tbl_izin_full_day.`status_full_day`,
				tbl_izin_full_day.`feedback_full_day`,
				tbl_izin_full_day.`tanggal_approval`,
				tbl_izin_full_day.`status_full_day_2`,
				tbl_izin_full_day.`feedback_full_day_2`,
				tbl_izin_full_day.`tanggal_approval_2`
			FROM `tbl_jabatan_approval` 
			INNER JOIN `tbl_jabatan` ON tbl_jabatan.`idJabatan` = tbl_jabatan_approval.`idJabatan` 
			INNER JOIN `tbl_izin_full_day` ON tbl_izin_full_day.`jabatan_full_day` = tbl_jabatan_approval.`idJabatan` 
			INNER JOIN `tbl_karyawan_struktur` ON tbl_karyawan_struktur.`nip` = tbl_izin_full_day.`nik_full_day` 
			WHERE (
					tbl_karyawan_struktur.idDivisi = '$id_divisi' 
					OR tbl_karyawan_struktur.idBagian = '$id_bagian'
				) 
			AND (
					tbl_jabatan_approval.idJabatanAtasan1 = '$jabatan' 
					OR tbl_jabatan_approval.idJabatanAtasan2 = '$jabatan'
				) 
		AND tbl_izin_full_day.`jenis_full_day` = 'DN' 
		ORDER BY tbl_izin_full_day.`id_full_day` DESC";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }
	
}
