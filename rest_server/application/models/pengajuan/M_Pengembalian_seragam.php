<?php

/**
 * 
 */
class M_Pengembalian_seragam extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_index_seragam($nik_baru = null)
	{
		$where = " `tbl_karyawan_seragam_kembali`.`id` is not null";
        
        if ($nik_baru!='') {
            $where .= "  and `tbl_karyawan_seragam_kembali`.`nik_pengajuan` = '$nik_baru'";
        }

		if ($nik_baru === null) {
			$sql="SELECT 
				`tbl_karyawan_seragam_kembali`.`id`
				, `tbl_karyawan_seragam_kembali`.`submit_date`
				, `tbl_karyawan_seragam_kembali`.`no_pengajuan`
				, `tbl_karyawan_seragam_kembali`.`nik_pengajuan`
				, `tbl_karyawan_seragam_kembali`.`ket_pengajuan`
				, `tbl_karyawan_seragam_kembali`.`nik_baru`
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, `tbl_karyawan_seragam_kembali`.`id_seragam`
				, `tbl_karyawan_seragam_kembali`.`qty_seragam`
				, `tbl_karyawan_seragam_kembali`.`harga_satuan`
				, `tbl_karyawan_seragam_kembali`.`tanggal_pengembalian`
				, `tbl_karyawan_seragam_kembali`.`ket_tambahan`
			FROM `tbl_karyawan_seragam_kembali` INNER JOIN `tbl_karyawan_struktur`
				ON `tbl_karyawan_seragam_kembali`.`nik_baru` = `tbl_karyawan_struktur`.
				`nik_baru`" ;
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		} else {
			$sql="SELECT 
				`tbl_karyawan_seragam_kembali`.`id`
				, `tbl_karyawan_seragam_kembali`.`submit_date`
				, `tbl_karyawan_seragam_kembali`.`no_pengajuan`
				, `tbl_karyawan_seragam_kembali`.`nik_pengajuan`
				, `tbl_karyawan_seragam_kembali`.`ket_pengajuan`
				, `tbl_karyawan_seragam_kembali`.`nik_baru`
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, `tbl_karyawan_seragam_kembali`.`id_seragam`
				, `tbl_karyawan_seragam_kembali`.`qty_seragam`
				, `tbl_karyawan_seragam_kembali`.`harga_satuan`
				, `tbl_karyawan_seragam_kembali`.`tanggal_pengembalian`
				, `tbl_karyawan_seragam_kembali`.`ket_tambahan`
			FROM `tbl_karyawan_seragam_kembali` INNER JOIN `tbl_karyawan_struktur`
				ON `tbl_karyawan_seragam_kembali`.`nik_baru` = `tbl_karyawan_struktur`.
				`nik_baru`			
				WHERE $where";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		}
	}

	public function createPengembalian($data)
	{
		$this->db2->insert('tbl_karyawan_seragam_kembali', $data);
		return $this->db2->affected_rows();
	}

}

?>