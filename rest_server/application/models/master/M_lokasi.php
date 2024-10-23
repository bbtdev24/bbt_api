<?php

/**
 * 
 */
class M_lokasi extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getLokasi($lokasi = null)
	{
		if ($lokasi === null) {
			$sql="SELECT 
					tbl.`depo_id`,
					tbl.`kode_nik_depo`,
					tbl.`kode_dms`,
					tbl.`depo_nama`,
					sn.`SN`,
					tbl.`id_company`
				FROM tbl_depo tbl JOIN sn_depo sn ON tbl.depo_id= sn.depo_id
				GROUP BY depo_id";
        		$hasil = $this->db2->query($sql);
    			return $hasil->result_array();
    	} else {
    		$sql="SELECT 
					tbl.`depo_id`,
					tbl.`kode_nik_depo`,
					tbl.`kode_dms`,
					tbl.`depo_nama`,
					sn.`SN`,
					tbl.`id_company`
				FROM tbl_depo tbl JOIN sn_depo sn ON tbl.depo_id= sn.depo_id WHERE tbl.`kode_dms` = '$lokasi'
				GROUP BY depo_id";
        		$hasil = $this->db2->query($sql);
    			return $hasil->result_array();
    	}
	}

	public function getkodeLokasi($namadepo = null)
	{
    		$sql="SELECT 
					tbl.`depo_id`,
					tbl.`kode_nik_depo`,
					tbl.`kode_dms`,
					tbl.`depo_nama`,
					tbl2.`depo_kode`,
					sn.`SN`
						FROM tbl_depo tbl JOIN sn_depo sn ON tbl.depo_id= sn.depo_id
						JOIN tbl_depo tbl2 ON tbl.`depo_nama` = tbl2.`depo_nama`
						WHERE tbl.`depo_nama` = '$namadepo'";
        		$hasil = $this->db2->query($sql);
    			return $hasil->result_array();
	}

	public function getkodenikdepo($kode_dms = null)
	{
    	$sql="SELECT * FROM tbl_depo WHERE kode_dms = '$kode_dms'";
       	$hasil = $this->db2->query($sql);
    	return $hasil->result_array();
	}

	public function getDepo($depo_nama = null)
	{
    	$sql="SELECT * FROM tbl_depo WHERE depo_nama = '$depo_nama'";
       	$hasil = $this->db2->query($sql);
    	return $hasil->result_array();
	}

	public function getLokasi_kode($kode = null)
	{
		if ($kode === null) {
			$sql="SELECT 
					tbl.`depo_id`,
					tbl.`kode_nik_depo`,
					tbl.`kode_dms`,
					tbl.`depo_nama`,
					sn.`SN`
				FROM tbl_depo tbl JOIN sn_depo sn ON tbl.depo_id= sn.depo_id";
        		$hasil = $this->db2->query($sql);
    			return $hasil->result_array();
    	} else {
    		$sql="SELECT 
					tbl.`depo_id`,
					tbl.`kode_nik_depo`,
					tbl.`kode_dms`,
					tbl.`depo_nama`,
					sn.`SN`
				FROM tbl_depo tbl JOIN sn_depo sn ON tbl.depo_id= sn.depo_id WHERE tbl.`kode_nik_depo` = '$kode'
				GROUP BY depo_id";
        		$hasil = $this->db2->query($sql);
    			return $hasil->result_array();
    	}
	}

	

}

?>