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
class Ptk extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('pengajuan/M_Ptk');
	}

	public function index_nomor_get()
	{
		$user = $this->M_Ptk->getNomor();

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

	public function index_nik_get()
	{
		$nik_baru = $this->get('nik_baru');
		$id = $this->get('id');

		$user = $this->M_Ptk->getDataByNik($nik_baru, $id);

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

	public function index_jabatan_get()
	{
		$jabatan = $this->get('jabatan');

		$user = $this->M_Ptk->getJabatan($jabatan);

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
		$getNik = $this->M_Ptk->getNomorUrutNik($this->post('nik_pengajuan'));
		foreach($getNik as $row) {
			$no_urut = $row['no_urut'];
		}

		$data = [
			'no_pengajuan' => $this->post('no_pengajuan'),
			'nik_pengajuan' => $this->post('nik_pengajuan'),
			'no_urut' => $no_urut,
			'jabatan_karyawan' => $this->post('jabatan_karyawan'),
			'jabatan_ptk' => $this->post('jabatan_ptk'),
			'depo_ptk' => $this->post('depo_ptk'),
			'dept_ptk' => $this->post('dept_ptk'),
			'analisa' => $this->post('analisa'),
			'tenaga_kerja' => $this->post('tenaga_kerja'),

			'status_atasan' => '0',
			'status_hrd' => '0',

		];

		if ($this->M_Ptk->createPTK($data) > 0) {
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

	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'status_atasan' => $this->put('status_atasan'),
			'tanggal_approve' => $this->put('tanggal_approve'),
			'ket_atasan' => $this->put('ket_atasan'),
		];

		if ($this->M_Ptk->updateApproval($data, $id) > 0) {
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


	public function index_manager_get()
	{
		$date1 = $this->get('date1');
		$date2 = $this->get('date2');

		$user = $this->M_Ptk->getDataManager($date1, $date2);

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

	public function index_manager_approval_get()
	{
		$status_manager = $this->get('status_manager');
		$date1 = $this->get('date1');
		$date2 = $this->get('date2');
		$user = $this->M_Ptk->getDataManagerApproval($status_manager, $date1, $date2);

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


	public function convertMonthToRoman($monthNumber)
    {
        // Define an array mapping month numbers to Roman numerals
        $romanNumerals = array(
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        );
        
        // Return the Roman numeral for the given month number
        return isset($romanNumerals[$monthNumber]) ? $romanNumerals[$monthNumber] : null;
    }

	public function index_manager_put()
	{
		$no_pengajuan = $this->put('no_pengajuan');
		$ket_manager = $this->put('ket_manager');
		$tanggal_manager = $this->put('tanggal_manager');
		$status = $this->put('status');

		$get = $this->M_Ptk->getNoPengajuan();
		foreach($get as $row) {
			$no_pengajuan_2 = $row['no_pengajuan'];
		}

		$get2 = $this->M_Ptk->getById($no_pengajuan);
		foreach($get2 as $row2) {
			$depo_ptk = $row2['depo_ptk'];
		}

		$get3 = $this->M_Ptk->getTempat($depo_ptk);
		foreach($get3 as $row3) {
			$tempat = $row3['tempat'];
		}

		$currentDate = date("n");
		$monthNumber = $currentDate; // Change this to the month number you want to convert
        $romanNumeral = $this->convertMonthToRoman($monthNumber);

        $currentYear = date("Y");

        if ($status == 1) {
        	$nomor_ptk = $no_pengajuan_2."/TVIP/".strtoupper($tempat)."/".$romanNumeral."/".$currentYear;
	        	$data = [
					'status_manager' => $status,
					'tanggal_manager' => $tanggal_manager,
					'ket_manager' => $ket_manager,
					'no_ptk' => $nomor_ptk,
				];
		} else {
		    $data = [
					'status_manager' => $status,
					'tanggal_manager' => $tanggal_manager,
					'ket_manager' => $ket_manager,
				];
		}

		if ($this->M_Ptk->updateApprovalManager($data, $no_pengajuan) > 0) {
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

	public function index_manager_update_put()
	{
		$no_pengajuan = $this->put('no_pengajuan');
		$status = $this->put('status');
		$tanggal_loker = $this->put('tanggal_loker');

		$data = [
			'status_loker' => $status,
			'tanggal_loker' => $tanggal_loker,
		];
		if ($this->M_Ptk->updateApprovalManager($data, $no_pengajuan) > 0) {
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

	public function index_manager_pengajuan_get()
	{
		$jabatan_ptk = $this->get('jabatan_ptk');
		$user = $this->M_Ptk->getDataPengajuan($jabatan_ptk);

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

	public function index_cancel_put()
	{
		$no_pengajuan = $this->put('no_pengajuan');

		$status = $this->put('status');
		$tanggal_cancel = $this->put('tanggal_cancel');
		$ket_cancel = $this->put('ket_cancel');

		$data = [
			'status_cancel' => $status,
			'tanggal_cancel' => $tanggal_cancel,
			'ket_cancel' => $ket_cancel,
		];
		if ($this->M_Ptk->updateApprovalManager($data, $no_pengajuan) > 0) {
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