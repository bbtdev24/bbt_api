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
class Login extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);


		$this->load->model('M_Login');
	}

	public function index_get()
	{
		$id = $this->get('nik_baru');

		if ($id === null) {
			$user = $this->M_Login->getUser();
		} else {
			$user = $this->M_Login->getUser($id);
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
			], REST_Controller::HTTP_OK);
		}
	}

	public function index_departement_get()
	{
		$depart = $this->get('dept_jabatan_karyawan');

		if ($depart === null) {
			$user = $this->M_Login->getDepart();
		} else {
			$user = $this->M_Login->getDepart($depart);
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

	public function index_kbkm_login_get()
	{
		$nik_ktp = $this->get('nik_ktp');

		if ($nik_ktp === null) {
			$user = $this->M_Login->getLoginKbkm();
		} else {
			$user = $this->M_Login->getLoginKbkm($nik_ktp);
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

	public function index_put()
	{
		$id = $this->put('nip');
		$password = md5($this->put('password'));

		$data = [
			'password' => md5($this->put('password_baru')),
		];

		if ($this->M_Login->updatePassword($data, $id, $password) > 0) {
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


	public function index_login_absensi_get()
	{
		$nip_karyawan = $this->get('nip');

		if ($nip_karyawan === null) {
			$user = $this->M_Login->getLoginByAbsensi();
		} else {
			$user = $this->M_Login->getLoginByAbsensi($nip_karyawan);
		}

		if ($user) {
			$this->response(
				[
					'status' => true,
					'data' => $user
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Kode Nomor Not Found'
				],
				REST_Controller::HTTP_NOT_FOUND
			);
		}
	}
}
