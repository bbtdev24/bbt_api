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
class Gratifikasi extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db9 = $this->load->database('db9', TRUE);
		$this->db10 = $this->load->database('db10', TRUE);
		$this->db11 = $this->load->database('db11', TRUE);
		$this->db17 = $this->load->database('db17', TRUE);
		$this->load->model('pengajuan/M_Gratifikasi');
	}

	public function index_get()
	{
		$nik_baru = $this->get('nik_baru');
		$date = $this->get('date');
		$date2 = $this->get('date2');

		$user = $this->M_Gratifikasi->get_gratifikasi($nik_baru, $date, $date2);

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
		$nomor = $this->M_Gratifikasi->get_NoPengajuan();
		foreach($nomor as $row) {
			$formatted_count_with_date = $row['formatted_count_with_date'];
		}

		$nomor_gambar = $this->M_Gratifikasi->get_NoPengajuanGambar();
		foreach($nomor_gambar as $row2) {
			$nomor_image = $row2['image_number'];
		}

		if (strpos($this->post('nominal'), '.') !== false) {
		    $cleanedNumberString = str_replace(".", "", $this->post('nominal'));
		} else {
		    $cleanedNumberString = $this->post('nominal');
		}
		

		$data = [
			'nomorLaporan' => $formatted_count_with_date,
			'namaPenerima' => $this->post('namaPenerima'),
			'jabatan' => $this->post('jabatan'),
			'departement' => $this->post('departement'),
			'dtmCreated' => $this->post('dtmCreated'),
			'pemberi' => $this->post('pemberi'),
			'nominal' => $cleanedNumberString,
			'keterangan' => $this->post('keterangan'),
			'userCreated' => $this->post('userCreated'),
			'tglKejadian' => $this->post('tglKejadian'),
			'fotoBukti' => $nomor_image.'_'.$this->post('userCreated').'.jpeg',
			'typeInput' => '1',
		];

		if ($this->M_Gratifikasi->create_gratifikasi($data) > 0) {
			$this->response([
				'status' => true,
				'message' => $nomor_image.'_'.$this->post('userCreated'),
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