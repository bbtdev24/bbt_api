<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */

// use namespace
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

/**
 * 
 */
class Resign extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('pengajuan/M_Resign');
	}

	public function index_keteranganresign_get()
	{

		$alasan = $this->get('alasan');
		
		if ($alasan === null) {
			$user = $this->M_Resign->get_index_alasan();
		} else {
			$user = $this->M_Resign->get_index_alasan($alasan);
		}


		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_keterangan_case_get()
	{

		$case = $this->get('case');
		
		if ($case === null) {
			$user = $this->M_Resign->get_index_case();
		} else {
			$user = $this->M_Resign->get_index_case($case);
		}


		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_id_get()
	{

		$id = $this->get('id');
		$user = $this->M_Resign->getid($id);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_nomorid_get()
	{
		$user = $this->M_Resign->getnomor();

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_nik_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getnikresign($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_soalexit_get()
	{
		$user = $this->M_Resign->getsoalexit();

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_jabatan_get()
	{
		$jabatan = $this->get('jabatan');
		$user = $this->M_Resign->getjabatan($jabatan);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_kuisioner_get()
	{
		$user = $this->M_Resign->getkuisioner();

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_soalkuisioner_get()
	{

		$type_soal = $this->get('type_soal');
		$user = $this->M_Resign->getsoalkuisioner($type_soal);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_jawabankuisioner_get()
	{
		$nik_baru = $this->get('nik_baru');
		$type_soal = $this->get('type_soal');
		$user = $this->M_Resign->getjawabankuisioner($nik_baru, $type_soal);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_kuisionerfinal_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getkuisionerfinal($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_serahterima_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getserahterima($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_serahalatkerja_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getserahalatkerja($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_hardcopy_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->gethardcopy($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_jawaban_exit_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getjawabanexit($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_softcopy_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getsoftcopy($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_project_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getproject($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_sdm_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getsdm($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_exitsarandanmasukan_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getcekexitsaran($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_cekexit_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getcekexit($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_statusterima_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getstatusterima($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_penerima_get()
	{
		$id = $this->get('id');
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getpenerima($nik_baru, $id);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_serahterimaalatkerja_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getserahterimaalatkerja($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_serahterimahardcopy_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getserahterimahardcopy($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_serahterimasoftcopy_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getserahterimasoftcopy($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_serahterimaproject_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getserahterimaproject($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_serahterimasdm_get()
	{
		$nik_baru = $this->get('nik_baru');
		$user = $this->M_Resign->getserahterimasdm($nik_baru);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}


	public function index_resign_post()
	{
		$data = [
			'no_pengajuan' => $this->post('no_pengajuan'),
			'nik_baru' => $this->post('nik_baru'),
			'jabatan' => $this->post('jabatan'),
			'tanggal_pengajuan' => $this->post('tanggal_pengajuan'),
			'jabatan' => $this->post('jabatan'),
			'status_atasan' => '0',
			'status_atasan_2' => '0',
			'alasan_resign' => $this->post('alasan_resign'), 
			'klarifikasi_resign' => $this->post('klarifikasi_resign'),
			'ket_resign' => $this->post('ket_resign'),
			'status_fa' => '0',
			'status_wop' => '0',
			'status_hrd' => '0',
			'status_ict' => '0',
			'status_ga' => '0',

			'status_qms' => '0',
			'status_pengajuan' => '0',
			'status_cuti' => '0',
			'status_kuisioner' => '0',
			'status_exit' => '0',
			'status_serah_terima' => '0',
			'status_clearance' => '0',
			



		];

		if ($this->M_Resign->createresign($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_resign_baru_post()
	{
		$data = [
			'no_pengajuan' => $this->post('no_pengajuan'),
			'nik_baru' => $this->post('nik_baru'),
			'jabatan' => $this->post('jabatan'),
			'tanggal_pengajuan' => $this->post('tanggal_pengajuan'),
			'jabatan' => $this->post('jabatan'),
			'status_atasan' => '0',
			'status_atasan_2' => '0',
			'alasan_resign' => $this->post('alasan_resign'), 
			'klarifikasi_resign' => $this->post('klarifikasi_resign'),
			'ket_resign' => $this->post('ket_resign'),
			'status_fa' => '0',
			'status_wop' => '0',
			'status_hrd' => '0',
			'status_ict' => '0',
			'status_ga' => '0',

			'status_qms' => '0',
			'status_pengajuan' => '0',
			'status_cuti' => '0',
			'status_kuisioner' => '0',
			'status_exit' => '0',
			'status_serah_terima' => '0',
			'status_clearance' => '0',
			'dokumen_resign' => $this->post('dokumen_resign'),
		];

		if ($this->M_Resign->createresignbaru($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_kuisioner_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'id_soal' => $this->post('id_soal'),
			'jawaban' => $this->post('jawaban'),
		];

		if ($this->M_Resign->createkuisioner($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_serahterima_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'nik_penerima_1' => $this->post('nik_penerima_1'),
			'status_penerima_1' => '0',

			'nik_penerima_2' => $this->post('nik_penerima_2'),
			'status_penerima_2' => '0',

			'status_atasan' => '0',
			'status_atasan_2' => '0',
			'status_serah_terima' => '0',
			
		];

		if ($this->M_Resign->createserahterima($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_kritiksaran_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'nilai_keseluruhan' => $this->post('nilai_keseluruhan'),
			'kategori_resign' => $this->post('kategori_resign'),
			'alasan_resign' => $this->post('alasan_resign'),
			'saran_masukan' => $this->post('saran_masukan'),
		];

		if ($this->M_Resign->createkritiksaran($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_alatkerja_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'alat_kerja' => $this->post('alat_kerja'),
			'jumlah_alat_kerja' => $this->post('jumlah_alat_kerja'),
			'satuan_alat_kerja' => $this->post('satuan_alat_kerja'),
			'kondisi_alat_kerja' => $this->post('kondisi_alat_kerja'),
			'keterangan_alat_kerja' => $this->post('keterangan_alat_kerja'),
		];

		if ($this->M_Resign->createserahalatkerja($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_hardcopy_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'nama_hardcopy' => $this->post('nama_hardcopy'),
			'jumlah_hardcopy' => $this->post('jumlah_hardcopy'),
			'satuan_hardcopy' => $this->post('satuan_hardcopy'),
			'tempat_hardcopy' => $this->post('tempat_hardcopy'),
			'keterangan_hardcopy' => $this->post('keterangan_hardcopy'),
		];

		if ($this->M_Resign->createhardcopy($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_softcopy_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'nama_softcopy' => $this->post('nama_softcopy'),
			'no_software' => $this->post('no_software'),
			'jenis_software' => $this->post('jenis_software'),
			'keterangan_software' => $this->post('keterangan_software'),
		];

		if ($this->M_Resign->createsoftcopy($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_project_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'nama_project' => $this->post('nama_project'),
			'sdm_project' => $this->post('sdm_project'),
			'hasil_project' => $this->post('hasil_project'),
			'outstanding_project' => $this->post('outstanding_project'),
			'deadline_project' => $this->post('deadline_project'),
		];

		if ($this->M_Resign->createproject($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statusserahterima_post()
	{
		$data = [
			'nik' => $this->post('nik'),
			'status_alat_kerja' => '0',
			'status_softcopy' => '0',
			'status_hardcopy' => '0',
			'status_project' => '0',
			'status_sdm' => '0',
		];

		if ($this->M_Resign->createstatusterima($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_sdm_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'jabatan_sdm' => $this->post('jabatan_sdm'),
			'jumlah_sdm' => $this->post('jumlah_sdm'),
			'jenis_kelamin_sdm' => $this->post('jenis_kelamin_sdm'),
			'promosi_sdm' => $this->post('promosi_sdm'),
			'mutasi_sdm' => $this->post('mutasi_sdm'),
			'demosi_sdm' => $this->post('demosi_sdm'),
			'sp1_sdm' => $this->post('sp1_sdm'),
			'sp2_sdm' => $this->post('sp2_sdm'),
			'sp3_sdm' => $this->post('sp3_sdm'), 
			'keterangan_sdm' => $this->post('keterangan_sdm'),
		];

		if ($this->M_Resign->createsdm($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_exitinterview_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'id_soal' => $this->post('id_soal'),
			'jawaban_soal' => $this->post('jawaban_soal'),
			'keterangan' => $this->post('keterangan'),
		];

		if ($this->M_Resign->createexitinterview($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_exitinterviewsaran_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'nomor_saran' => $this->post('nomor_saran'),
			'saran' => $this->post('saran'),
		];

		if ($this->M_Resign->createexitsaran($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_exitinterviewfinal_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'alasan_exit' => $this->post('alasan_exit'),
			'tambahan_exit' => $this->post('tambahan_exit'),
			'ketidaksesuai_exit' => $this->post('ketidaksesuai_exit'),
		];

		if ($this->M_Resign->createfinalexit($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'status_atasan' => $this->put('status_atasan'),
			'tanggal' => $this->put('tanggal'),
			'tanggal_efektif_resign' => $this->put('tanggal_efektif_resign'),
		];

		if ($this->M_Resign->updateApproval($data, $id) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_hakcuti_put()
	{
		$tahun = $this->put('tahun');
		$nik_sisa_cuti = $this->put('nik_sisa_cuti');

		$data = [
			'hak_cuti_utuh' => $this->put('hak_cuti_utuh'),
		];

		if ($this->M_Resign->updatehakcuti($data, $tahun, $nik_sisa_cuti) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statuscuti_put()
	{
		$nik_baru = $this->put('nik_baru');

		$data = [
			'status_cuti' => '1',
		];

		if ($this->M_Resign->statuscuti($data, $nik_baru) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statuskuisioner_put()
	{
		$nik_baru = $this->put('nik_baru');

		$data = [
			'status_kuisioner' => '1',
		];

		if ($this->M_Resign->statuskuisioner($data, $nik_baru) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statusserahterima_put()
	{
		$nik_baru = $this->put('nik_baru');

		$data = [
			'status_serah_terima' => '1',
		];

		if ($this->M_Resign->statusserahterima($data, $nik_baru) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statusexit_put()
	{
		$nik_baru = $this->put('nik_baru');

		$data = [
			'status_exit' => '1',
		];

		if ($this->M_Resign->statusexit($data, $nik_baru) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_approvalpenerima1_put()
	{
		$nik_penerima_1 = $this->put('nik_penerima_1');

		$data = [
			'status_penerima_1' => $this->put('status_penerima_1'),
			'tanggal_penerima_1' => $this->put('tanggal_penerima_1'),
		];

		if ($this->M_Resign->approval_serahterima1($data, $nik_penerima_1) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_approvalpenerima2_put()
	{
		$nik_penerima_2 = $this->put('nik_penerima_2');

		$data = [
			'status_penerima_2' => $this->put('status_penerima_2'),
			'tanggal_penerima_2' => $this->put('tanggal_penerima_2'),
		];

		if ($this->M_Resign->approval_serahterima2($data, $nik_penerima_2) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statusalatkerja_put()
	{
		$nik = $this->put('nik');

		$data = [
			'status_alat_kerja' => '1',
		];

		if ($this->M_Resign->approval_statusserahterima($data, $nik) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statussoftcopy_put()
	{
		$nik = $this->put('nik');

		$data = [
			'status_softcopy' => '1',
		];

		if ($this->M_Resign->approval_statusserahterima($data, $nik) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statushardcopy_put()
	{
		$nik = $this->put('nik');

		$data = [
			'status_hardcopy' => '1',
		];

		if ($this->M_Resign->approval_statusserahterima($data, $nik) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statusproject_put()
	{
		$nik = $this->put('nik');

		$data = [
			'status_project' => '1',
		];

		if ($this->M_Resign->approval_statusserahterima($data, $nik) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_statussdm_put()
	{
		$nik = $this->put('nik');

		$data = [
			'status_sdm' => '1',
		];

		if ($this->M_Resign->approval_statusserahterima($data, $nik) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}

?>