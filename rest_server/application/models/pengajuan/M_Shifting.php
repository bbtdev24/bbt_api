<?php

/**
 * 
 */
class M_Shifting extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_index_shift($nik_baru = null, $id = null, $shift_day = null)
	{
		$where = " `tmp_karyawan_shift`.`jam_kerja` IS NOT NULL";
        if ($id!='') {
            $where .= " AND `tmp_karyawan_shift`.`id_karyawan_shift` = '$id'";
        }
        if ($nik_baru!='') {
            $where .= "  AND `tmp_karyawan_shift`.`nik_shift` = '$nik_baru'";
        }
        if ($shift_day!='') {
            $where .= "  AND `tmp_karyawan_shift`.`tanggal_shift` = '$shift_day'";
        }

		if ($nik_baru === null and $id === null and $shift_day === null) {
			$sql="SELECT
				`tmp_karyawan_shift`.`id_karyawan_shift`
				, `tmp_karyawan_shift`.`nik_shift` AS nik_baru
				, `tmp_karyawan_shift`.`nama_karyawan_shift`
				, `tmp_karyawan_shift`.`lokasi_karyawan_shift`
				, `tbl_jabatan_karyawan`.`jabatan_karyawan`
				, `tmp_karyawan_shift`.`dept_karyawan_shift`
				, `tmp_karyawan_shift`.`tanggal_shift` AS shift_day
				, `tbl_shifting`.`waktu_masuk`
				, `tbl_shifting`.`waktu_keluar`
				, `tmp_karyawan_shift`.`jam_kerja`
			FROM `tmp_karyawan_shift`
			INNER JOIN `tbl_shifting`
				ON `tbl_shifting`.`id_shifting` = `tmp_karyawan_shift`.`jam_kerja`
			INNER JOIN `tbl_jabatan_karyawan`
				ON `tbl_jabatan_karyawan`.`no_jabatan_karyawan` = `tmp_karyawan_shift`.`jabatan_karyawan_shift`
			WHERE $where
			ORDER BY `tmp_karyawan_shift`.`tanggal_shift` DESC";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		} else {
			$sql="SELECT
				`tmp_karyawan_shift`.`id_karyawan_shift`
				, `tmp_karyawan_shift`.`nik_shift` AS nik_baru
				, `tmp_karyawan_shift`.`nama_karyawan_shift`
				, `tmp_karyawan_shift`.`lokasi_karyawan_shift`
				, `tmp_karyawan_shift`.`dept_karyawan_shift`
				, `tbl_jabatan_karyawan`.`jabatan_karyawan`
				, `tmp_karyawan_shift`.`tanggal_shift` AS shift_day
				, `tbl_shifting`.`waktu_masuk`
				, `tbl_shifting`.`waktu_keluar`
				, `tmp_karyawan_shift`.`jam_kerja`
			FROM `tmp_karyawan_shift`
			INNER JOIN `tbl_shifting`
				ON `tbl_shifting`.`id_shifting` = `tmp_karyawan_shift`.`jam_kerja`
			INNER JOIN `tbl_jabatan_karyawan`
				ON `tbl_jabatan_karyawan`.`no_jabatan_karyawan` = `tmp_karyawan_shift`.`jabatan_karyawan_shift`
			WHERE $where
			ORDER BY `tmp_karyawan_shift`.`tanggal_shift` DESC";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		}
	}
	public function createShift($data)
	{
		$this->db2->insert('tmp_karyawan_shift', $data);
		return $this->db2->affected_rows();
	}

	public function updateShift($data, $id)
	{
		$this->db2->update('tmp_karyawan_shift', $data, ['id_karyawan_shift' => $id]);
		return $this->db2->affected_rows();
	}

	public function deleteShift($id)
	{
		$this->db2->delete('tmp_karyawan_shift', ['id_karyawan_shift' => $id]);
		return $this->db2->affected_rows();
	}

	public function updateJam($data, $id, $shift_day)
	{
		$this->db2->update('tarikan_absen_adms', $data, ['userid' => $id, 'shift_day' => $shift_day]);
		return $this->db2->affected_rows();
	}

	public function get_index_atasan_shift($jabatan = null, $lokasi = null)
	{
		if ($lokasi == 'Pusat') {
			$sql = "SELECT
						`tmp_karyawan_shift`.`id_karyawan_shift`
						, `tmp_karyawan_shift`.`nik_shift` AS nik_baru
						, `tmp_karyawan_shift`.`nama_karyawan_shift`
						, `tmp_karyawan_shift`.`lokasi_karyawan_shift`
						, `tbl_jabatan_karyawan`.`jabatan_karyawan`
						, `tmp_karyawan_shift`.`dept_karyawan_shift`
						, `tmp_karyawan_shift`.`tanggal_shift` AS shift_day
						, `tbl_shifting`.`waktu_masuk`
						, `tbl_shifting`.`waktu_keluar`
						, `tmp_karyawan_shift`.`jam_kerja`
						FROM `tmp_karyawan_shift`
						INNER JOIN `tbl_shifting`
							ON `tbl_shifting`.`id_shifting` = `tmp_karyawan_shift`.`jam_kerja`
						INNER JOIN `tbl_jabatan_karyawan`
							ON `tbl_jabatan_karyawan`.`no_jabatan_karyawan` = `tmp_karyawan_shift`.`jabatan_karyawan_shift`
						INNER JOIN `tbl_jabatan_karyawan_approval` 
							ON tmp_karyawan_shift.`jabatan_karyawan_shift` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
						WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
							OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
						ORDER BY `tmp_karyawan_shift`.`tanggal_shift` DESC";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else {
			$sql = "SELECT
					`tmp_karyawan_shift`.`id_karyawan_shift`
					, `tmp_karyawan_shift`.`nik_shift` AS nik_baru
					, `tmp_karyawan_shift`.`nama_karyawan_shift`
					, `tmp_karyawan_shift`.`lokasi_karyawan_shift`
					, `tbl_jabatan_karyawan`.`jabatan_karyawan`
					, `tmp_karyawan_shift`.`dept_karyawan_shift`
					, `tmp_karyawan_shift`.`tanggal_shift` AS shift_day
					, `tbl_shifting`.`waktu_masuk`
					, `tbl_shifting`.`waktu_keluar`
					, `tmp_karyawan_shift`.`jam_kerja`
					FROM `tmp_karyawan_shift`
					INNER JOIN `tbl_shifting`
						ON `tbl_shifting`.`id_shifting` = `tmp_karyawan_shift`.`jam_kerja`
					INNER JOIN `tbl_jabatan_karyawan`
						ON `tbl_jabatan_karyawan`.`no_jabatan_karyawan` = `tmp_karyawan_shift`.`jabatan_karyawan_shift`
					INNER JOIN `tbl_jabatan_karyawan_approval` 
						ON tmp_karyawan_shift.`jabatan_karyawan_shift` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
					WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
						            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
					AND lokasi_karyawan_shift = '$lokasi'
					ORDER BY `tmp_karyawan_shift`.`tanggal_shift` DESC";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		}
	}

	public function getWaktu_absensi($nik_baru = null, $tanggal = null)
    {
        $sql="SELECT * FROM tarikan_absen_adms WHERE badgenumber = '$nik_baru' AND shift_day = '$tanggal'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        
    }
}
?>