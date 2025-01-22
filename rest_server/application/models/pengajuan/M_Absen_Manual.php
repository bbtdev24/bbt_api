<?php

/**
 * 
 */
class M_Absen_Manual extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function get_index_absen_manual($nik_baru = null, $id = null)
	{
		$where = "a.`id_absen` is not null"; // Awal kondisi

		// Tambahkan kondisi jika $id tidak kosong
		if ($id != '') {
			$where .= " AND a.`id_absen` = '$id'";
		}

		// Tambahkan kondisi jika $nik_baru tidak kosong
		if ($nik_baru != '') {
			$where .= " AND a.`nik_absen` = '$nik_baru'";
		}

		// Jika $nik_baru dan $id kosong
		if ($nik_baru === null && $id === null) {
			$sql = "SELECT 
            a.id_absen,
            a.tanggal_pengajuan,
            a.tanggal_pengajuan + INTERVAL 1 DAY AS tanggal_deadline,
            a.nik_absen AS nik_baru,
            d.depo_nama,
            b.namaKaryawan,
            c.depo_nama,
            -- a.jabatan_absen,
            a.jenis_absen,
            a.tanggal_absen,
            a.waktu_absen,
            a.ket_absen,
            a.status,
            a.tanggal,
            a.status_2,
            a.tanggal_2 
        FROM tbl_karyawan_absen_manual a 
        INNER JOIN tbl_karyawan_struktur b ON b.nip = a.nik_absen 
        INNER JOIN tbl_depo c ON c.depo_id = a.lokasi_absen
        INNER JOIN tbl_depo d ON d.depo_id = b.idLokasi";

			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT 
            a.id_absen,
            a.tanggal_pengajuan,
            a.tanggal_pengajuan + INTERVAL 1 DAY AS tanggal_deadline,
            a.nik_absen AS nik_baru,
            d.depo_nama,
            b.namaKaryawan,
            c.depo_nama,
            -- a.jabatan_absen,
            a.jenis_absen,
            a.tanggal_absen,
            a.waktu_absen,
            a.ket_absen,
            a.status,
            a.tanggal,
            a.status_2,
            a.tanggal_2 
        FROM tbl_karyawan_absen_manual a 
        INNER JOIN tbl_karyawan_struktur b ON b.nip = a.nik_absen 
        INNER JOIN tbl_depo c ON c.depo_id = a.lokasi_absen
        INNER JOIN tbl_depo d ON d.depo_id = b.idLokasi
        WHERE $where";

			$hasil = $this->db_absensi->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_index_absen_manual_atasan($jabatan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($jabatan === null) {
			$sql = "SELECT
		       `tbl_karyawan_absen_manual`.`id_absen`
				, `tbl_karyawan_absen_manual`.`tanggal_pengajuan`
				, `tbl_karyawan_absen_manual`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
				, `tbl_karyawan_absen_manual`.`nik_absen` AS nik_baru
				, `tbl_karyawan_struktur`.`lokasi_struktur`
				, `tbl_karyawan_absen_manual`.`jabatan_absen`
				, `tbl_karyawan_absen_manual`.`lokasi_absen`
				, `tbl_karyawan_absen_manual`.`jenis_absen`
				, `tbl_karyawan_absen_manual`.`tanggal_absen`
				, `tbl_karyawan_absen_manual`.`waktu_absen`
				, `tbl_karyawan_absen_manual`.`ket_absen`
				, `tbl_karyawan_absen_manual`.`status`
				, `tbl_karyawan_absen_manual`.`tanggal`
				, `tbl_karyawan_absen_manual`.`status_2`
				, `tbl_karyawan_absen_manual`.`tanggal_2`
			FROM `tbl_karyawan_absen_manual` 
				INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_absen_manual.`nik_absen`";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "SELECT
		        `tbl_karyawan_absen_manual`.`id_absen`
				, `tbl_karyawan_absen_manual`.`tanggal_pengajuan`
				, `tbl_karyawan_absen_manual`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
				, `tbl_karyawan_absen_manual`.`nik_absen` AS nik_baru
				, `tbl_karyawan_struktur`.`lokasi_struktur`
				, `tbl_karyawan_absen_manual`.`jabatan_absen`
				, `tbl_karyawan_absen_manual`.`lokasi_absen`
				, `tbl_karyawan_absen_manual`.`jenis_absen`
				, `tbl_karyawan_absen_manual`.`tanggal_absen`
				, `tbl_karyawan_absen_manual`.`waktu_absen`
				, `tbl_karyawan_absen_manual`.`ket_absen`
				, `tbl_karyawan_absen_manual`.`status`
				, `tbl_karyawan_absen_manual`.`tanggal`
				, `tbl_karyawan_absen_manual`.`status_2`
				, `tbl_karyawan_absen_manual`.`tanggal_2`
		    FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_absen_manual`
		            ON tbl_karyawan_absen_manual.`jabatan_absen` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_absen_manual.`nik_absen`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}

	public function createAbsenManual($data)
	{
		$this->db_absensi->insert('tbl_karyawan_absen_manual', $data);
		return $this->db_absensi->affected_rows();
	}

	public function updateApproval($data, $id_absen)
	{
		$this->db2->update('tbl_karyawan_absen_manual', $data, ['id_absen' => $id_absen]);
		return $this->db2->affected_rows();
	}

	public function get_index_absen_atasan_lokasi($jabatan = null, $lokasi = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($lokasi == 'Pusat') {
			$sql = "
	           SELECT
			        `tbl_karyawan_absen_manual`.`id_absen`
					, `tbl_karyawan_absen_manual`.`tanggal_pengajuan`
					, `tbl_karyawan_absen_manual`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
					, `tbl_karyawan_absen_manual`.`nik_absen` AS nik_baru
					, `tbl_karyawan_struktur`.`lokasi_struktur`
					, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
					, `tbl_karyawan_absen_manual`.`jabatan_absen`
					, `tbl_karyawan_absen_manual`.`lokasi_absen`
					, `tbl_depo`.`depo_nama`
					, `tbl_karyawan_absen_manual`.`jenis_absen`
					, `tbl_karyawan_absen_manual`.`tanggal_absen`
					, `tbl_karyawan_absen_manual`.`waktu_absen`
					, `tbl_karyawan_absen_manual`.`ket_absen`
					, `tbl_karyawan_absen_manual`.`status`
					, `tbl_karyawan_absen_manual`.`tanggal`
					, `tbl_karyawan_absen_manual`.`status_2`
					, `tbl_karyawan_absen_manual`.`tanggal_2`
			    FROM `tbl_jabatan_karyawan_approval`
			        INNER JOIN `tbl_jabatan_karyawan` 
			            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			        INNER JOIN `tbl_karyawan_absen_manual`
			            ON tbl_karyawan_absen_manual.`jabatan_absen` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			        INNER JOIN `tbl_karyawan_struktur`
			            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_absen_manual.`nik_absen`
			        INNER JOIN `sn_depo`
				    ON `tbl_karyawan_absen_manual`.`lokasi_absen` = `sn_depo`.`SN`
			        INNER JOIN `tbl_depo`
			            ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
			        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
			            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		} else {
			$sql = "
	           SELECT
			        `tbl_karyawan_absen_manual`.`id_absen`
					, `tbl_karyawan_absen_manual`.`tanggal_pengajuan`
					, `tbl_karyawan_absen_manual`.`tanggal_pengajuan` + INTERVAL 1 DAY AS tanggal_deadline
					, `tbl_karyawan_absen_manual`.`nik_absen` AS nik_baru
					, `tbl_karyawan_struktur`.`lokasi_struktur`
					, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
					, `tbl_karyawan_absen_manual`.`jabatan_absen`
					, `tbl_karyawan_absen_manual`.`lokasi_absen`
					, `tbl_depo`.`depo_nama`
					, `tbl_karyawan_absen_manual`.`jenis_absen`
					, `tbl_karyawan_absen_manual`.`tanggal_absen`
					, `tbl_karyawan_absen_manual`.`waktu_absen`
					, `tbl_karyawan_absen_manual`.`ket_absen`
					, `tbl_karyawan_absen_manual`.`status`
					, `tbl_karyawan_absen_manual`.`tanggal`
					, `tbl_karyawan_absen_manual`.`status_2`
					, `tbl_karyawan_absen_manual`.`tanggal_2`
			    FROM `tbl_jabatan_karyawan_approval`
			        INNER JOIN `tbl_jabatan_karyawan` 
			            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			        INNER JOIN `tbl_karyawan_absen_manual`
			            ON tbl_karyawan_absen_manual.`jabatan_absen` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			        INNER JOIN `tbl_karyawan_struktur`
			            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_absen_manual.`nik_absen`
			        INNER JOIN `sn_depo`
				    ON `tbl_karyawan_absen_manual`.`lokasi_absen` = `sn_depo`.`SN`
			        INNER JOIN `tbl_depo`
			            ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
			        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
			            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
			            AND lokasi_struktur = '$lokasi'
	        ";
			$hasil = $this->db2->query($sql);
			return $hasil->result_array();
		}
	}

	public function get_karyawan_lokasi_absen($no_urut_karyawan = null)
    {
		$sql = "SELECT 
		a.noUrut,
		a.status, 
		a.idlokasi 
		FROM `tbl_karyawan_lokasi_absen` a
		WHERE a.noUrut = '$no_urut_karyawan'
		AND a.status = '0'";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }

}
