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
class Cuti_khusus extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        $this->db_absensi = $this->load->database('db_absensi', TRUE);

        $this->load->model('pengajuan/M_Cuti_khusus');
    }

    public function index_get()
    {
        $id = $this->get('id_cuti_khusus');
        $nik_baru = $this->get('nik_baru');

        if ($nik_baru === null and $id === null) {
            $user = $this->M_Cuti_khusus->get_index_cuti_khusus();
        } else {
            $user = $this->M_Cuti_khusus->get_index_cuti_khusus($nik_baru, $id);
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
            'no_pengajuan_khusus'  => $this->post('no_pengajuan_khusus'),
            'nik_cuti_khusus'      => $this->post('nik_cuti_khusus'),
            'no_urut'              => $this->post('no_urut'),
            'jabatan_cuti_khusus'  => $this->post('jabatan_cuti_khusus'),
            'jenis_cuti_khusus'    => $this->post('jenis_cuti_khusus'),
            'kondisi'              => $this->post('kondisi'),
            'start_cuti_khusus'    => $this->post('start_cuti_khusus'),
            'ket_tambahan_khusus'  => $this->post('ket_tambahan_khusus'),
            'status_cuti_khusus'   => '0',
            'status_cuti_khusus_2' => '0',
            'dokumen_cuti_khusus'  => $this->post('dokumen_cuti_khusus'),
            'ket_input'            => 'ANDROID',
            'lat'                  => $this->post('lat'),
            'lon'                  => $this->post('lon'),
        ];

        if ($this->M_Cuti_khusus->createCuti_khusus($data) > 0) {
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
        $id = $this->put('id_cuti_khusus');
        $data = [
            'status_cuti_khusus' => $this->put('status_cuti_khusus'),
            'feedback_cuti_khusus' => $this->put('feedback_cuti_khusus'),
            'tanggal_approval_cuti_khusus' => $this->put('tanggal_approval_cuti_khusus'),
        ];

        $badgenumber = $this->put('nik_baru');
        $shift_day = $this->put('tanggal_absen');
        $status = $this->put('status_cuti_khusus');
        $data2 = [
            'jenis_cuti_khusus' => $this->put('jenis_cuti_khusus'),
        ];

        if ($this->M_Cuti_khusus->updateApproval($data, $id) > 0 and $this->M_Cuti_khusus->update_data($data2, $shift_day, $badgenumber, $status) > 0) {
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
            $team = $this->M_Cuti_khusus->get_index_cuti_khusus_atasan();
        } else {
            $team = $this->M_Cuti_khusus->get_index_cuti_khusus_atasan($jabatan);
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

    public function index_keterangan_get()
    {
        $keterangan = $this->get('keterangan');

        if ($keterangan === null) {
            $team = $this->M_Cuti_khusus->get_index_keterangan();
        } else {
            $team = $this->M_Cuti_khusus->get_index_keterangan($keterangan);
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


        $team = $this->M_Cuti_khusus->get_index_khusus_atasan_lokasi($jabatan, $lokasi);


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


        $team = $this->M_Cuti_khusus->get_index_khusus_feedback($nik_baru, $tanggal);


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

    public function index_groupby_get()
    {
        $nik_baru = $this->get('nik_baru');

        $team = $this->M_Cuti_khusus->get_index_groupby_cuti_khusus($nik_baru);


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

    public function index_groupby_approval_get()
    {
        $nik_baru = $this->get('nik_baru');
        $no_pengajuan_khusus = $this->get('no_pengajuan_khusus');


        $team = $this->M_Cuti_khusus->get_index_khusus_approval($nik_baru, $no_pengajuan_khusus);


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

    public function index_get_cuti_khusus_approval_atasan_get()
	{
		$id_divisi = $this->get('id_divisi');
		$id_bagian = $this->get('id_bagian');
		$jabatan   = $this->get('id_jabatan');

		$get = $this->M_Cuti_khusus->get_index_cuti_khusus_atasan_new($id_divisi, $id_bagian, $jabatan);
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
