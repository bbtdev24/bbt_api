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
class pendidikan extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db4 = $this->load->database('db4', TRUE);

		$this->load->model('website/M_pendidikan');
	}

	public function index_get()
	{

		$di_no_ktp = $this->get('di_no_ktp');
		
		if ($di_no_ktp === null) {
			$user = $this->M_pendidikan->get_pendidikan();
		} else {
			$user = $this->M_pendidikan->get_pendidikan($di_no_ktp);
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