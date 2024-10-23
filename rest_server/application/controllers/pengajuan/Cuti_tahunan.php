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
class Cuti_tahunan extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);

		$this->load->model('pengajuan/M_Cuti_tahunan');
	}

	public function index_get()
	{
		$id = $this->get('id_sisa_cuti');
		$nik_baru = $this->get('nik_baru');

		if ($nik_baru === null and $id === null) {
			$user = $this->M_Cuti_tahunan->get_index_cuti_tahunan();
		} else {
			$user = $this->M_Cuti_tahunan->get_index_cuti_tahunan($nik_baru, $id);
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
			'no_pengajuan_tahunan' => $this->post('no_pengajuan_tahunan'),
			'nik_sisa_cuti' => $this->post('nik_sisa_cuti'),
			'jabatan_cuti_tahunan' => $this->post('jabatan_cuti_tahunan'),
			'no_urut' => $this->post('no_urut'),
			'opsi_cuti_tahunan' => $this->post('opsi_cuti_tahunan'),
			'start_cuti_tahunan' => $this->post('start_cuti_tahunan'),
			'ket_tambahan_tahunan' => $this->post('ket_tambahan_tahunan'),
			'status_cuti_tahunan' => '0',
			'status_cuti_tahunan_2' => '0',
			'dok_cuti_tahunan' => $this->post('dok_cuti_tahunan'),
			'hak_cuti_utuh' => '1',
			'ket_input' => 'ANDROID',
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
		];

		if ($this->M_Cuti_tahunan->createCuti_tahunan($data) > 0) {
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

	public function index_2_put()
	{
		$id = $this->put('id_sisa_cuti');
		$data = [
			'status_cuti_tahunan' => $this->put('status_cuti_tahunan'),
			'feedback_cuti_tahunan' => $this->put('feedback_cuti_tahunan'),
			'tanggal_cuti_tahunan' => $this->put('tanggal_cuti_tahunan'),
		];

		$badgenumber = $this->put('nik_baru');
		$shift_day = $this->put('tanggal_absen');
		$status = $this->put('status_cuti_tahunan');
		$data2 = [
			'opsi_cuti_tahunan' => $this->put('opsi_cuti_tahunan'),
		];

		if ($this->M_Cuti_tahunan->updateApproval($data, $id) > 0 and $this->M_Cuti_tahunan->update_data($data2, $shift_day, $badgenumber, $status) > 0) {
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

	public function index_hakcuti_put()
	{
		$nik_sisa_cuti = $this->put('no_urut');
		$tahun         = $this->put('tahun');

		$data = [
			'hak_cuti_utuh' => $this->put('hak_cuti_utuh'),
		];

		if ($this->M_Cuti_tahunan->updateHakCuti($data, $nik_sisa_cuti, $tahun) > 0) {
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

	public function index_atasan_get()
	{
		$jabatan = $this->get('jabatan_struktur');

		if ($jabatan === null) {
			$team = $this->M_Cuti_tahunan->get_index_cuti_tahunan_atasan();
		} else {
			$team = $this->M_Cuti_tahunan->get_index_cuti_tahunan_atasan($jabatan);
		}

		if ($team) {
			$this->response([
				'status' => true,
				'data' => $team
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_atasan_lokasi_get()
	{
		$jabatan = $this->get('jabatan_struktur');
		$lokasi = $this->get('lokasi');


		$team = $this->M_Cuti_tahunan->get_index_tahunan_atasan_lokasi($jabatan, $lokasi);


		if ($team) {
			$this->response([
				'status' => true,
				'data' => $team
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_feedback_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');


		$team = $this->M_Cuti_tahunan->get_index_tahunan_feedback($nik_baru, $tanggal);


		if ($team) {
			$this->response([
				'status' => true,
				'data' => $team
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}


	// approval manager //

	public function index_manager_hr_get()
	{
		$status = $this->get('status');

		$date1 = $this->get('date1');
		$date2 = $this->get('date2');

		$team = $this->M_Cuti_tahunan->get_index_tahunan_manager($status, $date1, $date2);


		if ($team) {
			$this->response([
				'status' => true,
				'data' => $team
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_HR_put()
	{
		$id = $this->put('id_sisa_cuti');
		$data = [
			'status_cuti_tahunan' => $this->put('status_cuti_tahunan'),
			'feedback_cuti_tahunan' => $this->put('feedback_cuti_tahunan'),
			'tanggal_cuti_tahunan' => $this->put('tanggal_cuti_tahunan'),
		];

		if ($this->M_Cuti_tahunan->updateApproval($data, $id)) {
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

	public function index_HrManager_put()
	{
		$id = $this->put('id_sisa_cuti');
		$data = [
			'status_cuti_tahunan' => '1',
			'status_cuti_manager' => $this->put('status_cuti_manager'),
			'feedback_cuti_manager' => $this->put('feedback_cuti_manager'),
			'tanggal_cuti_manager' => $this->put('tanggal_cuti_manager'),
		];

		$badgenumber = $this->put('nik_baru');
		$shift_day = $this->put('tanggal_absen');
		$status = $this->put('status_cuti_manager');
		$data2 = [
			'opsi_cuti_tahunan' => $this->put('opsi_cuti_tahunan'),
		];

		if ($this->M_Cuti_tahunan->updateApproval($data, $id) > 0 and $this->M_Cuti_tahunan->update_data($data2, $shift_day, $badgenumber, $status) > 0) {
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


	public function index_get_cuti_tahunan_approval_atasan_get()
	{
		$id_divisi = $this->get('id_divisi');
		$id_bagian = $this->get('id_bagian');
		$jabatan   = $this->get('id_jabatan');

		$get = $this->M_Cuti_tahunan->get_index_cuti_tahunan_atasan_new($id_divisi, $id_bagian, $jabatan);
		$totaldata = count($get);
		if ($get) {
			$this->response([
				'status' => true,
				'total_data' => $totaldata,
				'data' => $get
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'total_data' => $totaldata,
				'message' => 'Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
}
