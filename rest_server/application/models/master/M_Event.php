<?php

/**
 * 
 */
class M_Event extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getEvent($birth_date = null)
	{
		if ($birth_date === null) {
			return $this->db2->get('events')->result_array();
		} else {
			return $this->db2->get_where('events', 
				['birth_date' => $birth_date])->result_array();
		}
		
	}

}

?>