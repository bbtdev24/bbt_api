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
		$where = " absensi_new.`tbl_karyawan_seragam_kembali`.`id` is not null";
        
        if ($nik_baru!='') {
            $where .= "  and absensi_new.`tbl_karyawan_seragam_kembali`.`nik_pengajuan` = '$nik_baru'";
        }

		if ($nik_baru === null) {
			$sql="SELECT 
				absensi_new.`tbl_karyawan_seragam_kembali`.`id`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`submit_date`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`no_pengajuan`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`nik_pengajuan`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`ket_pengajuan`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`nik_baru`
				, absensi_new.`tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`id_seragam`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`qty_seragam`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`harga_satuan`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`tanggal_pengembalian`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`ket_tambahan`
			FROM absensi_new.`tbl_karyawan_seragam_kembali` INNER JOIN absensi_new.`tbl_karyawan_struktur`
				ON absensi_new.`tbl_karyawan_seragam_kembali`.`nik_baru` = absensi_new.`tbl_karyawan_struktur`.
				`nik_baru`" ;
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		} else {
			$sql="SELECT 
				absensi_new.`tbl_karyawan_seragam_kembali`.`id`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`submit_date`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`no_pengajuan`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`nik_pengajuan`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`ket_pengajuan`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`nik_baru`
				, absensi_new.`tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`id_seragam`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`qty_seragam`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`harga_satuan`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`tanggal_pengembalian`
				, absensi_new.`tbl_karyawan_seragam_kembali`.`ket_tambahan`
			FROM absensi_new.`tbl_karyawan_seragam_kembali` INNER JOIN absensi_new.`tbl_karyawan_struktur`
				ON absensi_new.`tbl_karyawan_seragam_kembali`.`nik_baru` = absensi_new.`tbl_karyawan_struktur`.
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