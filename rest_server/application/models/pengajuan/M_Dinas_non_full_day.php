<?php

/**
 * 
 */
class M_Dinas_non_full_day extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_index_dinas_non_full_day($nik_baru = null, $id = null)
	{
		$where = " `tbl_izin_non_full`.`jenis_non_full` = 'DN'";
        if ($id!='') {
            $where .= " and `tbl_izin_non_full`.`id_non_full` = '$id'";
        }
        if ($nik_baru!='') {
            $where .= "  and `tbl_izin_non_full`.`nik_non_full` = '$nik_baru'";
        }

		if ($nik_baru === null) {
			$sql="SELECT 
				`tbl_izin_non_full`.`id_non_full`
				, `tbl_izin_non_full`.`no_pengajuan_non_full`
				, `tbl_izin_non_full`.`tanggal_pengajuan`
				, `tbl_izin_non_full`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline 
				, `tbl_izin_non_full`.`nik_non_full` AS nik_baru
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
			  	, `tbl_karyawan_struktur`.`lokasi_struktur`
				, `tbl_izin_non_full`.`jabatan_non_full`
				, `tbl_izin_non_full`.`jenis_non_full`
				, `tbl_izin_non_full`.`tanggal_non_full` AS tanggal_absen
				, `tbl_izin_non_full`.`ket_tambahan_non_full`
				, `tbl_izin_non_full`.`status_non_full`
				, `tbl_izin_non_full`.`tanggal_approval_non_full`
				, `tbl_izin_non_full`.`feedback_non_full`
				, `tbl_izin_non_full`.`status_non_full_2`
				, `tbl_izin_non_full`.`tanggal_approval_non_full_2`
				, `tbl_izin_non_full`.`feedback_non_full_2`
				, `tbl_izin_non_full`.`upload_non_full`
				, `tbl_izin_non_full`.`lat`
				, `tbl_izin_non_full`.`lon`
			FROM `tbl_izin_non_full`
			INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_izin_non_full.`nik_non_full`
			WHERE $where";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		} else {
			$sql="SELECT 
				`tbl_izin_non_full`.`id_non_full`
				, `tbl_izin_non_full`.`no_pengajuan_non_full`
				, `tbl_izin_non_full`.`tanggal_pengajuan`
				, `tbl_izin_non_full`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline 
				, `tbl_izin_non_full`.`nik_non_full` AS nik_baru
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, `tbl_karyawan_struktur`.`lokasi_struktur`
				, `tbl_izin_non_full`.`jabatan_non_full`
				, `tbl_izin_non_full`.`jenis_non_full`
				, `tbl_izin_non_full`.`tanggal_non_full` AS tanggal_absen
				, `tbl_izin_non_full`.`ket_tambahan_non_full`
				, `tbl_izin_non_full`.`status_non_full`
				, `tbl_izin_non_full`.`tanggal_approval_non_full`
				, `tbl_izin_non_full`.`feedback_non_full`
				, `tbl_izin_non_full`.`status_non_full_2`
				, `tbl_izin_non_full`.`tanggal_approval_non_full_2`
				, `tbl_izin_non_full`.`feedback_non_full_2`
				, `tbl_izin_non_full`.`upload_non_full`
				, `tbl_izin_non_full`.`lat`
				, `tbl_izin_non_full`.`lon`
			FROM `tbl_izin_non_full`
			INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_izin_non_full.`nik_non_full`
			WHERE $where";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		}
	}

	public function get_index_dinas__non_full_hari_ini($nik_baru = null, $tanggal = null)
	{
		$sql = "SELECT * FROM tbl_izin_non_full WHERE nik_non_full = '$nik_baru' AND jenis_non_full = 'DN' AND tanggal_non_full = '$tanggal'";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
	}

	public function createDinas_Non_full_day($data)
	{
		$this->db2->insert('tbl_izin_non_full', $data);
		return $this->db2->affected_rows();
	}

	public function updateApproval($data, $id)
	{
		$this->db2->update('tbl_izin_non_full', $data, ['id_non_full' => $id]);
		return $this->db2->affected_rows();
	}

	public function update_data($data, $shift_day, $badgenumber, $status) {
		if ($status == 1) {
			$this->db2->update('tarikan_absen_adms', $data, ['shift_day' => $shift_day, 'badgenumber' => $badgenumber]);
			return $this->db2->affected_rows();
		}
	}

	public function get_index_dinas_non_full_day_atasan($jabatan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($jabatan === null) {
			$sql = "
	            SELECT
		            tbl_izin_non_full.`id_non_full`
		            ,tbl_izin_non_full.`no_pengajuan_non_full`
		            ,tbl_izin_non_full.`tanggal_pengajuan`
		            ,tbl_izin_non_full.`nik_non_full`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_izin_non_full.`jenis_non_full`
		            ,tbl_izin_non_full.`tanggal_non_full`
		            ,tbl_izin_non_full.`ket_tambahan_non_full`
		            ,tbl_izin_non_full.`status_non_full`
		            ,tbl_izin_non_full.`tanggal_approval_non_full`
		            ,tbl_izin_non_full.`feedback_non_full`
		            ,tbl_izin_non_full.`status_non_full_2`
		            ,tbl_izin_non_full.`tanggal_approval_non_full_2`
		            ,tbl_izin_non_full.`feedback_non_full_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_izin_non_full`
		            ON tbl_izin_non_full.`jabatan_non_full` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_izin_non_full.`nik_non_full`
		        WHERE tbl_izin_non_full.`jenis_non_full` = 'DN' 
	        ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else if ($jabatan == 306) { 
			$sql = "SELECT
		            tbl_izin_non_full.`id_non_full`
		            ,tbl_izin_non_full.`no_pengajuan_non_full`
		            ,tbl_izin_non_full.`tanggal_pengajuan`
		            ,tbl_izin_non_full.`nik_non_full`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_izin_non_full.`jenis_non_full`
		            ,tbl_izin_non_full.`tanggal_non_full`
		            ,tbl_izin_non_full.`ket_tambahan_non_full`
		            ,tbl_izin_non_full.`status_non_full`
		            ,tbl_izin_non_full.`tanggal_approval_non_full`
		            ,tbl_izin_non_full.`feedback_non_full`
		            ,tbl_izin_non_full.`status_non_full_2`
		            ,tbl_izin_non_full.`tanggal_approval_non_full_2`
		            ,tbl_izin_non_full.`feedback_non_full_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_izin_non_full`
		            ON tbl_izin_non_full.`jabatan_non_full` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_izin_non_full.`nik_non_full`
		        WHERE tbl_izin_non_full.`jenis_non_full` = 'DN' 
			        AND dept_struktur = 'Warehouse Operation' AND level_jabatan_karyawan = '1' OR level_jabatan_karyawan = '2'
		            OR level_jabatan_karyawan = '3'";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else {
			$sql = "
	            SELECT
		            tbl_izin_non_full.`id_non_full`
		            ,tbl_izin_non_full.`no_pengajuan_non_full`
		            ,tbl_izin_non_full.`tanggal_pengajuan`
		            ,tbl_izin_non_full.`nik_non_full`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		             ,tbl_karyawan_struktur.`lokasi_hrd` AS lokasi_struktur
		            ,tbl_izin_non_full.`jenis_non_full`
		            ,tbl_izin_non_full.`tanggal_non_full`
		            ,tbl_izin_non_full.`ket_tambahan_non_full`
		            ,tbl_izin_non_full.`status_non_full`
		            ,tbl_izin_non_full.`tanggal_approval_non_full`
		            ,tbl_izin_non_full.`feedback_non_full`
		            ,tbl_izin_non_full.`status_non_full_2`
		            ,tbl_izin_non_full.`tanggal_approval_non_full_2`
		            ,tbl_izin_non_full.`feedback_non_full_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_izin_non_full`
		            ON tbl_izin_non_full.`jabatan_non_full` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_izin_non_full.`nik_non_full`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
		            and tbl_izin_non_full.`jenis_non_full` = 'DN' 
		           ORDER BY tbl_izin_non_full.`id_non_full` DESC
	        ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		}
	}


	//----------------------------------------------------------------------

	public function get_index_rekap_dinas_non_full($nik_baru = null, $id = null)
	{
		$where = " `tbl_izin_non_full`.`jenis_non_full` = 'DN'";

		if ($id != '') {
			$where .= " and `tbl_izin_non_full`.`id_non_full` = '$id'";
		}
		if ($nik_baru != '') {
			$where .= "  and `tbl_izin_non_full`.`nik_non_full` = '$nik_baru'";
		}

		if ($nik_baru === null) {
			$sql = "SELECT `tbl_izin_non_full`.`id_non_full`,
			`tbl_izin_non_full`.`no_pengajuan_non_full`,
			`tbl_izin_non_full`.`tanggal_pengajuan`,
			`tbl_izin_non_full`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline,
			`tbl_izin_non_full`.`nik_non_full` AS nik_baru,
			`tbl_karyawan_struktur`.`namaKaryawan` AS nama_karyawan_struktur,
			`tbl_lokasi`.`namaLokasi` AS lokasi_struktur,
			`tbl_izin_non_full`.`jabatan_non_full`,
			`tbl_izin_non_full`.`jenis_non_full`,
			`tbl_izin_non_full`.`tanggal_non_full` AS tanggal_absen,
			-- `tbl_izin_non_full`.`karyawan_pengganti`,
			`tbl_izin_non_full`.`ket_tambahan_non_full`,
			`tbl_izin_non_full`.`status_non_full`,
			`tbl_izin_non_full`.`feedback_non_full`,
			`tbl_izin_non_full`.`tanggal_approval_non_full`,
			`tbl_izin_non_full`.`status_non_full_2`,
			`tbl_izin_non_full`.`feedback_non_full_2`,
			`tbl_izin_non_full`.`tanggal_approval_non_full_2`,
			`tbl_izin_non_full`.`upload_non_full`,
			`tbl_izin_non_full`.`lat`,
			`tbl_izin_non_full`.`lon` 
			FROM `tbl_izin_non_full` 
			INNER JOIN `tbl_karyawan_struktur` ON `tbl_karyawan_struktur`.`nip` = `tbl_izin_non_full`.`nik_non_full` 
			LEFT JOIN `tbl_lokasi` ON `tbl_lokasi`.`idLokasi` = `tbl_karyawan_struktur`.`idLokasi` 
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();

		} else {
			$sql = "SELECT `tbl_izin_non_full`.`id_non_full`,
			`tbl_izin_non_full`.`no_pengajuan_non_full`,
			`tbl_izin_non_full`.`tanggal_pengajuan`,
			`tbl_izin_non_full`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline,
			`tbl_izin_non_full`.`nik_non_full` AS nik_baru,
			`tbl_karyawan_struktur`.`namaKaryawan` AS nama_karyawan_struktur,
			`tbl_lokasi`.`namaLokasi` AS lokasi_struktur,
			`tbl_izin_non_full`.`jabatan_non_full`,
			`tbl_izin_non_full`.`jenis_non_full`,
			`tbl_izin_non_full`.`tanggal_non_full` AS tanggal_absen,
			-- `tbl_izin_non_full`.`karyawan_pengganti`,
			`tbl_izin_non_full`.`ket_tambahan_non_full`,
			`tbl_izin_non_full`.`status_non_full`,
			`tbl_izin_non_full`.`feedback_non_full`,
			`tbl_izin_non_full`.`tanggal_approval_non_full`,
			`tbl_izin_non_full`.`status_non_full_2`,
			`tbl_izin_non_full`.`feedback_non_full_2`,
			`tbl_izin_non_full`.`tanggal_approval_non_full_2`,
			`tbl_izin_non_full`.`upload_non_full`,
			`tbl_izin_non_full`.`lat`,
			`tbl_izin_non_full`.`lon` 
			FROM `tbl_izin_non_full` 
			INNER JOIN `tbl_karyawan_struktur` ON `tbl_karyawan_struktur`.`nip` = `tbl_izin_non_full`.`nik_non_full` 
			LEFT JOIN `tbl_lokasi` ON `tbl_lokasi`.`idLokasi` = `tbl_karyawan_struktur`.`idLokasi` 
			WHERE $where";
			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}

	}


	public function get_index_dinas_atasan_new($id_divisi = null, $id_bagian = null, $jabatan = null)
    {
        $sql = "SELECT 
				`tbl_izin_non_full`.`id_non_full`,
				`tbl_izin_non_full`.`no_pengajuan_non_full`,
				`tbl_izin_non_full`.`tanggal_pengajuan`,
				`tbl_izin_non_full`.`nik_non_full`,
				`tbl_karyawan_struktur`.namaKaryawan AS nama_karyawan_struktur,
				`tbl_jabatan`.`jabatanKaryawan`,
				`tbl_karyawan_struktur`.`idLokasiHrd` AS lokasi_struktur,
				`tbl_izin_non_full`.`jenis_non_full`,
				`tbl_izin_non_full`.`tanggal_non_full`,
				-- `tbl_izin_non_full`.`karyawan_pengganti`,
				`tbl_izin_non_full`.`ket_tambahan_non_full`,
				`tbl_izin_non_full`.`status_non_full`,
				`tbl_izin_non_full`.`feedback_non_full`,
				`tbl_izin_non_full`.`tanggal_approval_non_full`,
				`tbl_izin_non_full`.`status_non_full_2`,
				`tbl_izin_non_full`.`feedback_non_full_2`,
				`tbl_izin_non_full`.`tanggal_approval_non_full_2`
			FROM `tbl_jabatan_approval` 
			INNER JOIN `tbl_jabatan` ON tbl_jabatan.`idJabatan` = tbl_jabatan_approval.`idJabatan` 
			INNER JOIN `tbl_izin_non_full` ON `tbl_izin_non_full`.`jabatan_non_full` = tbl_jabatan_approval.`idJabatan` 
			INNER JOIN `tbl_karyawan_struktur` ON tbl_karyawan_struktur.`nip` = `tbl_izin_non_full`.`nik_non_full` 
			WHERE (
					tbl_karyawan_struktur.idDivisi = '$id_divisi' 
					OR tbl_karyawan_struktur.idBagian = '$id_bagian'
				) 
			AND (
					tbl_jabatan_approval.idJabatanAtasan1 = '$jabatan' 
					OR tbl_jabatan_approval.idJabatanAtasan2 = '$jabatan'
				) 
		AND `tbl_izin_non_full`.`jenis_non_full` = 'DN' 
		ORDER BY `tbl_izin_non_full`.`id_non_full` DESC";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }

}

?>