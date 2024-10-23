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
class Pengembalian_seragam extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('pengajuan/M_Pengembalian_seragam');
	}

	public function index_get()
	{
		$nik_pengajuan = $this->get('nik_pengajuan');

		if ($nik_pengajuan === null) {
			$user = $this->M_Pengembalian_seragam->get_index_seragam();
		} else {
			$user = $this->M_Pengembalian_seragam->get_index_seragam($nik_pengajuan);
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
			'no_pengajuan' => $this->post('no_pengajuan'),
			'nik_pengajuan' => $this->post('nik_pengajuan'),
			'ket_pengajuan' => $this->post('ket_pengajuan'),
			'nik_baru' => $this->post('nik_baru'),
			'id_seragam' => $this->post('id_seragam'),
			'qty_seragam' => $this->post('qty_seragam'),
			'harga_satuan' => $this->post('harga_satuan'),
			'tanggal_pengembalian' => $this->post('tanggal_pengembalian'),
			'ket_tambahan' => $this->post('ket_tambahan'),
		];

		if ($this->M_Pengembalian_seragam->createPengembalian($data) > 0) {
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

}

?>