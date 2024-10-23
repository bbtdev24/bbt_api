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
class hasil extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db4 = $this->load->database('db4', TRUE);

		$this->load->model('website/M_Hasil');
	}

	public function index_get()
	{

		$id = $this->get('id');
		$no_ktp = $this->get('no_ktp');
		
		if ($id === null and $no_ktp === null) {
			$user = $this->M_Hasil->get_hasil_interview();
		} else {
			$user = $this->M_Hasil->get_hasil_interview($no_ktp, $id);
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
			'nilai_pertama' => $this->put('nilai_pertama'),
			'nilai_kedua' => $this->put('nilai_kedua'),
			'kelebihan' => $this->put('kelebihan'),
			'kekurangan' => $this->put('kekurangan'),
			'catatan_khusus' => $this->put('catatan_khusus'),
			'kesimpulan' => $this->put('kesimpulan'),

		];

		if ($this->M_Hasil->updateStatus($data, $id) > 0) {
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