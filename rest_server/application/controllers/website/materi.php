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
class materi extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db5 = $this->load->database('db5', TRUE);

		$this->load->model('website/M_Materi');
	}

	public function index_get()
	{

		$kode = $this->get('kode');
		
		if ($kode === null) {
			$user = $this->M_Materi->getMateri();
		} else {
			$user = $this->M_Materi->getMateri($kode);
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
}

?>