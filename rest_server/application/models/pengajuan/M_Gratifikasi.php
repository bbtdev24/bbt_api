<?php

/**
 * 
 */
class M_Gratifikasi extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_NoPengajuan()
	{
		$sql="SELECT 
				  CONCAT(
				    LPAD(COUNT(a.`idGratifikasi`) + 1, 4, '0'),
				    '/',
				    DATE_FORMAT(CURDATE(), '%Y/%m/%d')
				  ) AS formatted_count_with_date 
				FROM
				  `datagratifikasi` a
				  WHERE DATE(a.`dtmCreated`) = CURDATE()";
        $hasil = $this->db17->query($sql);
	   	return $hasil->result_array();
	}

	public function get_NoPengajuanGambar()
	{
		$sql="SELECT 
				  LPAD(COUNT(a.`idGratifikasi`) + 1, 4, '0') AS image_number 
				FROM
				  `datagratifikasi` a";
        $hasil = $this->db17->query($sql);
	   	return $hasil->result_array();
	}

	public function get_gratifikasi($nik_baru = null, $date = null, $date2 = null)
	{
		$sql="SELECT 
				  b.`nama_karyawan_struktur`,
				  a.nomorLaporan,
				  a.jabatan,
				  a.departement,
				  a.pemberi,
				  a.keterangan,
				  a.fotoBukti,
				  a.tglKejadian,
  				  CONCAT('Rp. ', FORMAT(a.`nominal`, 0, 'id_ID')) AS 'nominal' 
				FROM
				  `companyprofile`.`datagratifikasi` a 
				  INNER JOIN `tbl_karyawan_struktur` b 
				    ON a.`namaPenerima` = b.`nik_baru` 
				WHERE a.`userCreated` = '$nik_baru' 
				  AND DATE(a.`dtmCreated`) BETWEEN '$date' 
				  AND '$date2' 
				ORDER BY a.`idGratifikasi` DESC ;
				";
        $hasil = $this->db17->query($sql);
	   	return $hasil->result_array();
	}

	public function create_gratifikasi($data)
    {
        $this->db17->insert('datagratifikasi', $data);
        return $this->db17->affected_rows();
    }

}

?>