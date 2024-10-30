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
class Notifikasi extends REST_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        $this->db_absensi = $this->load->database('db_absensi', TRUE);

        $this->load->model('master/M_Notifikasi');
    }

    // ===== baru ===== //

    public function index_cekDeviceId_post()
    {
        $nik_baru = $this->post('nik_baru');
        
        $get = $this->M_Notifikasi->getEmployeeToken($nik_baru);

        if ($get) {
            $nik_baru = $this->post('nik_baru');
                $data = [
                    'nama_karyawan' => $this->post('nama_karyawan'),  
                    'kode_cabang' => $this->post('kode_cabang'),  
                    'lokasi' => $this->post('lokasi'),  
                    'device_brand' => $this->post('device_brand'),  
                    'device_model' => $this->post('device_model'),  
                    'device_sdk' => $this->post('device_sdk'),  
                    'device_version' => $this->post('device_version'),
                    'apps_last_open' => $this->post('apps_last_open'),  
                    'apps_version' => $this->post('apps_version'),  
                    'device_token' => $this->post('device_token'), 
                    'apps' => 'ESS',     
                    'status_user' => '1',
                ];
            $this->M_Notifikasi->putDeviceId($data, $nik_baru);
        } else {
            $data2 = [
                    'nik_baru' => $nik_baru,  
                    'nama_karyawan' => $this->post('nama_karyawan'),  
                    'kode_cabang' => $this->post('kode_cabang'),  
                    'lokasi' => $this->post('lokasi'),  
                    'device_brand' => $this->post('device_brand'),  
                    'device_model' => $this->post('device_model'),  
                    'device_sdk' => $this->post('device_sdk'),  
                    'device_version' => $this->post('device_version'),
                    'apps_last_open' => $this->post('apps_last_open'),  
                    'apps_version' => $this->post('apps_version'),  
                    'device_token' => $this->post('device_token'), 
                    'apps' => 'ESS',   
                    'status_user' => '1',

                ];

            $this->M_Notifikasi->createDeviceId($data2);
            
        }
    }

    public function index_logout_put()
    {
        $nik_baru = $this->put('nik_baru');
        $data = [
            'status_user' => '0',
            'apps_last_open' => $this->put('apps_last_open'),  
        ];

        if ($this->M_Notifikasi->putDeviceId($data, $nik_baru) > 0) {
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

    public function index_token_old_get()
    {
        $no_jabatan_karyawan = $this->get('no_jabatan_karyawan');
        $lokasi_hrd = $this->get('lokasi_hrd');
        
        $token = $this->M_Notifikasi->getToken_old($no_jabatan_karyawan, $lokasi_hrd);

        if ($token) {
            $this->response([
                'status' => true,
                'data' => $token
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_token_get()
    {
        $no_jabatan_karyawan = $this->get('no_jabatan_karyawan');
        $lokasi_hrd          = $this->get('lokasi_hrd');
        $id_divisi           = $this->get('idDivisi');
        $id_bagian           = $this->get('idBagian');

        $token = $this->M_Notifikasi->getToken($no_jabatan_karyawan, $lokasi_hrd, $id_divisi, $id_bagian);

        if ($token) {
            $this->response([
                'status' => true,
                'data'   => $token
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status'  => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_token_nik_get()
    {
        $nik_baru = $this->get('nik_baru');
        
        $token = $this->M_Notifikasi->getTokenNikBaru($nik_baru);

        if ($token) {
            $this->response([
                'status' => true,
                'data' => $token
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // ================ //
}

?>