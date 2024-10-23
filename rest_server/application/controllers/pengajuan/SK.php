<?php
defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */

// use namespace
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

/**
 * 
 */
class SK extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);

		$this->load->model('pengajuan/M_SK');
	}

	public function index_get()
	{
		$id = $this->get('id');
		$nik_baru = $this->get('nik_baru');

		if ($nik_baru === null and $id === null) {
			$user = $this->M_SK->get_index_sk();
		} else {
			$user = $this->M_SK->get_index_sk($nik_baru, $id);
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

	public function index_atasan_get()
	{
		$jabatan = $this->get('jabatan_struktur');

		if ($jabatan === null) {
			$team = $this->M_SK->get_index_SK_atasan();
		} else {
			$team = $this->M_SK->get_index_SK_atasan($jabatan);
		}

		if ($team) {
			$this->response([
				'status' => true,
				'data' => $team
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
			'no_urut' => $this->post('no_urut'),
			'nik_baru' => $this->post('nik_baru'),
			'jabatan_karyawan' => $this->post('jabatan_karyawan'),
			'keperluan' => $this->post('keperluan'),
			'analisa' => $this->post('analisa'),
			'status_atasan' => $this->post('status_atasan'),
			'status_hrd' => $this->post('status_hrd'),
		];

		if ($this->M_SK->createSK($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new shift has been created',
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
		];

		if ($this->M_SK->updateApproval($data, $id) > 0) {
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

	//---------------------------------------------------------------------

	public function index_get_pengajuan_sk_get()
	{
		$id = $this->get('id');
		$nik_baru = $this->get('nik_baru');

		if ($nik_baru === null and $id === null) {
			$user = $this->M_SK->get_index_pengajuan_sk();
		} else {
			$user = $this->M_SK->get_index_pengajuan_sk($nik_baru, $id);
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


	public function index_last_nomor_pengajuan_sk_get()
	{
		$user = $this->M_SK->get_last_nomor_pengajuan_sk();

		if ($user) {
			$this->response(
				[
					'status' => true,
					'data' => $user
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Kode Nomor Not Found'
				],
				REST_Controller::HTTP_NOT_FOUND
			);
		}
	}


	public function index_post_pengajuan_sk_post()
	{
		$data = [
			'no_urut' => $this->post('no_urut'),
			'nik_baru' => $this->post('nik_baru'),
			'jabatan_karyawan' => $this->post('jabatan_karyawan'),
			'keperluan' => $this->post('keperluan'),
			'analisa' => $this->post('analisa'),
			'status_atasan' => $this->post('status_atasan'),
			'status_hrd' => $this->post('status_hrd'),
		];

		if ($this->M_SK->post_pengajuan_sk($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new shift has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_get_sk_approval_atasan_get()
	{
		$id_divisi = $this->get('id_divisi');
		$id_bagian = $this->get('id_bagian');
		$jabatan   = $this->get('id_jabatan');

		$get = $this->M_SK->get_index_sk_approval_atasan_new($id_divisi, $id_bagian, $jabatan);
		$totaldata = count($get);
		if ($get) {
			$this->response([
				'status' => true,
				'total_data' => $totaldata,
				'data' => $get
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'total_data' => $totaldata,
				'message' => 'Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
}
