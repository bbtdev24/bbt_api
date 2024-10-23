<?php

/**
 * 
 */
class M_Perusahaan extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getPerusahaan($id = null)
	{
		if ($id === null) {
			return $this->db2->get('tbl_perusahaan')->result_array();
		} else {
			return $this->db2->get_where('tbl_perusahaan', ['perusahaan_id' => $id])->result_array();
		}
	}

	public function getkode($kode_perusahaan = null)
	{
		if ($kode_perusahaan === null) {
			return $this->db2->get('tbl_perusahaan')->result_array();
		} else {
			return $this->db2->get_where('tbl_perusahaan', ['kode_perusahaan' => $kode_perusahaan])->result_array();
		}
	}

}

?>