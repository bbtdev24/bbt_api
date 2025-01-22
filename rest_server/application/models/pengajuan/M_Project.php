<?php

/**
 * 
 */
class M_Project extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_index_project($nik_pengajuan = null)
	{
		if ($nik_pengajuan === null) {
			$sql="SELECT 
				`tbl_karyawan_project`.`nik_pengajuan`
				, `tbl_karyawan_project`.`start_date`
				, `tbl_karyawan_project`.`end_date`
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, `tbl_karyawan_project`.`nik_karyawan`
				, `tbl_karyawan_project`.`depo_karyawan`
				, `tbl_karyawan_project`.`upload_dokumen`
			FROM `tbl_karyawan_project`
			INNER JOIN `tbl_karyawan_struktur`
				ON `tbl_karyawan_struktur`.`nik_baru` = `tbl_karyawan_project`.`nik_karyawan`" ;
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		} else {
			$sql="SELECT 
				`tbl_karyawan_project`.`nik_pengajuan`
				, `tbl_karyawan_project`.`start_date`
				, `tbl_karyawan_project`.`end_date`
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, `tbl_karyawan_project`.`nik_karyawan`
				, `tbl_karyawan_project`.`depo_karyawan`
				, `tbl_karyawan_project`.`upload_dokumen`
			FROM `tbl_karyawan_project`
			INNER JOIN `tbl_karyawan_struktur`
				ON `tbl_karyawan_struktur`.`nik_baru` = `tbl_karyawan_project`.`nik_karyawan`
			WHERE `tbl_karyawan_project`.`nik_pengajuan` = '$nik_pengajuan'";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		}
	}

	public function createProject($data)
	{
		$this->db2->insert('tbl_karyawan_project', $data);
		return $this->db2->affected_rows();
	}

	public function gantiJabatan($data, $nik_baru)
	{
		$this->db2->update('tbl_karyawan_struktur', $data, ['nik_baru' => $nik_baru]);
		return $this->db2->affected_rows();
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