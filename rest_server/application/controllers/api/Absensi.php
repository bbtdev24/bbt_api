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
class Absensi extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);
		// $this->db3 = $this->load->database('db3', TRUE);
		$this->db_absensi = $this->load->database('db_absensi', TRUE);

		$this->load->model('M_Absensi');
	}

	public function index_masuk_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');

		$user = $this->M_Absensi->getKeteranganMasukMobile($nik_baru, $tanggal);

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

	public function index_keluar_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');

		$user = $this->M_Absensi->getKeteranganKeluarMobile($nik_baru, $tanggal);

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


	public function index_get()
	{
		$tanggal1 = $this->get('shift_day');
		$tanggal2 = $this->get('shift_day_2');
		$nik = $this->get('badgenumber');
		$depo = $this->get('lokasi_struktur');
		$pt = $this->get('perusahaan_struktur');
		$jabatan = $this->get('jabatan_struktur');
		$dept = $this->get('dept_struktur');

		$user = $this->M_Absensi->getAbsensi($tanggal1, $tanggal2, $nik, $depo, $pt, $jabatan, $dept);

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

	public function index_new_get()
	{
		$tanggal1 = $this->get('shift_day');
		$tanggal2 = $this->get('shift_day_2');
		$nik = $this->get('badgenumber');
		$depo = $this->get('lokasi_struktur');
		$pt = $this->get('perusahaan_struktur');
		$jabatan = $this->get('jabatan_struktur');
		$dept = $this->get('dept_struktur');

		$user = $this->M_Absensi->getAbsensi_new($tanggal1, $tanggal2, $nik, $depo, $pt, $jabatan, $dept);

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

	// public function insert_absen_get_in_post()
	// {
	// 	$data = [
	// 		'noUrut' => $this->post('nourut_karyawan'),
	// 		'nip' => $this->post('nip_karyawan'),
	// 		'checktime' => $this->post('checktime'),
	// 		'checktype' => '0',
	// 		'long' => $this->post('long'),
	// 		'lat' => $this->post('lat'),
	// 		'foto' => $this->post('url_foto'),
	// 		'userCreate' => $this->post('userCreate'),
	// 		'userDateCreate' => $this->post('userDateCreate'),
	// 		'typeInsert' => 'MOBILE',
	// 		'idlokasi' => $this->post('idlokasi'),
	// 	];

	// 	if ($this->M_Absensi->post_absen_get_in($data) > 0) {
	// 		$this->response([
	// 			'status' => true,
	// 			'message' => 'new pengajuan has been created',
	// 		], REST_Controller::HTTP_CREATED);
	// 	} else {
	// 		// Gagal
	// 		$this->response([
	// 			'status' => false,
	// 			'message' => 'Failed to create new data'
	// 		], REST_Controller::HTTP_BAD_REQUEST);
	// 	}
	// }

	
	//PAKE JAM SERVER
	public function insert_absen_get_in_post()
	{
    date_default_timezone_set('Asia/Jakarta'); // Set timezone ke Jakarta
    $current_time = date('Y-m-d H:i:s'); // Ambil waktu server

    $data = [
        'noUrut' => $this->post('nourut_karyawan'),
        'nip' => $this->post('nip_karyawan'),
        'checktime' => $current_time, // Pakai waktu server
        'checktype' => '0',
        'long' => $this->post('long'),
        'lat' => $this->post('lat'),
        'foto' => $this->post('url_foto'),
        'userCreate' => $this->post('userCreate'),
        'userDateCreate' => $current_time, // Pakai waktu server
        'typeInsert' => 'MOBILE',
        'idlokasi' => $this->post('idlokasi'),
    ];

    if ($this->M_Absensi->post_absen_get_in($data) > 0) {
        $this->response([
            'status' => true,
            'message' => 'new pengajuan has been created',
        ], REST_Controller::HTTP_CREATED);
    } else {
        $this->response([
            'status' => false,
            'message' => 'Failed to create new data'
        ], REST_Controller::HTTP_BAD_REQUEST);
   	}
	}


	public function insert_absen_get_out_post()
	{
	date_default_timezone_set('Asia/Jakarta'); // Set timezone ke Jakarta
    $current_time = date('Y-m-d H:i:s'); // Ambil waktu server

		$data = [
			'noUrut' => $this->post('nourut_karyawan'),
			'nip' => $this->post('nip_karyawan'),
        	'checktime' => $current_time, // Pakai waktu server
			'checktype' => '1',
			'long' => $this->post('long'),
			'lat' => $this->post('lat'),
			'foto' => $this->post('url_foto'),
			'userCreate' => $this->post('userCreate'),
        	'userDateCreate' => $current_time, // Pakai waktu server
			'typeInsert' => 'MOBILE',			
			'idlokasi' => $this->post('idlokasi'),
		];

		if ($this->M_Absensi->post_absen_get_out($data) > 0) {
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

	public function index_get_absen_getin_get()
	{
		$nip_karyawan = $this->get('nip');
		$checktime = $this->get('checktime');
		$typeInsert = $this->get('typeInsert');

		$get = $this->M_Absensi->get_absen_getin($nip_karyawan, $checktime, $typeInsert);
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

	public function index_get_absen_getout_get()
	{
		$nip_karyawan = $this->get('nip');
		$checktime = $this->get('checktime');
		$typeInsert = $this->get('typeInsert');

		$get = $this->M_Absensi->get_absen_getout($nip_karyawan, $checktime, $typeInsert);
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

	public function index_get_longlat_user_get()
	{
		// $nip_karyawan = $this->get('nip');
		// $checktime = $this->get('checktime');
		// $typeInsert = $this->get('typeInsert');

		$get = $this->M_Absensi->get_longlat_lokasi_user();
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

	public function index_get_payment_get()
	{
		$bulan_start = $this->get('bulan_start');
		$bulan_end = $this->get('bulan_end');
		$tahun = $this->get('tahun');
		$noUrut = $this->get('noUrut');

		$get = $this->M_Absensi->get_payment($bulan_start, $bulan_end, $tahun, $noUrut);
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
