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
class rekomendasi extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db4 = $this->load->database('db4', TRUE);

		$this->load->model('website/M_Rekomendasikandidat');
	}

	public function index_get()
	{
		$dd_id = $this->get('dd_id');

		if ($dd_id === null) {
			$user = $this->M_Rekomendasikandidat->get_index_rekomendasi();
		} else {
			$user = $this->M_Rekomendasikandidat->get_index_rekomendasi($dd_id);
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
			'posisi' => $this->post('posisi'),
			'no_ktp' => $this->post('no_ktp'),
			'nama_lengkap' => $this->post('nama_lengkap'),
			'tanggal_interview' => $this->post('tanggal_interview'),
			'jam_interview' => $this->post('jam_interview'),
			'lokasi_interview' => $this->post('lokasi_interview'),
			'status' => $this->post('status'),
		];

		if ($this->M_Rekomendasikandidat->createRekomendasi($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}

?>