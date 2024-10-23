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
class Logactivity extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db6 = $this->load->database('db6', TRUE);

		$this->load->model('pengajuan/M_Logactivity');
	}

	public function index_getketerangan_get()
	{
		$id = $this->get('id');
		$jabatan = $this->get('jabatan');

		if ($id === null and $jabatan === null) {
			$user = $this->M_Logactivity->get_index_keterangan();
		} else {
			$user = $this->M_Logactivity->get_index_keterangan($id, $jabatan);
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
	

		$user = $this->M_Logactivity->get_indexid($id);

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

	public function index_getketerangannik_get()
	{
		$nik_baru = $this->get('nik_baru');
		$id = $this->get('id');

		$user = $this->M_Logactivity->get_index_keterangan_nik($nik_baru, $id);
		

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

	public function index_persentase_get()
	{
		$nik = $this->get('nik');
		$date = $this->get('date');
		$date2 = $this->get('date2');

		$user = $this->M_Logactivity->get_persentase($nik, $date, $date2);
		

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

	public function index_perbandingan_get()
	{
		$nik = $this->get('nik');
		$date = $this->get('date');
		$date2 = $this->get('date2');

		$user = $this->M_Logactivity->get_absenvsdaily($nik, $date, $date2);
		

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

	public function index_persentaseperbandingan_get()
	{
		$nik = $this->get('nik');
		$date = $this->get('date');
		$date2 = $this->get('date2');

		$user = $this->M_Logactivity->get_internalvseksternal($nik, $date, $date2);
		

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

	public function index_getketerangannikbaru_get()
	{
		$nik_baru = $this->get('nik_baru');

		$user = $this->M_Logactivity->get_index_keterangan_nikbaru($nik_baru);
		

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

	public function index_getketerangannikbarudate_get()
	{
		$nik_baru = $this->get('nik_baru');
		$date = $this->get('date');
		$date2 = $this->get('date2');


		$user = $this->M_Logactivity->get_index_keterangan_nikdate($nik_baru, $date, $date2);
		

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

	public function index_keterangandaily_get()
	{
		$nik = $this->get('nik');
		$tanggal1 = $this->get('tanggal1');
		$tanggal2 = $this->get('tanggal2');

		$user = $this->M_Logactivity->getketerangan($nik, $tanggal1, $tanggal2);

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

	public function index_paretointernal_get()
	{
		$nik = $this->get('nik');
		$date = $this->get('date');
		$date2 = $this->get('date2');
	

		$user = $this->M_Logactivity->get_paretointernal($nik, $date, $date2);

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

	public function index_paretoeksternal_get()
	{
		$nik = $this->get('nik');
		$date = $this->get('date');
		$date2 = $this->get('date2');
	

		$user = $this->M_Logactivity->get_paretoeksternal($nik, $date, $date2);

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

	public function index_post()
	{
		$data = [
			'nik' => $this->post('nik'),
			'jabatan' => $this->post('jabatan'),
			'id_activity' => $this->post('id_activity'),
			'status' => $this->post('status'),
			'dokumen' => $this->post('dokumen'),
			'ket_tambahan' => $this->post('ket_tambahan'),
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
		];

		if ($this->M_Logactivity->createLogActivity($data) > 0) {
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

	public function index_gettmp_get()
	{
		$nik = $this->get('nik');

		$user = $this->M_Logactivity->get_index_tmp_hariini($nik);
		

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

	public function index_tmp_post()
	{
		$data = [
			'nik' => $this->post('nik'),
			'status_lokasi' => $this->post('status_lokasi'),
			'lokasi' => $this->post('lokasi'),
			'keterangan' => $this->post('keterangan'),
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
		];

		if ($this->M_Logactivity->createtmp($data) > 0) {
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

	public function index_real_post()
	{
		$data = [
			'nik' => $this->post('nik'),
			'waktu_submit' => $this->post('waktu_submit'),
			'status_lokasi' => $this->post('status_lokasi'),
			'lokasi' => $this->post('lokasi'),
			'keterangan' => $this->post('keterangan'),
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
			'ket_input' => 'ANDROID',
		];

		if ($this->M_Logactivity->createreal($data) > 0) {
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

	public function indexhapustmp_delete()
	{
		$nik = $this->put('nik');

		if ($this->M_Logactivity->hapustmp($nik) > 0) {
			$this->response([
				'status' => true,
				'message' => 'pengajuan has been delete',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function indexupdate_put()
	{
		$id = $this->put('id');

		$data = [
			'keterangan' => $this->put('keterangan'),
		];

		if ($this->M_Logactivity->updateKeterangan($data, $id) > 0) {
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

	public function index_delete()
	{
		$id = $this->delete('id');

		if ($this->M_Logactivity->hapusKeterangan($id) > 0) {
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