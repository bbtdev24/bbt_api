<?php

/**
 * 
 */
class M_Notifikasi extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getEmployeeToken($nik_baru = null)
	{
		$sql="SELECT 
				  * 
		FROM `master_device_info` a 
		WHERE a.`nik_baru` = '$nik_baru' AND a.apps = 'ESS'";
	    $hasil = $this->db_absensi->query($sql);
	    return $hasil->result_array();
	}

	public function putDeviceId($data, $nik_baru)
	{
		$this->db_absensi->update('master_device_info', $data, ['nik_baru' => $nik_baru, 'apps' => 'ESS']);
		return $this->db_absensi->affected_rows();
	}

	public function createDeviceId($data)
	{
		$this->db_absensi->insert('master_device_info', $data);
		return $this->db_absensi->affected_rows();
	}

	// public function getToken_old($no_jabatan_karyawan = null, $lokasi_hrd)
	// {
	// 	$sql="SELECT 
	// 			  b.`nik_baru`,
	// 			  b.`nama_karyawan_struktur`,
	// 			  c.`jabatan_karyawan`,
	// 			  d.`device_token` 
	// 			FROM
	// 			  absensi_new.`tbl_jabatan_karyawan_approval` a 
	// 			  LEFT JOIN absensi_new.`tbl_karyawan_struktur` b 
	// 			    ON a.`no_jabatan_karyawan_atasan_1` = b.`jabatan_hrd` 
	// 			  INNER JOIN absensi_new.`tbl_jabatan_karyawan` c 
	// 			    ON b.`jabatan_hrd` = c.`no_jabatan_karyawan` 
	// 			  INNER JOIN `absensi_new`.`master_device_info` d 
	// 			    ON b.`nik_baru` = d.`nik_baru` 
	// 			WHERE a.`no_jabatan_karyawan` = '$no_jabatan_karyawan' 
	// 			  AND b.`lokasi_hrd` = '$lokasi_hrd' 
	// 			  AND b.`status_karyawan` = '0' 
	// 			  AND d.status_user = '1' 
	// 			GROUP BY b.`nik_baru` 
	// 			LIMIT 1  ";
	//     $hasil = $this->db_absensi->query($sql);
	//     return $hasil->result_array();
	// }

	public function getToken_old($no_jabatan_karyawan = null, $lokasi_hrd)
	{
		$sql="SELECT 
			b.nip,
			b.namakaryawan,
			c.jabatanKaryawan,
			d.device_token 
			FROM
			tbl_jabatan_approval a 
			LEFT JOIN tbl_karyawan_struktur b ON a.idJabatanAtasan1 = b.idJabatanHrd
			INNER JOIN tbl_jabatan c 
				ON b.idJabatanHrd = c.idJabatan
			INNER JOIN master_device_info d 
				ON    b.nip            = d.nik_baru
				WHERE a.idJabatan      = '$no_jabatan_karyawan'
				AND   b.idlokasiHrd    = '$lokasi_hrd'
				AND   b.statusKaryawan = '0'
				AND   d.status_user    = '1'
			GROUP BY b.nip ";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function getToken($id_jabatan_karyawan = null, $lokasi_hrd = null, $id_divisi = null, $id_bagian = null)
	{
		$sql="SELECT 
		b.nip,
		b.namakaryawan,
		c.jabatanKaryawan,
		d.device_token 
		FROM tbl_jabatan_approval a 
		LEFT JOIN tbl_karyawan_struktur b ON a.idJabatanAtasan1 = b.idJabatanHrd 
		INNER JOIN tbl_jabatan c ON b.idJabatanHrd = c.idJabatan 
		INNER JOIN master_device_info d ON b.nip = d.nik_baru 
		WHERE a.idJabatan = '$id_jabatan_karyawan' 
		AND b.idlokasiHrd = '$lokasi_hrd' 
		AND b.statusKaryawan = '0' 
		AND d.status_user = '1' 
		AND (b.idDivisi = '$id_divisi' 
			OR b.idBagian = '$id_bagian') 
		GROUP BY b.nip";

		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}


	public function getTokenNikBaru($nik_baru = null)
	{
		$sql="SELECT 
			  d.`device_token` 
			FROM
			  `master_device_info` d 
			WHERE d.`nik_baru` = '$nik_baru'
			and d.status_user = '1'";
	    $hasil = $this->db_absensi->query($sql);
	    return $hasil->result_array();
	}

	



}



?>