<?php

/**
 * 
 */
class M_Jabatan extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getJabatan($id = null)
	{
		if ($id === null) {
			return $this->db2->get('tbl_jabatan_karyawan')->result_array();
		} else {
			return $this->db2->get_where('tbl_jabatan_karyawan', ['no_jabatan_karyawan' => $id])->result_array();
		}
	}

	public function getJabatanDepart($dept = null)
	{
		if ($dept === null) {
			return $this->db2->get('tbl_jabatan_karyawan')->result_array();
		} else {
			return $this->db2->get_where('tbl_jabatan_karyawan', ['dept_jabatan_karyawan' => $dept])->result_array();
		}
	}

}

?>