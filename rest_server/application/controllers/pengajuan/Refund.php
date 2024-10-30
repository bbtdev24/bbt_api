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
class Refund extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('pengajuan/M_Refund');
	}

	public function index_nomor_get()
	{

		$user = $this->M_Refund->getNomor();

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

	public function index_count_get()
	{
		$nik_pengajuan = $this->get('nik_pengajuan');
		$user = $this->M_Refund->getNomorPengajuan($nik_pengajuan);

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

	public function index_nikatasan_get()
	{
		$nik_pengajuan = $this->get('nik_pengajuan');
		$user = $this->M_Refund->getNikAtasan($nik_pengajuan);

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

	public function index_refundid_get()
	{
		$no_pengajuan = $this->get('no_pengajuan');
		$user = $this->M_Refund->getNomorId($no_pengajuan);

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

	public function index_refund_post()
	{
		$data = [
			'no_pengajuan' => $this->post('no_pengajuan'),
			'nik_pengajuan' => $this->post('nik_pengajuan'),
			'nik' => $this->post('nik'),
			'tanggal_absen' => $this->post('tanggal_absen'),
			'absen_awal' => $this->post('absen_awal'),
			'absen_akhir' => $this->post('absen_akhir'),
			'ket' => $this->post('ket'),
			'dokumen' => $this->post('dokumen'),
			'status_refund' => '0',
			'status_ba' => '0',
			'status_pengajuan' => '0'
		];

		if ($this->M_Refund->createrefund($data) > 0) {
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
			'status_ba' => $this->put('status_ba'),
			'no_ba' => $this->put('no_ba'),
			'tanggal_ba' => $this->put('tanggal_ba'),
		];

		if ($this->M_Refund->updateba($data, $id) > 0) {
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