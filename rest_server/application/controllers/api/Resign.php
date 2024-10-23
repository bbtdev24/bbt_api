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
class Resign extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('M_Resign');
	}

	public function index_get()
	{
		$tanggal1 = $this->get('tanggal_efektif_resign');
		$tanggal2 = $this->get('tanggal_efektif_resign_2');

		$resign = $this->M_Resign->getResign($tanggal1, $tanggal2);

		if ($resign) {
			$this->response([
				'status' => true,
				'data' => $resign
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