<?php

/**
 * 
 */
class M_Login extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function getUser($id = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($id === null) {
			$this->db->select('ks.id_struktur
				, ks.nik_baru
				, ks.password
				, ks.nama_karyawan_struktur
				, jk.level_jabatan_karyawan
				, ks.jabatan_hrd AS jabatan_struktur
				, jk.jabatan_karyawan
				, dp.kode_departement
				, dp.nama_departement
				, jk.dept_jabatan_karyawan
				, ks.lokasi_hrd AS lokasi_struktur
				, dpo.`kode_dms` as szBranch
				, ks.`perusahaan_struktur`
				, pr.`perusahaan_status`
				, ks.nama_atasan_struktur
				, jk.area
				, u.userid
				, d.`no_hp`
				, ks.`status_karyawan`
				, ks.`status_update`
			');
			$this->db->from('tbl_karyawan_struktur ks');
			$this->db->join('userinfo u', 'u.badgenumber = ks.nik_baru', 'left');
			$this->db->join('tbl_jabatan_karyawan jk', 'ks.jabatan_hrd = jk.no_jabatan_karyawan', 'left');
			$this->db->join('`tbl_karyawan_detail` d', 'd.`nik_baru` = ks.`nik_baru`', 'left');
			$this->db->join('`tbl_perusahaan` pr', 'pr.`perusahaan_nama` = ks.`perusahaan_struktur`', 'left');
			$this->db->join('`tbl_departement` dp', 'jk.dept_jabatan_karyawan = dp.`departement_id`', 'left');
			$this->db->join('`tbl_depo` dpo', 'ks.lokasi_hrd = dpo.`depo_nama`', 'left');

			$get = $this->db->get();
			return $get->result_array();
		} else {
			$this->db->select('ks.id_struktur
				, ks.nik_baru
				, ks.password
				, ks.nama_karyawan_struktur
				, jk.level_jabatan_karyawan
				, ks.jabatan_hrd AS jabatan_struktur
				, jk.jabatan_karyawan
				, dp.kode_departement
				, dp.nama_departement
				, jk.dept_jabatan_karyawan
				, ks.lokasi_hrd AS lokasi_struktur
				, dpo.`kode_dms` as szBranch
				, ks.`perusahaan_struktur`
				, pr.`perusahaan_status`
				, ks.nama_atasan_struktur
				, jk.area
				, u.userid
				, d.`no_hp`
				, ks.`status_karyawan`
				, ks.`status_update`
			');
			$this->db->from('tbl_karyawan_struktur ks');
			$this->db->join('userinfo u', 'u.badgenumber = ks.nik_baru', 'left');
			$this->db->join('tbl_jabatan_karyawan jk', 'ks.jabatan_hrd = jk.no_jabatan_karyawan', 'left');
			$this->db->join('`tbl_karyawan_detail` d', 'd.`nik_baru` = ks.`nik_baru`', 'left');
			$this->db->join('`tbl_perusahaan` pr', 'pr.`perusahaan_nama` = ks.`perusahaan_struktur`', 'left');
			$this->db->join('`tbl_depo` dpo', 'ks.lokasi_hrd = dpo.`depo_nama`', 'left');
			$this->db->where(['ks.nik_baru' => $id, 'ks.status_karyawan' => '0']);
			$this->db->join('`tbl_departement` dp', 'jk.dept_jabatan_karyawan = dp.`departement_id`', 'left');

			$get = $this->db->get();
			return $get->result_array();
		}
	}

	public function getDepart($depart = null)
	{
		// return $this->db->get('tbl_user')->result_array();
		if ($depart === null) {
			$this->db->select('ks.id_struktur
				, ks.nik_baru
				, ks.password
				, ks.nama_karyawan_struktur
				, jk.level_jabatan_karyawan
				, ks.jabatan_hrd AS jabatan_struktur
				, jk.dept_jabatan_karyawan
				, ks.lokasi_hrd AS lokasi_struktur
				, ks.`perusahaan_struktur`
				, ks.nama_atasan_struktur
				, jk.area
				, u.userid
				, d.`no_hp`
				, ks.`status_karyawan`
			');
			$this->db->from('userinfo u');
			$this->db->join('tbl_karyawan_struktur ks', 'u.badgenumber = ks.nik_baru', 'left');
			$this->db->join('tbl_jabatan_karyawan jk', 'ks.jabatan_hrd = jk.no_jabatan_karyawan', 'left');
			$this->db->join('`tbl_karyawan_detail` d', 'd.`nik_baru` = ks.`nik_baru`', 'left');

			$get = $this->db->get();
			return $get->result_array();
		} else {
			$this->db->select('ks.id_struktur
				, ks.nik_baru
				, ks.password
				, ks.nama_karyawan_struktur
				, jk.level_jabatan_karyawan
				, ks.jabatan_hrd AS jabatan_struktur
				, jk.dept_jabatan_karyawan
				, ks.lokasi_hrd AS lokasi_struktur
				, ks.`perusahaan_struktur`
				, ks.nama_atasan_struktur
				, jk.area
				, u.userid
				, d.`no_hp`
				, ks.`status_karyawan`
			');
			$this->db->from('userinfo u');
			$this->db->join('tbl_karyawan_struktur ks', 'u.badgenumber = ks.nik_baru', 'left');
			$this->db->join('tbl_jabatan_karyawan jk', 'ks.jabatan_hrd = jk.no_jabatan_karyawan', 'left');
			$this->db->join('`tbl_karyawan_detail` d', 'd.`nik_baru` = ks.`nik_baru`', 'left');
			$this->db->where(['jk.dept_jabatan_karyawan' => $depart]);

			$get = $this->db->get();
			return $get->result_array();
		}
	}

	public function getLoginKbkm($nik_ktp)
	{
		$sql = "SELECT * FROM tbl_karyawan_tkbm WHERE nik = '$nik_ktp' 
				AND(STATUS ='1' OR STATUS = '2')ORDER BY ID DESC LIMIT 1";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function updatePassword($data, $id, $password)
	{
		$this->db_absensi->update('tbl_karyawan_struktur', $data, ['nip' => $id, 'password' => $password]);
		return $this->db_absensi->affected_rows();
	}


	public function getLoginByAbsensi($nip_karyawan)
	{
		$sql = "SELECT 
		a.`noUrut`,
		a.`nip`,
		a.`idJabatanHrd` AS idJabatan,
		a.`idLokasiHrd` AS idLokasi,
		a.`idBagian`,
		a.`idDivisi`,
		a.`namaKaryawan` AS nama_karyawan_struktur,
		b.`jabatanKaryawan` AS jabatan_karyawan,
		c.`namaDivisi`,
		e.`namaBagian`,
		d.`namaLokasi`,
		a.`statusKaryawan`,
		f.`perusahaan_nama`,
		a.`password` 
		FROM
		`tbl_karyawan_struktur` a 
		LEFT JOIN `tbl_jabatan` b 
			ON a.`idJabatanHrd` = b.`idJabatan` 
		LEFT JOIN `tbl_divisi` c 
			ON a.`idDivisi` = c.`idDivisi` 
		LEFT JOIN `tbl_bagian` e 
			ON e.`idBagian` = c.`idBagian`   
		LEFT JOIN `tbl_lokasi` d 
			ON a.`idLokasiHrd` = d.`idLokasi` 
		LEFT JOIN `tbl_perusahaan` f 
			ON a.`idPerusahaan` = f.`perusahaan_id` 
		WHERE a.`nip` = '$nip_karyawan'";

		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}
}
