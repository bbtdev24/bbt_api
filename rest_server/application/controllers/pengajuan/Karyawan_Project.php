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
class Karyawan_Project extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('pengajuan/M_Project');
	}

	public function index_get()
	{
		$nik_pengajuan = $this->get('nik_pengajuan');

		if ($nik_pengajuan === null) {
			$user = $this->M_Project->get_index_project();
		} else {
			$user = $this->M_Project->get_index_project($nik_pengajuan);
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
		$getNik = $this->M_Project->get_NoUrut($this->post('nik_karyawan'));
		foreach($getNik as $row) {
			$no_urut = $row['no_urut'];
		}

		$string = $this->post('nik_karyawan');
		$result = str_replace(' ', '', $string);

		$data = [
			'no_urut' => $no_urut,
			'nik_pengajuan' => $this->post('nik_pengajuan'),
			'start_date' => $this->post('start_date'),
			'end_date' => $this->post('end_date'),
			'nik_karyawan' => $result,
			'depo_karyawan' => $this->post('depo_karyawan'),
			'upload_dokumen' => $this->post('upload_dokumen'),
			'depo_awal' => $this->post('depo_awal'),
			'jabatan_awal' => $this->post('jabatan_awal'),
			'jabatan_akhir' => $this->post('jabatan_akhir'),
			'upload_dokumen' => null,
		];

		$data2 = [
			'nik_baru' => $this->post('nik_karyawan'),
			'lokasi_hrd' => $this->post('depo_karyawan'),
			'jabatan_hrd' => $this->post('jabatan_akhir'),
			'status_hrd' => '3',
		];

		$this->M_Project->gantiJabatan($data2, $this->post('nik_karyawan'));

		if ($this->M_Project->createProject($data) > 0) {
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