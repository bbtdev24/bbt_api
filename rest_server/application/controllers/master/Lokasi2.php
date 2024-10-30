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
class Lokasi extends REST_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);

        $this->load->model('master/M_Lokasi');
    }

    public function index_get()
    {
        $lokasi = $this->get('lokasi');
        
        if ($lokasi === null) {
            $user = $this->M_Lokasi->getLokasi();
        } else {
            $user = $this->M_Lokasi->getLokasi($lokasi);
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

    public function index_kode_get()
    {
        $namadepo = $this->get('namadepo');
        
        $user = $this->M_Lokasi->getkodeLokasi($namadepo);
        
       
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

    public function index_lokasi_get()
    {
        $kode = $this->get('kode_nik_depo');
        
        if ($kode === null) {
            $user = $this->M_Lokasi->getLokasi_kode();
        } else {
            $user = $this->M_Lokasi->getLokasi_kode($kode);
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

    public function index_kodenikdepo_get()
    {
        $kode_dms = $this->get('kode_dms');
        
        $user = $this->M_Lokasi->getkodenikdepo($kode_dms);
        
       
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

    public function index_depo_get()
    {
        $depo_nama = $this->get('depo_nama');
        
        $user = $this->M_Lokasi->getDepo($depo_nama);
        
       
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