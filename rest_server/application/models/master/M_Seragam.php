<?php

/**
 * 
 */
class M_Seragam extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function getSeragam($id = null)
	{
		if ($id === null) {
			return $this->db_absensi->get('tbl_seragam')->result_array();
		} else {
			return $this->db_absensi->get_where('tbl_seragam', ['id_seragam' => $id])->result_array();
		}
	}
}
