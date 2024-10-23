<?php

/**
 * 
 */
class M_Departement extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getDepartement($departement_id = null)
	{
		if ($departement_id === null) {
			return $this->db2->get('tbl_departement')->result_array();
		} else {
			return $this->db2->get_where('tbl_departement', 
				['departement_id' => $departement_id])->result_array();
		}
	}

}

?>