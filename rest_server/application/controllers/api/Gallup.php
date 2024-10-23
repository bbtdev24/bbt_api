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
class Gallup extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('M_Gallup');
	}

	public function index_get()
	{
		$nik = $this->get('nik_baru');
		$depo = $this->get('lokasi_struktur');
		$pt = $this->get('perusahaan_struktur');
		$jabatan = $this->get('jabatan_struktur');
		$dept = $this->get('dept_struktur');

		$user = $this->M_Gallup->getGallup($nik, $depo, $pt, $jabatan, $dept);

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

	public function index_survey_get()
	{
		$nik = $this->get('nik_baru');
		$depo = $this->get('lokasi_struktur');
		$pt = $this->get('perusahaan_struktur');
		$jabatan = $this->get('jabatan_struktur');
		$dept = $this->get('dept_struktur');
		$tahun = $this->get('tahun');

		$user = $this->M_Gallup->getSurvey($nik, $depo, $pt, $jabatan, $dept, $tahun);

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

	public function index_survey_saran_get()
	{
		$nik = $this->get('nik_baru');
		$depo = $this->get('lokasi_struktur');
		$pt = $this->get('perusahaan_struktur');
		$jabatan = $this->get('jabatan_struktur');
		$dept = $this->get('dept_struktur');
		$tahun = $this->get('tahun');

		$user = $this->M_Gallup->getSurvey_saran($nik, $depo, $pt, $jabatan, $dept, $tahun);

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

	public function index_karyawan_survey_get()
	{
		$id = $this->get('lokasi_struktur');

		if ($id === null) {
            $karyawan = $this->M_Gallup->getKaryawan();
        } else {
            $karyawan = $this->M_Gallup->getKaryawan($id);
        }

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
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