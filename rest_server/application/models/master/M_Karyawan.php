<?php

/**
 * 
 */
class M_Karyawan extends CI_Model
{

	public function __construct()
	{
		# code...
	}

	public function getKaryawan($lokasi_struktur = null, $nik_baru = null, $keyword = null)
	{
		$where = " ks.`status_karyawan` = '0'
				AND (ks.`nik_baru` NOT LIKE '%.%')";
		if ($lokasi_struktur != '') {
			$where .= " and ks.lokasi_hrd = '$lokasi_struktur'";
		}
		if ($nik_baru != '') {
			$where .= "  and ks.nik_baru = '$nik_baru'";
		}
		if ($keyword != '') {
			$where .= "  and ks.nik_baru LIKE '$keyword%' ORDER BY ks.`nik_baru` DESC LIMIT 0, 1 ";
		}


		$sql = "
            SELECT 
		          ks.`nik_baru`
				, ks.`nama_karyawan_struktur`
				, ks.`lokasi_hrd` AS lokasi_struktur
				, jk.`jabatan_karyawan`
				, ks.`dept_struktur`
				, ks.`perusahaan_struktur`
				, ks.`status_karyawan_struktur`
				, ks.`join_date_struktur`
				, tb.`status_mobile`
		            FROM tbl_karyawan_struktur ks
		            INNER JOIN tbl_karyawan_induk ki
		                ON ki.nik_baru=ks.nik_baru
		            INNER JOIN tbl_jabatan_karyawan jk
		                ON jk.no_jabatan_karyawan=ks.jabatan_hrd
		            INNER JOIN tbl_depo tb
		                ON tb.`depo_nama`=ks.lokasi_hrd
		            WHERE ks.`nama_karyawan_struktur` NOT IN('VICTOR ADIGUNA') 
            AND $where";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}


	public function createDataInduk($data)
	{
		$this->db2->insert('tbl_karyawan_induk', $data);
		return $this->db2->affected_rows();
	}

	public function createDataDetail($data)
	{
		$this->db2->insert('tbl_karyawan_detail', $data);
		return $this->db2->affected_rows();
	}

	public function createDataKeluarga($data)
	{
		$this->db2->insert('tbl_karyawan_keluarga', $data);
		return $this->db2->affected_rows();
	}

	public function createDataSusunanKeluarga($data)
	{
		$this->db2->insert('tbl_karyawan_susunan_keluarga', $data);
		return $this->db2->affected_rows();
	}

	public function createDataAnak($data)
	{
		$this->db2->insert('tbl_karyawan_anak', $data);
		return $this->db2->affected_rows();
	}

	public function createDarurat($data)
	{
		$this->db2->insert('tbl_karyawan_darurat', $data);
		return $this->db2->affected_rows();
	}

	public function createSaudara($data)
	{
		$this->db2->insert('tbl_karyawan_saudara', $data);
		return $this->db2->affected_rows();
	}

	public function createPendidikan($data)
	{
		$this->db2->insert('tbl_karyawan_pendidikan', $data);
		return $this->db2->affected_rows();
	}

	public function createPengalaman($data)
	{
		$this->db2->insert('tbl_karyawan_pengalaman_kerja', $data);
		return $this->db2->affected_rows();
	}

	public function createPelatihan($data)
	{
		$this->db2->insert('tbl_karyawan_pelatihan', $data);
		return $this->db2->affected_rows();
	}

	public function createBahasa($data)
	{
		$this->db2->insert('tbl_karyawan_bahasa', $data);
		return $this->db2->affected_rows();
	}

	public function createHobi($data)
	{
		$this->db2->insert('tbl_karyawan_hobi', $data);
		return $this->db2->affected_rows();
	}

	public function createOrganisasi($data)
	{
		$this->db2->insert('tbl_karyawan_pengalaman_organisasi', $data);
		return $this->db2->affected_rows();
	}

	public function createMinat($data)
	{
		$this->db2->insert('tbl_karyawan_minat', $data);
		return $this->db2->affected_rows();
	}

	public function createStruktur($data)
	{
		$this->db2->insert('tbl_karyawan_struktur', $data);
		return $this->db2->affected_rows();
	}

	public function createKontrak($data)
	{
		$this->db2->insert('tbl_karyawan_kontrak', $data);
		return $this->db2->affected_rows();
	}

	public function getIdSeragam()
	{
		$sql = "SELECT 
				  LPAD(a.no_pengajuan + 1, 4, '0') AS id
				FROM 
				  tbl_karyawan_seragam a
				ORDER BY a.id_karyawan_seragam DESC
				LIMIT 1;";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function getNoUrut()
	{
		$sql = "SELECT 
				 a.`intLastCounter` + 1 AS no_urut 
				FROM
				  `tbl_counter` a 
				  WHERE a.szName = 'NO URUT KARYAWAN'";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function getNoUrutPerId($szId = null)
	{
		$sql = "SELECT 
				  a.`intLastCounter` + 1 AS no_urut 
				FROM
				  `tbl_counter` a 
				WHERE a.szId = '$szId' ";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}



	public function updateNoUrut($data, $szName)
	{
		$this->db2->update('tbl_karyawan_induk', $data, ['szName' => $szName]);
		return $this->db2->affected_rows();
	}

	public function updateNoUrutPerId($data, $szId)
	{
		$this->db2->update('tbl_counter', $data, ['szId' => $szId]);
		return $this->db2->affected_rows();
	}


	public function createSeragam($data)
	{
		$this->db2->insert('tbl_karyawan_seragam', $data);
		return $this->db2->affected_rows();
	}


	// ===== Baru ===== //

	public function getDataInduk($nik_baru = null)
	{
		$sql = "SELECT 
				  a.nik_baru,
				  a.nama_karyawan_struktur,
				  b.`digit_ktp`,
				  b.`digit_npwp`,
				  c.`no_tk`,
				  c.`no_kes`,
				  b.`digit_kk` 
				FROM
				  `tbl_karyawan_struktur` a 
				  LEFT JOIN tbl_karyawan_induk b 
				    ON a.`nik_baru` = b.`nik_baru` 
				  LEFT JOIN tbl_karyawan_bpjs c 
				    ON a.`nik_baru` = c.`nik` 
				WHERE a.`nik_baru` = '$nik_baru' ";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function updateInduk($data, $nik_baru)
	{
		$this->db2->update('tbl_karyawan_induk', $data, ['nik_baru' => $nik_baru]);
		return $this->db2->affected_rows();
	}


	public function getDataDetail($nik_baru = null)
	{
		$sql = "SELECT 
				  a.tanggal_lahir,
				  a.`tempat_lahir`,
				  a.`jenis_kelamin`,
				  a.`status_pernikahan`,
				  a.`alamat_ktp`,
				  a.`no_telp`,
				  a.`no_hp`,
				  a.`email`,
				  a.`alamat_domisili` 
				FROM
				  `tbl_karyawan_detail` a 
				WHERE a.`nik_baru` = '$nik_baru' ";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateDetail($data, $nik_baru)
	{
		$this->db2->update('tbl_karyawan_detail', $data, ['nik_baru' => $nik_baru]);
		return $this->db2->affected_rows();
	}

	public function getSuamiIstri($nik_baru = null)
	{
		$sql = "SELECT 
				  a.nama_keluarga,
				  a.`no_ktp_keluarga`,
				  a.`tanggal_lahir_keluarga`,
				  a.`tempat_lahir_keluarga`,
				  a.`gol_darah_keluarga`,
				  a.`agama_keluarga`,
				  a.`suku_keluarga`,
				  a.kewarganegaraan_keluarga,
				  a.`pendidikan_keluarga` 
				FROM
				  `tbl_karyawan_keluarga` a 
				WHERE a.`nik_baru` = '$nik_baru' ";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateKeluarga($data, $nik_baru)
	{
		$this->db2->update('tbl_karyawan_keluarga', $data, ['nik_baru' => $nik_baru]);
		return $this->db2->affected_rows();
	}

	public function getAnak($nik_baru = null)
	{
		$sql = "SELECT 
        		  a.`id_anak`,
				  a.`urutan_anak`,
				  a.nama_anak,
				  a.`no_ktp_anak`,
				  a.`tanggal_lahir_anak`,
				  a.`tempat_lahir_anak`,
				  a.`gol_darah_anak`,
				  a.`agama_anak`,
				  a.`suku_anak`,
				  a.kewarganegaraan_anak,
				  a.`pendidikan_anak` 
				FROM
				  `tbl_karyawan_anak` a 
				WHERE a.`nik_baru` = '$nik_baru' ";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateHapusAnak($data, $id_anak)
	{
		$this->db2->update('tbl_karyawan_anak', $data, ['id_anak' => $id_anak]);
		return $this->db2->affected_rows();
	}

	public function createPostAnak($data)
	{
		$this->db2->insert('tbl_karyawan_anak', $data);
		return $this->db2->affected_rows();
	}

	public function getSusunanKeluarga($nik_baru = null)
	{
		$sql = "SELECT 
				  a.nama_ayah,
				  a.`tanggal_lahir_ayah`,
				  a.`jenis_kelamin_ayah`,
				  a.`pekerjaan_ayah`,
				  a.`pendidikan_ayah`,
				  a.nama_ibu,
				  a.`tanggal_lahir_ibu`,
				  a.`jenis_kelamin_ibu`,
				  a.`pekerjaan_ibu`,
				  a.`pendidikan_ibu` 
				FROM
				  `tbl_karyawan_susunan_keluarga` a 
				WHERE a.`nik_baru` = '$nik_baru' ";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateSusunanKeluarga($data, $nik_baru)
	{
		$this->db2->update('tbl_karyawan_susunan_keluarga', $data, ['nik_baru' => $nik_baru]);
		return $this->db2->affected_rows();
	}

	public function getDarurat($nik_baru = null)
	{
		$sql = "SELECT 
				  a.`nama_darurat`,
				  a.`no_hp_darurat`,
				  a.`alamat_darurat` 
				FROM
				  `tbl_karyawan_darurat` a 
				WHERE a.`nik_baru` = '$nik_baru'";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function updateDarurat($data, $nik_baru)
	{
		$this->db2->update('tbl_karyawan_darurat', $data, ['nik_baru' => $nik_baru]);
		return $this->db2->affected_rows();
	}

	public function getPendidikan($nik_baru = null)
	{
		$sql = "SELECT 
				  a.`status_sd`,
				  a.`nama_sd`,
				  a.`tahun_sd`,
				  a.`ket_sd`,
				  a.`nilai_sd`,
				  a.`status_smp`,
				  a.`nama_smp`,
				  a.`tahun_smp`,
				  a.`ket_smp`,
				  a.`nilai_smp`,
				  a.`status_smk`,
				  a.`nama_smk`,
				  a.`jurusan_smk`,
				  a.`tahun_smk`,
				  a.`ket_smk`,
				  a.`nilai_smk`,
				  a.nama_st,
				  a.jurusan_st,
				  a.`tahun_st`,
				  a.ket_st,
				  a.ipk_st,
				  a.`tingkat_st`,
				  a.nama_s1,
				  a.jurusan_s1,
				  a.`tahun_s1`,
				  a.ket_s1,
				  a.ipk_s1,
				  a.`tingkat_s1`,
				  a.nama_s2,
				  a.jurusan_s2,
				  a.`tahun_s2`,
				  a.ket_s2,
				  a.ipk_s2,
				  a.`tingkat_s2`,
				  a.nama_s3,
				  a.jurusan_s3,
				  a.`tahun_s3`,
				  a.ket_s3,
				  a.ipk_s3,
				  a.`tingkat_s3` 
				FROM
				  `tbl_karyawan_pendidikan` a 
				WHERE a.`nik_baru` = '$nik_baru'";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function updatePendidikan($data, $nik_baru)
	{
		$this->db2->update('tbl_karyawan_pendidikan', $data, ['nik_baru' => $nik_baru]);
		return $this->db2->affected_rows();
	}

	public function updateStatus($data, $nik_baru)
	{
		$this->db2->update('tbl_karyawan_struktur', $data, ['nik_baru' => $nik_baru]);
		return $this->db2->affected_rows();
	}

	public function getContact()
	{
		$sql = "SELECT * FROM `tbl_kontak_hrd`";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	public function get_NoUrut($nik_baru = null)
	{
		$sql = "SELECT 
				  * 
				FROM
				  `tbl_karyawan_struktur` a 
				WHERE a.`nik_baru` = '$nik_baru' 
				  AND a.`status_karyawan` = '0' ";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}

	// =============== //

	// no urut //

	public function getNikNoUrut($nik_baru = null)
	{
		$sql = "SELECT 
				  * 
				FROM
				  `tbl_karyawan_struktur` a 
				WHERE a.`nik_baru` = '0100048400' 
				  AND a.`status_karyawan` = '0'  ";
		$hasil = $this->db2->query($sql);
		return $hasil->result_array();
	}



	public function getDataIndukNoUrut($no_urut = null)
	{
		$sql = "SELECT 
		a.`nip` AS nik_baru,
		a.`namaKaryawan` AS nama_karyawan_struktur,
		b.`digit_ktp`,
		b.`digit_npwp`,
		b.`no_bpjs_ket` AS `no_tk`,
		b.`no_bpjs_kes` AS `no_kes`,
		b.`digit_kk` 
		FROM `tbl_karyawan_struktur` a 
		LEFT JOIN tbl_karyawan_induk b ON a.`noUrut` = b.`no_urut` 
		WHERE a.`noUrut` = '$no_urut'";

		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateIndukNoUrut($data, $no_urut)
	{
		$this->db2->update('tbl_karyawan_induk', $data, ['no_urut' => $no_urut]);
		return $this->db2->affected_rows();
	}


	public function getDataDetailNoUrut($no_urut = null)
	{
		$sql = "SELECT 
				  a.tanggal_lahir,
				  a.`tempat_lahir`,
				  a.`jenis_kelamin`,
				  a.`status_pernikahan`,
				  a.`alamat_ktp`,
				  a.`no_telp`,
				  a.`no_hp`,
				  a.`email`,
				  a.`alamat_domisili` 
				FROM `tbl_karyawan_detail` a 
				WHERE a.`no_urut` = '$no_urut'";

		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateDetailNoUrut($data, $no_urut)
	{
		$this->db2->update('tbl_karyawan_detail', $data, ['no_urut' => $no_urut]);
		return $this->db2->affected_rows();
	}

	public function getSuamiIstriNoUrut($no_urut = null)
	{
		$sql = "SELECT 
				  a.nama_keluarga,
				  a.`no_ktp_keluarga`,
				  a.`tanggal_lahir_keluarga`,
				  a.`tempat_lahir_keluarga`,
				  a.`gol_darah_keluarga`,
				  a.`agama_keluarga`,
				  a.`suku_keluarga`,
				  a.kewarganegaraan_keluarga,
				  a.`pendidikan_keluarga` 
				FROM
				  `tbl_karyawan_keluarga` a 
				WHERE a.`no_urut` = '$no_urut' ";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateKeluargaNoUrut($data, $no_urut)
	{
		$this->db2->update('tbl_karyawan_keluarga', $data, ['no_urut' => $no_urut]);
		return $this->db2->affected_rows();
	}

	public function getAnakNoUrut($no_urut = null)
	{
		$sql = "SELECT 
        		  a.`id_anak`,
				  a.`urutan_anak`,
				  a.nama_anak,
				  a.`no_ktp_anak`,
				  a.`tanggal_lahir_anak`,
				  a.`tempat_lahir_anak`,
				  a.`gol_darah_anak`,
				  a.`agama_anak`,
				  a.`suku_anak`,
				  a.kewarganegaraan_anak,
				  a.`pendidikan_anak` 
				FROM
				  `tbl_karyawan_anak` a 
				WHERE a.`no_urut` = '$no_urut' ";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function getSusunanKeluargaNoUrut($no_urut = null)
	{
		$sql = "SELECT 
				  a.nama_ayah,
				  a.`tanggal_lahir_ayah`,
				  a.`jenis_kelamin_ayah`,
				  a.`pekerjaan_ayah`,
				  a.`pendidikan_ayah`,
				  a.nama_ibu,
				  a.`tanggal_lahir_ibu`,
				  a.`jenis_kelamin_ibu`,
				  a.`pekerjaan_ibu`,
				  a.`pendidikan_ibu` 
				FROM
				  `tbl_karyawan_susunan_keluarga` a 
				WHERE a.`no_urut` = '$no_urut' ";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateSusunanKeluargaNoUrut($data, $no_urut)
	{
		$this->db2->update('tbl_karyawan_susunan_keluarga', $data, ['no_urut' => $no_urut]);
		return $this->db2->affected_rows();
	}

	public function getDaruratNoUrut($no_urut = null)
	{
		$sql = "SELECT 
				  a.`nama_darurat`,
				  a.`no_hp_darurat`,
				  a.`alamat_darurat` 
				FROM
				  `tbl_karyawan_darurat` a 
				WHERE a.`no_urut` = '$no_urut'";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updateDaruratNoUrut($data, $no_urut)
	{
		$this->db2->update('tbl_karyawan_darurat', $data, ['no_urut' => $no_urut]);
		return $this->db2->affected_rows();
	}

	public function getPendidikanNoUrut($no_urut = null)
	{
		$sql = "SELECT 
				  a.`status_sd`,
				  a.`nama_sd`,
				  a.`tahun_sd`,
				  a.`ket_sd`,
				  a.`nilai_sd`,
				  a.`status_smp`,
				  a.`nama_smp`,
				  a.`tahun_smp`,
				  a.`ket_smp`,
				  a.`nilai_smp`,
				  a.`status_smk`,
				  a.`nama_smk`,
				  a.`jurusan_smk`,
				  a.`tahun_smk`,
				  a.`ket_smk`,
				  a.`nilai_smk`,
				  a.nama_st,
				  a.jurusan_st,
				  a.`tahun_st`,
				  a.ket_st,
				  a.ipk_st,
				  a.`tingkat_st`,
				  a.nama_s1,
				  a.jurusan_s1,
				  a.`tahun_s1`,
				  a.ket_s1,
				  a.ipk_s1,
				  a.`tingkat_s1`,
				  a.nama_s2,
				  a.jurusan_s2,
				  a.`tahun_s2`,
				  a.ket_s2,
				  a.ipk_s2,
				  a.`tingkat_s2`,
				  a.nama_s3,
				  a.jurusan_s3,
				  a.`tahun_s3`,
				  a.ket_s3,
				  a.ipk_s3,
				  a.`tingkat_s3` 
				FROM
				  `tbl_karyawan_pendidikan` a 
				WHERE a.`no_urut` = '$no_urut'";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function updatePendidikanNoUrut($data, $no_urut)
	{
		$this->db2->update('tbl_karyawan_pendidikan', $data, ['no_urut' => $no_urut]);
		return $this->db2->affected_rows();
	}

	public function updateStatusNoUrut($data, $no_urut)
	{
		$this->db2->update('tbl_karyawan_struktur', $data, ['no_urut' => $no_urut]);
		return $this->db2->affected_rows();
	}

	// public function updatePendidikanNoUrut($data, $no_urut)
	// {
	// 	$this->db2->update('tbl_karyawan_pendidikan', $data, ['no_urut' => $no_urut]);
	// 	return $this->db2->affected_rows();
	// }

	// ======= //

	//------------------------------------------------------

	public function getContact_hrd()
	{
		$sql = "SELECT * FROM `tbl_kontak_hrd`";
		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}

	public function get_master_karyawan($lokasi_struktur = null, $nik_baru = null, $keyword = null)
	{
		$where = " tbl_karyawan_struktur.statusKaryawan = '0'";

		if ($lokasi_struktur != '') {
			$where .= " and tbl_lokasi.namaLokasi = '$lokasi_struktur'";
		}
		if ($nik_baru != '') {
			$where .= "  and tbl_karyawan_struktur.nip = '$nik_baru'";
		}
		if ($keyword != '') {
			$where .= "  and tbl_karyawan_struktur.nip LIKE '$keyword%' ORDER BY tbl_karyawan_struktur.nip DESC LIMIT 0, 1 ";
		}

		$sql = "
					SELECT 
		tbl_karyawan_struktur.id,
		tbl_karyawan_struktur.noUrut,
		tbl_karyawan_struktur.nip AS nik_baru,
		tbl_karyawan_struktur.namaKaryawan AS nama_karyawan_struktur,
		tbl_karyawan_struktur.idJabatan,
		tbl_jabatan.jabatanKaryawan AS jabatan_karyawan,
		tbl_karyawan_struktur.idDivisi,
		tbl_divisi.namaDivisi AS dept_struktur,
		tbl_bagian.namaBagian,
		tbl_karyawan_struktur.tanggalJoin AS join_date_struktur,
		tbl_karyawan_detail.tanggal_lahir,
		tbl_karyawan_induk.digit_ktp,
		tbl_karyawan_struktur.statusKaryawan,
		tbl_karyawan_struktur.statusKepegawaian AS status_karyawan_struktur,
		tbl_karyawan_struktur.idLokasi,
		tbl_lokasi.namaLokasi AS lokasi_struktur,
		tbl_perusahaan.perusahaan_nama AS perusahaan_struktur
		FROM
		tbl_karyawan_struktur 
		INNER JOIN tbl_karyawan_induk 
			ON tbl_karyawan_struktur.noUrut = tbl_karyawan_induk.no_urut 
		LEFT JOIN tbl_karyawan_detail 
			ON tbl_karyawan_struktur.noUrut = tbl_karyawan_detail.no_urut 
		INNER JOIN tbl_jabatan 
			ON tbl_karyawan_struktur.idJabatan = tbl_jabatan.idJabatan 
		LEFT JOIN tbl_divisi 
			ON tbl_karyawan_struktur.idDivisi = tbl_divisi.idDivisi 
		LEFT JOIN tbl_bagian 
			ON tbl_divisi.idBagian = tbl_bagian.idBagian 
		LEFT JOIN tbl_lokasi
			ON tbl_lokasi.`idLokasi` = tbl_karyawan_struktur.idLokasiHrd
		LEFT JOIN tbl_perusahaan
			ON tbl_perusahaan.perusahaan_id = tbl_karyawan_struktur.idPerusahaan
		WHERE $where
		ORDER BY tbl_karyawan_struktur.namaKaryawan ASC";

		$hasil = $this->db_absensi->query($sql);
		return $hasil->result_array();
	}
}
