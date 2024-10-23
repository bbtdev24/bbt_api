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
class btb_supplier_testing extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db7 = $this->load->database('db8', TRUE);

		$this->load->model('waterin/M_SupplierTesting');
	}

	public function index_get()
	{
		$mk_barcode = $this->get('mk_barcode');

		$btbsupplier = $this->M_SupplierTesting->getBtbSupplier($mk_barcode);

		if ($btbsupplier) {
			$this->response([
				'status' => true,
				'data' => $btbsupplier
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Barcode Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_print_bakkb_get()
	{
		$co = $this->get('co');
		$asal_pengirim = $this->get('asal_pengirim');

		$bakkb_print = $this->M_SupplierTesting->getBakkbPrint($asal_pengirim, $co);

		if ($bakkb_print) {
			$this->response([
				'status' => true,
				'data' => $bakkb_print
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Barcode Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	

}

?>