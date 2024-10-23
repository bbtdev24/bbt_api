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
class jadwal extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db4 = $this->load->database('db4', TRUE);

		$this->load->model('website/M_jadwal');
	}

	public function index_get()
	{

		$id = $this->get('id');
		$no_ktp = $this->get('no_ktp');
		
		if ($id === null and $no_ktp === null) {
			$user = $this->M_jadwal->get_jadwal_interview();
		} else {
			$user = $this->M_jadwal->get_jadwal_interview($no_ktp, $id);
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

	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'status' => $this->put('status'),
		];

		if ($this->M_jadwal->updateStatus($data, $id) > 0) {
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

	public function index_jadwal_put()
	{
		$id = $this->put('id');
		$data = [
			'tanggal_interview' => $this->put('tanggal_interview'),
			'jam_interview' => $this->put('jam_interview'),
			'lokasi_interview' => $this->put('lokasi_interview'),
		];

		if ($this->M_jadwal->updateJadwal($data, $id) > 0) {
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


	public function index_post()
	{
		$data = [
			'no_ktp' => $this->post('no_ktp'),
			'pendidikan' => $this->post('pendidikan'),
			'posisi' => $this->post('posisi'),
			'nilai_pertama' => $this->post('nilai_pertama'),
			'nilai_kedua' => $this->post('nilai_kedua'),
			'kelebihan' => $this->post('kelebihan'),
			'kekurangan' => $this->post('kekurangan'),
			'catatan_khusus' => $this->post('catatan_khusus'),
			'kesimpulan' => $this->post('kesimpulan'),
			'pewawancara_satu' => $this->post('pewawancara_satu'),
			'pewawancara_dua' => $this->post('pewawancara_dua'),
			'pewawancara_tiga' => $this->post('pewawancara_tiga'),
			'nama_lengkap' => $this->post('nama_lengkap'),
			'id_user' => $this->post('id_user'),
			'umur' => $this->post('umur'),
			'waktu' => $this->post('waktu'),

		];

		if ($this->M_jadwal->createInterview($data) > 0) {
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