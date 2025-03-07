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
class Absen_manual2 extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);

		$this->load->model('pengajuan/M_Absen_Manual');
	}

	public function index_get()
	{
		$nik_baru = $this->get('nik_baru');
		$id = $this->get('id_absen');

		if ($nik_baru === null and $id === null) {
			$user = $this->M_Absen_Manual->get_index_absen_manual();
		} else {
			$user = $this->M_Absen_Manual->get_index_absen_manual($nik_baru, $id);
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

	public function index_atasan_get()
	{
		$jabatan = $this->get('jabatan_struktur');

		if ($jabatan === null) {
			$team = $this->M_Absen_Manual->get_index_absen_manual_atasan();
		} else {
			$team = $this->M_Absen_Manual->get_index_absen_manual_atasan($jabatan);
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


	public function index_post()
	{
		$data = [
			'nik_absen' => $this->post('nik_absen'),
			'jabatan_absen' => $this->post('jabatan_absen'),
			'lokasi_absen' => $this->post('lokasi_absen'),
			'jenis_absen' => $this->post('jenis_absen'),
			'tanggal_absen' => $this->post('tanggal_absen'),
			'waktu_absen' => $this->post('waktu_absen'),
			'ket_absen' => $this->post('ket_absen'),
			'status' => '0',
			'tanggal' => '0000-00-00',
			'status_2' => '0',
			'tanggal_2' => '0000-00-00',
		];

		if ($this->M_Absen_Manual->createAbsenManual($data) > 0) {
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

	public function index_manualin_put()
	{
		$badgenumber = $this->put('badgenumber');
		$shift_day = $this->put('shift_day');

		$data = [
			'in_manual' => $this->put('in_manual'),
		];

		if ($this->M_Absen_Manual->updateJam($data, $badgenumber, $shift_day) > 0) {
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

	public function index_manualout_put()
	{
		$badgenumber = $this->put('badgenumber');
		$shift_day = $this->put('shift_day');

		$data = [
			'out_manual' => $this->put('out_manual'),
		];

		if ($this->M_Absen_Manual->updateJam($data, $badgenumber, $shift_day) > 0) {
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

	public function index_put()
	{
		$id_absen = $this->put('id_absen');
		$data = [
			'status' => $this->put('status'),
			'tanggal' => $this->put('tanggal'),
		];

		if ($this->M_Absen_Manual->updateApproval($data, $id_absen) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_atasan_lokasi_get()
	{
		$jabatan = $this->get('jabatan_struktur');
		$lokasi = $this->get('lokasi');


		$team = $this->M_Absen_Manual->get_index_absen_atasan_lokasi($jabatan, $lokasi);


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

	public function index_lokasi_absen_karyawan_get()
	{
		$no_urut_karyawan = $this->get('noUrut');

		$get = $this->M_Absen_Manual->get_karyawan_lokasi_absen($no_urut_karyawan);
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


	public function index_get_absen_manual_approval_atasan_get()
	{
		$id_divisi = $this->get('id_divisi');
		$id_bagian = $this->get('id_bagian');
		$jabatan   = $this->get('id_jabatan');

		$get = $this->M_Absen_Manual->get_index_absen_manual_atasan_new($id_divisi, $id_bagian, $jabatan);
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
