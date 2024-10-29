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
class Nomor_Pengajuan extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);


		$this->load->model('M_Nomor_Pengajuan');
	}

	public function index_full_day_get()
	{
		$user = $this->M_Nomor_Pengajuan->getFullday();

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

	public function index_non_full_day_get()
	{
		$user = $this->M_Nomor_Pengajuan->getNonfullday();

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

	public function index_cuti_khusus_get()
	{
		$user = $this->M_Nomor_Pengajuan->getCutikhusus();

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

	public function index_cuti_tahunan_get()
	{
		$user = $this->M_Nomor_Pengajuan->getCutitahunan();

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

	public function index_kontrak_get()
	{
		$user = $this->M_Nomor_Pengajuan->getKontrak();

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


	public function index_last_nomor_pengajuan_get()
	{
		$user = $this->M_Nomor_Pengajuan->getFullday_new();

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
}
