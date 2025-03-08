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
class Absenmobile extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);

		$this->load->model('pengajuan/M_Absenmobile');
	}

	public function index_keterangan_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');


		$user = $this->M_Absenmobile->getKeterangan($nik_baru, $tanggal);

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

	public function index_nik_tkbm_get()
	{
		$nik_baru = $this->get('nik_baru');


		$user = $this->M_Absenmobile->getNikKaryawanTKBM($nik_baru);

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

	public function index_keterangannikbaru_get()
	{
		$nik_baru = $this->get('nik_baru');

		$user = $this->M_Absenmobile->getKeterangan3($nik_baru);

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

	public function index_karyawantkbm_get()
	{
		$lokasi = $this->get('lokasi');

		$user = $this->M_Absenmobile->getKaryawanTKBM($lokasi);

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

	public function index_absen_kbkm_get()
	{
		$nik_ktp = $this->get('nik_ktp');
		$tanggal = $this->get('tanggal');
		

		$user = $this->M_Absenmobile->getAbsenKbkm($nik_ktp, $tanggal);

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

	public function index_cek_absen_kbkm_get()
	{
		$nik_ktp = $this->get('nik_ktp');		

		$user = $this->M_Absenmobile->cekAbsenKbkm($nik_ktp);

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

	public function index_cek_absengigo_get()
	{
		$tanggal1 = $this->get('tanggal1');	
		$tanggal2 = $this->get('tanggal2');	
		$nik = $this->get('nik');
	

		$user = $this->M_Absenmobile->getCheckAbsen($tanggal1, $tanggal2, $nik);

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

	public function index_data_absen_kbkm_get()
	{
		$nik_ktp = $this->get('nik_ktp');		

		$user = $this->M_Absenmobile->getDataAbsen($nik_ktp);

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

	public function index_keteranganharini_get()
	{
		$nik_baru = $this->get('nik_baru');

		$user = $this->M_Absenmobile->getKeteranganhariini($nik_baru);

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

	public function index_get()
	{
		$nik_baru = $this->get('nik_baru');
		$shift_day = $this->get('shift_day');

		$user = $this->M_Absenmobile->getAbsen($nik_baru, $shift_day);

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

	public function index_keterangan_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'tanggal' => $this->post('tanggal'),
			'keterangan' => $this->post('keterangan'),
			'ket_input' => 'ANDROID',
		];

		if ($this->M_Absenmobile->createKeterangan($data) > 0) {
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

	public function index_post()
	{
		$data = [
			'nik' => $this->post('nik'),
			'nama' => $this->post('nama'),
			'kat' => $this->post('kat'),
			'time' => $this->post('time'),
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
		];

		if ($this->M_Absenmobile->createAbsenManual_2($data) > 0) {
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

	public function index_gigo_post()
	{
		$data = [
			'nik' => $this->post('nik'),
			'nama' => $this->post('nama'),
			'kat' => $this->post('kat'),
			'lokasi' => $this->post('lokasi'),
			'time' => $this->post('time'),
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
		];

		if ($this->M_Absenmobile->createtbkm($data) > 0) {
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

	public function index_gigo_leader_post()
	{
		$data = [
			'nik' => $this->post('nik'),
			'nama' => $this->post('nama'),
			'kat' => $this->post('kat'),
			'lokasi' => $this->post('lokasi'),
			'time' => $this->post('time'),
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
			'dokumen' => $this->post('dokumen'),
		];

		if ($this->M_Absenmobile->createtbkm($data) > 0) {
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

	public function index_manualin_put()
	{
		$id = $this->put('userid');
		$shift_day = $this->put('shift_day');

		$data = [
			'in_manual' => $this->put('in_manual'),
		];

		if ($this->M_Absenmobile->updateJam($data, $id, $shift_day) > 0) {
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

	public function index_manualinkbkm_put()
	{
		$nik_ktp = $this->put('nik_ktp');
		$shift_day = $this->put('shift_day');

		$data = [
			'in' => $this->put('in'),
		];

		if ($this->M_Absenmobile->updateJamKbkm($data, $nik_ktp, $shift_day) > 0) {
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

	public function index_manualout_put()
	{
		$id = $this->put('userid');
		$shift_day = $this->put('shift_day');

		$data = [
			'out_manual' => $this->put('out_manual'),
		];

		if ($this->M_Absenmobile->updateJam($data, $id, $shift_day) > 0) {
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

	public function index_manualoutkbkm_put()
	{
		$nik_ktp = $this->put('nik_ktp');
		$shift_day = $this->put('shift_day');

		$data = [
			'out' => $this->put('out'),
		];

		if ($this->M_Absenmobile->updateJamKbkm($data, $nik_ktp, $shift_day) > 0) {
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


	public function index_update_keterangan_put()
	{
		$id = $this->put('id');
		$data = [
			'tanggal' => $this->put('tanggal'),
			'keterangan' => $this->put('keterangan'),
		];

		if ($this->M_Absenmobile->updateketerangan($data, $id) > 0) {
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


	public function index_manualin_new_put()
	{
		$id = $this->put('badgenumber');
		$shift_day = $this->put('shift_day');

		$data = [
			'in_manual' => $this->put('in_manual'),
		];

		if ($this->M_Absenmobile->updateJam_new($data, $id, $shift_day) > 0) {
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


	public function index_manualout_new_put()
	{
		$id = $this->put('badgenumber');
		$shift_day = $this->put('shift_day');

		$data = [
			'out_manual' => $this->put('out_manual'),
		];

		if ($this->M_Absenmobile->updateJam_new($data, $id, $shift_day) > 0) {
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