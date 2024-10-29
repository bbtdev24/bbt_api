<?php

/**
 * 
 */
class M_Jam_Kerja extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getJamkerja($id = null)
	{
		if ($id === null) {
			return $this->db2->get('tbl_shifting')->result_array();
		} else {
			return $this->db2->get_where('tbl_shifting', ['id_shifting' => $id])->result_array();
		}
	}

}

?>