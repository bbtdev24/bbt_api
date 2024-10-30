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
class Shifting extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('pengajuan/M_Shifting');
	}

	public function index_get()
	{
		$id = $this->get('id_karyawan_shift');
		$nik_baru = $this->get('nik_baru');
		$shift_day = $this->get('shift_day');

		if ($nik_baru === null and $id === null and $shift_day === null) {
			$user = $this->M_Shifting->get_index_shift();
		} else {
			$user = $this->M_Shifting->get_index_shift($nik_baru, $id, $shift_day);
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
			'user_submit' => $this->post('user_submit'),
			'nik_shift' => $this->post('nik_shift'),
			'nama_karyawan_shift' => $this->post('nama_karyawan_shift'),
			'jabatan_karyawan_shift' => $this->post('jabatan_karyawan_shift'),
			'dept_karyawan_shift' => $this->post('dept_karyawan_shift'),
			'lokasi_karyawan_shift' => $this->post('lokasi_karyawan_shift'),
			'jam_kerja' => $this->post('jam_kerja'),
			'start_periode' => '0',
			'end_periode' => '0',
			'tanggal_shift' => $this->post('tanggal_shift'),
			'keterangan_shift' => '',
			'no_co_shift' => '',
		];

		if ($this->M_Shifting->createShift($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new shift has been created',
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
		$id = $this->put('id_karyawan_shift');
		$data = [
			'jam_kerja' => $this->put('jam_kerja'),
			'update_date' => $this->put('update_date'),
			'user_update' => $this->put('user_update'),

		];

		if ($this->M_Shifting->updateShift($data, $id) > 0) {
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

	public function index_delete()
	{
		$id = $this->put('id_karyawan_shift');

		if ($this->M_Shifting->deleteShift($id) > 0) {
			$this->response([
				'status' => true,
				'message' => 'pengajuan has been delete',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_jam_put()
	{
		$id = $this->put('userid');
		$shift_day = $this->put('shift_day');
		$data = [
			'waktu_shift' => $this->put('waktu_shift'),
		];

		if ($this->M_Shifting->updateJam($data, $id, $shift_day) > 0) {
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

	public function index_atasan_lokasi_get()
	{
		$jabatan = $this->get('jabatan_struktur');
        $lokasi = $this->get('lokasi');
       
        $team = $this->M_Shifting->get_index_atasan_shift($jabatan, $lokasi);
        

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

	public function index_waktu_shift_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');

		$user = $this->M_Shifting->getWaktu_absensi($nik_baru, $tanggal);

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