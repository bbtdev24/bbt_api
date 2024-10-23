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
class ojt extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db5 = $this->load->database('db5', TRUE);

		$this->load->model('website/M_Ojt');
	}

	public function index_get()
	{

		$nik = $this->get('nik');
		
		if ($nik === null) {
			$user = $this->M_Ojt->getOjt();
		} else {
			$user = $this->M_Ojt->getOjt($nik);
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

	public function index_post()
	{
		$data = [
			'id_materi' => $this->post('id_materi'),
			'id_user' => $this->post('id_user'),
			'kode_materi' => $this->post('kode_materi'),
			'nik' => $this->post('nik'),
			'jabatan' => $this->post('jabatan'),
			'tanggal_pelaksana_peserta' => $this->post('tanggal_pelaksana_peserta'),
			'status_user' => $this->post('status_user'),
			'lokasi' => $this->post('lokasi'),
			'remark_user' => $this->post('remark_user'),
		];

		if ($this->M_Ojt->createOjt($data) > 0) {
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
		$id_materi = $this->put('id_materi');
		$nik = $this->put('nik');

		$data = [
			'nama_pembimbing' => $this->put('nama_pembimbing'),
			'tanggal_pelaksana_pembimbing' => $this->put('tanggal_pelaksana_pembimbing'),
			'status_atasan' => $this->put('status_atasan'),
			'remark_atasan' => $this->put('remark_atasan'),
		];

		if ($this->M_Ojt->updateStatus($data, $id_materi, $nik) > 0) {
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