<?php

/**
 * 
 */
class M_Ptk extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getNomor()
	{
		$sql = " SELECT * FROM `tbl_karyawan_ptk`
		ORDER BY `tbl_karyawan_ptk`.`id` DESC
		LIMIT 0, 1
		";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getNomorUrutNik($nik_baru = null)
	{
		$sql = " SELECT 
				  a.`no_urut` 
				FROM
				  `tbl_karyawan_struktur` a 
				WHERE a.`nik_baru` = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getDataByNik($nik_baru = null, $id = null)
	{
		$where = " a.`id` is not null";
        if ($id!='') {
            $where .= " and a.`id` = '$id'";
        }

        if ($nik_baru!='') {
            $where .= " and a.`nik_pengajuan` = '$nik_baru'";
        }
		$sql = "SELECT 
				a.id,
				a.no_pengajuan,
				a.submit_date,
				a.nik_pengajuan,
				b.jabatan_karyawan,
				c.level_jabatan,
				a.depo_ptk,
				a.dept_ptk,
				a.analisa,
				a.tenaga_kerja,
				a.status_atasan,
				a.status_hrd,
				a.status_cancel
					FROM tbl_karyawan_ptk a INNER JOIN tbl_jabatan_karyawan b ON a.`jabatan_ptk` = b.`no_jabatan_karyawan` 
					INNER JOIN tbl_level_jabatan c ON b.`level_jabatan_karyawan` = c.`id_level_jabatan`
					WHERE $where";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getJabatan($jabatan = null)
	{
		$sql = "SELECT 
					a.id,
					a.submit_date,
					a.nik_pengajuan,
					a.jabatan_karyawan AS jabatan,
					b.jabatan_karyawan,
					c.level_jabatan,
					a.depo_ptk,
					a.dept_ptk,
					a.analisa,
					a.tenaga_kerja,
					a.status_atasan,
					a.status_hrd,
					a.status_cancel
						FROM tbl_karyawan_ptk a 
							INNER JOIN tbl_jabatan_karyawan b 
								ON a.`jabatan_ptk` = b.`no_jabatan_karyawan` 
							INNER JOIN tbl_level_jabatan c 
								ON b.`level_jabatan_karyawan` = c.`id_level_jabatan`
							INNER JOIN tbl_jabatan_karyawan d 
								ON d.`no_jabatan_karyawan` = a.`jabatan_karyawan`
							INNER JOIN tbl_jabatan_karyawan_approval e
								ON a.`jabatan_karyawan` = e.`no_jabatan_karyawan`
		  			        INNER JOIN tbl_karyawan_struktur f
								ON f.`nik_baru` = a.`nik_pengajuan`
							WHERE (e.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		     			        OR e.`no_jabatan_karyawan_atasan_2`='$jabatan')";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();

	}

	public function createPTK($data)
	{
		$this->db2->insert('tbl_karyawan_ptk', $data);
		return $this->db2->affected_rows();
	}

	public function updateApproval($data, $id)
	{
		$this->db2->update('tbl_karyawan_ptk', $data, ['id' => $id]);
		return $this->db2->affected_rows();
	}


	public function getDataManager($date1 = null, $date2 = null)
	{
		$sql = "SELECT 
				  a.*,
				  b.`jabatan_karyawan` AS 'nama_jabatan' 
				FROM
				  `tbl_karyawan_ptk` a 
				  INNER JOIN `tbl_jabatan_karyawan` b 
				    ON a.`jabatan_karyawan` = b.`no_jabatan_karyawan` 
				WHERE a.`status_manager` = '0' 
				  AND a.`status_hrd` = '0' 
				  AND a.`status_atasan` = '1' 
				  AND a.`status_cancel` = '0'
				  AND DATE(a.`submit_date`) BETWEEN '$date1' 
				  AND '$date2' 
				ORDER BY a.`no_pengajuan` DESC 
				";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getDataManagerApproval($status_manager = null, $date1 = null, $date2 = null)
	{
		$sql = "SELECT 
				  a.*,
				  b.`jabatan_karyawan` as 'nama_jabatan'
				FROM
				  `tbl_karyawan_ptk` a 
				  INNER JOIN `tbl_jabatan_karyawan` b
				  ON a.`jabatan_karyawan` = b.`no_jabatan_karyawan`
				WHERE a.`status_manager` = '$status_manager'
				AND a.`status_cancel` = '0'
				AND DATE(a.`submit_date`) BETWEEN '$date1' 
				  AND '$date2' 
				ORDER BY a.`tanggal_manager` DESC
				";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function updateApprovalManager($data, $no_pengajuan)
	{
		$this->db2->update('tbl_karyawan_ptk', $data, ['no_pengajuan' => $no_pengajuan]);
		return $this->db2->affected_rows();
	}

	public function getDataPengajuan($jabatan_ptk = null)
	{
		$sql = "SELECT 
				  a.*,
				  b.`jabatan_karyawan` AS 'nama_jabatan' 
				FROM
				  `tbl_karyawan_ptk` a 
				  INNER JOIN `tbl_jabatan_karyawan` b 
				    ON a.`jabatan_karyawan` = b.`no_jabatan_karyawan` 
				WHERE a.`status_manager` = '1' 
				  AND a.`status_hrd` = '1' 
				  AND a.`status_atasan` = '1' 
				  AND a.`status_pengajuan` = '0' 
				  AND a.`status_manager` IS NOT NULL
				  AND a.`jabatan_ptk` = '$jabatan_ptk'
				  AND a.`status_cancel` = '0'
				  AND a.`status_loker` = '0'
				ORDER BY a.`no_pengajuan` DESC 
				";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}


	// no_pengajuan //
	public function getNoPengajuan()
	{
		$sql = "SELECT 
				  LEFT(
				    a.`no_ptk`,
				    POSITION('/' IN a.`no_ptk`) - 1
				  ) + 1 AS no_pengajuan 
				FROM
				  `tbl_karyawan_ptk` a 
				WHERE a.`no_ptk` IS NOT NULL 
				ORDER BY a.`no_ptk` DESC 
				LIMIT 1  
				";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}


	public function getTempat($kode_dms = null)
	{
		$sql = "SELECT 
				  b.`tempat` 
				FROM
				  `tbl_depo` a 
				  INNER JOIN `tbl_office` b 
				    ON a.`office_id` = b.`office_id` 
				WHERE a.`depo_nama` = '$kode_dms'  
				";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}


	public function getById($no_pengajuan = null)
	{
		$sql = "SELECT 
				  a.*,
				  b.`jabatan_karyawan` as 'nama_jabatan'
				FROM
				  `tbl_karyawan_ptk` a 
				  INNER JOIN `tbl_jabatan_karyawan` b
				  ON a.`jabatan_karyawan` = b.`no_jabatan_karyawan`
				WHERE a.`no_pengajuan` = '$no_pengajuan' 
				";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}


	
}

?>