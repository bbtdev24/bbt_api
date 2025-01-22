<?php

/**
 * 
 */
class M_Team extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getJabatan($jabatan = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($jabatan === null) {
			$sql = "
	            SELECT
	                `tbl_karyawan_struktur`.`nik_baru`
	                , `tbl_karyawan_struktur`.`nik_lama`
	                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
	                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
	                , `tbl_jabatan_karyawan`.`level_jabatan_karyawan`
	                , `tbl_karyawan_struktur`.`lokasi_hrd` AS lokasi_struktur
	                , `tbl_karyawan_struktur`.`perusahaan_struktur`
	                , `tbl_karyawan_struktur`.`level_struktur`
	                , `tbl_karyawan_struktur`.`dept_struktur`
	                , `tbl_karyawan_struktur`.`join_date_struktur`
	            FROM `tbl_jabatan_karyawan_approval`
	            INNER JOIN `tbl_jabatan_karyawan` 
	            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            INNER JOIN `tbl_karyawan_struktur`
	            ON tbl_karyawan_struktur.`jabatan_hrd` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            WHERE `tbl_karyawan_struktur`.`status_karyawan` = '0'
	        ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
	    } else if ($jabatan == 306){
	    	$sql = "
	            SELECT
	                `tbl_karyawan_struktur`.`nik_baru`
	                , `tbl_karyawan_struktur`.`nik_lama`
	                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
	                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
	                , `tbl_jabatan_karyawan`.`level_jabatan_karyawan`
	                , `tbl_karyawan_struktur`.`lokasi_hrd` AS lokasi_struktur
	                , `tbl_karyawan_struktur`.`perusahaan_struktur`
	                , `tbl_karyawan_struktur`.`level_struktur`
	                , `tbl_karyawan_struktur`.`dept_struktur`
	                , `tbl_karyawan_struktur`.`join_date_struktur`
	            FROM `tbl_jabatan_karyawan_approval`
	            INNER JOIN `tbl_jabatan_karyawan` 
	            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            INNER JOIN `tbl_karyawan_struktur`
	            ON tbl_karyawan_struktur.`jabatan_hrd` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            WHERE dept_struktur = 'Warehouse Operation' AND level_jabatan_karyawan = '1' OR level_jabatan_karyawan = '2'
	            OR level_jabatan_karyawan = '3'
	        ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else if ($jabatan == 302){
	    	$sql = "SELECT
	                `tbl_karyawan_struktur`.`nik_baru`
	                , `tbl_karyawan_struktur`.`nik_lama`
	                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
	                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
	                , `tbl_jabatan_karyawan`.`level_jabatan_karyawan`
	                , `tbl_karyawan_struktur`.`lokasi_hrd` AS lokasi_struktur
	                , `tbl_karyawan_struktur`.`perusahaan_struktur`
	                , `tbl_karyawan_struktur`.`level_struktur`
	                , `tbl_karyawan_struktur`.`dept_struktur`
	                , `tbl_karyawan_struktur`.`join_date_struktur`
	            FROM `tbl_jabatan_karyawan_approval`
	            INNER JOIN `tbl_jabatan_karyawan` 
	            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            INNER JOIN `tbl_karyawan_struktur`
	            ON tbl_karyawan_struktur.`jabatan_hrd` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            WHERE `tbl_karyawan_struktur`.`status_karyawan` = '0'
	            AND (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='302' 
	            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='302')
	            OR tbl_karyawan_struktur.`jabatan_hrd`='305' 
	            AND tbl_karyawan_struktur.`nik_baru` NOT LIKE '%.%'";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else {
			$sql = "
	            SELECT
	                `tbl_karyawan_struktur`.`nik_baru`
	                , `tbl_karyawan_struktur`.`nik_lama`
	                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
	                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
	                , `tbl_jabatan_karyawan`.`level_jabatan_karyawan`
	                , `tbl_karyawan_struktur`.`lokasi_hrd` AS lokasi_struktur
	                , `tbl_karyawan_struktur`.`perusahaan_struktur`
	                , `tbl_karyawan_struktur`.`level_struktur`
	                , `tbl_karyawan_struktur`.`dept_struktur`
	                , `tbl_karyawan_struktur`.`join_date_struktur`
	            FROM `tbl_jabatan_karyawan_approval`
	            INNER JOIN `tbl_jabatan_karyawan` 
	            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            INNER JOIN `tbl_karyawan_struktur`
	            ON tbl_karyawan_struktur.`jabatan_hrd` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            WHERE `tbl_karyawan_struktur`.`status_karyawan` = '0'
	            AND (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
	            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		}
	}

	public function getManager()
	{
		$sql="SELECT
	                `tbl_karyawan_struktur`.`nik_baru`
	                , `tbl_karyawan_struktur`.`nik_lama`
	                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
	                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
	                , `tbl_jabatan_karyawan`.`level_jabatan_karyawan`
	                , `tbl_karyawan_struktur`.`lokasi_hrd` AS lokasi_struktur
	                , `tbl_karyawan_struktur`.`perusahaan_struktur`
	                , `tbl_karyawan_struktur`.`level_struktur`
	                , `tbl_karyawan_struktur`.`dept_struktur`
	                , `tbl_karyawan_struktur`.`join_date_struktur`
	            FROM `tbl_jabatan_karyawan_approval`
	            INNER JOIN `tbl_jabatan_karyawan` 
	            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            INNER JOIN `tbl_karyawan_struktur`
	            ON tbl_karyawan_struktur.`jabatan_hrd` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            WHERE `tbl_karyawan_struktur`.`status_karyawan` = '0'
	            AND `tbl_jabatan_karyawan`.`level_jabatan_karyawan`= '8'
	            OR `tbl_karyawan_struktur`.`nik_baru` = '0100003200'
	            OR `tbl_karyawan_struktur`.`nik_baru` = '0100042800'";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();

	}

	public function getTeamRdamt($jabatan = null)
	{
		$sql="SELECT
				  `tbl_karyawan_struktur`.`nik_baru`
				, `tbl_karyawan_struktur`.`nik_lama`
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, `tbl_jabatan_karyawan`.`jabatan_karyawan`
				, `tbl_jabatan_karyawan`.`level_jabatan_karyawan`
				, `tbl_karyawan_struktur`.`lokasi_hrd` AS lokasi_struktur
				, `tbl_karyawan_struktur`.`perusahaan_struktur`
				, `tbl_karyawan_struktur`.`level_struktur`
				, `tbl_karyawan_struktur`.`dept_struktur`
				, `tbl_karyawan_struktur`.`join_date_struktur`
	            FROM `tbl_jabatan_karyawan_approval`
			    INNER JOIN `tbl_jabatan_karyawan` 
		    ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
   				INNER JOIN `tbl_karyawan_struktur`
		    ON tbl_karyawan_struktur.`jabatan_hrd` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
			    WHERE `tbl_karyawan_struktur`.`status_karyawan` = '0'
		    AND (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		    OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
		    AND level_jabatan_karyawan NOT IN ('3')
		    AND level_jabatan_karyawan NOT IN ('2')
		    AND level_jabatan_karyawan NOT IN ('1')";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function get_team_lokasi($jabatan = null, $lokasi = null)
	{
		if ($lokasi == 'Pusat') {
			$sql = "
	            SELECT
	                `tbl_karyawan_struktur`.`nik_baru`
	                , `tbl_karyawan_struktur`.`nik_lama`
	                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
	                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
	                , `tbl_jabatan_karyawan`.`level_jabatan_karyawan`
	                , `tbl_karyawan_struktur`.`lokasi_hrd` AS lokasi_struktur
	                , `tbl_karyawan_struktur`.`perusahaan_struktur`
	                , `tbl_karyawan_struktur`.`level_struktur`
	                , `tbl_karyawan_struktur`.`dept_struktur`
	                , `tbl_karyawan_struktur`.`join_date_struktur`
	            FROM `tbl_jabatan_karyawan_approval`
	            INNER JOIN `tbl_jabatan_karyawan` 
	            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            INNER JOIN `tbl_karyawan_struktur`
	            ON tbl_karyawan_struktur.`jabatan_hrd` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            WHERE `tbl_karyawan_struktur`.`status_karyawan` = '0'
	            AND (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
	            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')
	        ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else {
			$sql = "
	            SELECT
	                `tbl_karyawan_struktur`.`nik_baru`
	                , `tbl_karyawan_struktur`.`nik_lama`
	                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
	                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
	                , `tbl_jabatan_karyawan`.`level_jabatan_karyawan`
	                , `tbl_karyawan_struktur`.`lokasi_hrd` AS lokasi_struktur
	                , `tbl_karyawan_struktur`.`perusahaan_struktur`
	                , `tbl_karyawan_struktur`.`level_struktur`
	                , `tbl_karyawan_struktur`.`dept_struktur`
	                , `tbl_karyawan_struktur`.`join_date_struktur`
	            FROM `tbl_jabatan_karyawan_approval`
	            INNER JOIN `tbl_jabatan_karyawan` 
	            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            INNER JOIN `tbl_karyawan_struktur`
	            ON tbl_karyawan_struktur.`jabatan_hrd` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
	            WHERE `tbl_karyawan_struktur`.`status_karyawan` = '0'
	            AND lokasi_hrd = '$lokasi'
	            AND (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan'
	            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')

	        ";
	        $hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		}
	}


}



?>