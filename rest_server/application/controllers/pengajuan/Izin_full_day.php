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
class Izin_full_day extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);


		$this->load->model('pengajuan/M_Izin_full_day');
	}

	public function index_get()
	{
		$id = $this->get('id_full_day');
		$nik_baru = $this->get('nik_baru');

		if ($nik_baru === null and $id === null) {
			$user = $this->M_Izin_full_day->get_index_full_day();
		} else {
			$user = $this->M_Izin_full_day->get_index_full_day($nik_baru, $id);
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
			'no_pengajuan_full_day' => $this->post('no_pengajuan_full_day'),
			'nik_full_day'          => $this->post('nik_full_day'),
			'jabatan_full_day'      => $this->post('jabatan_full_day'),
			'jenis_full_day'        => $this->post('jenis_full_day'),
			'start_full_day'        => $this->post('start_full_day'),
			'karyawan_pengganti'    => $this->post('karyawan_pengganti'),
			'ket_tambahan'          => $this->post('ket_tambahan'),
			'status_full_day'       => '0',
			'status_full_day_2'     => '0',
			'upload_full_day'       => $this->post('upload_full_day'),
			'ket_input'             => 'ANDROID',
			'lat'                   => $this->post('lat'),
			'lon'                   => $this->post('lon'),
		];

		if ($this->M_Izin_full_day->createFull_day($data) > 0) {
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
		$id   = $this->put('id_full_day');
		
		$data = [
			'status_full_day'   => $this->put('status_full_day'),
			'feedback_full_day' => $this->put('feedback_full_day'),
			'tanggal_approval'  => $this->put('tanggal_approval'),
		];

		$badgenumber = $this->put('nik_baru');
		$shift_day   = $this->put('tanggal_absen');
		$status      = $this->put('status_full_day');

		$data2       = [
			'jenis_full_day' => $this->put('jenis_full_day'),
		];

		if ($this->M_Izin_full_day->updateApproval($data, $id) > 0 and $this->M_Izin_full_day->update_data($data2, $shift_day, $badgenumber, $status) > 0) {
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
			$team = $this->M_Izin_full_day->get_index_full_day_atasan();
		} else {
			$team = $this->M_Izin_full_day->get_index_full_day_atasan($jabatan);
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


		$team = $this->M_Izin_full_day->get_index_full_day_atasan_lokasi($jabatan, $lokasi);


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


		$team = $this->M_Izin_full_day->get_index_full_day_feedback($nik_baru, $tanggal);


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

	//--------------------------------------------------------------------------------------------------------------------

	public function index_insert_izin_full_day_post()
	{
		$data = [
			'no_pengajuan_full_day' => $this->post('no_pengajuan_full_day'),
			'nik_full_day' => $this->post('nik_full_day'),
			'jabatan_full_day' => $this->post('jabatan_full_day'),
			'jenis_full_day' => $this->post('jenis_full_day'),
			'start_full_day' => $this->post('start_full_day'),
			'karyawan_pengganti' => $this->post('karyawan_pengganti'),
			'ket_tambahan' => $this->post('ket_tambahan'),
			'status_full_day' => '0',
			'status_full_day_2' => '0',
			'upload_full_day' => $this->post('upload_full_day'),
			'ket_input' => 'ANDROID',
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
		];

		if ($this->M_Izin_full_day->create_izin_full_day($data) > 0) {
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


	public function index_insert_dinas_full_day_post()
	{
		$data = [
			'no_pengajuan_full_day' => $this->post('no_pengajuan_full_day'),
			'nik_full_day' => $this->post('nik_full_day'),
			'jabatan_full_day' => $this->post('jabatan_full_day'),
			'jenis_full_day' => $this->post('jenis_full_day'),
			'start_full_day' => $this->post('start_full_day'),
			'karyawan_pengganti' => $this->post('karyawan_pengganti'),
			'ket_tambahan' => $this->post('ket_tambahan'),
			'status_full_day' => '0',
			'status_full_day_2' => '0',
			'ket_input' => 'ANDROID',
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
		];

		if ($this->M_Izin_full_day->create_dinas_full_day($data) > 0) {
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


	public function index_get_rekap_izin_full_day_get()
	{
		$id = $this->get('id_full_day');
		$nik_baru = $this->get('nik_baru');

		if ($nik_baru === null and $id === null) {
			$user = $this->M_Izin_full_day->get_index_rekap_full_day();
		} else {
			$user = $this->M_Izin_full_day->get_index_rekap_full_day($nik_baru, $id);
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

	public function index_get_full_day_approval_atasan_get()
	{
		$id_divisi = $this->get('id_divisi');
		$id_bagian = $this->get('id_bagian');
		$jabatan   = $this->get('id_jabatan');

		$get = $this->M_Izin_full_day->get_index_full_day_atasan_new($id_divisi, $id_bagian, $jabatan);
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
