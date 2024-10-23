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
class Pengajuan_seragam extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);

		$this->load->model('pengajuan/M_Pengajuan_seragam');
	}

	public function index_get()
	{
		$nik_pengajuan = $this->get('nik_pengajuan');

		if ($nik_pengajuan === null) {
			$user = $this->M_Pengajuan_seragam->get_index_seragam();
		} else {
			$user = $this->M_Pengajuan_seragam->get_index_seragam($nik_pengajuan);
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
			'submit_date' => $this->post('submit_date'),
			'nik_pengajuan' => $this->post('nik_pengajuan'),
			'no_pengajuan' => $this->post('no_pengajuan'),
			'ket_pengajuan' => $this->post('ket_pengajuan'),
			'nik_baru' => $this->post('nik_baru'),
			'nama_karyawan_seragam' => $this->post('nama_karyawan_seragam'),
			'jabatan_karyawan_seragam' => $this->post('jabatan_karyawan_seragam'),
			'dept_karyawan_seragam' => $this->post('dept_karyawan_seragam'),
			'lokasi_karyawan_seragam' => $this->post('lokasi_karyawan_seragam'),
			'kode_seragam' => $this->post('kode_seragam'),
			'nama_seragam' => $this->post('nama_seragam'),
			'qty_seragam' => $this->post('qty_seragam'),
			'harga_satuan' => $this->post('harga_satuan'),
			'tanggal_distribusi' => '0000-00-00',
			'status_realisasi' => '0',
			'status_distribusi' => '0',
		];

		if ($this->M_Pengajuan_seragam->createPengajuan($data) > 0) {
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
