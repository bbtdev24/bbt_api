<?php

/**
 * 
 */
class M_User extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getUser($id = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($id === null) {
			return $this->db->get('tbl_user')->result_array();
		} else {
			return $this->db->get_where('tbl_user', ['id' => $id])->result_array();
		}
	}

	public function deleteUser($id)
	{
		$this->db->delete('tbl_user', ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function createUser($data)
	{
		$this->db->insert('tbl_user', $data);
		return $this->db->affected_rows();
	}

	public function updateUser($data, $id)
	{
		$this->db->update('tbl_user', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}
}

?>